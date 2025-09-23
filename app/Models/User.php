<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\DatabaseNotification;
class User extends Authenticatable
{


    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'document_path'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
  // العلاقات
    public function aidRequests()
    {
        return $this->hasMany(AidRequest::class, 'beneficiary_id');
    }

    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'beneficiary_id');
    }

    public function volunteerDistributions()
    {
        return $this->hasMany(Distribution::class, 'volunteer_id');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVolunteer()
    {
        return $this->role === 'volunteer';
    }

    public function isBeneficiary()
    {
        return $this->role === 'beneficiary';
    }


    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }
        public function getRoleName()
    {
        $roles = [
            'admin' => 'مسؤول',
            'volunteer' => 'متطوع',
            'beneficiary' => 'مستفيد'
        ];

        return $roles[$this->role] ?? $this->role;

    }


// الاشعارات
   
public function getUnreadNotificationsCount()
{
    return $this->unreadNotifications()->count();
}

public function getRecentNotifications($limit = 5)
{
    return $this->notifications()
        ->orderBy('created_at', 'desc')
        ->take($limit)
        ->get();
}

public function markAllNotificationsAsRead()
{
     // return $this->unreadNotifications->markAsRead();
    return  $this->unreadNotifications()->update(['read_at' => now()]);
 
     
}

public function getNotificationsByType($type, $limit = null)
{
    $query = $this->notifications()
        ->where('type', 'like', '%' . $type . '%')
        ->orderBy('created_at', 'desc');
    
    if ($limit) {
        $query->take($limit);
    }
    
    return $query->get();
}
}
