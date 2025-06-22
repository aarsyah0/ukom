@extends('layouts.app')
@section('title', 'Lakukan Presensi')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Presensi: {{ $jadwal->matakuliah->nama }}</h2>
                    <p class="mb-0 text-muted">{{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                </div>
                <div class="card-body">
                    <div id="location-info" class="alert alert-info">
                        <p id="location-status"><i class="fas fa-spinner fa-spin"></i> Sedang mengambil data lokasi Anda...</p>
                        <p id="location-coords" class="d-none"></p>
                        <p id="location-distance" class="d-none fw-bold"></p>
                    </div>

                    <form action="{{ route('mahasiswa.presensi.store', $jadwal->id) }}" method="POST" id="presensi-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Status Kehadiran:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-hadir" value="hadir" disabled>
                                <label class="form-check-label" for="status-hadir">Hadir</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-sakit" value="sakit">
                                <label class="form-check-label" for="status-sakit">Sakit</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-izin" value="izin">
                                <label class="form-check-label" for="status-izin">Izin</label>
                            </div>
                        </div>

                        <div id="keterangan-group" class="mb-3 d-none">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>

                        <div id="file-bukti-group" class="mb-3 d-none">
                            <label for="file_bukti" class="form-label">Upload Surat Izin/Sakit (Opsional)</label>
                            <input class="form-control" type="file" id="file_bukti" name="file_bukti">
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="submit-button" class="btn btn-primary btn-lg" disabled>Kirim Presensi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const KAMPUS_LAT = {{ $settings['kampus_lat'] ?? -6.175392 }};
    const KAMPUS_LON = {{ $settings['kampus_lon'] ?? 106.827153 }};
    const MAX_RADIUS_METER = {{ $settings['kampus_radius'] ?? 100 }};

    const locationStatus = document.getElementById('location-status');
    const locationCoords = document.getElementById('location-coords');
    const locationDistance = document.getElementById('location-distance');
    const radioHadir = document.getElementById('status-hadir');
    const submitButton = document.getElementById('submit-button');
    const form = document.getElementById('presensi-form');
    const latInput = document.getElementById('latitude');
    const lonInput = document.getElementById('longitude');

    const keteranganGroup = document.getElementById('keterangan-group');
    const fileBuktiGroup = document.getElementById('file-bukti-group');

    const statusRadios = document.querySelectorAll('input[name="status"]');

    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // Jari-jari bumi dalam meter
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        return R * c; // dalam meter
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const userLat = position.coords.latitude;
                const userLon = position.coords.longitude;

                latInput.value = userLat;
                lonInput.value = userLon;

                const distance = getDistance(KAMPUS_LAT, KAMPUS_LON, userLat, userLon);

                locationCoords.classList.remove('d-none');
                locationDistance.classList.remove('d-none');
                locationCoords.textContent = `Lokasi Anda: Lat: ${userLat.toFixed(6)}, Lon: ${userLon.toFixed(6)}`;

                if (distance <= MAX_RADIUS_METER) {
                    locationStatus.innerHTML = '<i class="fas fa-check-circle"></i> Verifikasi Lokasi Berhasil!';
                    locationStatus.parentElement.classList.replace('alert-info', 'alert-success');
                    locationDistance.textContent = `Jarak dari kampus: ${distance.toFixed(0)} meter. Anda berada dalam jangkauan.`;
                    radioHadir.disabled = false;
                } else {
                    locationStatus.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Verifikasi Lokasi Gagal!';
                    locationStatus.parentElement.classList.replace('alert-info', 'alert-warning');
                    locationDistance.textContent = `Jarak dari kampus: ${distance.toFixed(0)} meter. Anda berada di luar jangkauan. Silakan pilih status Sakit atau Izin.`;
                    radioHadir.disabled = true;
                }
            },
            function(error) {
                locationStatus.innerHTML = '<i class="fas fa-times-circle"></i> Gagal mendapatkan lokasi. Pastikan Anda mengizinkan akses lokasi.';
                locationStatus.parentElement.classList.replace('alert-info', 'alert-danger');
                console.error("Geolocation error: ", error.message);

                // Enable submit button even if location fails (for sakit/izin)
                submitButton.disabled = false;
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 60000
            }
        );
    } else {
        locationStatus.innerHTML = '<i class="fas fa-times-circle"></i> Geolocation tidak didukung oleh browser ini.';
        locationStatus.parentElement.classList.replace('alert-info', 'alert-danger');

        // Enable submit button even if geolocation not supported
        submitButton.disabled = false;
    }

    statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            submitButton.disabled = false;
            if (this.value === 'sakit' || this.value === 'izin') {
                keteranganGroup.classList.remove('d-none');
                fileBuktiGroup.classList.remove('d-none');
            } else {
                keteranganGroup.classList.add('d-none');
                fileBuktiGroup.classList.add('d-none');
            }
        });
    });
});
</script>
@endpush
