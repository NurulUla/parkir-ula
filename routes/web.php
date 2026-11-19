<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;   // DITAMBAHKAN ✨
use App\Http\Controllers\PetugasDashboardController; // DITAMBAHKAN ✨
use App\Http\Controllers\OwnerDashboardController;   // DITAMBAHKAN ✨
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| LOGIN & LOGOUT
|--------------------------------------------------------------------------
*/

// Halaman login
Route::get('/', [AuthController::class, 'showLogin'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk menangani tombol lupa kata sandi
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

/*
|--------------------------------------------------------------------------
| DASHBOARD UTAMA (Kemudi otomatis saat pertama kali login)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| MENU UTAMA KHUSUS ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // Halaman Utama/Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD User
    Route::get('/users', [AdminDashboardController::class, 'crudUser'])->name('admin.user');
    Route::post('/users', [AdminDashboardController::class, 'simpanUser'])->name('admin.user.simpan');
    Route::delete('/users/hapus/{id}', [AdminDashboardController::class, 'hapusUser'])->name('admin.user.hapus');

    // CRUD Tarif Parkir
    Route::get('/tarif', [AdminDashboardController::class, 'crudTarif'])->name('admin.tarif');

    // CRUD Area Parkir
    Route::get('/area', [AdminDashboardController::class, 'crudArea'])->name('admin.area');

    // CRUD Kendaraan
    Route::get('/kendaraan', [AdminDashboardController::class, 'crudKendaraan'])->name('admin.kendaraan');
    Route::delete('/kendaraan/hapus/{id}', [AdminDashboardController::class, 'hapusKendaraan'])->name('admin.kendaraan.hapus');

    // Log Aktivitas
    Route::get('/log', [AdminDashboardController::class, 'aksesLog'])->name('admin.log');
    Route::delete('/log/hapus/{id}', [AdminDashboardController::class, 'hapusLog'])->name('admin.log.hapus');
    Route::delete('/log/hapus-semua', [AdminDashboardController::class, 'hapusSemuaLog'])->name('admin.log.hapusSemua');
});

/*
|--------------------------------------------------------------------------
| MENU UTAMA KHUSUS PETUGAS
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')->group(function () {

    // Halaman Utama/Dashboard Petugas
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');

    // Transaksi Parkir
    Route::get('/transaksi', [PetugasDashboardController::class, 'transaksi'])->name('petugas.transaksi');
    Route::post('/transaksi', [PetugasDashboardController::class, 'simpanTransaksiMasuk'])->name('petugas.transaksi.simpan');
    Route::delete('/transaksi/hapus/{id}', [PetugasDashboardController::class, 'hapusTransaksi'])->name('petugas.transaksi.hapus');
    Route::get('/transaksi/keluar/{id}', [PetugasDashboardController::class, 'prosesKeluar'])->name('petugas.transaksi.keluar');

    // Cetak Struk
    Route::get('/cetak/{id}', [PetugasDashboardController::class, 'cetakStruk'])->name('petugas.cetak');
});

/*
|--------------------------------------------------------------------------
| MENU UTAMA KHUSUS OWNER
|--------------------------------------------------------------------------
*/
Route::prefix('owner')->group(function () {

    // Halaman Utama/Dashboard Owner
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');

    // Rekap transaksi
    Route::get('/rekap', [OwnerDashboardController::class, 'rekapLaporan'])->name('owner.rekap');
});
