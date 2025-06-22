<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $jadwalHariIni = $mahasiswa->jadwal()
            ->where('hari', $this->getHariIni())
            ->where('aktif', true)
            ->where('jurusan', $mahasiswa->jurusan)
            ->where('prodi', $mahasiswa->prodi)
            ->with(['dosen', 'matakuliah', 'presensi' => function($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id)
                      ->where('tanggal', today());
            }])
            ->get();

        $totalJadwal = $mahasiswa->jadwal()
            ->where('jurusan', $mahasiswa->jurusan)
            ->where('prodi', $mahasiswa->prodi)
            ->count();
        $totalPresensi = $mahasiswa->presensi()->count();

        return view('mahasiswa.dashboard', compact('jadwalHariIni', 'totalJadwal', 'totalPresensi'));
    }

    public function jadwalIndex(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $query = $mahasiswa->jadwal()
            ->with(['dosen', 'matakuliah'])
            ->orderBy('hari')
            ->orderBy('jam_mulai');

        // Filter berdasarkan jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        // Filter berdasarkan prodi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $jadwal = $query->paginate(10)->withQueryString();

        // Get unique values for filter dropdowns
        $jurusanList = $mahasiswa->jadwal()->distinct()->pluck('jurusan')->filter();
        $prodiList = $mahasiswa->jadwal()->distinct()->pluck('prodi')->filter();
        $semesterList = $mahasiswa->jadwal()->distinct()->pluck('semester')->filter();

        return view('mahasiswa.jadwal.index', compact('jadwal', 'jurusanList', 'prodiList', 'semesterList'));
    }

    public function presensiIndex()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $presensi = $mahasiswa->presensi()
            ->with(['jadwal.dosen', 'jadwal.matakuliah'])
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        return view('mahasiswa.presensi.index', compact('presensi'));
    }

    public function presensiCreate($jadwalId)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $jadwal = $mahasiswa->jadwal()->with(['dosen', 'matakuliah'])->findOrFail($jadwalId);

        // Cek apakah sudah ada presensi (apapun statusnya) untuk hari ini
        $sudahPresensi = Presensi::where('mahasiswa_id', $mahasiswa->id)
            ->where('jadwal_id', $jadwalId)
            ->whereDate('tanggal', today())
            ->exists();

        // Cek apakah waktu presensi sudah lewat
        if (Carbon::now()->gt(Carbon::parse($jadwal->jam_selesai))) {
            // Jika belum ada record presensi sama sekali, buat record Alpha
            if (!$sudahPresensi) {
                Presensi::create([
                    'mahasiswa_id' => $mahasiswa->id,
                    'jadwal_id' => $jadwal->id,
                    'tanggal' => today(),
                    'waktu_presensi' => now(),
                    'status' => 'alpha',
                    'keterangan' => 'Terlambat mengakses halaman presensi.',
                ]);
            }
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Waktu presensi sudah habis. Anda ditandai Alpha.');
        }

        // Jika waktu belum lewat, tapi sudah presensi
        if ($sudahPresensi) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah melakukan presensi untuk mata kuliah ini hari ini.');
        }

        $settings = Setting::pluck('value', 'key');
        return view('mahasiswa.presensi.create', compact('jadwal', 'settings'));
    }

    public function presensiStore(Request $request, $jadwalId)
    {
        $request->validate([
            'status' => 'required|in:hadir,sakit,izin',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'keterangan' => 'nullable|string|max:255',
            'file_bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();
        $jadwal = Jadwal::findOrFail($jadwalId);

        // Cek apakah waktu presensi sudah lewat
        if (Carbon::now()->gt(Carbon::parse($jadwal->jam_selesai))) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Waktu presensi untuk mata kuliah ini sudah habis.');
        }

        // Cek apakah sudah presensi
        $sudahPresensi = Presensi::where('mahasiswa_id', $mahasiswa->id)
            ->where('jadwal_id', $jadwalId)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahPresensi) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah presensi untuk jadwal ini hari ini.');
        }

        $settings = Setting::pluck('value', 'key');
        $kampusLat = $settings['kampus_lat'] ?? 0;
        $kampusLon = $settings['kampus_lon'] ?? 0;
        $kampusRadius = $settings['kampus_radius'] ?? 100;

        // Validasi jarak hanya jika status 'hadir' dan lokasi tersedia
        if ($request->status == 'hadir') {
            if (!$request->latitude || !$request->longitude) {
                return redirect()->back()->with('error', 'Lokasi diperlukan untuk presensi hadir. Silakan pilih status Sakit atau Izin jika lokasi tidak tersedia.')->withInput();
            }

            $distance = $this->haversineDistance(
                $kampusLat,
                $kampusLon,
                $request->latitude,
                $request->longitude
            );

            if ($distance > $kampusRadius) {
                return redirect()->back()->with('error', 'Anda berada di luar radius yang diizinkan untuk presensi hadir. Silakan pilih status Sakit atau Izin.')->withInput();
            }
        }

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_bukti')) {
            $filePath = $request->file('file_bukti')->store('public/bukti_presensi');
        }

        Presensi::create([
            'mahasiswa_id' => $mahasiswa->id,
            'jadwal_id' => $jadwalId,
            'tanggal' => today(),
            'waktu_presensi' => now(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'file_bukti' => $filePath,
        ]);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Presensi berhasil dicatat.');
    }

    public function presensiByJadwal($jadwalId)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $jadwal = $mahasiswa->jadwal()
            ->with(['dosen', 'matakuliah'])
            ->findOrFail($jadwalId);

        $presensi = Presensi::where('jadwal_id', $jadwalId)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        return view('mahasiswa.presensi.by-jadwal', compact('jadwal', 'presensi'));
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    private function getHariIni()
    {
        Carbon::setLocale('id');
        return Carbon::now()->translatedFormat('l');
    }

    // Semester Schedule
    public function jadwalSemester()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $jadwal = $mahasiswa->jadwal()
            ->with(['dosen', 'matakuliah'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        return view('mahasiswa.jadwal.semester', compact('mahasiswa', 'jadwal'));
    }

    public function downloadJadwalSemester()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $jadwal = $mahasiswa->jadwal()
            ->with(['dosen', 'matakuliah'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        $pdf = Pdf::loadView('mahasiswa.jadwal.semester_pdf', compact('mahasiswa', 'jadwal'));
        return $pdf->download('jadwal-semester-'.$mahasiswa->nim.'.pdf');
    }
}
