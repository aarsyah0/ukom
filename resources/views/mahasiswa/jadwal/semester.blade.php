@extends('layouts.app')
@section('title', 'Jadwal Semester')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-0">Jadwal Semester Ini</h2>
            <p class="text-muted">Berikut adalah seluruh jadwal Anda untuk semester ini.</p>
        </div>
        <a href="{{ route('mahasiswa.jadwal.semester.download') }}" class="btn btn-primary">
            <i class="fas fa-download me-2"></i> Unduh Jadwal (PDF)
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Ruangan</th>
                            <th>SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $j)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $j->hari }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
                            <td>{{ $j->matakuliah->nama }}</td>
                            <td>{{ $j->dosen->nama }}</td>
                            <td>{{ $j->ruangan }}</td>
                            <td>{{ $j->matakuliah->sks }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Anda belum memiliki jadwal untuk semester ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
