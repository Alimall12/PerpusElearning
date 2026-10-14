<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\KeanggotaanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FirebaseAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Firebase OAuth callback
Route::post('/auth/firebase/callback', [FirebaseAuthController::class, 'callback']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/keanggotaan/daftar', [KeanggotaanController::class, 'create'])->name('keanggotaan.create');
    Route::post('/keanggotaan/daftar', [KeanggotaanController::class, 'store'])->name('keanggotaan.store');
});

Route::middleware(['auth', 'anggota.lengkap'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Katalog
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::get('/katalog/{buku}', [KatalogController::class, 'show'])->name('katalog.show');
    
    // Wishlist
    Route::post('/wishlist/{buku}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    
    // User borrow
    Route::post('/pinjam/{buku}', [PeminjamanController::class, 'userStore'])->name('pinjam.store');
    
    // User return
    Route::post('/peminjaman/{peminjaman}/return', [PeminjamanController::class, 'userReturn'])->name('peminjaman.return');
    
    // Reviews
    Route::post('/review/{buku}', [ReviewController::class, 'store'])->name('review.store');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    
    // Peminjaman index - accessible by all members
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    
    // Read book - accessible by borrowers
    Route::get('/baca/{buku}', [BukuController::class, 'baca'])->name('buku.baca');
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::resource('buku', BukuController::class);
        Route::resource('anggota', AnggotaController::class);
        Route::resource('peminjaman', PeminjamanController::class)->except(['index', 'show']);
    });
});

require __DIR__.'/auth.php';
