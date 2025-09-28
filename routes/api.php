<?php
// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Beneficiary\AidRequestController as BeneficiaryAidRequestController;
use App\Http\Controllers\Api\Volunteer\DistributionController as VolunteerDistributionController;
use App\Http\Controllers\Api\V1\StatsController;
use App\Http\Controllers\NotificationController;

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

// Routes API العامة (لا تتطلب مصادقة)
Route::get('/public/stats', function () {
    return response()->json([
        'total_donations' => \App\Models\Donation::count(),
        'total_beneficiaries_helped' => \App\Models\Distribution::where('delivery_status', 'delivered')->count(),
        'total_volunteers' => \App\Models\User::where('role', 'volunteer')->count(),
    ]);
})->name('api.public.stats');

// Routes API تتطلب مصادقة
Route::middleware(['auth:sanctum'])->group(function () {
    // Routes API للمستفيدين
    Route::prefix('beneficiary')->name('api.beneficiary.')->middleware(['beneficiary'])->group(function () {
        Route::apiResource('aid-requests', BeneficiaryAidRequestController::class);

        Route::get('profile', function (\Illuminate\Http\Request $request) {
            return response()->json($request->user());
        })->name('profile');
    });

    // Routes API للمتطوعين
    Route::prefix('volunteer')->name('api.volunteer.')->middleware(['volunteer'])->group(function () {
        Route::apiResource('distributions', VolunteerDistributionController::class)->only(['index', 'show', 'update']);

        Route::post('distributions/{distribution}/proof', [VolunteerDistributionController::class, 'updateWithProof'])
            ->name('distributions.update-proof');

        Route::get('stats', function (\Illuminate\Http\Request $request) {
            $user = $request->user();

            return response()->json([
                'total_assignments' => $user->volunteerDistributions()->count(),
                'completed_deliveries' => $user->volunteerDistributions()->where('delivery_status', 'delivered')->count(),
                'pending_deliveries' => $user->volunteerDistributions()->whereIn('delivery_status', ['assigned', 'in_progress'])->count(),
            ]);
        })->name('stats');
    });

    // Routes API للمسؤولين
    Route::prefix('admin')->name('api.admin.')->middleware(['admin'])->group(function () {
        Route::get('stats', [StatsController::class, 'index'])->name('stats');
        Route::get('activities', [StatsController::class, 'activities'])->name('activities');

        Route::get('reports/donations', function () {
            // TODO: Implement donation reports
            return response()->json(['message' => 'Donation reports endpoint']);
        })->name('reports.donations');

        Route::get('reports/distributions', function () {
            // TODO: Implement distribution reports
            return response()->json(['message' => 'Distribution reports endpoint']);
        })->name('reports.distributions');
    });

    // Routes API للإشعارات (لجميع المستخدمين)
 Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/unread', [NotificationController::class, 'unread'])->name('unread');
    Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
    Route::get('/recent', [NotificationController::class, 'recent'])->name('recent');
    Route::get('/type/{type}', [NotificationController::class, 'byType'])->name('by-type');
    Route::get('/export/{format?}', [NotificationController::class, 'export'])->name('export');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
    Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    Route::delete('/', [NotificationController::class, 'destroyAll'])->name('destroy-all');
});

    // Route للحصول على معلومات المستخدم الحالي
    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return response()->json($request->user());
    })->name('user');
});

// Fallback route للـ API
Route::fallback(function () {
    return response()->json([
        'message' => 'Endpoint not found. Please check the API documentation.',
        'documentation' => url('/api-docs')
    ], 404);
})->name('api.fallback');
