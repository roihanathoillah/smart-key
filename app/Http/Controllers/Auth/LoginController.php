<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Login;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $method = $request->input('method', 'email');

        if ($method === 'mobile') {
            $request->validate(['mobile' => 'required|string']);
            $credentials = ['mobile' => $request->input('mobile'), 'password' => $request->input('password')];
        } else {
            $request->validate(['email' => 'required|email']);
            $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];
        }

        if (Login::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $redirectRoute = $this->isSuperAdmin(Auth::user())
                ? route('super.admin')
                : route('dashboard');

            return redirect()->intended($redirectRoute);
        }

        return back()->withErrors(['password' => 'The provided credentials do not match our records.'])->withInput();
    }

    protected function isSuperAdmin($user): bool
    {
        return $user && $user->email === 'admin@smartkey.com';
    }
}