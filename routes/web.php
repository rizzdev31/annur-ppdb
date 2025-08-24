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
use App\Http\Controllers\Admin\AdminProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ========================================
// CLIENT/PUBLIC ROUTES
// ========================================

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');

// Berita Client
Route::get('/berita', [LandingController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{slug}', [LandingController::class, 'beritaShow'])->name('berita.show');

// PPDB Client Routes (Public Registration)
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/token', [PpdbController::class, 'showTokenForm'])->name('token');
    Route::post('/verify-token', [PpdbController::class, 'verifyToken'])->name('verify-token');
    Route::get('/form', [PpdbController::class, 'showForm'])->name('form');
    Route::post('/store', [PpdbController::class, 'store'])->name('store');
    Route::get('/success', [PpdbController::class, 'success'])->name('success');
});

// Santri/Client Authentication & Dashboard
Route::prefix('santri')->name('santri.')->group(function () {
    // Routes for guests (not logged in)
    Route::middleware('guest:pendaftaran')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Routes for authenticated santri/clients
    Route::middleware('auth:pendaftaran')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::post('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// ========================================
// ADMIN ROUTES
// ========================================

Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Guest Routes (Not Logged In)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Admin Authenticated Routes
    Route::middleware('auth')->group(function () {
        
        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', [DashboardAdminController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardAdminController::class, 'index']); // Alias untuk dashboard

        // ========================================
        // ACCOUNT MANAGEMENT
        // ========================================
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

            // Client Management
            Route::prefix('client')->name('client.')->group(function () {
                // Routes WITHOUT parameters (must be defined FIRST)
                Route::get('/', [AccountManagementController::class, 'clientIndex'])->name('index');
                Route::get('/export', [AccountManagementController::class, 'clientExport'])->name('export');
                Route::get('/export-csv', [AccountManagementController::class, 'clientExportCSV'])->name('export.csv');
                
                // Routes WITH parameters (defined AFTER routes without parameters)
                Route::get('/{id}', [AccountManagementController::class, 'clientShow'])->name('show');
                Route::get('/{id}/edit', [AccountManagementController::class, 'clientEdit'])->name('edit');
                Route::put('/{id}', [AccountManagementController::class, 'clientUpdate'])->name('update');
                Route::delete('/{id}', [AccountManagementController::class, 'clientDestroy'])->name('destroy');
                Route::post('/{id}/reset-password', [AccountManagementController::class, 'clientResetPassword'])->name('reset-password');
                Route::get('/{id}/show-password', [AccountManagementController::class, 'clientShowPassword'])->name('show-password');
            });

            // Activity Logs
            Route::get('/logs', [AccountManagementController::class, 'activityLogs'])->name('logs');
        });

        // ========================================
        // ADMIN PROFILE & SETTINGS
        // ========================================
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [AdminProfileController::class, 'profile'])->name('index');
            Route::put('/', [AdminProfileController::class, 'updateProfile'])->name('update');
            Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('update-password');
        });

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [AdminProfileController::class, 'settings'])->name('index');
            Route::put('/', [AdminProfileController::class, 'updateSettings'])->name('update');
        });

        // ========================================
        // USER MANAGEMENT (SANTRI)
        // ========================================
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserManagementController::class, 'index'])->name('index');
            Route::get('/{id}', [UserManagementController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/send-login-info', [UserManagementController::class, 'sendLoginInfo'])->name('send-login-info');
        });

        // ========================================
        // PPDB MANAGEMENT
        // ========================================
        Route::prefix('ppdb')->name('ppdb.')->group(function () {
            Route::get('/', [PpdbAdminController::class, 'index'])->name('index');
            Route::post('/generate-tokens', [PpdbAdminController::class, 'generateTokens'])->name('generate-tokens');
            Route::get('/export-whatsapp', [PpdbAdminController::class, 'exportWhatsApp'])->name('export-whatsapp');
            Route::get('/{id}', [PpdbAdminController::class, 'show'])->name('show');
            Route::put('/{id}/status', [PpdbAdminController::class, 'updateStatus'])->name('update-status');
            Route::delete('/{id}', [PpdbAdminController::class, 'destroy'])->name('destroy');
        });

        // ========================================
        // CMS MANAGEMENT
        // ========================================
        
        // Fasilitas
        Route::resource('fasilitas', FasilitasController::class);
        
        // Program Unggulan
        Route::resource('program', ProgramController::class);
        
        // Ekstrakurikuler
        Route::resource('ekstrakurikuler', EkstrakurikulerController::class);
        
        // Tahapan Pendaftaran
        Route::resource('tahapan', TahapanPendaftaranController::class);
        
        // Jenjang Pendidikan
        Route::resource('jenjang', JenjangPendidikanController::class);
        
        // Berita
        Route::resource('berita', BeritaController::class);

        // ========================================
        // TAHUN AJARAN & GELOMBANG
        // ========================================
        
        // Tahun Ajaran
        Route::resource('tahun-ajaran', TahunAjaranController::class);
        
        // Gelombang
        Route::resource('gelombang', GelombangController::class);

        // ========================================
        // TOKEN MANAGEMENT
        // ========================================
        Route::prefix('token')->name('token.')->group(function () {
            Route::get('/', [TokenController::class, 'index'])->name('index');
            Route::post('/generate', [TokenController::class, 'generate'])->name('generate');
            Route::get('/export', [TokenController::class, 'export'])->name('export');
            Route::delete('/{id}', [TokenController::class, 'destroy'])->name('destroy');
        });
    });
});

// ========================================
// FALLBACK ROUTE
// ========================================
Route::fallback(function () {
    return redirect()->route('home');
});