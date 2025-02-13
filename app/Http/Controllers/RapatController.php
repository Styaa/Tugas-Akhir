<?php

namespace App\Http\Controllers;

use App\Models\DivisiOrmawa;
use App\Models\DivisiProgramKerja;
use App\Models\IzinRapat;
use App\Models\Ormawa;
use App\Models\ProgramKerja;
use App\Models\Rapat;
use App\Models\RapatPartisipasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kodeOrmawa = $request->kode_ormawa;
        $userId = Auth::id(); // Ambil user yang sedang login

        // Ambil semua rapat berdasarkan kode Ormawa
        $meetings = Rapat::where('ormawa_id', $kodeOrmawa);

        // Jika user memilih "Your Meetings", cari rapat yang diikuti oleh user
        if ($request->has('filter') && $request->filter == 'your_meetings') {
            $rapatIds = RapatPartisipasi::where('user_id', $userId)->pluck('rapat_id'); // Ambil ID rapat yang diikuti
            $meetings = $meetings->whereIn('id', $rapatIds);
        }

        $meetings = $meetings->get();

        // Jika request AJAX, kembalikan hanya HTML rapat
        if ($request->ajax()) {
            return response()->json([
                'html' => view('includes.partials.meeting-list', compact('meetings'))->render()
            ]);
        }

        return view('rapat.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($kode_ormawa, Request $request)
    {
        // Ambil divisi berdasarkan kode ormawa
        $divisiOrmawas = DivisiOrmawa::where('ormawas_kode', $kode_ormawa)->get();

        // Ambil program kerja berdasarkan kode ormawa
        $programKerjas = ProgramKerja::where('ormawas_kode', $kode_ormawa)->get();

        // Ambil divisi program kerja berdasarkan program kerja yang ada dalam ormawa
        $divisiProgramKerjas = DivisiProgramKerja::whereIn('program_kerjas_id', $programKerjas->pluck('id'))->get();

        // Ambil user yang berada dalam struktur organisasi yang memiliki divisi yang sesuai dengan kode_ormawa
        $users = User::whereHas('strukturOrmawas', function ($query) use ($kode_ormawa) {
            $query->whereHas('divisiOrmawas', function ($q) use ($kode_ormawa) {
                $q->where('ormawas_kode', $kode_ormawa);
            });
        })->get();

        return view('rapat.create', compact('divisiOrmawas', 'programKerjas', 'divisiProgramKerjas', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($kode_oramwa, Request $request)
    {
        //
        $validated = $request->validate([
            'meetingName' => 'required|string|max:255',
            'meetingTopic' => 'nullable|string',
            'meetingDate' => 'required|date',
            'meetingTime' => 'required',
            'meetingLocation' => 'required|string|max:255',
            'ormawa_id' => 'nullable|string|max:255',
            'divisi_ormawas_id' => 'nullable|integer',
            'program_kerjas_id' => 'nullable|integer',
            'divisi_program_kerjas_id' => 'nullable|integer',
        ]);
        // dd($request['participants']);
        $userId = Auth::id();

        try {
            DB::beginTransaction();

            // Simpan Rapat
            $rapat = Rapat::create([
                'nama' => $validated['meetingName'],
                'topik' => $validated['meetingTopic'],
                'tanggal' => $validated['meetingDate'],
                'waktu' => $validated['meetingTime'],
                'tempat' => $validated['meetingLocation'],
                'ormawa_id' => $kode_oramwa,
                'divisi_ormawas_id' => $validated['divisi_ormawas_id'] ?? null,
                'program_kerjas_id' => $validated['program_kerjas_id'] ?? null,
                'divisi_program_kerjas_id' => $validated['divisi_program_kerjas_id'] ?? null,
                'created_by' => $userId,
            ]);

            // Simpan Partisipasi Rapat
            foreach ($request['participants'] as $userId) {
                RapatPartisipasi::create([
                    'rapat_id' => $rapat->id,
                    'user_id' => $userId,
                    'status_kehadiran' => 'absen', // Default hadir
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Rapat berhasil dibuat dan partisipasi dicatat.'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan rapat.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($kode_ormawa, Request $request)
    {
        //
        $rapat = Rapat::with(['peserta.user'])->where('ormawa_id', $kode_ormawa)->findOrFail($request->id_rapat);

        // Kirim data ke tampilan
        return view('rapat.show', compact('rapat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function perizinan($kode_ormawa){
        $izinRapat = IzinRapat::whereHas('rapat', function ($query) use ($kode_ormawa) {
            $query->where('ormawa_id', $kode_ormawa);
        })->with(['user', 'rapat'])->get();

        // dd($izinRapat);

        return view('rapat.perizinan', compact('izinRapat'));
    }

    public function izin($kode_oramwa, Request $request){
        IzinRapat::create([
            'user_id' => auth()->id(),
            'rapat_id' => $request->id_rapat,
            'alasan' => $request->alasan_izin,
        ]);

        return redirect()->back()->with('success', 'Izin berhasil diajukan.');
    }
}
