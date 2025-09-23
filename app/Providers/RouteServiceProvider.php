<?php
// app/Providers/RouteServiceProvider.php
namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            // Routes API الإصدار 1
            Route::prefix('api/v1')
                ->middleware('api')
                ->namespace($this->namespace . '\\Api\\V1')
                ->group(base_path('routes/api_v1.php'));
        });

        // تعريف pattern للنماذج
        Route::pattern('id', '[0-9]+');
        Route::pattern('user', '[0-9]+');
        Route::pattern('donation', '[0-9]+');
        Route::pattern('aidRequest', '[0-9]+');
        Route::pattern('distribution', '[0-9]+');

        // تعريف model binding
        Route::model('user', \App\Models\User::class);
        Route::model('donation', \App\Models\Donation::class);
        Route::model('aidRequest', \App\Models\AidRequest::class);
        Route::model('distribution', \App\Models\Distribution::class);
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Rate limiting للـ API
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(1000)->by($request->user()?->id ?: $request->ip());
        });

        // Rate limiting لتسجيل الدخول
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Rate limiting لإنشاء طلبات المساعدة
        RateLimiter::for('aid-requests', function (Request $request) {
            return Limit::perHour(10)->by($request->user()?->id);
        });

        // Rate limiting لإنشاء التبرعات
        RateLimiter::for('donations', function (Request $request) {
            return Limit::perHour(5)->by($request->user()?->id);
        });
    }

    /**
     * Configure the route model bindings.
     */
    protected function configureBindings(): void
    {
        // User binding مع التحقق من الصلاحيات
        Route::bind('user', function ($value) {
            $user = \App\Models\User::findOrFail($value);
            
            if (auth()->check() && !auth()->user()->isAdmin() && auth()->id() != $user->id) {
                abort(403, 'غير مصرح بالوصول إلى هذا المستخدم');
            }
            
            return $user;
        });

        // AidRequest binding مع التحقق من الصلاحيات
        Route::bind('aidRequest', function ($value) {
            $aidRequest = \App\Models\AidRequest::findOrFail($value);
            
            if (auth()->check()) {
                if (auth()->user()->isBeneficiary() && $aidRequest->beneficiary_id != auth()->id()) {
                    abort(403, 'غير مصرح بالوصول إلى هذا الطلب');
                }
                
                if (auth()->user()->isVolunteer()) {
                    $hasAccess = $aidRequest->distributions()
                        ->where('volunteer_id', auth()->id())
                        ->exists();
                    
                    if (!$hasAccess) {
                        abort(403, 'غير مصرح بالوصول إلى هذا الطلب');
                    }
                }
            }
            
            return $aidRequest;
        });

        // Distribution binding مع التحقق من الصلاحيات
        Route::bind('distribution', function ($value) {
            $distribution = \App\Models\Distribution::findOrFail($value);
            
            if (auth()->check()) {
                if (auth()->user()->isVolunteer() && $distribution->volunteer_id != auth()->id()) {
                    abort(403, 'غير مصرح بالوصول إلى هذا التوزيع');
                }
                
                if (auth()->user()->isBeneficiary() && $distribution->beneficiary_id != auth()->id()) {
                    abort(403, 'غير مصرح بالوصول إلى هذا التوزيع');
                }
            }
            
            return $distribution;
        });
    }
}