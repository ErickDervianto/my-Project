<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'superadmin') {
                return redirect()->intended(route('superadmin.dashboard'));
            }
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            Auth::logout();
            return back()->with('error', 'Halaman login ini khusus untuk Admin/Superadmin.');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
}