<?php
 
namespace App\Http\Controllers\Api\Beneficiary;

use App\Http\Controllers\Controller;
use App\Models\AidRequest;
use App\Http\Requests\StoreAidRequestRequest;
use App\Http\Requests\UpdateAidRequestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AidRequestController extends Controller
{
    public function index()
    {
        $requests = AidRequest::where('beneficiary_id', Auth::id())
            ->with('distributions.donation')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($requests);
    }

    public function store(StoreAidRequestRequest $request)
    {
        $validated = $request->validated();
        
        $aidRequest = new AidRequest();
        $aidRequest->beneficiary_id = Auth::id();
        $aidRequest->type = $validated['type'];
        $aidRequest->description = $validated['description'];
        $aidRequest->status = 'pending';
        
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
            $aidRequest->document_url = $path;
        }
        
        $aidRequest->save();

        return response()->json($aidRequest, 201);
    }

    public function show(AidRequest $aidRequest)
    {
        if ($aidRequest->beneficiary_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح بالوصول'], 403);
        }

        $aidRequest->load('distributions.donation', 'distributions.volunteer');
        return response()->json($aidRequest);
    }

    public function update(UpdateAidRequestRequest $request, AidRequest $aidRequest)
    {
        if ($aidRequest->beneficiary_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح بالتعديل'], 403);
        }

        if ($aidRequest->status !== 'pending') {
            return response()->json(['error' => 'لا يمكن تعديل الطلب بعد المراجعة'], 400);
        }

        $validated = $request->validated();
        
        $aidRequest->type = $validated['type'];
        $aidRequest->description = $validated['description'];
        
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
            $aidRequest->document_url = $path;
        }
        
        $aidRequest->save();

        return response()->json($aidRequest);
    }

    public function destroy(AidRequest $aidRequest)
    {
        if ($aidRequest->beneficiary_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح بالحذف'], 403);
        }

        if ($aidRequest->status !== 'pending') {
            return response()->json(['error' => 'لا يمكن حذف الطلب بعد المراجعة'], 400);
        }

        $aidRequest->delete();

        return response()->json(['message' => 'تم حذف طلب المساعدة بنجاح']);
    }
}