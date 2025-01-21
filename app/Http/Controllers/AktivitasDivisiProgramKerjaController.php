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

    public function update(Request $request, $kode_ormawa, $nama_program_kerja, $id, $aktivitas_id)
    {
        // dd($kode_ormawa, $nama_program_kerja, $id, $aktivitas_id, $request->all());
        $keys = array_keys($request->all());
        $value = array_values($request->all());

        // Cari aktivitas berdasarkan ID
        $activity = AktivitasDivisiProgramKerja::find($aktivitas_id);

        // Update data aktivitas
        $activity->update($request->all());

        // Response JSON
        return response()->json(['success' => true, 'message' => 'Aktivitas berhasil diperbarui.']);
    }
}
