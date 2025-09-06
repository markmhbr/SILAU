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
        return view('layouts.register');
    }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'email.unique' => 'Email sudah terdaftar, silahkan gunakan email lain!',
            'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
        ]);
        // Baris dd($request->all()); telah dihapus karena menghentikan eksekusi kode.
        // Anda bisa menggunakannya lagi jika perlu untuk debugging.

        try {
            // Create a new user in the database
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
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

            // Redirect to the login page with a success message
            return redirect()->route('login')->with('success', 'Akun berhasil didaftarkan. Silahkan masuk!');
        } catch (\Throwable $th) {
            // If something goes wrong, redirect back with an error
            throw ValidationException::withMessages([
                'email' => ['Pendaftaran gagal. Silahkan coba lagi.'],
            ]);

        }
    }

}
