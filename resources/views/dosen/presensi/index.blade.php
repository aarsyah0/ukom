@extends('layouts.app')
@section('title', 'Presensi Mahasiswa')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Presensi Mahasiswa</h2>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Mata Kuliah</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($presensi as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $p->waktu_presensi->format('H:i') }}</td>
                        <td>{{ $p->mahasiswa->nama }}</td>
                        <td>{{ $p->mahasiswa->nim }}</td>
                        <td>{{ $p->jadwal->matakuliah->nama }}</td>
                        <td>
                            @if($p->status == 'hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif($p->status == 'sakit')
                                <span class="badge bg-warning text-dark">Sakit</span>
                            @elseif($p->status == 'izin')
                                <span class="badge bg-info text-dark">Izin</span>
                            @else
                                <span class="badge bg-danger">Alpha</span>
                            @endif
                        </td>
                        <td>{{ $p->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $presensi->links() }}
        </div>
    </div>
</div>
@endsection