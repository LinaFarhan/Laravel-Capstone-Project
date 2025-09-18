<?php
 
namespace App\Policies;

use App\Models\User;
use App\Models\AidRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class AidRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // المسؤول والمتطوع يمكنهم رؤية جميع الطلبات
        return $user->isAdmin() || $user->isVolunteer();
    }

    public function view(User $user, AidRequest $aidRequest)
    {
        // المسؤول يمكنه رؤية أي طلب
        if ($user->isAdmin()) {
            return true;
        }

        // المتطوع يمكنه رؤية الطلبات المرتبطة بتوزيعاته
        if ($user->isVolunteer()) {
            return $user->volunteerDistributions()
                ->where('aid_request_id', $aidRequest->id)
                ->exists();
        }

        // المستفيد يمكنه رؤية طلباته فقط
        if ($user->isBeneficiary()) {
            return $aidRequest->beneficiary_id === $user->id;
        }

        return false;
    }

    public function create(User $user)
    {
        // فقط المستفيدون يمكنهم إنشاء طلبات مساعدة
        return $user->isBeneficiary();
    }

    public function update(User $user, AidRequest $aidRequest)
    {
        // المسؤول يمكنه تعديل أي طلب
        if ($user->isAdmin()) {
            return true;
        }

        // المستفيد يمكنه تعديل طلباته فقط إذا كانت pending
        if ($user->isBeneficiary() && $aidRequest->beneficiary_id === $user->id) {
            return $aidRequest->status === 'pending';
        }

        return false;
    }

    public function delete(User $user, AidRequest $aidRequest)
    {
        // فقط المسؤول يمكنه حذف الطلبات
        return $user->isAdmin();
    }

    public function approve(User $user)
    {
        // فقط المسؤول يمكنه الموافقة على الطلبات
        return $user->isAdmin();
    }

    public function deny(User $user)
    {
        // فقط المسؤول يمكنه رفض الطلبات
        return $user->isAdmin();
    }
}