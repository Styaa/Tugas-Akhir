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
            'nilai' => $request->input('nilai')
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

        // Cari aktivitas berdasarkan ID
        $activity = AktivitasDivisiProgramKerja::findOrFail($aktivitas_id);

        // Update status
        if ($request->has('status')) {
            $newStatus = $request->input('status');
            $activity->status = $newStatus;

            // Cek apakah status berubah menjadi 'In Progress'
            if ($newStatus === 'sedang_berjalan' && !$activity->tanggal_mulai) {
                $activity->tanggal_mulai = now()->format('Y-m-d');
            }

            // Cek apakah status berubah menjadi 'Completed'
            if ($newStatus === 'selesai' && !$activity->tanggal_selesai) {
                $activity->tanggal_selesai = now()->format('Y-m-d');
            }
        }

        // Update field lainnya (jika ada)
        $activity->update($request->except(['status', 'tanggal_mulai', 'tanggal_selesai']));

        // Simpan perubahan ke database
        $activity->save();

        // Return response JSON
        return response()->json([
            'success' => true,
            'message' => 'Activity status updated successfully.',
            'data' => $activity
        ]);
    }
}
