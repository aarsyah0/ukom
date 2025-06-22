@extends('layouts.app')
@section('title', 'Manajemen Kelas')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manajemen Kelas</h2>
        <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kelas
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Filter Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.kelas.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Cari Mahasiswa</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="Nama atau NIM...">
                </div>
                <div class="col-md-2">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <select class="form-select" id="prodi" name="prodi">
                        <option value="">Semua Prodi</option>
                        @foreach($prodiList as $prodi)
                            <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                {{ $prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-select" id="semester" name="semester">
                        <option value="">Semua Semester</option>
                        @foreach($semesterList as $semester)
                            <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                                {{ $semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="dosen_id" class="form-label">Dosen</label>
                    <select class="form-select" id="dosen_id" name="dosen_id">
                        <option value="">Semua Dosen</option>
                        @foreach($dosenList as $dosen)
                            <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Pagination Info -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        Menampilkan {{ $kelas->firstItem() ?? 0 }} - {{ $kelas->lastItem() ?? 0 }}
                        dari {{ $kelas->total() }} data kelas
                    </p>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-primary">{{ $kelas->perPage() }} data per halaman</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Mahasiswa</th>
                            <th width="25%">Jadwal Mata Kuliah</th>
                            <th width="15%">Dosen</th>
                            <th width="20%">Hari & Jam</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas as $k)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() }}</td>
                            <td>
                                <strong>{{ $k->mahasiswa->nama }}</strong><br>
                                <small class="text-muted">{{ $k->mahasiswa->nim }} | {{ $k->mahasiswa->prodi }}</small>
                            </td>
                            <td>
                                <strong>{{ $k->jadwal->matakuliah->nama }}</strong><br>
                                <small class="text-muted">{{ $k->jadwal->matakuliah->kode }} | {{ $k->jadwal->semester }}</small>
                            </td>
                            <td>{{ $k->jadwal->dosen->nama }}</td>
                            <td>
                                <span class="badge bg-info">{{ $k->jadwal->hari }}</span><br>
                                <small>{{ \Carbon\Carbon::parse($k->jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($k->jadwal->jam_selesai)->format('H:i') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p class="mb-0">Belum ada data kelas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Enhanced Pagination -->
            @if($kelas->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    <small>
                        Halaman {{ $kelas->currentPage() }} dari {{ $kelas->lastPage() }}
                    </small>
                </div>

                <nav aria-label="Kelas pagination">
                    {{ $kelas->links('pagination::bootstrap-5') }}
                </nav>

                <div class="text-muted">
                    <small>
                        Total: {{ $kelas->total() }} data
                    </small>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

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

.btn-group .btn {
    margin: 0 1px;
}

@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }

    .col-md-6.text-end {
        text-align: left !important;
    }

    .row.g-3 > .col-md-2,
    .row.g-3 > .col-md-3 {
        margin-bottom: 1rem;
    }
}
</style>
@endsection
