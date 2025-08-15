<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PpdbAdminController;
use App\Http\Controllers\Client\LandingController;
use App\Http\Controllers\Client\PpdbController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\EkstrakurikulerController;
use App\Http\Controllers\Admin\TahapanPendaftaranController;
use App\Http\Controllers\Admin\JenjangPendidikanController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\GelombangController;
use App\Http\Controllers\Admin\TokenController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\SantriController;
use App\Http\Controllers\Client\SantriProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AccountManagementController;
use App\Http\Controllers\Admin\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

// ===== CLIENT ROUTES =====
Route::get('/', [LandingController::class, 'index'])->name('home');

// Berita Client
Route::get('/berita', [LandingController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [LandingController::class, 'beritaShow'])->name('berita.show');

// PPDB Client Routes
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/token', [PpdbController::class, 'showTokenForm'])->name('token');
    Route::post('/verify-token', [PpdbController::class, 'verifyToken'])->name('verify-token');
    Route::get('/form', [PpdbController::class, 'showForm'])->name('form');
    Route::post('/store', [PpdbController::class, 'store'])->name('store');
    Route::get('/success', [PpdbController::class, 'success'])->name('success');
});

// Santri Auth & Dashboard
Route::prefix('santri')->name('santri.')->group(function () {
    // Routes for guests (not logged in)
    Route::middleware('guest:pendaftaran')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Routes for authenticated users
    Route::middleware('auth:pendaftaran')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::post('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// ===== ADMIN ROUTES =====
Route::prefix('admin')->name('admin.')->group(function () {

    // Rute untuk admin yang belum login (Guest)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Rute untuk admin yang sudah login (Authenticated)
    Route::middleware('auth')->group(function () {
        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', [DashboardAdminController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardAdminController::class, 'index']); // Alias untuk dashboard

        // Account Management Routes
        Route::prefix('accounts')->name('accounts.')->group(function () {
            // Dashboard
            Route::get('/', [AccountManagementController::class, 'dashboard'])->name('dashboard');

            // Admin Management
            Route::prefix('admin')->name('admin.')->group(function () {
                Route::get('/', [AccountManagementController::class, 'adminIndex'])->name('index');
                Route::get('/create', [AccountManagementController::class, 'adminCreate'])->name('create');
                Route::post('/', [AccountManagementController::class, 'adminStore'])->name('store');
                Route::get('/{id}', [AccountManagementController::class, 'adminShow'])->name('show');
                Route::get('/{id}/edit', [AccountManagementController::class, 'adminEdit'])->name('edit');
                Route::put('/{id}', [AccountManagementController::class, 'adminUpdate'])->name('update');
                Route::delete('/{id}', [AccountManagementController::class, 'adminDestroy'])->name('destroy');
                Route::post('/{id}/toggle-status', [AccountManagementController::class, 'adminToggleStatus'])->name('toggle-status');
            });

            // Client Management Routes
            Route::prefix('client')->name('client.')->group(function () {
                Route::get('/', [AccountManagementController::class, 'clientIndex'])->name('index');
                Route::get('/{id}', [AccountManagementController::class, 'clientShow'])->name('show');
                Route::get('/{id}/edit', [AccountManagementController::class, 'clientEdit'])->name('edit');
                Route::put('/{id}', [AccountManagementController::class, 'clientUpdate'])->name('update');
                Route::delete('/{id}', [AccountManagementController::class, 'clientDestroy'])->name('destroy');
                Route::post('/{id}/reset-password', [AccountManagementController::class, 'clientResetPassword'])->name('reset-password');
                Route::get('/{id}/show-password', [AccountManagementController::class, 'clientShowPassword'])->name('show-password');
                Route::get('/export', [AccountManagementController::class, 'clientExport'])->name('export');
                Route::get('/export-csv', [AccountManagementController::class, 'clientExportCSV'])->name('export.csv');
            });

            // Activity Logs
            Route::get('/logs', [AccountManagementController::class, 'activityLogs'])->name('logs');
        });

        // User Management (Santri)
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/{id}', [UserManagementController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/send-login-info', [UserManagementController::class, 'sendLoginInfo'])->name('send-login-info');
        });

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
        Route::resource('ekstrakurikuler', EkstrakurikulerController::class);
        Route::resource('tahapan', TahapanPendaftaranController::class);
        Route::resource('jenjang', JenjangPendidikanController::class);
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