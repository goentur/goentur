<?php

use App\Http\Controllers\Pegawai\DashboardController as pd;
use App\Http\Controllers\Pegawai\SkpController as ps;
use App\Http\Controllers\Pegawai\ProfilController as pp;
use App\Http\Controllers\Pegawai\JabatanController as pj;
use App\Http\Controllers\Pegawai\KegiatanController as pk;
use App\Http\Controllers\Pegawai\VerifikasiController as pv;
use App\Http\Controllers\Opd\DashboardController as od;
use App\Http\Controllers\Admin\DashboardController as ad;
use App\Http\Controllers\LockController as lc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();
Route::post('/unlock', [lc::class, 'unlockUser'])->middleware(['auth']);
Route::middleware(['auth', 'checksession', 'role:pegawai'])->prefix('pegawai')->group(function () {
    Route::get('/dashboard', [pd::class, 'index']);

    // PROFIL & JABATAN
    Route::get('/profil', [pp::class, 'index']);
    Route::get('/jabatan', [pj::class, 'jabatanAtasan']);
    Route::get('/riwayat-jabatan', [pj::class, 'riwayatJabatan']);
    Route::post('/data-riwayat-jabatan', [pj::class, 'dataRiwayatJabatan']);

    // SKP
    Route::get('/tupoksi', [ps::class, 'tupoksi']);
    Route::post('/data-tupoksi', [ps::class, 'dataTupoksi']);
    Route::post('/simpan-tupoksi', [ps::class, 'simpanTupoksi']);
    Route::post('/hapus-tupoksi', [ps::class, 'hapusTupoksi']);
    Route::get('/periode-skp', [ps::class, 'periode']);
    Route::post('/data-periode-skp', [ps::class, 'dataPeriode']);
    Route::post('/simpan-periode-skp', [ps::class, 'simpanPeriode']);
    Route::post('/hapus-periode-skp', [ps::class, 'hapusPeriode']);
    Route::get('/skp', [ps::class, 'skp']);
    Route::post('/data-kegiatan-atasan', [ps::class, 'kegiatanAtasan']);
    Route::post('/simpan-skp', [ps::class, 'simpanSkp']);
    Route::post('/data-skp', [ps::class, 'dataSkp']);
    Route::post('/kirim-skp', [ps::class, 'kirimSkp']);
    Route::post('/cetak-skp', [ps::class, 'cetakSkp']);
    Route::post('/hapus-skp', [ps::class, 'hapusSkp']);
    Route::get('/breakdown-skp', [ps::class, 'breakdownSkp']);
    Route::post('/tampil-breakdown-skp', [ps::class, 'tampilBreakdownSkp']);
    Route::post('/simpan-breakdown-skp', [ps::class, 'simpanBreakdownSkp']);

    // KEGIATAN
    Route::get('/kegiatan-harian', [pk::class, 'kegiatanHari']);
    Route::post('/simpan-kegiatan-harian', [pk::class, 'simpanKegiatanHari']);
    Route::post('/data-kegiatan-harian', [pk::class, 'dataKegiatanHari']);
    Route::post('/data-form-kegiatan-harian', [pk::class, 'dataFormKegiatanHari']);
    Route::post('/hapus-kegiatan-harian', [pk::class, 'hapusKegiatanHari']);
    Route::get('/kegiatan-bulanan', [pk::class, 'kegiatanBulanan']);
    Route::post('/data-kegiatan-bulanan', [pk::class, 'dataKegiatanBulanan']);

    // VERIFIKASI SKP
    Route::get('/verifikasi-skp', [pv::class, 'index']);
    Route::post('/verifikasi-skp', [pv::class, 'dataPns']);
    Route::post('/lihat-data-skp', [pv::class, 'dataSKP']);
    Route::post('/proses-data-skp', [pv::class, 'prosesDataSKP']);
    // VERIFIKASI KEGIATAN
    Route::get('/verifikasi-aktivitas', [pv::class, 'aktivitas']);
    Route::post('/verifikasi-aktivitas', [pv::class, 'dataPns']);
    Route::post('/lihat-data-aktivitas', [pv::class, 'dataAktivitas']);
    Route::post('/proses-data-aktivitas', [pv::class, 'prosesDataAktivitas']);
});
Route::middleware(['auth', 'role:opd'])->prefix('opd')->group(function () {
    Route::get('/dashboard', [od::class, 'index']);
});
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [ad::class, 'index']);
});
