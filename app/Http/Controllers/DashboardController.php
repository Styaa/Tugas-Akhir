<?php

namespace App\Http\Controllers;

use App\Models\DivisiPelaksana;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        //
        $programKerjas = ProgramKerja::all();
        $divisiPelaksanas = DivisiPelaksana::all();
        $periode = date('Y');
        $user = Auth::user();
        $kode_ormawa = $user->strukturOrmawas()
            ->with('divisiOrmawas.ormawa')
            ->get()
            ->pluck('divisiOrmawas.ormawa.kode')
            ->first();

        // dd($programKerjas);
        return view('dashboard.dashboard', compact('programKerjas', 'divisiPelaksanas', 'periode', 'kode_ormawa'));
    }
}
