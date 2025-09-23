<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /* تعرض قائمة المستخدمين مرتبة حسب تاريخ الإنشاء تنازليًا.

تستخدم Pagination (10 مستخدمين لكل صفحة).

ترسل المتغير $users إلى view admin.users.index. */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    /* تعرض نموذج إضافة مستخدم جديد.

لا تحتاج بيانات مسبقة. */

    public function create()
    {
        return view('admin.users.create');
    }
    /* يتحقق من صحة البيانات (validate) قبل الإدخال.

يشفر كلمة المرور باستخدام bcrypt.

ينشئ المستخدم باستخدام User::create($validated).

يعيدك لقائمة المستخدمين مع رسالة نجاح. */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,volunteer,beneficiary',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }
    /* تعرض نموذج تعديل المستخدم مع تمرير بيانات المستخدم المحدد. */

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    /* يتحقق من صحة البيانات.

يسمح بتحديث كلمة المرور فقط إذا تم تعبئتها.

يقوم بتحديث بيانات المستخدم. */

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,volunteer,beneficiary',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    /* 
تحذف المستخدم المحدد.

تعيدك لقائمة المستخدمين مع رسالة نجاح.

 */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}