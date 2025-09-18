<?php
 
namespace App\Http\Controllers\Beneficiary;

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
        $aidRequests = AidRequest::where('beneficiary_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('beneficiary.aid-requests.index', compact('aidRequests'));
    }

    public function create()
    {
        return view('beneficiary.aid-requests.create');
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

        return redirect()->route('beneficiary.aid-requests.index')
            ->with('success', 'تم إرسال طلب المساعدة بنجاح');
    }

    public function show(AidRequest $aidRequest)
    {
        // التحقق من أن الطلب مخصص لهذا المستفيد
        if ($aidRequest->beneficiary_id !== Auth::id()) {
            abort(403, 'غير مصرح بالوصول إلى هذا الطلب');
        }

        $aidRequest->load('distributions.donation', 'distributions.volunteer');
        return view('beneficiary.aid-requests.show', compact('aidRequest'));
    }

    public function edit(AidRequest $aidRequest)
    {
        if ($aidRequest->beneficiary_id !== Auth::id()) {
            abort(403, 'غير مصرح بتعديل هذا الطلب');
        }

        if ($aidRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'لا يمكن تعديل الطلب بعد المراجعة');
        }

        return view('beneficiary.aid-requests.edit', compact('aidRequest'));
    }

    public function update(UpdateAidRequestRequest $request, AidRequest $aidRequest)
    {
        if ($aidRequest->beneficiary_id !== Auth::id()) {
            abort(403, 'غير مصرح بتعديل هذا الطلب');
        }

        if ($aidRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'لا يمكن تعديل الطلب بعد المراجعة');
        }

        $validated = $request->validated();
        
        $aidRequest->type = $validated['type'];
        $aidRequest->description = $validated['description'];
        
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
            $aidRequest->document_url = $path;
        }
        
        $aidRequest->save();

        return redirect()->route('beneficiary.aid-requests.index')
            ->with('success', 'تم تحديث طلب المساعدة بنجاح');
    }

    public function destroy(AidRequest $aidRequest)
    {
        if ($aidRequest->beneficiary_id !== Auth::id()) {
            abort(403, 'غير مصرح بحذف هذا الطلب');
        }

        if ($aidRequest->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'لا يمكن حذف الطلب بعد المراجعة');
        }

        $aidRequest->delete();

        return redirect()->route('beneficiary.aid-requests.index')
            ->with('success', 'تم حذف طلب المساعدة بنجاح');
    }
}