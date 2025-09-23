<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\AidRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BeneficiaryAidRequestTest extends TestCase
{
    use RefreshDatabase;

    
    public function beneficiary_can_create_aid_request()
    {
        Storage::fake('public');

        $beneficiary = User::factory()->beneficiary()->create();

        $response = $this->actingAs($beneficiary)->post('/beneficiary/aid-requests', [
            'type' => 'food',
            'description' => 'أحتاج إلى مساعدة غذائية عاجلة',
            'document' => UploadedFile::fake()->create('document.pdf', 1024)
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('aid_requests', [
            'beneficiary_id' => $beneficiary->id,
            'type' => 'food',
            'status' => 'pending'
        ]);
    }

   
    public function beneficiary_can_view_their_requests()
    {
        $beneficiary = User::factory()->beneficiary()->create();
        AidRequest::factory()->count(3)->create(['beneficiary_id' => $beneficiary->id]);

        $response = $this->actingAs($beneficiary)->get('/beneficiary/aid-requests');

        $response->assertStatus(200);
        $response->assertSee('طلباتي');
    }

  
    public function beneficiary_cannot_view_others_requests()
    {
        $beneficiary1 = User::factory()->beneficiary()->create();
        $beneficiary2 = User::factory()->beneficiary()->create();
        
        $request = AidRequest::factory()->create(['beneficiary_id' => $beneficiary2->id]);

        $response = $this->actingAs($beneficiary1)->get('/beneficiary/aid-requests/' . $request->id);

        $response->assertStatus(403);
    }

    
    public function beneficiary_can_update_pending_request()
    {
        $beneficiary = User::factory()->beneficiary()->create();
        $request = AidRequest::factory()->create([
            'beneficiary_id' => $beneficiary->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($beneficiary)->put('/beneficiary/aid-requests/' . $request->id, [
            'type' => 'medical',
            'description' => 'تحديث الوصف'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('aid_requests', [
            'id' => $request->id,
            'type' => 'medical'
        ]);
    }

 
    public function beneficiary_cannot_update_approved_request()
    {
        $beneficiary = User::factory()->beneficiary()->create();
        $request = AidRequest::factory()->create([
            'beneficiary_id' => $beneficiary->id,
            'status' => 'approved'
        ]);

        $response = $this->actingAs($beneficiary)->put('/beneficiary/aid-requests/' . $request->id, [
            'type' => 'medical',
            'description' => 'تحديث الوصف'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}