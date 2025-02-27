<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDivisiProgramKerja;
use App\Models\ProgramKerja;
use App\Models\User;
use App\Notifications\AssignPICReminder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schedule;

class AktivitasDivisiProgramKerjaController extends Controller
{
    //
    public function store(Request $request, $kode_ormawa, $nama_program_kerja, $id)
    {
        $idProgramKerja = ProgramKerja::where('ormawas_kode', $kode_ormawa)
            ->where('nama', $nama_program_kerja)
            ->value('id');

        // Simpan aktivitas dan ambil ID-nya
        $aktivitas = AktivitasDivisiProgramKerja::create([
            'nama' => $request->input('name'),
            'prioritas' => $request->input('priority', 'sedang'),
            'person_in_charge' => $request->input('assignee'),
            'tenggat_waktu' => $request->input('tenggat_waktu'),
            'dependency_id' => $request->input('dependency'),
            'divisi_pelaksana_id' => $id,
            'program_kerjas_id' => $idProgramKerja,
        ]);

        // Kirim notifikasi secara asinkron setelah response dikirim
        $user = User::find($aktivitas->person_in_charge);

        if ($user) {
            Notification::send($user, new AssignPICReminder($aktivitas));
        }

        return redirect()->back()->with('success', 'Aktivitas berhasil ditambahkan.');
    }

    public function update(Request $request, $kode_ormawa, $nama_program_kerja, $id, $aktivitas_id)
    {
        // dd($kode_ormawa, $nama_program_kerja, $id, $aktivitas_id, $request->all());
        $keys = array_keys($request->all());
        $value = array_values($request->all());

        $activity = AktivitasDivisiProgramKerja::find($aktivitas_id);

        $activity->update($request->all());

        return response()->json(['success' => true, 'message' => 'Aktivitas berhasil diperbarui.']);
    }
}
