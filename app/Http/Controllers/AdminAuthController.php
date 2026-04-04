<?php

namespace App\Http\Controllers;

use App\Models\AdminList;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()?->isAdminPanelMember()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Admin giris bilgileri gecersiz.',
            ])->onlyInput('email');
        }

        $user = Auth::guard('admin')->user();
        if (! $user || ! $user->isAdminPanelMember()) {
            Auth::guard('admin')->logout();

            return back()->withErrors([
                'email' => 'Bu hesap yonetim paneli listesinde kayitli degil.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function registerCreate(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()?->isAdminPanelMember()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.register');
    }

    public function registerStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
        ]);

        AdminList::query()->create(['user_id' => $user->id]);

        Auth::guard('admin')->login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();

        return redirect()->route('acp.login');
    }
}
