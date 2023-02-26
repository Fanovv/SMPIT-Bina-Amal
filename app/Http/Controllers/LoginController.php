<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider as ProvidersRouteServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = ProvidersRouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();
            switch ($user->level) {
                case 'admin':
                    return redirect()->intended(route('admin.dashboard'));
                case 'bk':
                    return redirect()->intended(route('bk.dashboard'));
                case 'tu':
                    return redirect()->intended(route('tu.dashboard'));
                case 'wali':
                    return redirect()->intended(route('wali.dashboard'));
                case 'guru':
                    return redirect()->intended(route('guru.dashboard'));
                default:
                    return redirect()->intended(route('loginform'));
            }
        }

        return redirect()->back()->with('fail', 'login failed');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
