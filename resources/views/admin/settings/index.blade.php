@extends('layouts.app')
@section('title', 'Pengaturan Aplikasi')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Pengaturan Aplikasi</h2>
            <p class="text-muted">Atur parameter global untuk aplikasi di sini.</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pengaturan Lokasi Presensi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kampus_lat" class="form-label">Latitude Kampus</label>
                            <input type="text" class="form-control @error('kampus_lat') is-invalid @enderror" id="kampus_lat" name="kampus_lat" value="{{ old('kampus_lat', $settings['kampus_lat'] ?? '') }}" required>
                             @error('kampus_lat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Contoh: -6.175392 (untuk Monas)</div>
                        </div>
                        <div class="mb-3">
                            <label for="kampus_lon" class="form-label">Longitude Kampus</label>
                            <input type="text" class="form-control @error('kampus_lon') is-invalid @enderror" id="kampus_lon" name="kampus_lon" value="{{ old('kampus_lon', $settings['kampus_lon'] ?? '') }}" required>
                             @error('kampus_lon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Contoh: 106.827153 (untuk Monas)</div>
                        </div>
                        <div class="mb-3">
                            <label for="kampus_radius" class="form-label">Radius Presensi (dalam meter)</label>
                            <input type="number" class="form-control @error('kampus_radius') is-invalid @enderror" id="kampus_radius" name="kampus_radius" value="{{ old('kampus_radius', $settings['kampus_radius'] ?? '100') }}" required>
                             @error('kampus_radius')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Jarak maksimum mahasiswa bisa melakukan presensi dari titik pusat kampus.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
