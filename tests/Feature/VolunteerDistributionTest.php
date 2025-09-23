<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Distribution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VolunteerDistributionTest extends TestCase
{
    use RefreshDatabase;

    
    public function volunteer_can_view_their_distributions()
    {
        $volunteer = User::factory()->volunteer()->create();
        Distribution::factory()->count(3)->create(['volunteer_id' => $volunteer->id]);

        $response = $this->actingAs($volunteer)->get('/volunteer/distributions');

        $response->assertStatus(200);
        $response->assertSee('المهام الموكلة');
    }

    /** @test */
    public function volunteer_cannot_view_others_distributions()
    {
        $volunteer1 = User::factory()->volunteer()->create();
        $volunteer2 = User::factory()->volunteer()->create();
        
        $distribution = Distribution::factory()->create(['volunteer_id' => $volunteer2->id]);

        $response = $this->actingAs($volunteer1)->get('/volunteer/distributions/' . $distribution->id);

        $response->assertStatus(403);
    }

  
    public function volunteer_can_update_distribution_status()
    {
        Storage::fake('public');

        $volunteer = User::factory()->volunteer()->create();
        $distribution = Distribution::factory()->create([
            'volunteer_id' => $volunteer->id,
            'delivery_status' => 'assigned'
        ]);

        $response = $this->actingAs($volunteer)->put('/volunteer/distributions/' . $distribution->id . '/status', [
            'delivery_status' => 'in_progress',
            'notes' => 'بدأت عملية التوزيع'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('distributions', [
            'id' => $distribution->id,
            'delivery_status' => 'in_progress'
        ]);
    }

   
    public function volunteer_can_upload_delivery_proof()
    {
        Storage::fake('public');

        $volunteer = User::factory()->volunteer()->create();
        $distribution = Distribution::factory()->create([
            'volunteer_id' => $volunteer->id,
            'delivery_status' => 'in_progress'
        ]);

        $response = $this->actingAs($volunteer)->put('/volunteer/distributions/' . $distribution->id . '/status', [
            'delivery_status' => 'delivered',
            'proof_file' => UploadedFile::fake()->image('delivery.jpg'),
            'notes' => 'تم التسليم بنجاح'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('distributions', [
            'id' => $distribution->id,
            'delivery_status' => 'delivered'
        ]);
    }
}