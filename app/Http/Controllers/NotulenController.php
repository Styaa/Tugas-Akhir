<?php

namespace App\Http\Controllers;

use App\Models\DivisiOrmawa;
use App\Models\DivisiProgramKerja;
use App\Models\Notulen;
use App\Models\Ormawa;
use App\Models\ProgramKerja;
use App\Models\Rapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotulenController extends Controller
{
    //
    public function index(Request $request, $kode_ormawa)
    {
        $query = Notulen::with([
            'user',
            'rapat',
            'ormawa',
            'divisiOrmawa',
            'programKerja',
            'divisiProgramKerja.divisiPelaksana'
        ])->where('ormawas_id', $kode_ormawa);

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Handle filtering by penyelenggara
        if ($request->has('filter') && !empty($request->filter)) {
            switch ($request->filter) {
                case 'ormawas':
                    $query->whereNull('divisi_ormawas_id')
                        ->whereNull('program_kerjas_id')
                        ->whereNull('divisi_program_kerjas_id');
                    break;
                case 'divisi_ormawas':
                    $query->whereNotNull('divisi_ormawas_id');
                    break;
                case 'program_kerjas':
                    $query->whereNotNull('program_kerjas_id')
                        ->whereNull('divisi_program_kerjas_id');
                    break;
                case 'divisi_program_kerjas':
                    $query->whereNotNull('divisi_program_kerjas_id');
                    break;
            }
        }

        // If filtering by rapat
        if ($request->has('rapat_id') && !empty($request->rapat_id)) {
            $query->where('rapat_id', $request->rapat_id);
        }

        $notulens = $query->latest()->paginate(10);

        // dd($notulens[0]);

        return view('rapat.notulen.index', compact('notulens', 'kode_ormawa'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'rapat_id' => 'required|exists:rapats,id',
            'ormawa_id' => 'required|exists:ormawas,kode',
            'divisi_ormawas_id' => 'nullable|exists:divisi_ormawas,id',
            'program_kerjas_id' => 'nullable|exists:program_kerjas,id',
            'divisi_program_kerjas_id' => 'nullable|exists:divisi_program_kerjas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $notulen = new Notulen();
            $notulen->title = $request->title;
            $notulen->content = $request->content;
            $notulen->user_id = Auth::id();
            $notulen->rapat_id = $request->rapat_id;
            $notulen->ormawa_id = $request->ormawa_id;
            $notulen->divisi_ormawas_id = $request->divisi_ormawas_id;
            $notulen->program_kerjas_id = $request->program_kerjas_id;
            $notulen->divisi_program_kerjas_id = $request->divisi_program_kerjas_id;

            $notulen->save();

            return response()->json([
                'message' => 'Notulen saved successfully',
                'id' => $notulen->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to save notulen',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, $ormawaKode, $id)
    {
        $notulen = Notulen::with([
            'user',
            'rapat',
            'ormawa',
            'divisiOrmawa',
            'programKerja',
            'divisiProgramKerja'
        ])->findOrFail($id);

        return view('rapat.notulen.show', compact('notulen', 'ormawaKode'));
    }

    public function edit(Request $request, $ormawaKode, $id)
    {
        $notulen = Notulen::with([
            'user',
            'rapat',
            'ormawa',
            'divisiOrmawa',
            'programKerja',
            'divisiProgramKerja'
        ])->findOrFail($id);

        // Make sure user has permission to edit
        if (Auth::id() !== $notulen->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit notulen ini');
        }

        // Dapatkan ormawa berdasarkan kode
        $ormawa = Ormawa::where('kode', $ormawaKode)->first();

        // Ambil daftar rapat untuk dropdown
        $rapats = Rapat::where('ormawa_id', $ormawaKode)
            ->latest('tanggal')
            ->get();

        // Ambil daftar divisi ormawa untuk dropdown
        $divisiOrmawas = DivisiOrmawa::where('ormawas_kode', $ormawaKode)->get();

        // Ambil daftar program kerja untuk dropdown
        $programKerjas = ProgramKerja::where('ormawas_kode', $ormawaKode)->get();

        // Ambil daftar divisi program kerja untuk dropdown
        $divisiProgramKerjas = DivisiProgramKerja::whereHas('programKerja', function ($query) use ($ormawaKode) {
            $query->where('ormawas_kode', $ormawaKode);
        })->with('divisiPelaksana', 'programKerja')->get();

        return view('rapat.notulen.edit', compact(
            'notulen',
            'ormawa',
            'rapats',
            'divisiOrmawas',
            'programKerjas',
            'divisiProgramKerjas'
        ));
    }

    public function update(Request $request, $ormawaKode, $id)
    {
        $notulen = Notulen::findOrFail($id);

        // Make sure user has permission to edit
        if (Auth::id() !== $notulen->user_id) {
            return response()->json([
                'message' => 'You do not have permission to edit this notulen'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'rapat_id' => 'required|exists:rapats,id',
            'ormawa_id' => 'required|exists:ormawas,kode',
            'divisi_ormawas_id' => 'nullable|exists:divisi_ormawas,id',
            'program_kerjas_id' => 'nullable|exists:program_kerjas,id',
            'divisi_program_kerjas_id' => 'nullable|exists:divisi_program_kerjas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $notulen->title = $request->title;
            $notulen->content = $request->content;
            $notulen->rapat_id = $request->rapat_id;
            $notulen->ormawa_id = $request->ormawa_id;
            $notulen->divisi_ormawas_id = $request->divisi_ormawas_id;
            $notulen->program_kerjas_id = $request->program_kerjas_id;
            $notulen->divisi_program_kerjas_id = $request->divisi_program_kerjas_id;

            $notulen->save();

            return response()->json([
                'message' => 'Notulen updated successfully',
                'id' => $notulen->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update notulen',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $ormawaKode, $id)
    {
        $notulen = Notulen::findOrFail($id);

        // Make sure user has permission to delete
        if (Auth::id() !== $notulen->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus notulen ini');
        }

        try {
            $notulen->delete();
            return redirect()->route('rapat.notulen.index', ['kode_ormawa' => $ormawaKode])
                ->with('success', 'Notulen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus notulen: ' . $e->getMessage());
        }
    }

    public function apiSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'rapat_id' => 'required|exists:rapats,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get rapat to fill in related data
            $rapat = Rapat::findOrFail($request->rapat_id);

            $notulen = new Notulen();
            $notulen->title = $request->title;
            $notulen->content = $request->content;
            $notulen->users_id = Auth::id();
            $notulen->rapats_id = $request->rapat_id;
            $notulen->ormawas_id = $rapat->ormawa_id;

            // Set optional foreign keys if they exist in the rapat or request
            $notulen->divisi_ormawas_id = $request->divisi_ormawas_id ?? $rapat->divisi_ormawas_id;
            $notulen->program_kerjas_id = $request->program_kerjas_id ?? $rapat->program_kerjas_id;
            $notulen->divisi_program_kerjas_id = $request->divisi_program_kerjas_id ?? $rapat->divisi_program_kerjas_id;

            $notulen->save();

            return response()->json([
                'message' => 'Notulen saved successfully',
                'id' => $notulen->id,
                'ormawa_id' => $notulen->ormawa_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to save notulen',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
