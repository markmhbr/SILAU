<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.content.register');
    }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'email.unique' => 'Email sudah terdaftar, silahkan gunakan email lain!',
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
        ]);
    
        try {
            // Create a new user in the database
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'pelanggan', // Default role
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            Pelanggan::create([
                'user_id' => $user->id,
                'foto'    => '',
                'no_hp'   => '',
                'alamat'  => '',
            ]);
            
            // If AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Akun berhasil didaftarkan. Silahkan masuk!',
                    'redirect' => route('login')
                ]);
            }
            
            // Redirect to the login page with a success message
            return redirect()->route('login')->with('success', 'Akun berhasil didaftarkan. Silahkan masuk!');
        } catch (\Throwable $th) {
            // If something goes wrong, redirect back with an error
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran gagal. Silahkan coba lagi.'
                ]);
            }
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Pendaftaran gagal. Silahkan coba lagi.']);
        }
    }

}
