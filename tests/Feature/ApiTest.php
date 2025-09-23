<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\AidRequest;
use App\Models\Distribution;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

   #[Test]
    public function user_can_get_api_token()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    /** @test */
    public function beneficiary_can_get_their_aid_requests_via_api()
    {
        $beneficiary = User::factory()->beneficiary()->create();
        AidRequest::factory()->count(3)->create(['beneficiary_id' => $beneficiary->id]);

        Sanctum::actingAs($beneficiary);

        $response = $this->get('/api/beneficiary/aid-requests');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /** @test */
    public function volunteer_can_get_their_distributions_via_api()
    {
        $volunteer = User::factory()->volunteer()->create();
        Distribution::factory()->count(2)->create(['volunteer_id' => $volunteer->id]);

        Sanctum::actingAs($volunteer);

        $response = $this->get('/api/volunteer/distributions');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    /** @test */
    public function admin_can_get_stats_via_api()
    {
        $admin = User::factory()->admin()->create();

        Sanctum::actingAs($admin);

        $response = $this->get('/api/admin/stats');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'total_users',
            'total_donations',
            'total_beneficiaries',
            'total_volunteers'
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_protected_api_endpoints()
    {
        $response = $this->get('/api/admin/stats');

        $response->assertStatus(401);
    }

    /** @test */
    public function user_can_update_profile_via_api()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->put('/api/user/profile', [
            'name' => 'Updated Name',
            'phone' => '1234567890'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name'
        ]);
    }
}