<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // =========================
            // SUPER ADMIN LAMA
            // =========================
            // Tetap dipertahankan agar sistem lama tidak rusak.
            if ($user->role === 'super_admin') {
                return redirect()->route('super.admin');
            }

            // =========================
            // ADMIN
            // =========================
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }

            // =========================
            // ROLE SESUAI FLOWCHART
            // =========================
            if (in_array($user->role, [
                'officer_1_assurance',
                'hsa',
                'officer_3',
                'korlap',
                'korlap_b2b',
                'teknisi_b2b',
            ])) {
                /*
                 * Untuk sementara seluruh role flowchart
                 * diarahkan ke Dashboard.
                 *
                 * Hak akses masing-masing role akan
                 * dibedakan pada tahap middleware dan routes.
                 */
                return redirect()->route('dashboard');
            }

            // Jika role tidak dikenal, logout demi keamanan.
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Role akun tidak valid.',
            ])->withInput();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}