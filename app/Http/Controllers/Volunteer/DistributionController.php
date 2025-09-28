<?php
namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class DistributionController extends Controller
{
    /* - يعرض قائمة التوزيعات الخاصة بالمتطوع.
- يستخدم with() لجلب بيانات المستفيد والتبرع.
- يفلتر حسب volunteer_id ويعرض النتائج بترتيب تنازلي.
 */
    public function index()
    {
        $distributions = Distribution::with(['beneficiary', 'donation'])
            ->where('volunteer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('volunteer.distributions.index', compact('distributions'));
    }

    /* - يعرض تفاصيل توزيع معين.
- يتحقق من أن المتطوع هو صاحب التوزيع.
- يحمل العلاقات المرتبطة: المستفيد، التبرع، طلب المساعدة.
 */
    public function show(Distribution $distribution)
    {
        // التحقق من أن التوزيع مخصص لهذا المتطوع
        if ($distribution->volunteer_id !== Gate::authorize('update', $distribution)) {
            abort(403, 'غير مصرح بالوصول إلى هذا التوزيع');
        }

        $distribution->load(['beneficiary', 'donation', 'aidRequest']);
        return view('volunteer.distributions.show', compact('distribution'));
    }


    /* - يسمح للمتطوع بتحديث حالة التوزيع.
- يتحقق من الصلاحية.
- يتحقق من صحة البيانات (delivery_status, proof_file, notes).
- يحفظ الملف في مجلد public/proofs.
- يحدث السجل ويعيد التوجيه مع رسالة نجاح.
 */

    public function updateStatus(Request $request, Distribution $distribution)
    {
        if ($distribution->volunteer_id !== Gate::authorize('update', $distribution)) {
            abort(403, 'غير مصرح بتحديث هذا التوزيع');
        }

        $request->validate([
            'delivery_status' => 'required|in:assigned,in_progress,delivered,cancelled',
            'proof_file' => 'nullable|file|max:2048|mimes:jpg,png,pdf',
            'notes' => 'nullable|string|max:1000',
        ]);

        $distribution->delivery_status = $request->delivery_status;
        $distribution->notes = $request->notes;

        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('proofs', 'public');
            $distribution->proof_file = $path;
        }

        $distribution->save();

        return redirect()->back()->with('success', 'تم تحديث حالة التوزيع بنجاح');
    }
}
