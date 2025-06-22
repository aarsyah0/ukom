# DESKRIPSI USE CASE DIAGRAM SISTEM INFORMASI AKADEMIK (SIA)

## 1. MANAJEMEN AKUN DAN AUTENTIKASI

### 1.1 Login
**Judul Use Case:** Login ke Sistem

**Aktor:** Admin, Dosen, Mahasiswa

**Deskripsi:** Pengguna memasuki sistem dengan kredensial yang valid

**Alur Utama:**
1. Pengguna membuka halaman login
2. Sistem menampilkan form login
3. Pengguna memasukkan email dan password
4. Sistem memvalidasi kredensial
5. Sistem mengarahkan ke dashboard sesuai role

**Alternatif:**
- Kredensial tidak valid: sistem menampilkan pesan error
- Akun tidak aktif: sistem menampilkan pesan akun dinonaktifkan

**Prakondisi:** Pengguna memiliki akun terdaftar di sistem

**Pasca-kondisi:** Pengguna berhasil masuk ke dashboard sesuai rolenya

### 1.2 Logout
**Judul Use Case:** Logout dari Sistem

**Aktor:** Admin, Dosen, Mahasiswa

**Deskripsi:** Pengguna keluar dari sistem dengan aman

**Alur Utama:**
1. Pengguna mengklik tombol logout
2. Sistem mengakhiri sesi pengguna
3. Sistem mengarahkan ke halaman login

**Alternatif:** Tidak ada

**Prakondisi:** Pengguna sedang login ke sistem

**Pasca-kondisi:** Sesi pengguna berakhir dan diarahkan ke halaman login

## 2. MANAJEMEN ADMIN

### 2.1 Kelola Dosen
**Judul Use Case:** Mengelola Data Dosen

**Aktor:** Admin

**Deskripsi:** Admin dapat menambah, mengedit, dan menghapus data dosen

**Alur Utama:**
1. Admin mengakses menu Kelola Dosen
2. Sistem menampilkan daftar dosen
3. Admin memilih aksi (tambah/edit/hapus)
4. Admin mengisi/mengubah data dosen
5. Sistem menyimpan perubahan

**Alternatif:**
- Data tidak valid: sistem menampilkan pesan error
- Dosen masih terkait jadwal: sistem mencegah penghapusan

**Prakondisi:** Admin sudah login ke sistem

**Pasca-kondisi:** Data dosen berhasil ditambah/diubah/dihapus

### 2.2 Kelola Mahasiswa
**Judul Use Case:** Mengelola Data Mahasiswa

**Aktor:** Admin

**Deskripsi:** Admin dapat menambah, mengedit, dan menghapus data mahasiswa

**Alur Utama:**
1. Admin mengakses menu Kelola Mahasiswa
2. Sistem menampilkan daftar mahasiswa
3. Admin memilih aksi (tambah/edit/hapus)
4. Admin mengisi/mengubah data mahasiswa
5. Sistem menyimpan perubahan

**Alternatif:**
- Data tidak valid: sistem menampilkan pesan error
- Mahasiswa masih terkait presensi: sistem mencegah penghapusan

**Prakondisi:** Admin sudah login ke sistem

**Pasca-kondisi:** Data mahasiswa berhasil ditambah/diubah/dihapus

### 2.3 Kelola Matakuliah
**Judul Use Case:** Mengelola Data Matakuliah

**Aktor:** Admin

**Deskripsi:** Admin dapat menambah, mengedit, dan menghapus data matakuliah

**Alur Utama:**
1. Admin mengakses menu Kelola Matakuliah
2. Sistem menampilkan daftar matakuliah
3. Admin memilih aksi (tambah/edit/hapus)
4. Admin mengisi/mengubah data matakuliah
5. Sistem menyimpan perubahan

**Alternatif:**
- Data tidak valid: sistem menampilkan pesan error
- Matakuliah masih terkait jadwal: sistem mencegah penghapusan

**Prakondisi:** Admin sudah login ke sistem

