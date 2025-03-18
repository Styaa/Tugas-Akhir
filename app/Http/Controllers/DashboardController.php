<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDivisiProgramKerja;
use App\Models\DivisiOrmawa;
use App\Models\DivisiPelaksana;
use App\Models\Ormawa;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index($kodeOrmawa)
    {
        $userId = Auth::id(); // Ambil user yang sedang login

        // Program Kerja User
        $programKerjaUsers = ProgramKerja::whereHas('divisiProgramKerjas.strukturProker', function ($query) use ($userId) {
            $query->where('users_id', $userId);
        })->get()->map(function ($programKerja) {
            return [
                'id_program_kerja' => $programKerja->id,
                'nama_program_kerja' => $programKerja->nama,
                'tanggal_mulai_program_kerja' => Carbon::parse($programKerja->tanggal_mulai)->translatedFormat('d F Y'), // Contoh: 12 Maret 2023
                'tanggal_selesai_program_kerja' => Carbon::parse($programKerja->tanggal_selesai)->translatedFormat('d F Y'),
            ];
        });

        // Program Kerja Mendatang
        $today = Carbon::now();
        $twoMonthsLater = Carbon::now()->addMonths(2);

        $programKerjaTerdekats = ProgramKerja::whereBetween('tanggal_mulai', [$today, $twoMonthsLater])
            ->get()
            ->map(function ($program) {
                return [
                    'id' => $program->id,
                    'nama' => $program->nama,
                    'deskripsi' => $program->deskripsi,
                    'tanggal_mulai' => Carbon::parse($program->tanggal_mulai)->translatedFormat('d F Y'),
                    'tanggal_selesai' => Carbon::parse($program->tanggal_selesai)->translatedFormat('d F Y'),
                    'tempat' => $program->tempat,
                ];
            });

        // Aktivitas User
        $aktivitasUsers = AktivitasDivisiProgramKerja::with('programKerja')
            ->where('person_in_charge', $userId)
            ->get();

        $ormawas = Ormawa::where('kode', $kodeOrmawa)->get();

        $divisiOrmawas = DivisiOrmawa::where('ormawas_kode', $kodeOrmawa)->get();

        // Get Critical Tasks Count
        $kritikalTasksCount = AktivitasDivisiProgramKerja::whereHas('divisiProgramKerja.programKerja', function ($query) use ($kodeOrmawa) {
            $query->where('ormawas_kode', $kodeOrmawa);
        })->where('prioritas', 'kritikal')->count();

        // Get Completed Tasks Count
        $completedTasksCount = AktivitasDivisiProgramKerja::whereHas('divisiProgramKerja.programKerja', function ($query) use ($kodeOrmawa) {
            $query->where('ormawas_kode', $kodeOrmawa);
        })->where('status', 'selesai')->count();

        // Get Overdue Tasks Count
        $overdueTasksCount = AktivitasDivisiProgramKerja::whereHas('divisiProgramKerja.programKerja', function ($query) use ($kodeOrmawa) {
            $query->where('ormawas_kode', $kodeOrmawa);
        })->where('tenggat_waktu', '<', now())
            ->where('status', '!=', 'selesai')
            ->count();

        // dd($divisiOrmawas);

        return view('dashboard.dashboard', compact(
            'programKerjaUsers',
            'programKerjaTerdekats',
            'aktivitasUsers',
            'ormawas',
            'divisiOrmawas',
            'kodeOrmawa',
            'kritikalTasksCount',
            'completedTasksCount',
            'overdueTasksCount'
        ));
    }

    public function alurDanaKemahasiswaan()
    {
        return view('alur-dana.kemahasiswaan');
    }

    public function alurDanaJurusan()
    {
        return view('alur-dana.jurusan');
    }
}
