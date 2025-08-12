<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PpdbAdminController;
use App\Http\Controllers\Client\LandingController;
use App\Http\Controllers\Client\PpdbController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\GelombangController;
use App\Http\Controllers\Admin\TokenController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\SantriController;
use App\Http\Controllers\Client\SantriProfileController;    
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== CLIENT ROUTES =====
Route::get('/', [LandingController::class, 'index'])->name('home');

// Berita
Route::get('/berita', [LandingController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [LandingController::class, 'beritaShow'])->name('berita.show');

// PPDB Routes
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/token', [PpdbController::class, 'showTokenForm'])->name('token');
    Route::post('/verify-token', [PpdbController::class, 'verifyToken'])->name('verify-token');
    Route::get('/form', [PpdbController::class, 'showForm'])->name('form');
    Route::post('/store', [PpdbController::class, 'store'])->name('store');
    Route::get('/success', [PpdbController::class, 'success'])->name('success');
});

// Santri Auth & Dashboard
Route::prefix('santri')->name('santri.')->group(function () {
    Route::middleware('guest:pendaftaran')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });
    
    Route::middleware('auth:pendaftaran')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// ===== ADMIN ROUTES COMPLETE =====
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });
    
    // Authenticated routes
    Route::middleware('auth')->group(function () {
        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // Dashboard
        Route::get('/', [DashboardAdminController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardAdminController::class, 'index']);
        
        // PPDB Management
        Route::prefix('ppdb')->name('ppdb.')->group(function () {
            Route::get('/', [PpdbAdminController::class, 'index'])->name('index');
            Route::post('/generate-tokens', [PpdbAdminController::class, 'generateTokens'])->name('generate-tokens');
            Route::get('/export-whatsapp', [PpdbAdminController::class, 'exportWhatsApp'])->name('export-whatsapp');
            Route::get('/{id}', [PpdbAdminController::class, 'show'])->name('show');
            Route::put('/{id}/status', [PpdbAdminController::class, 'updateStatus'])->name('update-status');
            Route::delete('/{id}', [PpdbAdminController::class, 'destroy'])->name('destroy');
        });
        
        // CMS Management
        Route::resource('fasilitas', FasilitasController::class);
        Route::resource('program', ProgramController::class);
        Route::resource('berita', BeritaController::class);
        
        // Tahun Ajaran & Gelombang
        Route::resource('tahun-ajaran', TahunAjaranController::class);
        Route::resource('gelombang', GelombangController::class);
        
        // Token Management
        Route::prefix('token')->name('token.')->group(function () {
            Route::get('/', [TokenController::class, 'index'])->name('index');
            Route::post('/generate', [TokenController::class, 'generate'])->name('generate');
            Route::get('/export', [TokenController::class, 'export'])->name('export');
            Route::delete('/{id}', [TokenController::class, 'destroy'])->name('destroy');
        });
    });
});
// Fallback route
Route::fallback(function () {
    return redirect()->route('home');
});