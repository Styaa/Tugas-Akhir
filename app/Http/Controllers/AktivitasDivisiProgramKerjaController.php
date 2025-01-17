<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDivisiProgramKerja;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class AktivitasDivisiProgramKerjaController extends Controller
{
    //
    public function store(Request $request, $kode_ormawa, $nama_program_kerja, $id)
    {
        $idProgramKerja = ProgramKerja::where('ormawas_kode', $kode_ormawa)
            ->where('nama', $nama_program_kerja)
            ->value('id');

        AktivitasDivisiProgramKerja::create([
            'nama' => $request->input('name'),
            'prioritas' => $request->input('priority', 'sedang'),
            'person_in_charge' => $request->input('assignee'),
            'tenggat_waktu' => $request->input('tenggat_waktu'),
            'dependency_id' => $request->input('dependency'),
            'divisi_pelaksana_id' => $id,
            'program_kerjas_id' => $idProgramKerja,
        ]);

        return redirect()->back()->with('success', 'Aktivitas berhasil ditambahkan.');
    }
}
