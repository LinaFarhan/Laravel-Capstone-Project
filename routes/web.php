<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\AidRequestController;
use App\Http\Controllers\Admin\DistributionController;
use App\Http\Controllers\Volunteer\VolunteerController;
use App\Http\Controllers\Volunteer\DistributionController as VolunteerDistributionController;
use App\Http\Controllers\Beneficiary\BeneficiaryController;
use App\Http\Controllers\Beneficiary\AidRequestController as BeneficiaryAidRequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

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
Route::middleware(['auth'])->group(function () {
// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Routes المصادقة (يتم إنشاؤها تلقائياً بواسطة Laravel Breeze)
require __DIR__.'/auth.php';

// Routes تتطلب تسجيل الدخول

    // لوحة التحكم العامة
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 🔐 Routes للمسؤولين فقط
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // إدارة المستخدمين
        Route::resource('users', UserController::class);

        // إدارة التبرعات
        Route::resource('donations', DonationController::class);

        // إدارة طلبات المساعدة
        Route::get('aid-requests', [AidRequestController::class, 'index'])->name('aid-requests.index');
        Route::get('aid-requests/{aidRequest}', [AidRequestController::class, 'show'])->name('aid-requests.show');
        Route::put('aid-requests/{aidRequest}/status', [AidRequestController::class, 'updateStatus'])->name('aid-requests.update-status');
        Route::delete('aid-requests/{aidRequest}', [AidRequestController::class, 'destroy'])->name('aid-requests.destroy');

        // إدارة التوزيعات
        Route::resource('distributions', DistributionController::class);
    });

    // 🔐 Routes للمتطوعين
    Route::prefix('volunteer')->name('volunteer.')->middleware(['volunteer'])->group(function () {
        Route::get('/dashboard', [VolunteerController::class, 'dashboard'])->name('dashboard');

        // إدارة توزيعات المتطوع
        Route::get('distributions', [VolunteerDistributionController::class, 'index'])->name('distributions.index');
        Route::get('distributions/{distribution}', [VolunteerDistributionController::class, 'show'])->name('distributions.show');
        Route::put('distributions/{distribution}/status', [VolunteerDistributionController::class, 'updateStatus'])->name('distributions.update-status');
    });

    // 🔐 Routes للمستفيدين
    Route::prefix('beneficiary')->name('beneficiary.')->middleware(['beneficiary'])->group(function () {
        Route::get('/dashboard', [BeneficiaryController::class, 'dashboard'])->name('dashboard');

        // إدارة طلبات مساعدة المستفيد
        Route::resource('aid-requests', BeneficiaryAidRequestController::class)->except(['destroy']);
    });

    // 👤 Profile routes (لجميع المستخدمين)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  

// Routes للصفحات العامة (لا تتطلب تسجيل الدخول)
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');


    // 🔔 Routes الإشعارات (لجميع المستخدمين)
  
Route::prefix('notifications')->name('notifications.')->middleware(['auth','notification.owner'])->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/unread', [NotificationController::class, 'unread'])->name('unread');
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
    Route::delete('/', [NotificationController::class, 'destroyAll'])->name('destroy-all');
    Route::get('/export/{format?}', [NotificationController::class, 'export'])->name('export');

    Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
     Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
       Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    
});

});