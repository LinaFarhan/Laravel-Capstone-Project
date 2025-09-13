<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AidRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'beneficiary_id', 'title', 'description', 'quantity',
        'id_card_path', 'address', 'city', 'status', 'rejection_reason'
    ];

    // العلاقة مع المستفيد
    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }

    // العلاقة مع عمليات التوزيع (Many-to-Many)
    public function distributions()
    {
        return $this->belongsToMany(Distribution::class);
    }
}
