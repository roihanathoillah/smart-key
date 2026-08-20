<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'username' => $request->input('name'),
            'nama_lengkap' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => 'admin',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}