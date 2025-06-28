@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Mata Kuliah: {{ $matakuliah->nama }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.matakuliah.update', $matakuliah->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode" class="form-label">Kode Mata Kuliah</label>
                                    <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                           id="kode" name="kode" value="{{ old('kode', $matakuliah->kode) }}"
                                           placeholder="Contoh: TI101" required>
                                    @error('kode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Mata Kuliah</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                           id="nama" name="nama" value="{{ old('nama', $matakuliah->nama) }}"
                                           placeholder="Contoh: Pemrograman Dasar" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sks" class="form-label">SKS</label>
                                    <select class="form-select @error('sks') is-invalid @enderror"
                                            id="sks" name="sks" required>
                                        <option value="">Pilih SKS</option>
                                        @for($i = 1; $i <= 6; $i++)
                                            <option value="{{ $i }}" {{ old('sks', $matakuliah->sks) == $i ? 'selected' : '' }}>
                                                {{ $i }} SKS
                                            </option>
                                        @endfor
                                    </select>
                                    @error('sks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="semester" class="form-label">Semester</label>
                                    <select class="form-select @error('semester') is-invalid @enderror"
                                            id="semester" name="semester" required>
                                        <option value="">Pilih Semester</option>
                                        @for($i = 1; $i <= 8; $i++)
                                            <option value="{{ $i }}" {{ old('semester', $matakuliah->semester) == $i ? 'selected' : '' }}>
                                                Semester {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <select class="form-select @error('jurusan') is-invalid @enderror"
                                            id="jurusan" name="jurusan" required>
                                        <option value="">Pilih Jurusan</option>
                                        <option value="Teknologi Informasi" {{ old('jurusan', $matakuliah->jurusan) == 'Teknologi Informasi' ? 'selected' : '' }}>
                                            Teknologi Informasi
                                        </option>
                                    </select>
                                    @error('jurusan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <select class="form-select @error('prodi') is-invalid @enderror"
                                    id="prodi" name="prodi" required>
                                <option value="">Pilih Program Studi</option>
                                <option value="TIF" {{ old('prodi', $matakuliah->prodi) == 'TIF' ? 'selected' : '' }}>
                                    Teknik Informatika (TIF)
                                </option>
                                <option value="TKK" {{ old('prodi', $matakuliah->prodi) == 'TKK' ? 'selected' : '' }}>
                                    Teknik Komputer (TKK)
                                </option>
                                <option value="MIF" {{ old('prodi', $matakuliah->prodi) == 'MIF' ? 'selected' : '' }}>
                                    Manajemen Informatika (MIF)
                                </option>
                            </select>
                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.matakuliah.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Mata Kuliah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
