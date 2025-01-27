<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.signin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        // Periksa apakah user ditemukan dan statusnya tidak aktif
        if ($user && $user->status != 'aktif') {
            return back()->withErrors([
                'login_gagal' => 'Akun Anda masih dalam proses penerimaan.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil kode_ormawa dari relasi user
            $kodeOrmawa = $user->strukturOrmawas()
                ->with('divisiOrmawas.ormawa')
                ->get()
                ->pluck('divisiOrmawas.ormawa.kode')
                ->first();

            // Ambil periode dari request atau fallback ke tahun saat ini
            $periode = date('Y');

            // Redirect ke halaman program kerja dengan kode_ormawa dan periode
            return redirect()->route('dashboard', ['kode_ormawa' => $kodeOrmawa]) . "?periode=$periode";
        }


        return back()->withErrors([
            'login_gagal' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('auth/login');
    }
}
