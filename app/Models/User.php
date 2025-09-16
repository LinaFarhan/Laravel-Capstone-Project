<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
         'role',
          'phone',
           'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin(){
        return $this->role==='admin';
    }
     public function isVolunteer(){
        return $this->role==='volunteer';
    }
     public function isBeneficiary(){
        return $this->role==='beneficiary';
    }
      // العلاقة مع طلبات المساعدة (كمستفيد)
    public function aidRequests()
    {
        return $this->hasMany(AidRequest::class, 'beneficiary_id');
    }

    // العلاقة مع عمليات التوزيع (كمتطوع)
    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'volunteer_id');
    }

    // العلاقة مع الملف الشخصي للمتطوع
    public function volunteerProfile()
    {
        return $this->hasOne(VolunteerProfile::class);
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}


