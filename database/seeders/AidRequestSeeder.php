<?php
 
namespace Database\Seeders;

use App\Models\AidRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class AidRequestSeeder extends Seeder
{
    public function run(): void
    {
        // طلبات معلقة
        AidRequest::factory()->pending()->count(15)->create();

        // طلبات موافق عليها
        AidRequest::factory()->approved()->count(25)->create();

        // طلبات مرفوضة
        AidRequest::factory()->denied()->count(10)->create();

        // طلبات غذائية
        AidRequest::factory()->food()->count(20)->create();

        // طلبات طبية
        AidRequest::factory()->medical()->count(15)->create();

        // طلبات من مستفيدين محددين
        $beneficiaries = User::where('role', 'beneficiary')->take(5)->get();
        foreach ($beneficiaries as $beneficiary) {
            AidRequest::factory()->count(3)->create([
                'beneficiary_id' => $beneficiary->id,
                'status' => 'approved',
            ]);
        }
    }
}