**Pasca-kondisi:** Data matakuliah berhasil ditambah/diubah/dihapus

### 2.4 Kelola Jadwal
**Judul Use Case:** Mengelola Jadwal Kuliah

**Aktor:** Admin

**Deskripsi:** Admin dapat menambah, mengedit, dan menghapus jadwal kuliah

**Alur Utama:**
1. Admin mengakses menu Kelola Jadwal
2. Sistem menampilkan daftar jadwal
3. Admin memilih aksi (tambah/edit/hapus)
4. Admin mengisi/mengubah data jadwal
5. Sistem menyimpan perubahan

**Alternatif:**
- Data tidak valid: sistem menampilkan pesan error
- Jadwal masih terkait kelas: sistem mencegah penghapusan

**Prakondisi:** Admin sudah login ke sistem

**Pasca-kondisi:** Data jadwal berhasil ditambah/diubah/dihapus

### 2.5 Kelola Kelas
**Judul Use Case:** Mengelola Pendaftaran Kelas

**Aktor:** Admin

**Deskripsi:** Admin dapat mendaftarkan mahasiswa ke kelas tertentu

**Alur Utama:**
1. Admin mengakses menu Kelola Kelas
2. Sistem menampilkan daftar kelas
3. Admin memilih aksi (tambah/edit/hapus)
4. Admin memilih jadwal dan mahasiswa
5. Sistem menyimpan pendaftaran

**Alternatif:**
- Mahasiswa sudah terdaftar: sistem menampilkan pesan error
- Jadwal tidak sesuai jurusan/prodi: sistem mencegah pendaftaran

**Prakondisi:** Admin sudah login ke sistem

**Pasca-kondisi:** Mahasiswa berhasil didaftarkan ke kelas

### 2.6 Lihat Presensi
**Judul Use Case:** Melihat Data Presensi

**Aktor:** Admin

**Deskripsi:** Admin dapat melihat data presensi seluruh mahasiswa

**Alur Utama:**
1. Admin mengakses menu Lihat Presensi
2. Sistem menampilkan daftar presensi
3. Admin dapat memfilter berdasarkan kriteria
4. Admin dapat melihat detail presensi

**Alternatif:** Tidak ada

**Prakondisi:** Admin sudah login ke sistem

**Pasca-kondisi:** Admin berhasil melihat data presensi

### 2.7 Kelola Pengaturan
**Judul Use Case:** Mengelola Pengaturan Sistem

**Aktor:** Admin

**Deskripsi:** Admin dapat mengatur parameter sistem

**Alur Utama:**
1. Admin mengakses menu Pengaturan
2. Sistem menampilkan form pengaturan
3. Admin mengubah nilai pengaturan
4. Sistem menyimpan perubahan

**Alternatif:**
- Data tidak valid: sistem menampilkan pesan error

**Prakondisi:** Admin sudah login ke sistem

**Pasca-kondisi:** Pengaturan sistem berhasil diubah

## 3. MANAJEMEN DOSEN

### 3.1 Lihat Jadwal Mengajar
**Judul Use Case:** Melihat Jadwal Mengajar

**Aktor:** Dosen

**Deskripsi:** Dosen dapat melihat jadwal mengajar yang diampu

**Alur Utama:**
1. Dosen mengakses menu Jadwal Mengajar
2. Sistem menampilkan jadwal mengajar dosen
3. Dosen dapat memfilter berdasarkan semester/jurusan/prodi
4. Dosen dapat melihat detail jadwal

**Alternatif:** Tidak ada

**Prakondisi:** Dosen sudah login ke sistem

**Pasca-kondisi:** Dosen berhasil melihat jadwal mengajar

### 3.2 Lihat Presensi Mahasiswa
**Judul Use Case:** Melihat Presensi Mahasiswa

**Aktor:** Dosen

**Deskripsi:** Dosen dapat melihat presensi mahasiswa di kelas yang diampu

