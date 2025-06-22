<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,dosen,mahasiswa'
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;

        if ($role === 'admin') {
            if (Auth::attempt($credentials)) {
                // Set session untuk admin
                $request->session()->put('auth_role', 'admin');
                $request->session()->put('auth_user_id', Auth::id());
                return redirect()->intended('/admin/dashboard');
            }
        } elseif ($role === 'dosen') {
            if (Auth::guard('dosen')->attempt($credentials)) {
                // Set session untuk dosen
                $request->session()->put('auth_role', 'dosen');
                $request->session()->put('auth_user_id', Auth::guard('dosen')->id());
                return redirect()->intended('/dosen/dashboard');
            }
        } elseif ($role === 'mahasiswa') {
            if (Auth::guard('mahasiswa')->attempt($credentials)) {
                // Set session untuk mahasiswa
                $request->session()->put('auth_role', 'mahasiswa');
                $request->session()->put('auth_user_id', Auth::guard('mahasiswa')->id());
                return redirect()->intended('/mahasiswa/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        // Logout dari semua guards
        Auth::logout();
        Auth::guard('dosen')->logout();
        Auth::guard('mahasiswa')->logout();

        // Clear session
        $request->session()->forget(['auth_role', 'auth_user_id']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
