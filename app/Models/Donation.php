<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'donor_name',
        'type',
        'quantity',
        'status',
    ];

    /**
     * العلاقة مع التوزيعات
     */
    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }
}