**Alur Utama:**
1. Dosen mengakses menu Presensi
2. Sistem menampilkan daftar jadwal yang diampu
3. Dosen memilih jadwal tertentu
4. Sistem menampilkan data presensi mahasiswa
5. Dosen dapat melihat detail presensi

**Alternatif:** Tidak ada

**Prakondisi:** Dosen sudah login ke sistem

**Pasca-kondisi:** Dosen berhasil melihat presensi mahasiswa

### 3.3 Cetak Laporan Presensi
**Judul Use Case:** Mencetak Laporan Presensi

**Aktor:** Dosen

**Deskripsi:** Dosen dapat mencetak laporan presensi dalam format PDF

**Alur Utama:**
1. Dosen mengakses menu Presensi
2. Dosen memilih jadwal tertentu
3. Dosen mengklik tombol cetak
4. Sistem menghasilkan file PDF
5. Sistem menampilkan file PDF

**Alternatif:** Tidak ada

**Prakondisi:** Dosen sudah login ke sistem

**Pasca-kondisi:** Laporan presensi berhasil dicetak

## 4. MANAJEMEN MAHASISWA

### 4.1 Lihat Jadwal Kuliah
**Judul Use Case:** Melihat Jadwal Kuliah

**Aktor:** Mahasiswa

**Deskripsi:** Mahasiswa dapat melihat jadwal kuliah yang diikuti

**Alur Utama:**
1. Mahasiswa mengakses menu Jadwal Kuliah
2. Sistem menampilkan jadwal kuliah mahasiswa
3. Mahasiswa dapat memfilter berdasarkan semester
4. Mahasiswa dapat melihat detail jadwal

**Alternatif:** Tidak ada

**Prakondisi:** Mahasiswa sudah login ke sistem

**Pasca-kondisi:** Mahasiswa berhasil melihat jadwal kuliah

### 4.2 Input Presensi
**Judul Use Case:** Menginput Presensi

**Aktor:** Mahasiswa

**Deskripsi:** Mahasiswa dapat menginput presensi untuk jadwal tertentu

**Alur Utama:**
1. Mahasiswa mengakses menu Presensi
2. Sistem menampilkan jadwal yang dapat dipresensi
3. Mahasiswa memilih jadwal tertentu
4. Sistem menampilkan form presensi
5. Mahasiswa mengisi data presensi (status, keterangan, bukti)
6. Sistem memvalidasi lokasi (jika diperlukan)
7. Sistem menyimpan presensi

**Alternatif:**
- Lokasi tidak sesuai: sistem menampilkan pesan error
- Waktu presensi tidak valid: sistem menampilkan pesan error
- Data tidak lengkap: sistem menampilkan pesan error

**Prakondisi:** Mahasiswa sudah login ke sistem

**Pasca-kondisi:** Presensi berhasil disimpan

### 4.3 Lihat Riwayat Presensi
**Judul Use Case:** Melihat Riwayat Presensi

**Aktor:** Mahasiswa

**Deskripsi:** Mahasiswa dapat melihat riwayat presensi pribadi

**Alur Utama:**
1. Mahasiswa mengakses menu Presensi
2. Sistem menampilkan riwayat presensi mahasiswa
3. Mahasiswa dapat memfilter berdasarkan jadwal/tanggal
4. Mahasiswa dapat melihat detail presensi

**Alternatif:** Tidak ada

**Prakondisi:** Mahasiswa sudah login ke sistem

**Pasca-kondisi:** Mahasiswa berhasil melihat riwayat presensi

## 5. MANAJEMEN SISTEM

### 5.1 Backup Database
**Judul Use Case:** Backup Database

**Aktor:** Sistem

**Deskripsi:** Sistem melakukan backup database secara otomatis

**Alur Utama:**
1. Sistem menjalankan cron job backup
2. Sistem membuat salinan database
3. Sistem menyimpan file backup
4. Sistem mencatat log backup

**Alternatif:**
- Backup gagal: sistem mencatat error log

**Prakondisi:** Sistem berjalan normal

