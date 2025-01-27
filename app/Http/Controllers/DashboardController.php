<?php

namespace App\Http\Controllers;

use App\Models\DivisiPelaksana;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Jumlah anggota aktif dalam Ormawa
        $jumlahAnggota = DB::table('users')
            ->join('registrasi_ormawas', 'users.id', '=', 'registrasi_ormawas.users_id')
            ->where('registrasi_ormawas.status', 'accepted')
            ->where('users.status', 'aktif')
            ->count();

        // Jumlah program kerja
        $jumlahProker = DB::table('program_kerjas')->count();

        // Jumlah program kerja yang sudah selesai
        $prokerSelesai = DB::table('program_kerjas')
            ->where('tanggal_selesai', '<=', now())
            ->count();

        // Jumlah proposal atau LPJ yang telat
        $proposalTelat = DB::table('program_kerjas')
            ->where('tanggal_selesai', '<', now())
            ->where('disetujui', 'Tidak')
            ->count();

        // Timeline aktivitas divisi
        $timeline = DB::table('aktivitas_divisi_program_kerjas')
            ->select('nama', 'status', 'prioritas', 'tenggat_waktu')
            ->orderBy('tenggat_waktu', 'asc')
            ->take(10)
            ->get();

        // Tugas atau aktivitas berdasarkan prioritas tinggi/kritikal
        $tugas = DB::table('aktivitas_divisi_program_kerjas')
            ->whereIn('prioritas', ['tinggi', 'kritikal'])
            ->where('status', '!=', 'selesai')
            ->orderBy('tenggat_waktu', 'asc')
            ->take(5)
            ->get();

        // Statistik anggaran dana (total anggaran dan penggunaan)
        $anggaranTotal = DB::table('program_kerjas')
            ->sum(DB::raw("JSON_UNQUOTE(JSON_EXTRACT(anggaran_dana, '$[0]'))"));

        // Divisi dan anggota per divisi
        $divisiAnggota = DB::table('divisi_ormawas')
            ->select('divisi_ormawas.nama as nama_divisi', DB::raw('COUNT(users.id) as jumlah_anggota'))
            ->leftJoin('struktur_ormawas', 'divisi_ormawas.id', '=', 'struktur_ormawas.divisi_ormawas_id')
            ->leftJoin('users', 'struktur_ormawas.users_id', '=', 'users.id')
            ->groupBy('divisi_ormawas.id')
            ->get();

        // Pengumuman terbaru
        $pengumuman = DB::table('program_kerjas')
            ->select('nama', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai')
            ->orderBy('tanggal_mulai', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.dashboard', compact(
            'jumlahAnggota',
            'jumlahProker',
            'prokerSelesai',
            'proposalTelat',
            'timeline',
            'tugas',
            'anggaranTotal',
            'divisiAnggota',
            'pengumuman'
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
