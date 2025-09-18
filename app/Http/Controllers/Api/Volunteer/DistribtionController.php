<?php
 
namespace App\Http\Controllers\Api\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::with(['beneficiary', 'donation', 'aidRequest'])
            ->where('volunteer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($distributions);
    }

    public function show(Distribution $distribution)
    {
        if ($distribution->volunteer_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح بالوصول'], 403);
        }

        $distribution->load(['beneficiary', 'donation', 'aidRequest']);
        return response()->json($distribution);
    }

    public function update(Request $request, Distribution $distribution)
    {
        if ($distribution->volunteer_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح بالتحديث'], 403);
        }

        $validated = $request->validate([
            'delivery_status' => 'required|in:assigned,in_progress,delivered,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $distribution->update($validated);

        return response()->json($distribution);
    }

    public function updateWithProof(Request $request, Distribution $distribution)
    {
        if ($distribution->volunteer_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح بالتحديث'], 403);
        }

        $validated = $request->validate([
            'delivery_status' => 'required|in:delivered',
            'proof_file' => 'required|file|max:2048|mimes:jpg,png,pdf',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('proofs', 'public');
            $validated['proof_file'] = $path;
        }

        $distribution->update($validated);

        return response()->json($distribution);
    }
}