**Pasca-kondisi:** Database berhasil dibackup

### 5.2 Validasi Presensi Otomatis
**Judul Use Case:** Validasi Presensi Otomatis

**Aktor:** Sistem

**Deskripsi:** Sistem memvalidasi presensi berdasarkan waktu dan lokasi

**Alur Utama:**
1. Mahasiswa menginput presensi
2. Sistem memeriksa waktu presensi
3. Sistem memeriksa lokasi presensi
4. Sistem menentukan status presensi
5. Sistem menyimpan hasil validasi

**Alternatif:**
- Waktu tidak valid: sistem menandai terlambat/alpha
- Lokasi tidak valid: sistem menandai tidak hadir

**Prakondisi:** Mahasiswa menginput presensi

**Pasca-kondisi:** Presensi tervalidasi dan tersimpan

### 5.3 Generate Laporan
**Judul Use Case:** Generate Laporan

**Aktor:** Sistem

**Deskripsi:** Sistem menghasilkan laporan presensi otomatis

**Alur Utama:**
1. Sistem menerima permintaan laporan
2. Sistem mengambil data presensi
3. Sistem memproses data
4. Sistem menghasilkan format laporan
5. Sistem menampilkan/mengirim laporan

**Alternatif:**
- Data tidak ditemukan: sistem menampilkan pesan kosong

**Prakondisi:** Data presensi tersedia

**Pasca-kondisi:** Laporan berhasil dihasilkan

## 6. FITUR TAMBAHAN

### 6.1 Filter Data
**Judul Use Case:** Filter Data

**Aktor:** Admin, Dosen, Mahasiswa

**Deskripsi:** Pengguna dapat memfilter data berdasarkan kriteria tertentu

**Alur Utama:**
1. Pengguna mengakses halaman data
2. Pengguna memilih kriteria filter
3. Pengguna mengklik tombol filter
4. Sistem menampilkan data yang difilter

**Alternatif:** Tidak ada

**Prakondisi:** Data tersedia di sistem

**Pasca-kondisi:** Data ditampilkan sesuai filter

### 6.2 Export Data
**Judul Use Case:** Export Data

**Aktor:** Admin, Dosen

**Deskripsi:** Pengguna dapat mengexport data ke format tertentu

**Alur Utama:**
1. Pengguna mengakses halaman data
2. Pengguna memilih format export
3. Pengguna mengklik tombol export
4. Sistem menghasilkan file export
5. Sistem menampilkan file untuk download

**Alternatif:** Tidak ada

**Prakondisi:** Data tersedia di sistem

**Pasca-kondisi:** File export berhasil dihasilkan

### 6.3 Notifikasi Sistem
**Judul Use Case:** Notifikasi Sistem

**Aktor:** Sistem

**Deskripsi:** Sistem mengirim notifikasi kepada pengguna

**Alur Utama:**
1. Sistem mendeteksi event tertentu
2. Sistem menentukan penerima notifikasi
3. Sistem mengirim notifikasi
4. Pengguna menerima notifikasi

**Alternatif:** Tidak ada

**Prakondisi:** Event terjadi di sistem

**Pasca-kondisi:** Notifikasi berhasil dikirim

---

## KESIMPULAN

Use case diagram ini mencakup seluruh fungsionalitas sistem SIA yang meliputi:

1. **Manajemen Akun dan Autentikasi** - Login/logout untuk semua role
2. **Manajemen Admin** - CRUD untuk semua entitas utama
3. **Manajemen Dosen** - Melihat jadwal dan presensi mahasiswa
4. **Manajemen Mahasiswa** - Input dan lihat presensi pribadi
5. **Manajemen Sistem** - Backup, validasi otomatis, dan laporan
6. **Fitur Tambahan** - Filter, export, dan notifikasi

Setiap use case memiliki alur yang jelas dengan alternatif dan kondisi yang terdefinisi dengan baik, memastikan sistem dapat menangani berbagai skenario penggunaan dengan robust. 
