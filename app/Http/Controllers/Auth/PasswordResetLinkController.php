<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
    public function storeDirect(Request $request): \Illuminate\Http\RedirectResponse
{
    // تحقق من البريد
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    // الحصول على المستخدم
    $user = \App\Models\User::where('email', $request->email)->firstOrFail();

    // إنشاء توكن مؤقت عشوائي
    $token = Str::random(64);

    // حفظ التوكن في جدول password_resets
    DB::table('password_resets')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => Hash::make($token),
            'created_at' => now()
        ]
    );

    // إعادة التوجيه مباشرةً لصفحة Reset Password
    return redirect()->route('password.reset', [
        'token' => $token,
        'email' => $request->email
    ]);
}

}
