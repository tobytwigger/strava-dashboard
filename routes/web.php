<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StravaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard/{team_slug}', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('connect', [StravaController::class, 'index'])->name('strava.connect');
    Route::get('strava/logs', [\App\Http\Controllers\StravaConnectionLogController::class, 'index'])->name('strava.logs');
    Route::get('strava/sync', [\App\Http\Controllers\ClubSyncronisationController::class, 'index'])->name('strava.sync');

    Route::prefix('strava')->group(function() {
        Route::get('login', [StravaController::class, 'login'])->name('strava.login');
        Route::get('callback', [StravaController::class, 'callback'])->name('strava.callback');
    });

});
