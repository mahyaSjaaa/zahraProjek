<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IkanController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\PreventBackHistory;

// ===================
// Beranda umum
// ===================
Route::get('/', function () {
    return view('home');
})->name('home');

// ===================
// Auth (tanpa auth middleware)
// ===================
Route::middleware([PreventBackHistory::class])->group(function () {
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->middleware('guest')
        ->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('guest')
        ->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->middleware('guest')
        ->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('guest')
        ->name('register.post');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});

// ===================
// Admin (auth + admin + prevent-back-history)
// ===================
Route::middleware(['auth', 'admin', PreventBackHistory::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('admin.ikan.index');
        })->name('home');

        Route::resource('ikan', IkanController::class)->except(['show']);
    });

// ===================
// Katalog (boleh tanpa login)
// ===================
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{ikan}', [KatalogController::class, 'show'])->name('katalog.show');

// ===================
// Route setelah login
// ===================
Route::middleware(['auth', PreventBackHistory::class])->group(function () {

    // Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{ikan}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/update/{ikan}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{ikan}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::delete('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan'])->name('keranjang.kosongkan');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/sukses/{transaksi}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Transaksi & struk
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/cetak', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');
    Route::get('/transaksi/{transaksi}/struk-pdf', [TransaksiController::class, 'strukPdf'])->name('transaksi.struk_pdf');
    Route::get('/transaksi/{transaksi}/struk', [TransaksiController::class, 'strukHtml'])->name('transaksi.struk');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
