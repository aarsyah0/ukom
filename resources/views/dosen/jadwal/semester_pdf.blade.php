<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Mengajar Semester</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; }
        .container { width: 100%; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { text-align: right; font-size: 9px; margin-top: 20px; position: fixed; bottom: 0; right: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Jadwal Mengajar Semester</h2>
            <p><strong>Dosen:</strong> {{ $dosen->nama }}</p>
        </div>

        <table>
            <thead>
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
                    <td>{{ $j->matakuliah->nama ?? 'N/A' }}</td>
                    <td>{{ $j->semester }}</td>
                    <td>{{ $j->ruangan }}</td>
                    <td>{{ $j->matakuliah->sks ?? 'N/A' }}</td>
                    <td>{{ $j->mahasiswa->count() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data jadwal.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
