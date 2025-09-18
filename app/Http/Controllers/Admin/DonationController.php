<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        return view('admin.donations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'type' => 'required|in:food,clothing,medical,financial,other',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,received,distributed,expired',
            'description' => 'nullable|string|max:1000',
        ]);

        Donation::create($validated);

        return redirect()->route('admin.donations.index')
            ->with('success', 'تم إضافة التبرع بنجاح');
    }

    public function edit(Donation $donation)
    {
        return view('admin.donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'type' => 'required|in:food,clothing,medical,financial,other',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,received,distributed,expired',
            'description' => 'nullable|string|max:1000',
        ]);

        $donation->update($validated);

        return redirect()->route('admin.donations.index')
            ->with('success', 'تم تحديث التبرع بنجاح');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')
            ->with('success', 'تم حذف التبرع بنجاح');
    }
}