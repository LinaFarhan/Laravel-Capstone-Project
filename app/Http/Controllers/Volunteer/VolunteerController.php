<?php
 
namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use Illuminate\Support\Facades\Auth;

class VolunteerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_assignments' => Distribution::where('volunteer_id', $user->id)->count(),
            'completed_deliveries' => Distribution::where('volunteer_id', $user->id)
                ->where('delivery_status', 'delivered')
                ->count(),
            'pending_deliveries' => Distribution::where('volunteer_id', $user->id)
                ->whereIn('delivery_status', ['assigned', 'in_progress'])
                ->count(),
        ];

        $recentDistributions = Distribution::with(['beneficiary', 'donation'])
            ->where('volunteer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('volunteer.dashboard', compact('stats', 'recentDistributions'));
    }
}