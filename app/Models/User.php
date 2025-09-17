<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
}