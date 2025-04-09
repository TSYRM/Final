<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\BookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function () {
        return Auth::user();
    });

    // Services routes
    Route::apiResource('services', ServiceController::class);

    // Bookings routes
    Route::apiResource('bookings', BookingController::class);
});

Route::middleware([
    'auth:sanctum',
    Config::get('jetstream.auth_middleware', 'inertia')
])->group(function () {
    Route::get('/dashboard', function () {
        return View::make('dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php'; 