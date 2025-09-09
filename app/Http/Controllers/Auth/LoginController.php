<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('layouts.login'); // buat file login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        $remember = $request->has('remember');
    
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Return JSON response untuk AJAX
            if ($request->ajax()) {
                $redirectUrl = '/login';
                if (Auth::user()->role === 'admin') {
                    $redirectUrl = '/admin/dashboard';
                } else if (Auth::user()->role === 'pelanggan') {
                    $redirectUrl = '/pelanggan/profil';
                }
                
                return response()->json([
                    'success' => true,
                    'message' => 'Selamat Anda Berhasil Login',
                    'redirect' => $redirectUrl
                ]);
            }
            
            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } else if (Auth::user()->role === 'pelanggan') {
                return redirect()->intended('pelanggan/profil');
            }
        }
        
        // Return JSON error untuk AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah!'
            ]);
        }
        
        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Selamat Anda Berhasil Logout');
    }
}
