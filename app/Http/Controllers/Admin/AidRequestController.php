<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AidRequest;
use Illuminate\Http\Request;

class AidRequestController extends Controller
{
    public function index()
    {
        $aidRequests = AidRequest::with('beneficiary')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.aid-requests.index', compact('aidRequests'));
    }

    public function show(AidRequest $aidRequest)
    {
        $aidRequest->load('beneficiary', 'distributions');
        return view('admin.aid-requests.show', compact('aidRequest'));
    }

    public function updateStatus(Request $request, AidRequest $aidRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,denied'
        ]);

        $aidRequest->status = $request->status;
        $aidRequest->save();

        // إرسال إشعار للمستفيد
        if ($request->status === 'approved') {
            // $aidRequest->beneficiary->notify(new AidRequestApprovedNotification($aidRequest));
        } elseif ($request->status === 'denied') {
            // $aidRequest->beneficiary->notify(new AidRequestDeniedNotification($aidRequest));
        }

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function destroy(AidRequest $aidRequest)
    {
        $aidRequest->delete();
        return redirect()->route('admin.aid-requests.index')
            ->with('success', 'تم حذف طلب المساعدة بنجاح');
    }
}