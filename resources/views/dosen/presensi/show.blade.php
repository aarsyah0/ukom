@extends('layouts.app')
@section('title', 'Detail Kehadiran - ' . $jadwal->matakuliah->nama)
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-0">Detail Kehadiran</h2>
            <p class="text-muted">{{ $jadwal->matakuliah->nama }} - {{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
        </div>
        <a href="{{ route('dosen.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Mahasiswa ({{ $jadwal->mahasiswa->count() }} terdaftar)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th width="25%">Ubah Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal->mahasiswa as $mahasiswa)
                        @php
                            $status = $presensiStatus[$mahasiswa->id] ?? 'alpha'; // Default to alpha if no record
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mahasiswa->nim }}</td>
                            <td>{{ $mahasiswa->nama }}</td>
                            <td>
                                <form action="{{ route('dosen.presensi.update') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                                    <input type="hidden" name="mahasiswa_id" value="{{ $mahasiswa->id }}">

                                    <select name="status" class="form-select form-select-sm">
                                        <option value="hadir" @if($status == 'hadir') selected @endif>Hadir</option>
                                        <option value="sakit" @if($status == 'sakit') selected @endif>Sakit</option>
                                        <option value="izin" @if($status == 'izin') selected @endif>Izin</option>
                                        <option value="alpha" @if($status == 'alpha') selected @endif>Alpha</option>
                                    </select>

                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada mahasiswa yang terdaftar di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
