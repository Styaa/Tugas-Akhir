<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Ormawa;
use App\Models\RegistrasiOrmawas;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $ormawas = Ormawa::all();
        return view('auth.signup', compact('ormawas'));
    }

    protected function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
            'nrp' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'id_line' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'pilihan_ormawa_1' => 'required|string|exists:ormawas,kode',
            'pilihan_ormawa_2' => 'nullable|string|exists:ormawas,kode|different:pilihan_ormawa_1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors(['password' => 'Password dan Konfirmasi Password harus sama.'])->withInput();
        }
    }

    protected function createUser(Request $request)
    {
        // dd($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'nrp' => $request->nrp,
            'jurusan' => $request->jurusan,
            'id_line' => $request->id_line,
            'no_hp' => $request->no_hp,
        ]);

        // Simpan pilihan ormawa ke tabel registrasi_ormawa
        if ($request->filled('pilihan_ormawa_1')) {
            RegistrasiOrmawas::create([
                'users_id' => $user->id,
                'ormawas_kode' => $request->pilihan_ormawa_1,
                'pilihan_divisi_1' => $request['divisi_divisi-container1_1'],
                'pilihan_divisi_2' => $request['divisi_divisi-container1_2'],
                'status' => 'waiting',
            ]);
        }

        if ($request->filled('pilihan_ormawa_2')) {
            RegistrasiOrmawas::create([
                'users_id' => $user->id,
                'ormawas_kode' => $request->pilihan_ormawa_2,
                'pilihan_divisi_1' => $request['divisi_divisi-container2_1'],
                'pilihan_divisi_2' => $request['divisi_divisi-container2_2'],
                'status' => 'waiting',
            ]);
        }
    }

    public function register(Request $request)
    {
        $this->validateRequest($request);

        $this->createUser($request);

        // Login user setelah registrasi
        // auth()->login($user);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.'); // Ganti dengan route yang sesuai
    }
}
