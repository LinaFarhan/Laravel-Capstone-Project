<?php
 
namespace App\Policies;

use App\Models\User;
use App\Models\Donation;
use Illuminate\Auth\Access\HandlesAuthorization;

class DonationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // المسؤول والمتطوع يمكنهم رؤية التبرعات
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function view(User $user, Donation $donation)
    {
        // المسؤول يمكنه رؤية أي تبرع
        return $user->isAdmin();
    }

    public function create(User $user)
    {
        // فقط المسؤول يمكنه إضافة تبرعات
        return $user->isAdmin();
    }

    public function update(User $user, Donation $donation)
    {
        // فقط المسؤول يمكنه تعديل التبرعات
        return $user->isAdmin();
    }

    public function delete(User $user, Donation $donation)
    {
        // فقط المسؤول يمكنه حذف التبرعات
        return $user->isAdmin();
    }

    public function distribute(User $user, Donation $donation)
    {
        // المسؤول يمكنه توزيع أي تبرع
        // المتطوع يمكنه توزيع التبرعات المخصصة له
        return $user->isAdmin() || 
               ($user->isVolunteer() && $donation->status === 'assigned');
    }
}