<?php
 
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // المسؤول يمكنه رؤية جميع المستخدمين
        return $user->isAdmin();
    }

    public function view(User $user, User $model)
    {
        // المسؤول يمكنه رؤية أي مستخدم
        // المستخدم يمكنه رؤية ملفه الشخصي
        return $user->isAdmin() || $user->id === $model->id;
    }

    public function create(User $user)
    {
        // فقط المسؤول يمكنه إنشاء مستخدمين
        return $user->isAdmin();
    }

    public function update(User $user, User $model)
    {
        // المسؤول يمكنه تعديل أي مستخدم
        // المستخدم يمكنه تعديل ملفه الشخصي
        return $user->isAdmin() || $user->id === $model->id;
    }

    public function delete(User $user, User $model)
    {
        // المسؤول يمكنه حذف أي مستخدم (ما عدا نفسه)
        return $user->isAdmin() && $user->id !== $model->id;
    }

    public function changeRole(User $user)
    {
        // فقط المسؤول يمكنه تغيير أدوار المستخدمين
        return $user->isAdmin();
    }

    public function viewDashboard(User $user)
    {
        // كل المستخدمين المسجلين يمكنهم رؤية dashboard
        return true;
    }
}