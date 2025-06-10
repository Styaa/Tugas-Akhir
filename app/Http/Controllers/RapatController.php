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
            // foreach ($users as $user) {
            //     Notification::send($user, new RapatDibuatNotification($rapat));
            // }

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
        // Get the rapat with participants
        $rapat = Rapat::with(['peserta.user'])->where('ormawa_id', $kode_ormawa)->findOrFail($request->id_rapat);

        // Get excused absence requests
        $daftarIzin = IzinRapat::where('rapat_id', $request->id_rapat)->with('user')->get();

        // Get attendance records (rapat_partisipasi)
        $rapat_partisipasi = RapatPartisipasi::where('rapat_id', $request->id_rapat)
            ->with('user')
            ->get();

        // Check if user has permission to mark attendance
        $canMarkAttendance = $this->userCanMarkAttendance($rapat);

        // Get participation statistics
        $stats = $this->getMeetingParticipationStats($request->id_rapat);

        return view('rapat.show', compact('rapat', 'daftarIzin', 'rapat_partisipasi', 'canMarkAttendance', 'stats', 'kode_ormawa'));
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
        // Get all izin related to the ormawa
        $daftarIzin = IzinRapat::with(['user', 'rapat'])
            ->whereHas('rapat', function ($query) use ($kode_ormawa) {
                $query->where('ormawa_id', $kode_ormawa);
            })
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('rapat.perizinan', compact('daftarIzin', 'kode_ormawa'));
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

    public function absensi($kode_ormawa, Request $request)
    {
        $id_rapat = $request->id_rapat;
        $rapat = Rapat::where('ormawa_id', $kode_ormawa)->findOrFail($id_rapat);

        // Check if user has permission to mark attendance
        if (!$this->userCanMarkAttendance($rapat)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengisi absensi rapat.');
        }

        // Validate request
        $validated = $request->validate([
            'kehadiran' => 'required|array',
            'kehadiran.*.user_id' => 'required|exists:users,id',
            'kehadiran.*.hadir' => 'nullable',
            'kehadiran.*.status' => 'nullable|in:hadir,absen',
            'kehadiran.*.waktu' => 'nullable|date_format:H:i',
            'catatan_absensi' => 'nullable|string',
        ]);

        // Begin transaction
        DB::beginTransaction();

        try {
            // Process attendance for each participant
            foreach ($validated['kehadiran'] as $userId => $data) {
                $user_id = $data['user_id'];

                // Check if there's an existing participation record
                $partisipasi = RapatPartisipasi::where('rapat_id', $id_rapat)
                    ->where('user_id', $user_id)
                    ->first();

                // Check if user has an excused absence with 'disetujui' status
                $hasApprovedIzin = IzinRapat::where('rapat_id', $id_rapat)
                    ->where('user_id', $user_id)
                    ->where('status', 'disetujui')
                    ->exists();

                // Determine attendance status
                $status_kehadiran = 'absen';
                if (isset($data['hadir']) || (isset($data['status']) && $data['status'] === 'hadir')) {
                    $status_kehadiran = 'hadir';
                }

                // Set check-in time for present participants
                $waktu_check_in = null;
                if ($status_kehadiran === 'hadir' && isset($data['waktu'])) {
                    $waktu_check_in = date('Y-m-d ') . $data['waktu'] . ':00';
                }

                // If user has an approved izin, don't update attendance
                if ($hasApprovedIzin) {
                    continue;
                } else {
                    $partisipasi->update([
                        'status_kehadiran' => $status_kehadiran,
                        'waktu_check_in' => $waktu_check_in,
                    ]);
                }

                if ($partisipasi) {
                    // Update existing record
                    $partisipasi->update([
                        'status_kehadiran' => $status_kehadiran,
                        'waktu_check_in' => $waktu_check_in,
                    ]);
                } else {
                    // Create new record
                    RapatPartisipasi::create([
                        'rapat_id' => $id_rapat,
                        'user_id' => $user_id,
                        'status_kehadiran' => $status_kehadiran,
                        'waktu_check_in' => $waktu_check_in,
                    ]);
                }

                // If attendance is marked as present, update any rejected izin status
                if ($status_kehadiran === 'hadir') {
                    // Find any rejected izin and mark it as superseded by attendance
                    $rejectedIzin = IzinRapat::where('rapat_id', $id_rapat)
                        ->where('user_id', $user_id)
                        ->where('status', 'ditolak')
                        ->first();

                    if ($rejectedIzin) {
                        $rejectedIzin->update([
                            'status' => 'ditolak_hadir',  // Custom status to indicate overridden by attendance
                            'tanggal_verifikasi' => now(),
                        ]);
                    }
                }
            }

            // Update meeting with attendance notes
            if (isset($validated['catatan_absensi'])) {
                $rapat->update([
                    'catatan_absensi' => $validated['catatan_absensi']
                ]);
            }

            DB::commit();

            return redirect()->route('rapat.show', ['kode_ormawa' => $kode_ormawa, 'id_rapat' => $id_rapat])
                ->with('success', 'Absensi peserta rapat berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created excuse request in storage.
     *
     * @param  string  $kode_ormawa
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIzin($kode_ormawa, Request $request)
    {
        $rapat = Rapat::where('ormawa_id', $kode_ormawa)->findOrFail($request->id_rapat);

        // Check if user already has an excuse request for this meeting
        $existingIzin = IzinRapat::where('rapat_id', $request->id_rapat)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingIzin) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan izin untuk rapat ini.');
        }

        // Validate request
        $validated = $request->validate([
            'alasan' => 'required|string|min:10',
        ]);

        // Create excuse request
        IzinRapat::create([
            'rapat_id' => $request->id_rapat,
            'user_id' => Auth::id(),
            'alasan' => $validated['alasan'],
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()->route('rapat.show', ['kode_ormawa' => $kode_ormawa, 'id_rapat' => $request->id_rapat])
            ->with('success', 'Permohonan izin berhasil diajukan.');
    }

    /**
     * Update the specified excuse request in storage.
     *
     * @param  string  $kode_ormawa
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateIzin($kode_ormawa, $id_izin, Request $request)
    {
        // Get the id_rapat from the query string
        $id_rapat = $request->query('id_rapat');

        // Find the izin
        $izin = IzinRapat::findOrFail($id_izin);

        // Ensure the izin belongs to the specified meeting
        if ($izin->rapat_id != $id_rapat) {
            return redirect()->back()->with('error', 'Data izin tidak valid.');
        }

        // Get the rapat
        $rapat = Rapat::where('id', $id_rapat)
            ->where('ormawa_id', $kode_ormawa)
            ->firstOrFail();

        // Check permissions (only coordinators/chairs can approve/reject)
        $user = Auth::user();
        $isAuthorized = false;

        // Meeting creator always has permission
        if ($rapat->created_by === $user->id) {
            $isAuthorized = true;
        }

        // Check if user has coordinator/chair role in ormawa
        if (!$isAuthorized && $rapat->ormawa_id) {
            $hasOrmawaPower = DB::table('struktur_ormawas')
                ->where('users_id', $user->id)
                ->where('jabatan_id', '<=', 3) // Ketua, Wakil Ketua, SC
                ->exists();

            if ($hasOrmawaPower) {
                $isAuthorized = true;
            }
        }

        if (!$isAuthorized) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memverifikasi izin rapat.');
        }

        // Validate request
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        // Begin transaction
        DB::beginTransaction();

        try {
            // Update excuse status
            $izin->update([
                'status' => $request->status,
                'tanggal_verifikasi' => now(),
                'verifikasi_oleh' => $user->id,
            ]);

            // If excuse is approved, update or create participation record
            if ($request->status === 'disetujui') {
                RapatPartisipasi::updateOrCreate(
                    ['rapat_id' => $id_rapat, 'user_id' => $izin->user_id],
                    [
                        'status_kehadiran' => 'izin',
                        'alasan' => $izin->alasan
                    ]
                );
            }

            DB::commit();

            return redirect()->route('rapat.show', [
                'kode_ormawa' => $kode_ormawa,
                'id_rapat' => $id_rapat
            ])->with('success', 'Status izin berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function getMeetingParticipationStats($id_rapat)
    {
        // Count total participants
        $totalParticipants = RapatPartisipasi::where('rapat_id', $id_rapat)->count();

        // Count attendance by status
        $hadir = RapatPartisipasi::where('rapat_id', $id_rapat)
            ->where('status_kehadiran', 'hadir')
            ->count();

        $izin = IzinRapat::where('rapat_id', $id_rapat)
            ->where('status', 'disetujui')
            ->count();

        $absen = $totalParticipants - $hadir - $izin;

        // Calculate percentages
        $persenHadir = $totalParticipants > 0 ? round(($hadir / $totalParticipants) * 100) : 0;
        $persenIzin = $totalParticipants > 0 ? round(($izin / $totalParticipants) * 100) : 0;
        $persenAbsen = $totalParticipants > 0 ? round(($absen / $totalParticipants) * 100) : 0;

        return [
            'total' => $totalParticipants,
            'hadir' => $hadir,
            'izin' => $izin,
            'absen' => $absen,
            'persenHadir' => $persenHadir,
            'persenIzin' => $persenIzin,
            'persenAbsen' => $persenAbsen,
        ];
    }

    /**
     * Check if user has permission to mark attendance
     *
     * @param  \App\Models\Rapat  $rapat
     * @return bool
     */
    private function userCanMarkAttendance($rapat)
    {
        $user = Auth::user();

        // Meeting creator always has permission
        if ($rapat->created_by === $user->id) {
            return true;
        }

        // Check if user has coordinator/chair role in ormawa
        if ($rapat->ormawa_id) {
            $hasOrmawaPower = DB::table('struktur_ormawas')
                ->where('users_id', $user->id)
                ->where('jabatan_id', '<=', 3) // Ketua, Wakil Ketua, SC
                ->exists();

            if ($hasOrmawaPower) {
                return true;
            }
        }

        return false;
    }
}
