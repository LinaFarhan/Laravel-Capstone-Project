<?php
 
namespace Database\Seeders;

use App\Models\Distribution;
use App\Models\User;
use App\Models\Donation;
use App\Models\AidRequest;
use Illuminate\Database\Seeder;

class DistributionSeeder extends Seeder
{
    public function run(): void
    {
        // توزيعات معينة
        Distribution::factory()->assigned()->count(8)->create();

        // توزيعات قيد التقدم
        Distribution::factory()->inProgress()->count(5)->create();

        // توزيعات مكتملة
        Distribution::factory()->delivered()->count(12)->create();

        // توزيعات ملغاة
        Distribution::factory()->cancelled()->count(3)->create();

        // توزيعات لمتطوعين محددين
        $volunteers = User::where('role', 'volunteer')->take(3)->get();
        foreach ($volunteers as $volunteer) {
            Distribution::factory()->count(4)->create([
                'volunteer_id' => $volunteer->id,
                'delivery_status' => 'delivered',
            ]);
        }

        // توزيعات مرتبطة بطلبات محددة
        $approvedRequests = AidRequest::where('status', 'approved')->take(10)->get();
        foreach ($approvedRequests as $request) {
            Distribution::factory()->create([
                'beneficiary_id' => $request->beneficiary_id,
                'aid_request_id' => $request->id,
                'donation_id' => Donation::where('status', 'received')->inRandomOrder()->first()->id,
                'delivery_status' => 'delivered',
            ]);
        }
    }
}