<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donation;
use App\Models\AidRequest;
use App\Models\Distribution;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_donations' => Donation::count(),
            'total_beneficiaries' => User::where('role', 'beneficiary')->count(),
            'total_volunteers' => User::where('role', 'volunteer')->count(),
            'pending_requests' => AidRequest::where('status', 'pending')->count(),
            'completed_distributions' => Distribution::where('delivery_status', 'delivered')->count(),
            'active_donations' => Donation::where('status', 'received')->count(),
        ];

        $recentRequests = AidRequest::with('beneficiary')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentDonations = Donation::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentDistributions = Distribution::with(['volunteer', 'beneficiary', 'donation'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests', 'recentDonations', 'recentDistributions'));
    }
}
