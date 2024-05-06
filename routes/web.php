<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Guest\DashboardController as GuestDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SliderController;
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

// # Rotte pubbliche
Route::get('/', [GuestDashboardController::class, 'index'])->name('home');

Route::get('/get-image-urls', [SliderController::class, 'getImageUrls']);

// # Rotte protette
Route::middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('apartments', ApartmentController::class);

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

require __DIR__ . '/auth.php';
