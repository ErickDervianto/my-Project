<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\OrganizationRegistrationController;
use App\Http\Controllers\VolunteerRegistrationController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\AdminController;

// Rute Publik
Route::get('/', function () { return view('landingpage'); })->name('landingpage');
Route::get('/pendaftaran', function () { return view('pendaftaran'); })->name('pendaftaran');

// Rute Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Rute Umum Setelah Login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'superadmin') return redirect()->route('superadmin.dashboard');
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        return redirect()->route('mahasiswa.dashboard');
    })->name('dashboard');
});

// Rute Superadmin
Route::middleware(['auth', 'isSuperadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('dashboard', [SuperadminController::class, 'dashboard'])->name('dashboard');
    
    // Rute Manual untuk Kelola Admin
    Route::get('admins', [SuperadminController::class, 'adminsIndex'])->name('admins.index');
    Route::get('admins/create', [SuperadminController::class, 'adminsCreate'])->name('admins.create');
    Route::post('admins', [SuperadminController::class, 'adminsStore'])->name('admins.store');
    Route::get('admins/{admin}/edit', [SuperadminController::class, 'adminsEdit'])->name('admins.edit');
    Route::put('admins/{admin}', [SuperadminController::class, 'adminsUpdate'])->name('admins.update');
    Route::delete('admins/{admin}', [SuperadminController::class, 'adminsDestroy'])->name('admins.destroy');

    // Rute Manual untuk Kelola Organisasi
    Route::get('organizations', [SuperadminController::class, 'organizationsIndex'])->name('organizations.index');
    Route::get('organizations/create', [SuperadminController::class, 'organizationsCreate'])->name('organizations.create');
    Route::post('organizations', [SuperadminController::class, 'organizationsStore'])->name('organizations.store');
    Route::get('organizations/{organization}/edit', [SuperadminController::class, 'organizationsEdit'])->name('organizations.edit');
    Route::put('organizations/{organization}', [SuperadminController::class, 'organizationsUpdate'])->name('organizations.update');
    Route::delete('organizations/{organization}', [SuperadminController::class, 'organizationsDestroy'])->name('organizations.destroy');
});

// Rute Admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('org-registrations/{id}', [AdminController::class, 'showOrgRegistration'])->name('org_registration.show');
    Route::get('vol-registrations/{id}', [AdminController::class, 'showVolRegistration'])->name('vol_registration.show');
    Route::put('registrations/{type}/{id}/status', [AdminController::class, 'updateRegistrationStatus'])->name('registration.update');

    Route::resource('events', AdminController::class)->except(['show'])->names('events');

    Route::put('organization/status', [AdminController::class, 'toggleOrganizationStatus'])->name('organization.toggleStatus');
    Route::get('organization/edit', [AdminController::class, 'editOrganization'])->name('organization.edit');
    Route::put('organization/update', [AdminController::class, 'updateOrganization'])->name('organization.update');
});

// Rute Mahasiswa
Route::middleware(['auth', 'isMahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('profile/edit', [MahasiswaController::class, 'editProfile'])->name('profile.edit');
    Route::put('profile/update', [MahasiswaController::class, 'updateProfile'])->name('profile.update');

    Route::get('daftar-organisasi/step-1', [OrganizationRegistrationController::class, 'createStep1'])->name('org.step1');
    Route::post('daftar-organisasi/step-1', [OrganizationRegistrationController::class, 'postStep1'])->name('org.postStep1');
    Route::get('daftar-organisasi/step-2', [OrganizationRegistrationController::class, 'createStep2'])->name('org.step2');
    Route::post('daftar-organisasi/step-2', [OrganizationRegistrationController::class, 'postStep2'])->name('org.postStep2');
    Route::get('daftar-organisasi/step-3', [OrganizationRegistrationController::class, 'createStep3'])->name('org.step3');
    Route::post('daftar-organisasi/step-3', [OrganizationRegistrationController::class, 'postStep3'])->name('org.postStep3');
    Route::get('daftar-organisasi/step-4', [OrganizationRegistrationController::class, 'createStep4'])->name('org.step4');
    Route::post('daftar-organisasi/store', [OrganizationRegistrationController::class, 'store'])->name('org.store');

    Route::get('daftar-volunteer/step-1', [VolunteerRegistrationController::class, 'createStep1'])->name('vol.step1');
    Route::post('daftar-volunteer/step-1', [VolunteerRegistrationController::class, 'postStep1'])->name('vol.postStep1');
    Route::get('daftar-volunteer/step-2', [VolunteerRegistrationController::class, 'createStep2'])->name('vol.step2');
    Route::post('daftar-volunteer/step-2', [VolunteerRegistrationController::class, 'postStep2'])->name('vol.postStep2');
    Route::get('daftar-volunteer/step-3', [VolunteerRegistrationController::class, 'createStep3'])->name('vol.step3');
    Route::post('daftar-volunteer/step-3', [VolunteerRegistrationController::class, 'postStep3'])->name('vol.postStep3');
    Route::get('daftar-volunteer/step-4', [VolunteerRegistrationController::class, 'createStep4'])->name('vol.step4');
    Route::post('daftar-volunteer/store', [VolunteerRegistrationController::class, 'store'])->name('vol.store');

    Route::get('pendaftaran/{id}/detail', [MahasiswaController::class, 'showRegistrationDetail'])->name('pendaftaran.detail');

    Route::get('pendaftaran-volunteer/{id}/detail', [MahasiswaController::class, 'showVolunteerRegistrationDetail'])->name('pendaftaran_volunteer.detail');
});