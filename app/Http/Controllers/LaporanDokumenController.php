<?php

namespace App\Http\Controllers;

use App\Models\LaporanDokumen;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanDokumenController extends Controller
{
    //
    public function progressProposal($kode_ormawa, $id)
    {
        // Ambil data program kerja
        $programKerja = ProgramKerja::findOrFail($id);
        $user = Auth::user();

        // Cek apakah program kerja ini menggunakan dana kemahasiswaan
        $sumberDana = json_decode($programKerja->anggaran_dana);
        $isDanaKemahasiswaan = in_array('Dana Kemahasiswaan', $sumberDana);

        // Definisikan langkah-langkah berdasarkan jenis dana
        // Daripada mengambil dari database, kita definisikan langkah-langkah secara statis
        $steps = $this->getAlurDanaSteps($isDanaKemahasiswaan);

        // Ambil progress yang sudah disimpan dari tabel LaporanDokumen
        $laporanDokumens = LaporanDokumen::where('program_kerja_id', $id)
            ->get();

        // Inisialisasi progress dari laporan dokumen
        $progress = $this->mapProgressFromLaporanDokumen($laporanDokumens, $steps);
        // dd($progress);
        // Hitung statistik progress
        $totalSteps = count($steps);
        $completedSteps = count(array_filter($progress, function ($item) {
            return $item['status'] === 'selesai';
        }));
        $inProgressSteps = count(array_filter($progress, function ($item) {
            return $item['status'] === 'sedang_dikerjakan';
        }));
        $progressPercentage = $totalSteps > 0 ? ($completedSteps / $totalSteps) * 100 : 0;

        return view('program-kerja.dokumen.proposal.progress', compact(
            'programKerja',
            'user',
            'steps',
            'progress',
            'isDanaKemahasiswaan',
            'totalSteps',
            'completedSteps',
            'inProgressSteps',
            'progressPercentage',
            'kode_ormawa'
        ));
    }

    /**
     * Mendapatkan definisi langkah-langkah alur dana
     *
     * @param bool $isDanaKemahasiswaan
     * @return array
     */
    private function getAlurDanaSteps($isDanaKemahasiswaan = true)
    {
        if ($isDanaKemahasiswaan) {
            return [
                [
                    'step_number' => 1,
                    'nama' => 'Membuat Proposal',
                    'deskripsi' => 'Buat proposal kegiatan yang akan diajukan untuk mendapatkan dana.',
                    'icon' => 'bi-pencil-square',
                    'requires_upload' => false
                ],
                [
                    'step_number' => 2,
                    'nama' => 'Mengajukan Proposal',
                    'deskripsi' => 'Ajukan proposal ke BEM FT untuk diaudit oleh BEM FT dan DPM FT.',
                    'icon' => 'bi-send',
                    'requires_upload' => false
                ],
                [
                    'step_number' => 3,
                    'nama' => 'Audit Proposal',
                    'deskripsi' => 'Proposal diaudit oleh BEM FT dan DPM FT. Jika tidak ada revisi, lanjut ke langkah berikutnya.',
                    'icon' => 'bi-search',
                    'requires_upload' => false
                ],
                [
                    'step_number' => 4,
                    'nama' => 'Tanda Tangan Pimpinan DPM FT',
                    'deskripsi' => 'Setelah disetujui, proposal ditandatangani oleh Pimpinan DPM FT dan dikembalikan ke ORMAWA.',
                    'icon' => 'bi-pen',
                    'requires_upload' => true
                ],
                [
                    'step_number' => 5,
                    'nama' => 'Tanda Tangan Gubernur FT',
                    'deskripsi' => 'Proposal ditandatangani oleh Gubernur FT dan dikembalikan ke ORMAWA.',
                    'icon' => 'bi-person-badge',
                    'requires_upload' => true
                ],
                [
                    'step_number' => 6,
                    'nama' => 'Pengajuan BS ke AD BEM FT',
                    'deskripsi' => 'ORMAWA mengajukan BS (Bon Sementara) ke AD BEM FT.',
                    'icon' => 'bi-cash',
                    'requires_upload' => true
                ],
                [
                    'step_number' => 7,
                    'nama' => 'Arsip',
                    'deskripsi' => 'Proposal disimpan di Arsip DPM FT dan Arsip BEM FT untuk catatan dokumen.',
                    'icon' => 'bi-archive',
                    'requires_upload' => false
                ],
                [
                    'step_number' => 8,
                    'nama' => 'Transfer Dana',
                    'deskripsi' => 'Setelah proses selesai, dana ditransfer ke rekening Bendahara Acara.',
                    'icon' => 'bi-bank',
                    'requires_upload' => true
                ],
            ];
        } else {
            // Definisi langkah-langkah untuk dana jurusan
            return [
                // Definisikan langkah-langkah untuk dana jurusan
                [
                    'step_number' => 1,
                    'nama' => 'Membuat Proposal Dana Jurusan',
                    'deskripsi' => 'Buat proposal kegiatan yang akan diajukan untuk mendapatkan dana jurusan.',
                    'icon' => 'bi-pencil-square',
                    'requires_upload' => false
                ],
                // Tambahkan langkah-langkah lain untuk dana jurusan
            ];
        }
    }

    /**
     * Memetakan progress dari LaporanDokumen ke format yang sesuai untuk view
     *
     * @param Collection $laporanDokumens
     * @param array $steps
     * @return array
     */
    private function mapProgressFromLaporanDokumen($laporanDokumens, $steps)
    {
        $progress = [];

        // Inisialisasi semua langkah sebagai belum mulai
        foreach ($steps as $step) {
            $progress[$step['step_number']] = [
                'step_number' => $step['step_number'],
                'status' => 'belum_mulai',
                'dokumen_id' => null,
                'catatan' => null,
                'completed_by' => null,
                'completed_at' => null
            ];
        }

        // Cari dokumen proposal
        $proposal = $laporanDokumens->where('tipe', 'proposal')->first();

        if ($proposal) {
            $currentStep = $proposal->step;

            // Semua langkah sebelum currentStep sudah selesai
            for ($i = 1; $i < $currentStep; $i++) {
                if (isset($progress[$i])) {
                    $progress[$i]['status'] = 'selesai';
                    $progress[$i]['dokumen_id'] = $proposal->id;
                    $progress[$i]['catatan'] = $proposal->catatan_revisi;
                    $progress[$i]['completed_by'] = $proposal->created_by;
                    $progress[$i]['completed_at'] = $proposal->created_at;
                }
            }

            // Langkah currentStep sedang dikerjakan
            if (isset($progress[$currentStep])) {
                $progress[$currentStep]['status'] = 'sedang_dikerjakan';
                $progress[$currentStep]['dokumen_id'] = $proposal->id;
            }
        }

        return $progress;
    }

    public function updateStep(Request $request, $kode_ormawa, $id)
    {
        $request->validate([
            'step_number' => 'required|integer',
            'status' => 'required|in:belum_mulai,sedang_dikerjakan,selesai',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $programKerja = ProgramKerja::findOrFail($id);
            $stepNumber = $request->step_number;
            $status = $request->status;

            // Cari dokumen proposal untuk program kerja ini
            $proposal = LaporanDokumen::where('program_kerja_id', $id)
                ->where('tipe', 'proposal')
                ->first();

            if (!$proposal) {
                // Jika tidak ada dokumen proposal, berarti belum ada langkah yang diselesaikan
                return response()->json([
                    'success' => false,
                    'message' => 'Dokumen proposal tidak ditemukan'
                ], 404);
            }

            // Update status step berdasarkan stepNumber
            if ($status === 'selesai') {
                // Jika langkah ini selesai, update step ke langkah berikutnya
                $proposal->step = $stepNumber + 1;
                $proposal->status = 'disetujui'; // Atau status yang sesuai
                $proposal->catatan_revisi = $request->catatan;
                $proposal->updated_by = Auth::id();
                $proposal->save();
            } else if ($status === 'sedang_dikerjakan') {
                // Jika langkah ini sedang dikerjakan, update step ke langkah ini
                $proposal->step = $stepNumber;
                $proposal->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status langkah berhasil diperbarui',
                'data' => $proposal
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
}
