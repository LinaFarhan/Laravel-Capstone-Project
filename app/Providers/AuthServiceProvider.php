<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\AidRequest;
use App\Models\Donation;
use App\Models\Distribution;
use App\Policies\AidRequestPolicy;
use App\Policies\DonationPolicy;
use App\Policies\DistributionPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     *    
     */
    protected $policies = [
        AidRequest::class => AidRequestPolicy::class,
        Donation::class => DonationPolicy::class,
        Distribution::class => DistributionPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * تسجيل أي خدمات مصادقة / تفويض.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // تعريف الـ Gates للصلاحيات العامة
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-donations', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-distributions', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('view-reports', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('request-aid', function (User $user) {
            return $user->isBeneficiary();
        });

        Gate::define('deliver-aid', function (User $user) {
            return $user->isVolunteer();
        });

        // Gates للتحقق من الأدوار
        Gate::define('is-admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('is-volunteer', function (User $user) {
            return $user->isVolunteer();
        });

        Gate::define('is-beneficiary', function (User $user) {
            return $user->isBeneficiary();
        });

        // Gates للتحقق من حالة المستخدم
        Gate::define('has-completed-profile', function (User $user) {
            return !empty($user->phone) && !empty($user->address);
        });

        Gate::define('can-upload-documents', function (User $user) {
            return $user->isBeneficiary();
        });
    }
}
