<?php
// routes/api_v1.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StatsController;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Version 1 of the Humanitarian Aid Platform API
|
*/

Route::prefix('v1')->name('api.v1.')->group(function () {
    // Public endpoints
    Route::get('/stats', [StatsController::class, 'public'])->name('stats.public');
    
    // Authenticated endpoints
    Route::middleware(['auth:sanctum'])->group(function () {
        // Beneficiary endpoints
        Route::middleware(['beneficiary'])->prefix('beneficiary')->name('beneficiary.')->group(function () {
            Route::get('/stats', [StatsController::class, 'beneficiary'])->name('stats');
            Route::apiResource('aid-requests', \App\Http\Controllers\Api\Beneficiary\AidRequestController::class);
        });
        
        // Volunteer endpoints
        Route::middleware(['volunteer'])->prefix('volunteer')->name('volunteer.')->group(function () {
            Route::get('/stats', [StatsController::class, 'volunteer'])->name('stats');
            Route::apiResource('distributions', \App\Http\Controllers\Api\Volunteer\DistributionController::class);
        });
        
        // Admin endpoints
        Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/stats', [StatsController::class, 'admin'])->name('stats');
            Route::apiResource('users', \App\Http\Controllers\Admin\UserController::class);
            Route::apiResource('donations', \App\Http\Controllers\Admin\DonationController::class);
            Route::apiResource('aid-requests', \App\Http\Controllers\Admin\AidRequestController::class);
            Route::apiResource('distributions', \App\Http\Controllers\Admin\DistributionController::class);
        });
    });
});