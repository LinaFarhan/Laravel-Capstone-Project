<?php
// app/Http/Controllers/Api/V1/StatsController.php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donation;
use App\Models\AidRequest;
use App\Models\Distribution;

class StatsController extends Controller
{
    public function public()
    {
        return response()->json([
            'total_donations' => Donation::count(),
            'total_beneficiaries_helped' => Distribution::where('delivery_status', 'delivered')->count(),
            'total_volunteers' => User::where('role', 'volunteer')->count(),
            'platform_launch_date' => '2024-01-01',
        ]);
    }

    public function beneficiary(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'total_requests' => $user->aidRequests()->count(),
            'approved_requests' => $user->aidRequests()->where('status', 'approved')->count(),
            'pending_requests' => $user->aidRequests()->where('status', 'pending')->count(),
            'received_aid' => $user->distributions()->where('delivery_status', 'delivered')->count(),
        ]);
    }

    public function volunteer(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'total_assignments' => $user->volunteerDistributions()->count(),
            'completed_deliveries' => $user->volunteerDistributions()->where('delivery_status', 'delivered')->count(),
            'pending_deliveries' => $user->volunteerDistributions()->whereIn('delivery_status', ['assigned', 'in_progress'])->count(),
        ]);
    }

    public function admin()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_donations' => Donation::count(),
            'total_beneficiaries' => User::where('role', 'beneficiary')->count(),
            'total_volunteers' => User::where('role', 'volunteer')->count(),
            'pending_requests' => AidRequest::where('status', 'pending')->count(),
            'completed_distributions' => Distribution::where('delivery_status', 'delivered')->count(),
            'active_donations' => Donation::where('status', 'received')->count(),
        ]);
    }
}