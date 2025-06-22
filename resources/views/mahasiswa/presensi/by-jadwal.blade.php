@extends('layouts.app')
@section('title', 'Presensi - ' . $jadwal->matakuliah->nama)
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Presensi - {{ $jadwal->matakuliah->nama }}</h2>
        <a href="{{ route('mahasiswa.presensi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Jadwal</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Mata Kuliah:</strong></td>
                            <td>{{ $jadwal->matakuliah->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dosen:</strong></td>
                            <td>{{ $jadwal->dosen->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hari:</strong></td>
                            <td>{{ $jadwal->hari }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Ruangan:</strong></td>
                            <td>{{ $jadwal->ruangan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Semester:</strong></td>
                            <td>{{ $jadwal->semester }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Presensi</h5>
                </div>
                <div class="card-body">
                    @if($presensi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Presensi</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presensi as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->waktu_presensi)->format('H:i:s') }}</td>
                                        <td>
                                            @if($p->status == 'hadir')
                                                <span class="badge bg-success">Hadir</span>
                                            @elseif($p->status == 'sakit')
                                                <span class="badge bg-warning">Sakit</span>
                                            @elseif($p->status == 'izin')
                                                <span class="badge bg-info">Izin</span>
                                            @else
                                                <span class="badge bg-danger">Alpha</span>
                                            @endif
                                        </td>
                                        <td>{{ $p->keterangan ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $presensi->links() }}
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data presensi untuk mata kuliah ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
