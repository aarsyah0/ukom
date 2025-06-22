@extends('layouts.app')
@section('title', 'Dashboard Dosen')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Dashboard Dosen</h2>

    <!-- Jurusan dan Prodi Info -->
    @if($jurusanList->count() > 0 || $prodiList->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informasi Jurusan & Program Studi</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @if($jurusanList->count() > 0)
                <div class="col-md-6">
                    <h6>Jurusan yang Diampu:</h6>
                    <ul class="list-unstyled">
                        @foreach($jurusanList as $jurusan)
                            <li><i class="fas fa-graduation-cap text-primary"></i> {{ $jurusan }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if($prodiList->count() > 0)
                <div class="col-md-6">
                    <h6>Program Studi yang Diampu:</h6>
                    <ul class="list-unstyled">
                        @foreach($prodiList as $prodi)
                            <li><i class="fas fa-book text-success"></i> {{ $prodi }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="stats-card text-center">
                <h5><i class="fas fa-calendar-alt fa-2x mb-2"></i><br>Total Jadwal</h5>
                <h2>{{ $totalJadwal }}</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stats-card text-center">
                <h5><i class="fas fa-clipboard-check fa-2x mb-2"></i><br>Total Presensi</h5>
                <h2>{{ $totalPresensi }}</h2>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Jadwal Hari Ini</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Mata Kuliah</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        <th>Total Hadir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalHariIni as $j)
                    <tr>
                        <td>{{ $j->matakuliah->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
                        <td>{{ $j->ruangan }}</td>
                        <td>{{ $j->jurusan }}</td>
                        <td>{{ $j->prodi }}</td>
                        <td>{{ $j->presensi->count() }} Mahasiswa</td>
                        <td>
                            <a href="{{ route('dosen.presensi.show', $j->id) }}" class="btn btn-sm btn-info">Lihat Kehadiran</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Tidak ada jadwal hari ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
