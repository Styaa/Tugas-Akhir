<?php

namespace App\Http\Controllers;

use App\Models\RegistrasiOrmawas;
use App\Models\StrukturOrmawa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    //
    public function candidateMembers(Request $request)
    {
        $candidate = User::whereHas('registrations', function ($query) {
            $query->where('ormawas_kode', 'KSMIF')
                ->where('status', 'waiting'); // Tambahkan kondisi status "waiting"
        })->get();

        return view('our-member.candidate-members', compact('candidate'));
    }

    public function acceptCandidate(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->input('user_id');
        $users = User::find($userId);
        if ($users) {
            // Contoh: Ubah status pengguna atau logika lainnya
            $users->status = 'aktif';
            $users->save();
        }

        // Ambil ormawa_kode dari user yang sedang login
        $user = Auth::user();
        $ormawasKode = $user->strukturOrmawas()
            ->with('divisiOrmawas.ormawa')
            ->get()
            ->pluck('divisiOrmawas.ormawa.kode')
            ->first();

        // Update status registrasi_ormawas menjadi accepted untuk ormawa_kode yang sesuai
        RegistrasiOrmawas::where('users_id', $request->user_id)
            ->where('ormawas_kode', $ormawasKode)
            ->update(['status' => 'accepted']);

        // Update status registrasi_ormawas menjadi rejected untuk ormawa_kode lain
        RegistrasiOrmawas::where('users_id', $request->user_id)
            ->where('ormawas_kode', '!=', $ormawasKode)
            ->update(['status' => 'rejected']);

        StrukturOrmawa::create([
            'divisi_ormawas_id' => 2, //Masih perlu penyesuaian berdasarkan input user
            'users_id' => $request->user_id, // ID user yang diterima
            'periodes_periode' => 2023, //now()->year //Untuk Mendapatkan periode saat ini
            'jabatan_id' => 7,
        ]);

        // Kembalikan respons
        return response()->json([
            'success' => true,
            'message' => 'User has been accepted and activated successfully.',
        ]);
    }

    public function acceptRequest($registrasiId)
    {
        // Dapatkan data registrasi
        $registrasi = User::find($registrasiId);

        if (!$registrasi) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        // Update status registrasi menjadi accepted
        $registrasi->update(['status' => 'aktif']);

        // Tolak semua permintaan lain dari user tersebut
        RegistrasiOrmawas::where('users_id', $registrasi->users_id)
            ->where('id', '!=', $registrasi->id)
            ->update(['status' => 'rejected']);
    }
}
