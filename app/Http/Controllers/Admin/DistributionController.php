<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Models\User;
use App\Models\Donation;
use App\Models\AidRequest;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::with(['volunteer', 'beneficiary', 'donation'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.distributions.index', compact('distributions'));
    }

    public function create()
    {
        $volunteers = User::where('role', 'volunteer')->get();
        $beneficiaries = User::where('role', 'beneficiary')->get();
        $donations = Donation::where('status', 'received')->get();
        $aidRequests = AidRequest::where('status', 'approved')->get();

        return view('admin.distributions.create', compact('volunteers', 'beneficiaries', 'donations', 'aidRequests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'volunteer_id' => 'required|exists:users,id',
            'beneficiary_id' => 'required|exists:users,id',
            'donation_id' => 'required|exists:donations,id',
            'aid_request_id' => 'nullable|exists:aid_requests,id',
            'delivery_status' => 'required|in:assigned,in_progress,delivered,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        Distribution::create($validated);

        // إرسال إشعار للمتطوع
        // $volunteer = User::find($validated['volunteer_id']);
        // $volunteer->notify(new DistributionAssignedNotification($distribution));

        return redirect()->route('admin.distributions.index')
            ->with('success', 'تم إنشاء التوزيع بنجاح');
    }

    public function edit(Distribution $distribution)
    {
        $volunteers = User::where('role', 'volunteer')->get();
        $beneficiaries = User::where('role', 'beneficiary')->get();
        $donations = Donation::where('status', 'received')->get();
        $aidRequests = AidRequest::where('status', 'approved')->get();

        return view('admin.distributions.edit', compact('distribution', 'volunteers', 'beneficiaries', 'donations', 'aidRequests'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $validated = $request->validate([
            'volunteer_id' => 'required|exists:users,id',
            'beneficiary_id' => 'required|exists:users,id',
            'donation_id' => 'required|exists:donations,id',
            'aid_request_id' => 'nullable|exists:aid_requests,id',
            'delivery_status' => 'required|in:assigned,in_progress,delivered,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $distribution->update($validated);

        return redirect()->route('admin.distributions.index')
            ->with('success', 'تم تحديث التوزيع بنجاح');
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();
        return redirect()->route('admin.distributions.index')
            ->with('success', 'تم حذف التوزيع بنجاح');
    }
}
