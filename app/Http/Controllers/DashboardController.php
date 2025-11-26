<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->has('user')) {
            return redirect('/')->with('error', 'Silakan login dulu.');
        }

        return view('admin.dashboard', [
            'user' => session('user')
        ]);
    }
}
