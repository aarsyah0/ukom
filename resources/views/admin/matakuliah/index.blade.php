@extends('layouts.app')

@section('title', 'Kelola Mata Kuliah')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Kelola Mata Kuliah</h4>
                    <a href="{{ route('admin.matakuliah.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Mata Kuliah
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Semester</th>
                                    <th>Jurusan</th>
                                    <th>Program Studi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($matakuliah as $index => $mk)
                                <tr>
                                    <td>{{ $index + 1 + ($matakuliah->currentPage() - 1) * $matakuliah->perPage() }}</td>
                                    <td><strong>{{ $mk->kode }}</strong></td>
                                    <td>{{ $mk->nama }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $mk->sks }} SKS</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">Semester {{ $mk->semester }}</span>
                                    </td>
                                    <td>{{ $mk->jurusan }}</td>
                                    <td>{{ $mk->prodi }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.matakuliah.edit', $mk->id) }}"
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.matakuliah.destroy', $mk->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')"
                                                  style="display: inline;">
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
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-book fa-3x mb-3"></i>
                                            <p class="mb-0">Belum ada data mata kuliah</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($matakuliah->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $matakuliah->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
