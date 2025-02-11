<?php

namespace App\Http\Controllers;

use App\Models\DivisiOrmawa;
use App\Models\DivisiProgramKerja;
use App\Models\Ormawa;
use App\Models\ProgramKerja;
use App\Models\Rapat;
use App\Models\RapatPartisipasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $meetings = [
            [
                'title' => 'Problem Solving Office Hours',
                'day' => 'Wednesday',
                'time' => '3:00 PM',
                'host' => 'James Wang',
                'image' => 'https://source.unsplash.com/150x100/?office,meeting'
            ],
            [
                'title' => 'Research Group Meeting',
                'day' => 'Thursday',
                'time' => '10:00 AM',
                'host' => 'David Patterson',
                'image' => 'https://source.unsplash.com/150x100/?business,teamwork'
            ],
            [
                'title' => 'Lecture on Quantum Computing',
                'day' => 'Friday',
                'time' => '1:00 PM',
                'host' => 'Margaret Martonosi',
                'image' => 'https://source.unsplash.com/150x100/?science,lecture'
            ],
            [
                'title' => 'Monthly Organization Planning',
                'day' => 'Saturday',
                'time' => '4:00 PM',
                'host' => 'Ormawa Leader',
                'image' => 'https://source.unsplash.com/150x100/?planning,organization'
            ]
        ];

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
    public function show(string $id)
    {
        //
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

    public function perizinan(){
        return view('rapat.perizinan');
    }
}
