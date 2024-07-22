<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $type = $request->input('type');
        // dd($type);
    
        if ($type === 'admin' || $type === 'Admin') {
            if ($this->attemptLogin('admin', $credentials)) {
                // dd("isAdmin");
                return redirect()->intended(route('tasks.create'));
            }
        } else {
            if ($this->attemptLogin('web', $credentials)) {
                return redirect()->intended(route('tasks.index'));
            }
        }
    
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    protected function attemptLogin(string $guard, array $credentials): bool
    {
        return Auth::guard($guard)->attempt($credentials, request()->filled('remember'));
    }

    
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
