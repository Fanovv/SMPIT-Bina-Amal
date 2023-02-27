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
            if ($user->level == 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->level == 'wali') {
                return redirect()->intended(route('wali.dashboard'));
            } else {
                return redirect()->back()->with('fail', 'login failed');
            }
        }

        return redirect()->back()->with('fail', 'Email dan Password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
