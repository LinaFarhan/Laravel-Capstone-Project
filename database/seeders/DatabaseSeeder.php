<?php
 
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DonationSeeder::class,
            AidRequestSeeder::class,
            DistributionSeeder::class,
            NotificationSeeder::class, // تمت الإضافة
        ]);
    }
}