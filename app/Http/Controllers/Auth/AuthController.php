<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function home(Request $request): RedirectResponse
    {
        if ($request->user()) {
            return $this->redirectAuthenticatedUser($request->user());
        }

        return redirect()->route('login.form');
    }

    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return $this->redirectAuthenticatedUser($request->user());
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        if ($request->user()) {
            return $this->redirectAuthenticatedUser($request->user());
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials provided.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->redirectAuthenticatedUser(Auth::user());
    }

    public function showRegister(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return $this->redirectAuthenticatedUser($request->user());
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        if ($request->user()) {
            return $this->redirectAuthenticatedUser($request->user());
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'lecturer',
        ]);

        $this->ensureSpatieRoleExists('lecturer');

        if (method_exists($user, 'assignRole') && !$user->hasRole('lecturer')) {
            $user->assignRole('lecturer');
        }

        Auth::login($user);

        return redirect()->route('lecturer.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }

    private function redirectAuthenticatedUser(object $user): RedirectResponse
    {
        return redirect()->route($this->dashboardRouteFor($user));
    }

    private function dashboardRouteFor(object $user): string
    {
        return $this->resolveRole($user) === 'admin' ? 'admin.dashboard' : 'lecturer.dashboard';
    }

    private function ensureSpatieRoleExists(string $role): void
    {
        if (class_exists('Spatie\Permission\Models\Role')) {
            \Spatie\Permission\Models\Role::findOrCreate($role, 'web');
        }
    }

    private function resolveRole(object $user): string
    {
        if (($user->role ?? null) === 'admin') {
            return 'admin';
        }

        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return 'admin';
        }

        return $user->role ?? 'lecturer';
    }
}
