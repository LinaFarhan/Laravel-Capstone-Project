<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AidRequest extends Model
{
    use HasFactory;

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'beneficiary_id',
        'type',
        'description',
        'status',
        'document_url',
    ];

    /**
     * العلاقة مع المستفيد (User)
     */
    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }

    /**
     * العلاقة مع التوزيعات (Distributions)
     */
    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'aid_request_id');
    }
}
