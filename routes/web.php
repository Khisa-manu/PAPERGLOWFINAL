<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppCatalogController;
use App\Http\Controllers\BrandingController;
use App\Http\Controllers\DashboardController;
use App\Livewire\ChamaManager;
use App\Livewire\ClinicOpdQueue;
use App\Livewire\SchoolFeesLedger;
use App\Livewire\PropertyManagerHub;
use App\Livewire\InvoiceGenerator;

/*
|--------------------------------------------------------------------------
| Paperglow Web Routes (Laravel 11 + Blade + Livewire 3 + PHP 8.3)
| DirectAdmin / Shujaa Host Production Stack
|--------------------------------------------------------------------------
*/

// Section 1-7: Paperglow Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Applications Suite Catalog & Detail
Route::get('/apps', [AppCatalogController::class, 'index'])->name('apps.catalog');
Route::get('/apps/{slug}', [AppCatalogController::class, 'show'])->name('apps.show');

// Custom Physical Branding & Uniforms
Route::get('/branding', [BrandingController::class, 'index'])->name('branding');

// Client SSO Portal Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Livewire 3 Monolith Interactive Workspaces (Zero Node.js in Production)
Route::prefix('workspace')->group(function () {
    Route::get('/chama', ChamaManager::class)->name('apps.chama');
    Route::get('/clinic', ClinicOpdQueue::class)->name('apps.clinic');
    Route::get('/school', SchoolFeesLedger::class)->name('apps.school');
    Route::get('/property', PropertyManagerHub::class)->name('apps.property');
    Route::get('/invoice', InvoiceGenerator::class)->name('apps.invoice');
});
