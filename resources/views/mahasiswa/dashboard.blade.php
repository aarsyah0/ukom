@extends('layouts.app')
@section('title', 'Dashboard Mahasiswa')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Dashboard Mahasiswa</h2>

    <!-- Informasi Mahasiswa -->
    @php
        $mahasiswa = Auth::guard('mahasiswa')->user();
    @endphp
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informasi Mahasiswa</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>NIM:</strong> {{ $mahasiswa->nim }}
                </div>
                <div class="col-md-3">
                    <strong>Nama:</strong> {{ $mahasiswa->nama }}
                </div>
                <div class="col-md-3">
                    <strong>Jurusan:</strong> {{ $mahasiswa->jurusan }}
                </div>
                <div class="col-md-3">
                    <strong>Program Studi:</strong> {{ $mahasiswa->prodi }}
                </div>
            </div>
        </div>
    </div>

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
        <div class="card-header">Jadwal Hari Ini ({{ $mahasiswa->jurusan }} - {{ $mahasiswa->prodi }})</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                        <th>Jurusan</th>
                        <th>Prodi</th>
                        <th>Status Presensi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalHariIni as $j)
                    <tr>
                        <td>{{ $j->matakuliah->nama }}</td>
                        <td>{{ $j->dosen->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
                        <td>{{ $j->ruangan }}</td>
                        <td>{{ $j->jurusan }}</td>
                        <td>{{ $j->prodi }}</td>
                        <td>
                            @if($j->presensi->isNotEmpty())
                                <span class="badge bg-success">Sudah Presensi</span>
                            @else
                                <span class="badge bg-danger">Belum Presensi</span>
                            @endif
                        </td>
                        <td>
                            @if($j->presensi->isEmpty())
                                <a href="{{ route('mahasiswa.presensi.create', $j->id) }}" class="btn btn-sm btn-primary">Presensi</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">Tidak ada jadwal hari ini</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
