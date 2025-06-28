<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login.form');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Dosen Management
    Route::get('dosen', [AdminController::class, 'dosenIndex'])->name('dosen.index');
    Route::get('dosen/create', [AdminController::class, 'dosenCreate'])->name('dosen.create');
    Route::post('dosen', [AdminController::class, 'dosenStore'])->name('dosen.store');
    Route::get('dosen/{id}/edit', [AdminController::class, 'dosenEdit'])->name('dosen.edit');
    Route::put('dosen/{id}', [AdminController::class, 'dosenUpdate'])->name('dosen.update');
    Route::delete('dosen/{id}', [AdminController::class, 'dosenDestroy'])->name('dosen.destroy');

    // Mahasiswa Management
    Route::get('mahasiswa', [AdminController::class, 'mahasiswaIndex'])->name('mahasiswa.index');
    Route::get('mahasiswa/create', [AdminController::class, 'mahasiswaCreate'])->name('mahasiswa.create');
    Route::post('mahasiswa', [AdminController::class, 'mahasiswaStore'])->name('mahasiswa.store');
    Route::get('mahasiswa/{id}/edit', [AdminController::class, 'mahasiswaEdit'])->name('mahasiswa.edit');
    Route::put('mahasiswa/{id}', [AdminController::class, 'mahasiswaUpdate'])->name('mahasiswa.update');
    Route::delete('mahasiswa/{id}', [AdminController::class, 'mahasiswaDestroy'])->name('mahasiswa.destroy');

    // Matakuliah Management
    Route::get('matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
    Route::get('matakuliah/create', [MatakuliahController::class, 'create'])->name('matakuliah.create');
    Route::post('matakuliah', [MatakuliahController::class, 'store'])->name('matakuliah.store');
    Route::get('matakuliah/{id}/edit', [MatakuliahController::class, 'edit'])->name('matakuliah.edit');
    Route::put('matakuliah/{id}', [MatakuliahController::class, 'update'])->name('matakuliah.update');
    Route::delete('matakuliah/{id}', [MatakuliahController::class, 'destroy'])->name('matakuliah.destroy');

    // Jadwal Management
    Route::get('jadwal', [AdminController::class, 'jadwalIndex'])->name('jadwal.index');
    Route::get('jadwal/create', [AdminController::class, 'jadwalCreate'])->name('jadwal.create');
    Route::post('jadwal', [AdminController::class, 'jadwalStore'])->name('jadwal.store');
    Route::get('jadwal/{id}/edit', [AdminController::class, 'jadwalEdit'])->name('jadwal.edit');
    Route::put('jadwal/{id}', [AdminController::class, 'jadwalUpdate'])->name('jadwal.update');
    Route::delete('jadwal/{id}', [AdminController::class, 'jadwalDestroy'])->name('jadwal.destroy');

    // Kelas Management
    Route::get('kelas', [AdminController::class, 'kelasIndex'])->name('kelas.index');
    Route::get('kelas/create', [AdminController::class, 'kelasCreate'])->name('kelas.create');
    Route::post('kelas', [AdminController::class, 'kelasStore'])->name('kelas.store');
    Route::get('kelas/{id}/edit', [AdminController::class, 'kelasEdit'])->name('kelas.edit');
    Route::put('kelas/{id}', [AdminController::class, 'kelasUpdate'])->name('kelas.update');
    Route::delete('kelas/{id}', [AdminController::class, 'kelasDestroy'])->name('kelas.destroy');

    // Presensi Report
    Route::get('presensi', [AdminController::class, 'presensiIndex'])->name('presensi.index');

    // Settings
    Route::get('settings', [AdminController::class, 'settingsIndex'])->name('settings.index');
    Route::post('settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
});

// Dosen Routes
Route::middleware(['auth.multiple:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('jadwal', [DosenController::class, 'jadwalIndex'])->name('jadwal.index');
    Route::get('presensi', [DosenController::class, 'presensiIndex'])->name('presensi.index');
    Route::get('presensi/jadwal/{jadwal}', [DosenController::class, 'presensiByJadwal'])->name('presensi.by-jadwal');
    Route::get('presensi/show/{jadwal}', [DosenController::class, 'presensiShow'])->name('presensi.show');
    Route::post('presensi/update', [DosenController::class, 'presensiUpdate'])->name('presensi.update');

    // Semester Schedule
    Route::get('jadwal-semester', [DosenController::class, 'jadwalSemester'])->name('jadwal.semester');
    Route::get('jadwal-semester/download', [DosenController::class, 'downloadJadwalSemester'])->name('jadwal.semester.download');
});

// Mahasiswa Routes
Route::middleware(['auth.multiple:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('jadwal', [MahasiswaController::class, 'jadwalIndex'])->name('jadwal.index');
    Route::get('presensi', [MahasiswaController::class, 'presensiIndex'])->name('presensi.index');
    Route::get('presensi/create/{jadwalId}', [MahasiswaController::class, 'presensiCreate'])->name('presensi.create');
    Route::post('presensi/{jadwalId}', [MahasiswaController::class, 'presensiStore'])->name('presensi.store');
    Route::get('presensi/jadwal/{jadwalId}', [MahasiswaController::class, 'presensiByJadwal'])->name('presensi.by-jadwal');

    // Semester Schedule
    Route::get('jadwal-semester', [MahasiswaController::class, 'jadwalSemester'])->name('jadwal.semester');
    Route::get('jadwal-semester/download', [MahasiswaController::class, 'downloadJadwalSemester'])->name('jadwal.semester.download');
});
