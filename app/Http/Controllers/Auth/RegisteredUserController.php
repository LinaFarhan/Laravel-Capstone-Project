<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:admin,volunteer,beneficiary'], // تحقق من صحة الدور
        'phone' => ['nullable', 'string', 'max:20'],
        'document_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
    ]); 

    $documentPath = null;
if ($request->hasFile('document_path')) {
    $documentPath = $request->file('document_path')->store('documents', 'public');
}

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role, // حفظ الدور
        'phone' => $request->phone,
        'document_path' => $documentPath,
    ]);

    event(new Registered($user));

    Auth::login($user);

if ($user->isAdmin()) {
    return redirect()->route('admin.dashboard');
} elseif ($user->isVolunteer()) {
    return redirect()->route('volunteer.dashboard');
} elseif ($user->isBeneficiary()) {
    return redirect()->route('beneficiary.dashboard');
} else {
    return redirect()->route('dashboard'); // fallback
}

}

}
