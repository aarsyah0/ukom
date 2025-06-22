@extends('layouts.app')
@section('title', 'Data Jadwal')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Jadwal</h2>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Jadwal</a>
    </div>

    <!-- Filter Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.jadwal.index') }}" class="row g-3">
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
                    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Reset</a>
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
                        <th>Dosen</th>
                        <th>Mata Kuliah</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                        <th>Semester</th>
                        <th>Tahun Akademik</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwal as $j)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $j->dosen->nama }}</td>
                        <td>{{ $j->matakuliah->nama }}</td>
                        <td>{{ $j->hari }}</td>
                        <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                        <td>{{ $j->ruangan }}</td>
                        <td>{{ $j->semester }}</td>
                        <td>{{ $j->tahun_akademik }}</td>
                        <td>{{ $j->jurusan }}</td>
                        <td>{{ $j->prodi }}</td>
                        <td>
                            @if($j->aktif)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Info & Controls -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    <small>
                        Menampilkan {{ $jadwal->firstItem() ?? 0 }} - {{ $jadwal->lastItem() ?? 0 }} dari {{ $jadwal->total() }} data jadwal
                    </small>
                </div>
                <nav aria-label="Jadwal pagination">
                    {{ $jadwal->links('pagination::bootstrap-5') }}
                </nav>
                <div class="text-muted">
                    <small>
                        Halaman {{ $jadwal->currentPage() }} dari {{ $jadwal->lastPage() }}
                    </small>
                </div>
            </div>
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

<style>
.pagination {
    margin-bottom: 0;
}
.page-link {
    color: #007bff;
    border-color: #dee2e6;
}
.page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}
.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
}
.table th {
    vertical-align: middle;
    font-weight: 600;
}
.badge {
    font-size: 0.75em;
}
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endsection
