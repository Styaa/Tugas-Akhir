<?php

namespace App\Http\Controllers;

use App\Models\LaporanDokumen;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        $dokumenId = DB::table('laporan_dokumens')
            ->where('program_kerja_id', $id)
            ->where('ormawas_kode', $kode_ormawa)
            ->where('tipe', 'proposal')
            ->pluck('id')
            ->first();

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
            'kode_ormawa',
            'dokumenId'
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

    /**
     * Save new proposal via API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function SaveProposal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isi_dokumen' => 'required',
            'program_kerja_id' => 'required|exists:program_kerjas,id', // Changed to match DB column
            'tipe' => 'required|string|in:proposal', // Changed from 'type' to 'tipe'
            'status' => 'nullable|string|in:draft,submitted,approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get program_kerja to fill in related data
            $programKerja = ProgramKerja::findOrFail($request->program_kerja_id);

            $proposal = new LaporanDokumen();
            $proposal->isi_dokumen = $request->isi_dokumen; // Changed to match DB column
            $proposal->created_by = Auth::id(); // Assuming users_id exists
            $proposal->program_kerja_id = $request->program_kerja_id; // Changed to match DB column
            $proposal->ormawas_kode = $programKerja->ormawas_kode; // Changed to match DB column
            $proposal->tipe = $request->tipe; // Changed from 'type' to 'tipe'
            $proposal->status = $request->status ?? 'draft';
            $proposal->tanggal_pengajuan = now();

            // Set other database columns with defaults
            $proposal->step = $request->step ?? 1;

            // if ($request->has('tanggal_peninjauan')) {
            //     $proposal->tanggal_peninjauan = $request->tanggal_peninjauan;
            // }

            $proposal->save();

            // Update program_kerja status if needed
            // if ($request->status === 'submitted' && $programKerja->status === 'planning') {
            //     $programKerja->status = 'proposal_submitted';
            //     $programKerja->save();
            // }

            return response()->json([
                'message' => 'Proposal saved successfully',
                'id' => $proposal->id,
                'ormawa_kode' => $proposal->ormawas_kode // Changed to match DB column
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to save proposal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function UpdateProposal(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'isi_dokumen' => 'required',
            'program_kerja_id' => 'required|exists:program_kerjas,id',
            'tipe' => 'required|string|in:proposal',
            'status' => 'nullable|string|in:draft,submitted,approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Find existing proposal
            $proposal = LaporanDokumen::findOrFail($id);

            // Update fields
            $proposal->isi_dokumen = $request->isi_dokumen;
            $proposal->status = $request->status ?? $proposal->status;
            $proposal->updated_by = Auth::id();
            $proposal->step = $request->step ?? $proposal->step;

            // Update other fields if needed
            if ($request->status === 'submitted' && $proposal->tanggal_pengajuan === null) {
                $proposal->tanggal_pengajuan = now();
            }

            $proposal->save();

            return response()->json([
                'message' => 'Proposal updated successfully',
                'id' => $proposal->id,
                'ormawa_kode' => $proposal->ormawas_kode
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update proposal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save new laporan pertanggungjawaban (LPJ) via API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiSaveLPJ(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'program_kerjas_id' => 'required|exists:program_kerjas,id',
            'type' => 'required|string|in:lpj', // Ensure type is lpj
            'status' => 'nullable|string|in:draft,submitted,approved,rejected',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Optional file upload (10MB max)
            'implementation_date' => 'nullable|date',
            'budget_spent' => 'nullable|numeric',
            'participant_count' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get program_kerja to fill in related data
            $programKerja = ProgramKerja::findOrFail($request->program_kerjas_id);

            // Check if program is completed - only completed programs should have LPJs
            if ($programKerja->status !== 'completed' && $request->status === 'submitted') {
                return response()->json([
                    'message' => 'Cannot submit LPJ for a program that is not marked as completed',
                ], 422);
            }

            $lpj = new LaporanDokumen();
            $lpj->title = $request->title;
            $lpj->content = $request->content;
            $lpj->users_id = Auth::id();
            $lpj->program_kerjas_id = $request->program_kerjas_id;
            $lpj->ormawas_id = $programKerja->ormawa_id;
            $lpj->type = 'lpj';
            $lpj->status = $request->status ?? 'draft';

            // Set optional foreign keys if they exist in the request or program kerja
            $lpj->divisi_ormawas_id = $request->divisi_ormawas_id ?? $programKerja->divisi_ormawas_id;
            $lpj->divisi_program_kerjas_id = $request->divisi_program_kerjas_id ?? null;

            // Add LPJ specific data
            if ($request->has('implementation_date')) {
                $lpj->implementation_date = $request->implementation_date;
            }

            if ($request->has('budget_spent')) {
                $lpj->budget_spent = $request->budget_spent;
            }

            if ($request->has('participant_count')) {
                $lpj->participant_count = $request->participant_count;
            }

            // Handle file upload if present
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = 'lpj_' . time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('lpj', $fileName, 'public');
                $lpj->file_path = $filePath;
            }

            $lpj->save();

            // Update program_kerja status if needed
            if ($request->status === 'submitted' && $programKerja->status === 'completed') {
                $programKerja->status = 'lpj_submitted';
                $programKerja->save();
            }

            return response()->json([
                'message' => 'Laporan Pertanggungjawaban saved successfully',
                'id' => $lpj->id,
                'ormawa_id' => $lpj->ormawas_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to save Laporan Pertanggungjawaban',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
