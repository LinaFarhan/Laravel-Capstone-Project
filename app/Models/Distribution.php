<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'volunteer_id',
        'beneficiary_id',
        'donation_id',
        'delivery_status',
        'proof_file',
    ];

    /**
     * العلاقة مع المتطوع (User)
     */
    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    /**
     * العلاقة مع المستفيد (User)
     */
    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }

    /**
     * العلاقة مع التبرع (Donation)
     */
    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
