<?php
 
namespace Database\Seeders;

use App\Models\Donation;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        // تبرعات غذائية
        Donation::factory()->food()->count(20)->create([
            'status' => 'received',
        ]);

        // تبرعات ملابس
        Donation::factory()->clothing()->count(15)->create([
            'status' => 'received',
        ]);

        // تبرعات طبية
        Donation::factory()->medical()->count(10)->create([
            'status' => 'received',
        ]);

        // تبرعات مالية
        Donation::factory()->financial()->count(8)->create([
            'status' => 'received',
        ]);

        // تبرعات متنوعة
        Donation::factory()->count(7)->create([
            'status' => 'pending',
        ]);

        // تبرعات موزعة
        Donation::factory()->count(5)->create([
            'status' => 'distributed',
        ]);
    }
}