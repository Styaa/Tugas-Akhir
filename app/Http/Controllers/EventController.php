<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDivisiProgramKerja;
use App\Models\ProgramKerja;
use App\Models\Rapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    //
    public function getEvents(Request $request)
    {
        $user = Auth::user();
        $kodeOrmawa = $request->kode_ormawa;

        // Ambil data program kerja berdasarkan kode_ormawa
        $programKerja = ProgramKerja::where('ormawas_kode', $kodeOrmawa)
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->nama,
                    'start' => $item->tanggal_mulai,
                    'end' => $item->tanggal_selesai,
                    'color' => '#3b82f6'
                ];
            });

        // Ambil data rapat berdasarkan kode_ormawa dan user login
        $rapat = Rapat::where('ormawa_id', $kodeOrmawa)
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->nama,
                    'start' => $item->tanggal,
                    'color' => ''
                ];
            });

        // Ambil data aktivitas berdasarkan kode_ormawa dan user login
        $aktivitas = AktivitasDivisiProgramKerja::whereHas('programKerja', function ($query) use ($kodeOrmawa) {
            $query->where('ormawas_kode', $kodeOrmawa);
        })
            ->where('person_in_charge', $user->id)
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->nama,
                    'start' => $item->tenggat_waktu,
                    'color' => '#10b981'
                ];
            });

        // Gabungkan semua data event
        $events = collect($programKerja)
            ->merge($rapat)
            ->merge($aktivitas);

        return response()->json($events);
    }
}
