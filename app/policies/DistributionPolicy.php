<?php
 
namespace App\Policies;

use App\Models\User;
use App\Models\Distribution;
use Illuminate\Auth\Access\HandlesAuthorization;

class DistributionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // الجميع يمكنهم رؤية التوزيعات (مع قيود في العرض)
        return true;
    }

    public function view(User $user, Distribution $distribution)
    {
        // المسؤول يمكنه رؤية أي توزيع
        if ($user->isAdmin()) {
            return true;
        }

        // المتطوع يمكنه رؤية توزيعاته فقط
        if ($user->isVolunteer()) {
            return $distribution->volunteer_id === $user->id;
        }

        // المستفيد يمكنه رؤية توزيعاته فقط
        if ($user->isBeneficiary()) {
            return $distribution->beneficiary_id === $user->id;
        }

        return false;
    }

    public function create(User $user)
    {
        // فقط المسؤول يمكنه إنشاء توزيعات
        return $user->isAdmin();
    }

    public function update(User $user, Distribution $distribution)
    {
        // المسؤول يمكنه تعديل أي توزيع
        if ($user->isAdmin()) {
            return true;
        }

        // المتطوع يمكنه تحديث حالة توزيعاته فقط
        if ($user->isVolunteer()) {
            return $distribution->volunteer_id === $user->id;
        }

        return false;
    }

    public function delete(User $user, Distribution $distribution)
    {
        // فقط المسؤول يمكنه حذف التوزيعات
        return $user->isAdmin();
    }

    public function markDelivered(User $user, Distribution $distribution)
    {
        // المتطوع يمكنه标记 التسليم لتوزيعاته
        if ($user->isVolunteer()) {
            return $distribution->volunteer_id === $user->id;
        }

        return false;
    }
}