<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('buku', BukuController::class);
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'kategori'])->name('buku.kategori');

    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Buku
    Route::resource('buku', BukuController::class);
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    // Rute yang perlu ditambahkan:
    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'kategori'])->name('buku.kategori');

    // Anggota
    Route::resource('anggota', AnggotaController::class);

    // Transaksi
    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
});

require __DIR__.'/auth.php';
