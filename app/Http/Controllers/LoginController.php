<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('/admin/index');
            } elseif (Auth::user()->role == 'teacher') {
                return redirect()->intended('/teacher/index');
            } elseif (Auth::user()->role == 'student') {
                return redirect()->intended('/student/index');
            }
        }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
