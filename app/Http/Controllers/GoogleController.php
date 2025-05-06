<?php

namespace App\Http\Controllers;

use App\Models\StrukturOrmawa;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $findUserWithAcc = User::where('google_id', $user->id)->first();
            $findUserWithEmail = User::where('email', $user->email)->first();

            // Check if user with this email doesn't exist at all
            if (!$findUserWithEmail) {
                // Redirect to register with error message
                return redirect()->route('register')
                    ->with('error', 'Akun dengan email ini belum terdaftar. Google login hanya untuk pengguna yang sudah terdaftar. Silakan daftar terlebih dahulu.');
            }

            if ($findUserWithAcc) {
                // User already has Google authentication set up
                $kodeOrmawa = $findUserWithAcc->strukturOrmawas()
                    ->with('divisiOrmawas.ormawa')
                    ->get()
                    ->pluck('divisiOrmawas.ormawa.kode')
                    ->first();

                $periode = StrukturOrmawa::where('users_id', $findUserWithAcc->id)->get()->pluck('periodes_periode');

                Auth::login($findUserWithAcc);

                return redirect()->route('dashboard', ['kode_ormawa' => $kodeOrmawa]) . "?periode=$periode";
            } else {
                // User exists but doesn't have Google auth - update their Google ID
                $updatedUser = User::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'google_id' => $user->id,
                    ]
                );

                // This needs to use $updatedUser, not $findUserWithAcc which is null here
                $kodeOrmawa = $updatedUser->strukturOrmawas()
                    ->with('divisiOrmawas.ormawa')
                    ->get()
                    ->pluck('divisiOrmawas.ormawa.kode')
                    ->first();

                $periode = StrukturOrmawa::where('users_id', $updatedUser->id)->get()->pluck('periodes_periode');

                Auth::login($updatedUser);

                return redirect()->route('dashboard', ['kode_ormawa' => $kodeOrmawa]) . "?periode=$periode";
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
