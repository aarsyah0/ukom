@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Tambah Kelas Baru</h4>
                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.kelas.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mahasiswa_id" class="form-label">Mahasiswa <span class="text-danger">*</span></label>
                                    <select class="form-select @error('mahasiswa_id') is-invalid @enderror" id="mahasiswa_id" name="mahasiswa_id" required>
                                        <option value="">Pilih Mahasiswa</option>
                                        @foreach($mahasiswa as $mhs)
                                            <option value="{{ $mhs->id }}"
                                                data-jurusan="{{ $mhs->jurusan }}"
                                                data-prodi="{{ $mhs->prodi }}"
                                                data-semester="{{ $mhs->semester }}"
                                                {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                                {{ $mhs->nama }} ({{ $mhs->nim }}) - {{ $mhs->prodi }} S{{ $mhs->semester }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mahasiswa_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jadwal_id" class="form-label">Jadwal Mata Kuliah <span class="text-danger">*</span></label>
                                    <select class="form-select @error('jadwal_id') is-invalid @enderror" id="jadwal_id" name="jadwal_id" required>
                                        <option value="">Pilih Jadwal</option>
                                        @foreach($jadwal as $jdl)
                                            <option value="{{ $jdl->id }}"
                                                data-jurusan="{{ $jdl->jurusan }}"
                                                data-prodi="{{ $jdl->prodi }}"
                                                data-semester="{{ $jdl->semester }}"
                                                {{ old('jadwal_id') == $jdl->id ? 'selected' : '' }}>
                                                {{ $jdl->matakuliah->nama }} - {{ $jdl->dosen->nama }} ({{ $jdl->hari }}, {{ \Carbon\Carbon::parse($jdl->jam_mulai)->format('H:i') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jadwal_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Information Alert -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-info-circle"></i> Informasi
                                    </h6>
                                    <p class="mb-0">
                                        Mahasiswa yang ditampilkan hanya yang memiliki <strong>jurusan</strong>, <strong>prodi</strong>, dan <strong>semester</strong> yang sama dengan jadwal yang dipilih.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jadwalSelect = document.getElementById('jadwal_id');
    const mahasiswaSelect = document.getElementById('mahasiswa_id');
    const allMahasiswaOptions = Array.from(mahasiswaSelect.options);

    function filterMahasiswa() {
        const selectedJadwal = jadwalSelect.options[jadwalSelect.selectedIndex];

        if (!selectedJadwal || selectedJadwal.value === '') {
            // Jika tidak ada jadwal yang dipilih, tampilkan semua mahasiswa
            mahasiswaSelect.innerHTML = '';
            allMahasiswaOptions.forEach(opt => {
                mahasiswaSelect.appendChild(opt.cloneNode(true));
            });
            return;
        }

        const jadwalJurusan = selectedJadwal.getAttribute('data-jurusan');
        const jadwalProdi = selectedJadwal.getAttribute('data-prodi');
        const jadwalSemester = selectedJadwal.getAttribute('data-semester');

        // Clear current options
        mahasiswaSelect.innerHTML = '';

        // Add default option
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Pilih Mahasiswa';
        mahasiswaSelect.appendChild(defaultOption);

        // Filter mahasiswa berdasarkan jurusan, prodi, dan semester yang sama
        allMahasiswaOptions.forEach(opt => {
            if (opt.value === '') return; // Skip default option

            const mhsJurusan = opt.getAttribute('data-jurusan');
            const mhsProdi = opt.getAttribute('data-prodi');
            const mhsSemester = opt.getAttribute('data-semester');

            // Cek apakah jurusan, prodi, dan semester sama
            if (mhsJurusan === jadwalJurusan &&
                mhsProdi === jadwalProdi &&
                mhsSemester === jadwalSemester) {
                mahasiswaSelect.appendChild(opt.cloneNode(true));
            }
        });

        // Jika tidak ada mahasiswa yang cocok, tampilkan pesan
        if (mahasiswaSelect.options.length === 1) {
            const noMatchOption = document.createElement('option');
            noMatchOption.value = '';
            noMatchOption.textContent = 'Tidak ada mahasiswa yang sesuai';
            noMatchOption.disabled = true;
            mahasiswaSelect.appendChild(noMatchOption);
        }
    }

    jadwalSelect.addEventListener('change', filterMahasiswa);

    // Jalankan filter saat halaman pertama kali dimuat jika jadwal sudah terpilih
    filterMahasiswa();
});
</script>

<style>
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffeaa7;
    color: #856404;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.btn {
    font-weight: 500;
}

.invalid-feedback {
    font-size: 0.875em;
}
</style>
@endsection
