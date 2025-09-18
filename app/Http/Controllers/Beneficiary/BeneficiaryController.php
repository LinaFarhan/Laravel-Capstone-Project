<?php
 
namespace App\Http\Controllers\Beneficiary;

use App\Http\Controllers\Controller;
use App\Models\AidRequest;
use App\Models\Distribution;
use Illuminate\Support\Facades\Auth;

class BeneficiaryController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_requests' => AidRequest::where('beneficiary_id', $user->id)->count(),
            'approved_requests' => AidRequest::where('beneficiary_id', $user->id)
                ->where('status', 'approved')
                ->count(),
            'pending_requests' => AidRequest::where('beneficiary_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'received_aid' => Distribution::where('beneficiary_id', $user->id)
                ->where('delivery_status', 'delivered')
                ->count(),
        ];

        $recentRequests = AidRequest::where('beneficiary_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentDistributions = Distribution::with(['volunteer', 'donation'])
            ->where('beneficiary_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('beneficiary.dashboard', compact('stats', 'recentRequests', 'recentDistributions'));
    }
}