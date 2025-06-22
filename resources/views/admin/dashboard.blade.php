@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Dashboard Admin</h2>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="stats-card text-center">
                <h5><i class="fas fa-chalkboard-teacher fa-2x mb-2"></i><br>Dosen</h5>
                <h2>{{ $totalDosen }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center">
                <h5><i class="fas fa-user-graduate fa-2x mb-2"></i><br>Mahasiswa</h5>
                <h2>{{ $totalMahasiswa }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center">
                <h5><i class="fas fa-calendar-alt fa-2x mb-2"></i><br>Jadwal</h5>
                <h2>{{ $totalJadwal }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center">
                <h5><i class="fas fa-clipboard-check fa-2x mb-2"></i><br>Presensi</h5>
                <h2>{{ $totalPresensi }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
