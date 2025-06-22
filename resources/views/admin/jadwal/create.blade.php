@extends('layouts.app')
@section('title', 'Tambah Jadwal')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Tambah Jadwal</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="dosen_id" class="form-label">Dosen</label>
                    <select class="form-select @error('dosen_id') is-invalid @enderror" id="dosen_id" name="dosen_id" required>
                        <option value="">Pilih Dosen</option>
                        @foreach($dosen as $d)
                            <option value="{{ $d->id }}" {{ old('dosen_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->nama }} ({{ $d->nip }})
                            </option>
                        @endforeach
                    </select>
                    @error('dosen_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                    <select class="form-select @error('matakuliah_id') is-invalid @enderror" id="matakuliah_id" name="matakuliah_id" required>
                        <option value="">Pilih Mata Kuliah</option>
                        @foreach($matakuliah as $mk)
                            <option value="{{ $mk->id }}" {{ old('matakuliah_id') == $mk->id ? 'selected' : '' }}>
                                {{ $mk->nama }} ({{ $mk->kode }})
                            </option>
                        @endforeach
                    </select>
                    @error('matakuliah_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <select class="form-select @error('hari') is-invalid @enderror" id="hari" name="hari" required>
                        <option value="">Pilih Hari</option>
                        <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                    </select>
                    @error('hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                    @error('jam_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                    @error('jam_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="ruangan" class="form-label">Ruangan</label>
                    <input type="text" class="form-control @error('ruangan') is-invalid @enderror" id="ruangan" name="ruangan" value="{{ old('ruangan') }}" placeholder="Contoh: A101, Lab 1" required>
                    @error('ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                        <option value="">Pilih Semester</option>
                        <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                        <option value="3" {{ old('semester') == '3' ? 'selected' : '' }}>Semester 3</option>
                        <option value="4" {{ old('semester') == '4' ? 'selected' : '' }}>Semester 4</option>
                        <option value="5" {{ old('semester') == '5' ? 'selected' : '' }}>Semester 5</option>
                        <option value="6" {{ old('semester') == '6' ? 'selected' : '' }}>Semester 6</option>
                        <option value="7" {{ old('semester') == '7' ? 'selected' : '' }}>Semester 7</option>
                        <option value="8" {{ old('semester') == '8' ? 'selected' : '' }}>Semester 8</option>
                    </select>
                    @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                    <input type="text" class="form-control @error('tahun_akademik') is-invalid @enderror" id="tahun_akademik" name="tahun_akademik" value="{{ old('tahun_akademik') }}" placeholder="Contoh: 2023/2024" required>
                    @error('tahun_akademik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" required>
                        <option value="">Pilih Jurusan</option>
                        <option value="Teknologi Informasi" {{ old('jurusan') == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                    </select>
                    @error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi (Prodi)</label>
                    <select class="form-select @error('prodi') is-invalid @enderror" id="prodi" name="prodi" required>
                        <option value="">Pilih Program Studi</option>
                        <option value="TIF" {{ old('prodi') == 'TIF' ? 'selected' : '' }}>TIF - Teknik Informatika</option>
                        <option value="TKK" {{ old('prodi') == 'TKK' ? 'selected' : '' }}>TKK - Teknik Komputer</option>
                        <option value="MIF" {{ old('prodi') == 'MIF' ? 'selected' : '' }}>MIF - Manajemen Informatika</option>
                    </select>
                    @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input @error('aktif') is-invalid @enderror" type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif') ? 'checked' : '' }}>
                        <label class="form-check-label" for="aktif">
                            Jadwal Aktif
                        </label>
                        @error('aktif')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="form-text text-muted">Centang jika jadwal ini aktif dan dapat digunakan untuk presensi</small>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jurusanSelect = document.getElementById('jurusan');
    const prodiSelect = document.getElementById('prodi');

    // Data mapping jurusan ke prodi
    const jurusanProdiMap = {
        'Teknologi Informasi': ['TIF', 'TKK', 'MIF']
    };

    // Function untuk update dropdown prodi berdasarkan jurusan yang dipilih
    function updateProdiOptions() {
        const selectedJurusan = jurusanSelect.value;
        prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

        if (selectedJurusan && jurusanProdiMap[selectedJurusan]) {
            const prodiLabels = {
                'TIF': 'TIF - Teknik Informatika',
                'TKK': 'TKK - Teknik Komputer',
                'MIF': 'MIF - Manajemen Informatika'
            };

            jurusanProdiMap[selectedJurusan].forEach(prodi => {
                const option = document.createElement('option');
                option.value = prodi;
                option.textContent = prodiLabels[prodi];
                prodiSelect.appendChild(option);
            });
        }
    }

    // Event listener untuk perubahan jurusan
    jurusanSelect.addEventListener('change', updateProdiOptions);

    // Initialize prodi options if jurusan is already selected (for form validation errors)
    if (jurusanSelect.value) {
        updateProdiOptions();
        prodiSelect.value = '{{ old("prodi") }}';
    }
});
</script>
@endsection
