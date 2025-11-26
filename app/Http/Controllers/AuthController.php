<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // 👇 fungsi untuk membuka tampilan login
    public function showLogin()
    {
        // jika sudah login langsung masuk dashboard
        if (session()->has('user')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login'); // pastikan file view ini ada
    }

    public function login(Request $request)
    {
        // Validasi form
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Login bebas (tanpa database)
        session()->put('user', [
            'id'    => 1,
            'name'  => explode('@', $request->email)[0],
            'email' => $request->email,
            'role'  => 'admin'
        ]);

        return redirect()->route('dashboard')->with('success', 'Login berhasil!');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
