<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'volunteer_id', 'title', 'location',
        'distribution_date', 'status'
    ];

    // العلاقة مع المتطوع
    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    // العلاقة مع طلبات المساعدة (Many-to-Many)
    public function aidRequests()
    {
        return $this->belongsToMany(AidRequest::class);
    }
}
