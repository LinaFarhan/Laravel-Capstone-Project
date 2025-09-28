<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Distribution;
/**
 * @mixin IdeHelperDonation
 */
class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'type',
        'quantity',
        'status',
        'description'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function distributions()
    {
        return $this->hasMany(Distribution::class);
    }
}