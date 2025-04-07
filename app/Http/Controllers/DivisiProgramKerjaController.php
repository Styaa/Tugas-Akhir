<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DivisiProgramKerjaController extends Controller
{
    //
    public function show($kode_ormawa, $prokerNama, $id)
    {

        $prokerId = ProgramKerja::where('nama', $prokerNama)->value('id');

        // dd($id);

        $namaDivisi = DB::table('divisi_program_kerjas')
            ->join('divisi_pelaksanas', 'divisi_program_kerjas.divisi_pelaksanas_id', '=', 'divisi_pelaksanas.id')
            ->where('divisi_program_kerjas.id', $id)
            ->select('divisi_pelaksanas.nama AS nama_divisi', 'divisi_program_kerjas.id AS id_divisi', 'divisi_program_kerjas.divisi_pelaksanas_id AS id_pelaksana')
            ->first();

        // dd($namaDivisi);


        $anggotaProker = DB::table('struktur_prokers')
            ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
            ->join('program_kerjas', 'divisi_program_kerjas.program_kerjas_id', '=', 'program_kerjas.id')
            ->where('divisi_program_kerjas.id', $id)
            ->where('program_kerjas.id', $prokerId)
            ->select(
                'users.id AS user_id',
                'users.name AS nama_user',
                'jabatans.nama AS nama_jabatan',
                'divisi_program_kerjas.id AS divisi_program_kerja_id',
                'program_kerjas.nama AS nama_program_kerja'
            )
            ->get();


        $activities = DB::table('tugas_divisi_program_kerjas')
            ->where('divisi_pelaksana_id', $id)
            ->where('program_kerjas_id', $prokerId)
            ->get();
        // dd($activities);
        foreach ($activities as $activity) {
            $activity->tenggat_waktu = $activity->tenggat_waktu ? Carbon::parse($activity->tenggat_waktu)->format('Y-m-d') : null;

            // dd($activity->nilai);
        }

        // dd($activities->first()->tenggat_waktu);


        // dd($anggotaProker[0]->nama_program_kerja);
        return view('program-kerja.divisi.show', compact('anggotaProker', 'namaDivisi', 'activities', 'prokerNama', 'prokerId'));
    }
}
