@extends('layouts.app')
@section('title', 'Jadwal Saya')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Jadwal Saya</h2>

    <!-- Filter Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('mahasiswa.jadwal.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="jurusan" class="form-label">Filter Jurusan</label>
                    <select class="form-select" id="jurusan" name="jurusan">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusanList as $jurusan)
                            <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>
                                {{ $jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="prodi" class="form-label">Filter Prodi</label>
                    <select class="form-select" id="prodi" name="prodi">
                        <option value="">Semua Prodi</option>
                        @foreach($prodiList as $prodi)
                            <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                {{ $prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="semester" class="form-label">Filter Semester</label>
                    <select class="form-select" id="semester" name="semester">
                        <option value="">Semua Semester</option>
                        @foreach($semesterList as $semester)
                            <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                                Semester {{ $semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                        <th>Semester</th>
                        <th>Tahun Akademik</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwal as $j)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $j->matakuliah->nama }}</td>
                        <td>{{ $j->dosen->nama }}</td>
                        <td>{{ $j->hari }}</td>
                        <td>{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
                        <td>{{ $j->ruangan }}</td>
                        <td>{{ $j->semester }}</td>
                        <td>{{ $j->tahun_akademik }}</td>
                        <td>{{ $j->jurusan }}</td>
                        <td>{{ $j->prodi }}</td>
                        <td>
                            <a href="{{ route('mahasiswa.presensi.by-jadwal', $j->id) }}" class="btn btn-sm btn-info">Lihat Presensi</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $jadwal->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jurusanFilter = document.getElementById('jurusan');
    const prodiFilter = document.getElementById('prodi');

    // Data mapping jurusan ke prodi untuk filter
    const jurusanProdiMap = {
        'Teknologi Informasi': ['TIF', 'TKK', 'MIF']
    };

    // Function untuk update filter prodi berdasarkan jurusan yang dipilih
    function updateProdiFilter() {
        const selectedJurusan = jurusanFilter.value;
        const currentProdi = prodiFilter.value;

        // Clear current options
        prodiFilter.innerHTML = '<option value="">Semua Prodi</option>';

        if (selectedJurusan && jurusanProdiMap[selectedJurusan]) {
            const prodiLabels = {
                'TIF': 'TIF - Teknik Informatika',
                'TKK': 'TKK - Teknik Komputer',
                'MIF': 'MIF - Manajemen Informatika'
            };

            jurusanProdiMap[selectedJurusan].forEach(prodi => {
                const option = document.createElement('option');
                option.value = prodi;
                option.textContent = prodiLabels[prodi];
                prodiFilter.appendChild(option);
            });
        }

        // Restore selected value if it's still valid
        if (currentProdi && jurusanProdiMap[selectedJurusan] && jurusanProdiMap[selectedJurusan].includes(currentProdi)) {
            prodiFilter.value = currentProdi;
        }
    }

    // Event listener untuk perubahan jurusan filter
    jurusanFilter.addEventListener('change', updateProdiFilter);
});
</script>
@endsection
