<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DosenController extends Controller
{
    public function dashboard()
    {
        $dosen = Auth::guard('dosen')->user();
        $jadwalHariIni = Jadwal::where('dosen_id', $dosen->id)
            ->where('hari', $this->getHariIni())
            ->where('aktif', true)
            ->with(['matakuliah', 'presensi' => function($query) {
                $query->where('tanggal', today());
            }])
            ->get();

        $totalJadwal = Jadwal::where('dosen_id', $dosen->id)->count();
        $totalPresensi = Presensi::whereHas('jadwal', function($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })->whereDate('tanggal', today())->count();

        // Get unique jurusan and prodi for this dosen
        $jurusanList = Jadwal::where('dosen_id', $dosen->id)->distinct()->pluck('jurusan')->filter();
        $prodiList = Jadwal::where('dosen_id', $dosen->id)->distinct()->pluck('prodi')->filter();

        return view('dosen.dashboard', compact('jadwalHariIni', 'totalJadwal', 'totalPresensi', 'jurusanList', 'prodiList'));
    }

    public function jadwalIndex(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();
        $query = Jadwal::where('dosen_id', $dosen->id)
            ->with(['matakuliah', 'mahasiswa'])
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
        $jurusanList = Jadwal::where('dosen_id', $dosen->id)->distinct()->pluck('jurusan')->filter();
        $prodiList = Jadwal::where('dosen_id', $dosen->id)->distinct()->pluck('prodi')->filter();
        $semesterList = Jadwal::where('dosen_id', $dosen->id)->distinct()->pluck('semester')->filter();

        return view('dosen.jadwal.index', compact('jadwal', 'jurusanList', 'prodiList', 'semesterList'));
    }

    public function presensiIndex()
    {
        $dosen = Auth::guard('dosen')->user();
        $presensi = Presensi::whereHas('jadwal', function($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })
        ->with(['jadwal.matakuliah', 'mahasiswa'])
        ->orderBy('tanggal', 'desc')
        ->paginate(15);

        return view('dosen.presensi.index', compact('presensi'));
    }

    public function presensiByJadwal($jadwalId)
    {
        $dosen = Auth::guard('dosen')->user();
        $jadwal = Jadwal::where('dosen_id', $dosen->id)
            ->with(['matakuliah', 'mahasiswa'])
            ->findOrFail($jadwalId);

        $presensi = Presensi::where('jadwal_id', $jadwalId)
            ->with('mahasiswa')
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        return view('dosen.presensi.by-jadwal', compact('jadwal', 'presensi'));
    }

    public function presensiByDate(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();
        $tanggal = $request->get('tanggal', today());

        $presensi = Presensi::whereHas('jadwal', function($query) use ($dosen) {
            $query->where('dosen_id', $dosen->id);
        })
        ->where('tanggal', $tanggal)
        ->with(['jadwal.matakuliah', 'mahasiswa'])
        ->orderBy('waktu_presensi')
        ->get();

        return view('dosen.presensi.by-date', compact('presensi', 'tanggal'));
    }

    public function presensiShow($jadwalId)
    {
        $dosen = Auth::guard('dosen')->user();
        $jadwal = Jadwal::where('dosen_id', $dosen->id)
            ->with(['matakuliah', 'mahasiswa' => function($query) {
                $query->orderBy('nama');
            }])
            ->findOrFail($jadwalId);

        // Ambil status semua mahasiswa yang sudah ada record presensinya hari ini
        $presensiStatus = Presensi::where('jadwal_id', $jadwalId)
            ->whereDate('tanggal', today())
            ->pluck('status', 'mahasiswa_id');

        return view('dosen.presensi.show', compact('jadwal', 'presensiStatus'));
    }

    public function presensiUpdate(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'status' => 'required|in:hadir,sakit,izin,alpha',
        ]);

        // Gunakan updateOrCreate untuk handle kasus mahasiswa yg belum ada recordnya
        Presensi::updateOrCreate(
            [
                'jadwal_id' => $request->jadwal_id,
                'mahasiswa_id' => $request->mahasiswa_id,
                'tanggal' => today(),
            ],
            [
                'waktu_presensi' => now(),
                'status' => $request->status,
                'keterangan' => 'Status diubah oleh Dosen.',
            ]
        );

        return redirect()->route('dosen.presensi.show', $request->jadwal_id)
            ->with('success', 'Status presensi mahasiswa berhasil diperbarui.');
    }

    private function getHariIni()
    {
        Carbon::setLocale('id');
        return Carbon::now()->translatedFormat('l');
    }

    // Semester Schedule
    public function jadwalSemester(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();
        $selectedJadwalId = $request->get('jadwal_id');
        $selectedSemester = $request->get('semester');

        $jadwalQuery = Jadwal::where('dosen_id', $dosen->id)
            ->with(['matakuliah', 'mahasiswa'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai');

        if ($selectedJadwalId) {
            $jadwalQuery->where('id', $selectedJadwalId);
        }
        if ($selectedSemester) {
            $jadwalQuery->where('semester', $selectedSemester);
        }

        $jadwal = $jadwalQuery->get();

        $kelasOptions = Jadwal::where('dosen_id', $dosen->id)
            ->with('matakuliah')
            ->get()
            ->map(function($j) {
                return [
                    'id' => $j->id,
                    'nama' => $j->matakuliah->nama . ' (' . $j->hari . ', ' . \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') . ')'
                ];
            });

        $semesterOptions = Jadwal::where('dosen_id', $dosen->id)->distinct()->pluck('semester');

        return view('dosen.jadwal.semester', compact('dosen', 'jadwal', 'kelasOptions', 'selectedJadwalId', 'semesterOptions', 'selectedSemester'));
    }

    public function downloadJadwalSemester(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();
        $selectedJadwalId = $request->get('jadwal_id');
        $selectedSemester = $request->get('semester');

        $jadwalQuery = Jadwal::where('dosen_id', $dosen->id)
            ->with(['matakuliah', 'mahasiswa'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai');

        if ($selectedJadwalId) {
            $jadwalQuery->where('id', $selectedJadwalId);
        }
        if ($selectedSemester) {
            $jadwalQuery->where('semester', $selectedSemester);
        }

        $jadwal = $jadwalQuery->get();

        $pdf = Pdf::loadView('dosen.jadwal.semester_pdf', compact('dosen', 'jadwal'));
        return $pdf->download('jadwal-dosen-semester.pdf');
    }
}
