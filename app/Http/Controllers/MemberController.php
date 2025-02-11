<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDivisiProgramKerja;
use App\Models\ProgramKerja;
use App\Models\RegistrasiOrmawas;
use App\Models\StrukturOrmawa;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

    public function acceptCandidate(Request $request, $kode_ormawa)
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
        // $user = Auth::user();
        // $ormawasKode = $user->strukturOrmawas()
        //     ->with('divisiOrmawas.ormawa')
        //     ->get()
        //     ->pluck('divisiOrmawas.ormawa.kode')
        //     ->first();

        // Update status registrasi_ormawas menjadi accepted untuk ormawa_kode yang sesuai
        RegistrasiOrmawas::where('users_id', $request->user_id)
            ->where('ormawas_kode', $kode_ormawa)
            ->update(['status' => 'accepted']);

        // Update status registrasi_ormawas menjadi rejected untuk ormawa_kode lain
        RegistrasiOrmawas::where('users_id', $request->user_id)
            ->where('ormawas_kode', '!=', $kode_ormawa)
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

    public function allMembers($kode_ormawa)
    {
        $anggotas = User::whereHas('strukturOrmawas.divisiOrmawas.ormawa', function ($query) use ($kode_ormawa) {
            $query->where('kode', $kode_ormawa);
        })
        ->with(['strukturOrmawas.divisiOrmawas.ormawa', 'strukturOrmawas.jabatan'])
        ->get();

        // dd($anggotas[0]->strukturOrmawas[0]s);

        return view('our-member.members', compact('anggotas'));
    }

    public function show($kode_ormawa, Request $request){
        $id_member = $request->id_member;

        $anggota = User::find($id_member);

        // dd($request);

        $aktivitasUsers = AktivitasDivisiProgramKerja::with('programKerja')
            ->where('person_in_charge', $id_member)
            ->get();

        $programKerjaUsers = ProgramKerja::whereHas('divisiProgramKerjas.strukturProker', function ($query) use ($id_member) {
            $query->where('users_id', $id_member);
        })->get()->map(function ($programKerja) {
            return [
                'id_program_kerja' => $programKerja->id,
                'nama_program_kerja' => $programKerja->nama,
                'tanggal_mulai_program_kerja' => Carbon::parse($programKerja->tanggal_mulai)->translatedFormat('d F Y'), // Contoh: 12 Maret 2023
                'tanggal_selesai_program_kerja' => Carbon::parse($programKerja->tanggal_selesai)->translatedFormat('d F Y'),
            ];
        });

        return view('our-member.member-profile', compact('anggota', 'aktivitasUsers', 'programKerjaUsers'));
    }
}
