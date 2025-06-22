@extends('layouts.app')
@section('title', 'Data Mahasiswa')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Mahasiswa</h2>
        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Mahasiswa</a>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        <th>Semester</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswa as $m)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->nama }}</td>
                        <td>{{ $m->email }}</td>
                        <td>{{ $m->jurusan }}</td>
                        <td>{{ $m->prodi }}</td>
                        <td>{{ $m->semester }}</td>
                        <td>{{ $m->no_hp }}</td>
                        <td>{{ $m->alamat }}</td>
                        <td>
                            <a href="{{ route('admin.mahasiswa.edit', $m->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.mahasiswa.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $mahasiswa->links() }}
        </div>
    </div>
</div>
@endsection
