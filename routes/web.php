<?php

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
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// صفحات عامة (بدون تسجيل دخول)
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/faq', fn() => view('faq'))->name('faq');

Route::get('/register/choose', function () {
    return view('auth.choose');
})->name('register.choose');

// Routes المصادقة (Laravel Breeze أو Fortify أو Jetstream)
require __DIR__.'/auth.php';

// Routes تتطلب تسجيل الدخول
Route::middleware(['auth'])->group(function () {

    // لوحة التحكم العامة
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // 🔐 Routes للمسؤولين فقط
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('users', UserController::class);
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
        Route::get('distributions', [VolunteerDistributionController::class, 'index'])->name('distributions.index');
        Route::get('distributions/{distribution}', [VolunteerDistributionController::class, 'show'])->name('distributions.show');
        Route::put('distributions/{distribution}/status', [VolunteerDistributionController::class, 'updateStatus'])->name('distributions.update-status');
    });

    // 🔐 Routes للمستفيدينBeneficiary
    Route::prefix('beneficiary')->name('beneficiary.')->middleware(['beneficiary'])->group(function () {
        Route::get('/dashboard', [BeneficiaryController::class, 'dashboard'])->name('dashboard');
        Route::resource('aid-requests', BeneficiaryAidRequestController::class)->except(['destroy']);
    });

    // 👤 Profile routes (لجميع المستخدمين)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔔 الإشعارات (لجميع المستخدمين)
    Route::prefix('notifications')->name('notifications.')->middleware(['notification.owner'])->group(function () {
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

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->middleware('guest')->name('password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.update');

 
  // الفورم يرسل مباشرة
Route::post('forgot-password', [PasswordResetLinkController::class, 'storeDirect'])->middleware('guest')->name('password.email');
