<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function publicIndex()
    {
        return view('public.user.login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email:dns',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->role->name == "Admin") {
                return redirect()->intended('/waiting-for-verification/sukarelawans')->with('success', 'Admin login successful!');
            }
            return redirect()->intended('/')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Login failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logout successful!');
    }
}
