@extends('layouts.app')
@section('title', 'Jadwal Semester')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-0">Jadwal Mengajar Semester Ini</h2>
            <p class="text-muted">Berikut adalah seluruh jadwal mengajar Anda.</p>
        </div>
        <a href="{{ route('dosen.jadwal.semester.download', ['jadwal_id' => $selectedJadwalId, 'semester' => $selectedSemester]) }}" class="btn btn-primary">
            <i class="fas fa-download me-2"></i> Unduh Jadwal (PDF)
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('dosen.jadwal.semester') }}" method="GET">
                <div class="row g-2">
                    <div class="col-md-5">
                        <label for="jadwal_id" class="form-label">Filter Berdasarkan Kelas</label>
                        <select name="jadwal_id" id="jadwal_id" class="form-select">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelasOptions as $kelas)
                                <option value="{{ $kelas['id'] }}" @if($kelas['id'] == $selectedJadwalId) selected @endif>
                                    {{ $kelas['nama'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="semester" class="form-label">Filter Berdasarkan Semester</label>
                        <select name="semester" id="semester" class="form-select">
                            <option value="">-- Semua Semester --</option>
                            @foreach($semesterOptions as $semester)
                                <option value="{{ $semester }}" @if($semester == $selectedSemester) selected @endif>
                                    Semester {{ $semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="btn btn-info w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
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
                            <th>Semester</th>
                            <th>Ruangan</th>
                            <th>SKS</th>
                            <th>Jumlah Mahasiswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $j)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $j->hari }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</td>
                            <td>{{ $j->matakuliah->nama }}</td>
                            <td>{{ $j->semester }}</td>
                            <td>{{ $j->ruangan }}</td>
                            <td>{{ $j->matakuliah->sks }}</td>
                            <td>{{ $j->mahasiswa->count() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data jadwal yang sesuai dengan filter.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
