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
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    //
    public function candidateMembers(Request $request)
    {
        $candidate = User::whereHas('registrations', function ($query) {
            $query->where('ormawas_kode', 'KSMIF')
                ->where('status', 'waiting'); // Hanya ambil yang statusnya "waiting"
        })
            ->with(['registrations.divisi1', 'registrations.divisi2']) // Ambil data registrasi_ormawas juga
            ->get();


        // dd($candidate);

        return view('our-member.candidate-members', compact('candidate'));
    }

    public function acceptCandidate(Request $request, $kode_ormawa)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'divisi_selected' => 'required'
        ]);

        $userId = $request->input('user_id');
        $users = User::find($userId);
        if ($users) {
            // Contoh: Ubah status pengguna atau logika lainnya
            $users->status = 'aktif';
            $users->save();
        }

        // Update status registrasi_ormawas menjadi accepted untuk ormawa_kode yang sesuai
        RegistrasiOrmawas::where('users_id', $request->user_id)
            ->where('ormawas_kode', $kode_ormawa)
            ->update(['status' => 'accepted']);

        // Update status registrasi_ormawas menjadi rejected untuk ormawa_kode lain
        RegistrasiOrmawas::where('users_id', $request->user_id)
            ->where('ormawas_kode', '!=', $kode_ormawa)
            ->update(['status' => 'rejected']);

        $periode = DB::table('periodes')
            ->orderBy('periode', 'DESC')
            ->first();

        StrukturOrmawa::create([
            'divisi_ormawas_id' => $request->divisi_selected, //Masih perlu penyesuaian berdasarkan input user
            'users_id' => $request->user_id, // ID user yang diterima
            'periodes_periode' => $periode->periode, //now()->year //Untuk Mendapatkan periode saat ini
            'jabatan_id' => 13,
        ]);

        // Kembalikan respons
        return response()->json([
            'success' => true,
            'message' => 'User has been accepted and activated successfully.',
        ]);
    }

    // public function acceptRequest($registrasiId)
    // {
    //     // Dapatkan data registrasi
    //     $registrasi = User::find($registrasiId);

    //     if (!$registrasi) {
    //         return response()->json(['message' => 'Request not found'], 404);
    //     }

    //     // Update status registrasi menjadi accepted
    //     $registrasi->update(['status' => 'aktif']);

    //     // Tolak semua permintaan lain dari user tersebut
    //     RegistrasiOrmawas::where('users_id', $registrasi->users_id)
    //         ->where('id', '!=', $registrasi->id)
    //         ->update(['status' => 'rejected']);
    // }

    public function allMembers($kode_ormawa)
    {
        $anggotas = User::whereHas('strukturOrmawas.divisiOrmawas.ormawa', function ($query) use ($kode_ormawa) {
            $query->where('kode', $kode_ormawa);
        })
            ->with(['strukturOrmawas.divisiOrmawas.ormawa', 'strukturOrmawas.jabatan'])
            ->orderBy('name', 'ASC')
            ->get();

        // dd($anggotas[0]->strukturOrmawas[0]);

        return view('our-member.members', compact('anggotas'));
    }

    public function show($kode_ormawa, Request $request)
    {
        // dd(Auth::user()->jabatan);
        $id_member = $request->id_member;

        $anggotaOrmawa = User::find($id_member);

        // dd($request);

        $aktivitasUsers = AktivitasDivisiProgramKerja::with('programKerja')
            ->where('person_in_charge', $id_member)
            ->get();

        $programKerjaUsers = ProgramKerja::whereHas('divisiProgramKerjas.strukturProker', function ($query) use ($id_member) {
            $query->where('users_id', $id_member);
        })->get()->map(function ($programKerja) {
            $ketuaAcara = $programKerja->strukturProkers
                ->where('jabatans_id', '2')
                ->first();
            $programKerja->ketua_acara = $ketuaAcara ? $ketuaAcara->user->name : 'Belum Ditentukan';
            return [
                'id_program_kerja' => $programKerja->id,
                'nama_program_kerja' => $programKerja->nama,
                'tipe_program_kerja' => $programKerja->tipe,
                'deskripsi_program_kerja' => $programKerja->deskripsi,
                'ketua_acara' => $programKerja->ketua_acara,
                'tanggal_mulai_program_kerja' => Carbon::parse($programKerja->tanggal_mulai)->translatedFormat('d F Y'), // Contoh: 12 Maret 2023
                'tanggal_selesai_program_kerja' => Carbon::parse($programKerja->tanggal_selesai)->translatedFormat('d F Y'),
            ];
        });

        $divisiUser = StrukturOrmawa::with(['divisiOrmawas', 'jabatan'])
            ->where('users_id', $id_member)
            ->where('periodes_periode', $request->periode)
            ->first();

        // dd($programKerjaUsers[0]['id_program_kerja']);

        // dd($divisiUser->divisiOrmawas->nama);

        return view('our-member.member-profile', compact('anggotaOrmawa', 'aktivitasUsers', 'programKerjaUsers', 'divisiUser'));
    }
}
