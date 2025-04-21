<?php

namespace App\Http\Controllers;

use App\Models\DivisiOrmawa;
use App\Models\DivisiProgramKerja;
use App\Models\IzinRapat;
use App\Models\Ormawa;
use App\Models\ProgramKerja;
use App\Models\Rapat;
use App\Models\RapatPartisipasi;
use App\Models\StrukturOrmawa;
use App\Models\StrukturProker;
use App\Models\User;
use App\Notifications\RapatDibuatNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kodeOrmawa = $request->kode_ormawa;
        $userId = Auth::id();

        // Start building the query
        $meetings = Rapat::where('ormawa_id', $kodeOrmawa);

        // Filter for user's meetings if requested
        if ($request->has('filter') && $request->filter == 'your_meetings') {
            $rapatIds = RapatPartisipasi::where('user_id', $userId)->pluck('rapat_id');
            $meetings = $meetings->whereIn('id', $rapatIds);
        }

        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $meetings = $meetings->where(function ($query) use ($searchTerm) {
                $query->where('nama', 'like', "%{$searchTerm}%")
                    ->orWhere('topik', 'like', "%{$searchTerm}%")
                    ->orWhere('tempat', 'like', "%{$searchTerm}%");
            });
        }

        $meetings = $meetings->get();

        // If AJAX request, return only the HTML
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

        // Get division data for each user
        foreach ($users as $user) {
            // Get division information
            $divisionData = StrukturOrmawa::where('users_id', $user->id)
                ->with('divisiOrmawas')
                ->first();

            $user->division = $divisionData ? $divisionData->divisiOrmawas : null;

            // Get program_kerja data where user is a member
            $prokerStructures = StrukturProker::where('users_id', $user->id)
                ->with('divisiProgramKerja.programKerja')
                ->get();

            // Add program and division proker IDs to user for easier filtering
            $user->program_ids = $prokerStructures->pluck('divisiProgramKerja.program_kerjas_id')->unique()->toArray();
            $user->division_proker_ids = $prokerStructures->pluck('divisi_program_kerjas_id')->toArray();
        }

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
            'sessionFormat' => 'required',
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
                'tipe' => $validated['sessionFormat'],
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

            $users = User::whereIn('id', function ($query) use ($rapat) {
                $query->select('user_id')
                    ->from('rapat_partisipasis')
                    ->where('rapat_id', $rapat->id);
            })->get();

            // Kirim notifikasi ke semua peserta rapat
            foreach ($users as $user) {
                Notification::send($user, new RapatDibuatNotification($rapat));
            }

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
        $rapat = Rapat::with(['peserta.user'])->where('ormawa_id', $kode_ormawa)->findOrFail($request->id_rapat);
        $daftarIzin = IzinRapat::where('rapat_id', $request->id_rapat);

        return view('rapat.show', compact('rapat', 'daftarIzin'));
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

    public function perizinan($kode_ormawa)
    {
        $izinRapat = IzinRapat::whereHas('rapat', function ($query) use ($kode_ormawa) {
            $query->where('ormawa_id', $kode_ormawa);
        })->with(['user', 'rapat'])->get();

        // dd($izinRapat);

        return view('rapat.perizinan', compact('izinRapat'));
    }

    public function izin($kode_oramwa, Request $request)
    {
        IzinRapat::create([
            'user_id' => auth()->id(),
            'rapat_id' => $request->id_rapat,
            'alasan' => $request->alasan_izin,
        ]);

        return redirect()->back()->with('success', 'Izin berhasil diajukan.');
    }

    public function kalender($kode_oramwa)
    {
        return view('kalender');
    }

    public function tulisNotulensi($id_rapat)
    {
        return view('rapat.notulen');
    }
}
