<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Presensi;
use App\Models\Kelas;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalDosen = Dosen::count();
        $totalMahasiswa = Mahasiswa::count();
        $totalJadwal = Jadwal::count();
        $totalPresensi = Presensi::count();

        return view('admin.dashboard', compact('totalDosen', 'totalMahasiswa', 'totalJadwal', 'totalPresensi'));
    }

    // Dosen Management
    public function dosenIndex()
    {
        $dosen = Dosen::paginate(10);
        return view('admin.dosen.index', compact('dosen'));
    }

    public function dosenCreate()
    {
        return view('admin.dosen.create');
    }

    public function dosenStore(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:dosen,nip',
            'nama' => 'required',
            'email' => 'required|email|unique:dosen,email',
            'password' => 'required|min:6',
            'no_hp' => 'nullable',
            'alamat' => 'nullable'
        ]);

        Dosen::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan');
    }

    public function dosenEdit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    public function dosenUpdate(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:dosen,nip,' . $id,
            'nama' => 'required',
            'email' => 'required|email|unique:dosen,email,' . $id,
            'no_hp' => 'nullable',
            'alamat' => 'nullable'
        ]);

        $dosen->update($request->only(['nip', 'nama', 'email', 'no_hp', 'alamat']));

        if ($request->password) {
            $dosen->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil diupdate');
    }

    public function dosenDestroy($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->delete();
        return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil dihapus');
    }

    // Mahasiswa Management
    public function mahasiswaIndex()
    {
        $mahasiswa = Mahasiswa::paginate(10);
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function mahasiswaCreate()
    {
        return view('admin.mahasiswa.create');
    }

    public function mahasiswaStore(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim',
            'nama' => 'required',
            'email' => 'required|email|unique:mahasiswa,email',
            'password' => 'required|min:6',
            'jurusan' => 'required',
            'prodi' => 'required',
            'semester' => 'required',
            'no_hp' => 'nullable',
            'alamat' => 'nullable'
        ]);

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jurusan' => $request->jurusan,
            'prodi' => $request->prodi,
            'semester' => $request->semester,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function mahasiswaEdit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function mahasiswaUpdate(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim,' . $id,
            'nama' => 'required',
            'email' => 'required|email|unique:mahasiswa,email,' . $id,
            'jurusan' => 'required',
            'prodi' => 'required',
            'semester' => 'required',
            'no_hp' => 'nullable',
            'alamat' => 'nullable'
        ]);

        $mahasiswa->update($request->only(['nim', 'nama', 'email', 'jurusan', 'prodi', 'semester', 'no_hp', 'alamat']));

        if ($request->password) {
            $mahasiswa->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate');
    }

    public function mahasiswaDestroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
    }

    // Jadwal Management
    public function jadwalIndex(Request $request)
    {
        $query = Jadwal::with(['dosen', 'matakuliah']);

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
        $jurusanList = Jadwal::distinct()->pluck('jurusan')->filter();
        $prodiList = Jadwal::distinct()->pluck('prodi')->filter();
        $semesterList = Jadwal::distinct()->pluck('semester')->filter();

        return view('admin.jadwal.index', compact('jadwal', 'jurusanList', 'prodiList', 'semesterList'));
    }

    public function jadwalCreate()
    {
        $dosen = Dosen::all();
        $matakuliah = Matakuliah::all();
        return view('admin.jadwal.create', compact('dosen', 'matakuliah'));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required',
            'semester' => 'required',
            'tahun_akademik' => 'required',
            'jurusan' => 'required',
            'prodi' => 'required'
        ]);

        $data = $request->all();
        $data['aktif'] = $request->has('aktif') ? 1 : 0;

        Jadwal::create($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function jadwalEdit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $dosen = Dosen::all();
        $matakuliah = Matakuliah::all();
        return view('admin.jadwal.edit', compact('jadwal', 'dosen', 'matakuliah'));
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required',
            'semester' => 'required',
            'tahun_akademik' => 'required',
            'jurusan' => 'required',
            'prodi' => 'required'
        ]);

        $data = $request->all();
        $data['aktif'] = $request->has('aktif') ? 1 : 0;

        $jadwal->update($data);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diupdate');
    }

    public function jadwalDestroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    // Presensi Report
    public function presensiIndex()
    {
        $presensi = Presensi::with(['mahasiswa', 'jadwal.matakuliah'])
            ->orderBy('tanggal', 'desc')
            ->paginate(20);
        return view('admin.presensi.index', compact('presensi'));
    }

    // Kelas Management
    public function kelasIndex(Request $request)
    {
        $query = Kelas::with(['mahasiswa', 'jadwal.matakuliah', 'jadwal.dosen']);

        // Search by mahasiswa name or NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('mahasiswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter by prodi
        if ($request->filled('prodi')) {
            $query->whereHas('mahasiswa', function($q) use ($request) {
                $q->where('prodi', $request->prodi);
            });
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        // Filter by dosen
        if ($request->filled('dosen_id')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('dosen_id', $request->dosen_id);
            });
        }

        $kelas = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // Get data for filters
        $prodiList = Mahasiswa::distinct()->pluck('prodi')->filter();
        $semesterList = Jadwal::distinct()->pluck('semester')->filter();
        $dosenList = Dosen::orderBy('nama')->get();

        return view('admin.kelas.index', compact('kelas', 'prodiList', 'semesterList', 'dosenList'));
    }

    public function kelasCreate()
    {
        $mahasiswa = Mahasiswa::orderBy('nama')->get();
        $jadwal = Jadwal::with(['matakuliah', 'dosen'])->orderBy('matakuliah_id')->get();
        return view('admin.kelas.create', compact('mahasiswa', 'jadwal'));
    }

    public function kelasStore(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'jadwal_id' => 'required|exists:jadwal,id',
        ]);

        // Check for duplicates
        $exists = Kelas::where('mahasiswa_id', $request->mahasiswa_id)
            ->where('jadwal_id', $request->jadwal_id)
            ->exists();

        if ($exists) {
            return redirect()->route('admin.kelas.create')->with('error', 'Mahasiswa sudah terdaftar di jadwal ini.')->withInput();
        }

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function kelasEdit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $mahasiswa = Mahasiswa::orderBy('nama')->get();
        $jadwal = Jadwal::with(['matakuliah', 'dosen'])->orderBy('matakuliah_id')->get();
        return view('admin.kelas.edit', compact('kelas', 'mahasiswa', 'jadwal'));
    }

    public function kelasUpdate(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'jadwal_id' => 'required|exists:jadwal,id',
        ]);

        $kelas = Kelas::findOrFail($id);

        // Check for duplicates, excluding the current record
        $exists = Kelas::where('mahasiswa_id', $request->mahasiswa_id)
            ->where('jadwal_id', $request->jadwal_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->route('admin.kelas.edit', $id)->with('error', 'Mahasiswa sudah terdaftar di jadwal ini.')->withInput();
        }

        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function kelasDestroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    // Settings Management
    public function settingsIndex()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $request->validate([
            'kampus_lat' => 'required|numeric',
            'kampus_lon' => 'required|numeric',
            'kampus_radius' => 'required|integer|min:1',
        ]);

        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
