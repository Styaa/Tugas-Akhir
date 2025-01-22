<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDivisiProgramKerja;
use App\Models\DivisiPelaksana;
use App\Models\DivisiProgramKerja;
use App\Models\Jabatan;
use App\Models\ProgramKerja;
use App\Models\StrukturProker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\alert;

class ProgramKerjaController extends Controller
{
    //
    public function index()
    {
        //
        $programKerjas = ProgramKerja::all();
        $divisiPelaksanas = DivisiPelaksana::all();
        $periode = date('Y');
        $user = Auth::user();
        $kode_ormawa = $user->strukturOrmawas()
            ->with('divisiOrmawas.ormawa')
            ->get()
            ->pluck('divisiOrmawas.ormawa.kode')
            ->first();

        // dd($programKerjas);
        return view('dashboard.project-dashboard', compact('programKerjas', 'divisiPelaksanas', 'periode', 'kode_ormawa'));
    }

    protected function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'manfaat' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'anggaran_dana' => 'required|string|max:255',
            'konsep' => 'required|string|max:45',
            'tempat' => 'required|string|max:45',
            'sasaran_kegiatan' => 'required|string|max:255',
            'indikator_keberhasilan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|timestamp',
            'tanggal_selesai' => 'required|timestamp',
            'anggaran' => 'required|array',
            'anggaran.*' => 'string',
            'divisis' => 'required|array',
            'divisis.*' => 'string'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    }

    protected function storeProker(Request $request)
    {
        // dd($request->all());
        ProgramKerja::create([
            'nama' => $request->nama,
            'tujuan' => json_encode($request->tujuan),
            'deskripsi' => $request->deskripsi, // Hash password
            'manfaat' => json_encode($request->manfaat),
            'tipe' => $request->tipe,
            'anggaran_dana' => json_encode($request->anggaran),
            'konsep' => $request->konsep,
            'tempat' => $request->tempat,
            'sasaran_kegiatan' => $request->sasaran, // Hash password
            'indikator_keberhasilan' => $request->indikator,
            'tanggal_mulai' => $request->mulai,
            'tanggal_selesai' => $request->selesai,
            'ormawas_kode' => 'KSMIF',
            'periode' => $request->periode,
        ]);
    }

    protected function storeDivisi(Request $request)
    {
        $divisiValues = $request->divisis;

        // dd($divisiValues);

        // You can now use $anggaranValues as needed
        // For example, saving to the database or processing further
        // $anggaranValues will be an array of selected budget values

        // Example of processing anggaran values
        foreach ($divisiValues as $divisi) {
            DivisiProgramKerja::create([
                'program_kerjas_id' => ProgramKerja::latest()->first()->id,
                'divisi_pelaksanas_id' => $divisi,
            ]);
        }
    }

    public function create(Request $request)
    {
        $this->validateRequest($request);

        $this->storeProker($request);
        $this->storeDivisi($request);

        // Login user setelah registrasi
        // auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Program kerja berhasil ditambahkan.'); // Ganti dengan route yang sesuai
    }

    public function edit(Request $request)
    {
        $program = ProgramKerja::find($request->id); // Mengambil data program kerja berdasarkan ID
        $divisiProker = DivisiProgramKerja::where('program_kerjas_id', $request->id)->pluck('divisi_pelaksanas_id');
        // dd($divisiProker);
        return response()->json([
            'nama' => $program->nama,
            'tujuan' => json_decode($program->tujuan), // Pastikan dikembalikan sebagai JSON string
            'manfaat' => json_decode($program->manfaat), // Pastikan dikembalikan sebagai JSON string
            'deskripsi' => $program->deskripsi,
            'tipe' => $program->tipe,
            'anggaran' => json_decode($program->anggaran_dana),
            'konsep' => $program->konsep,
            'tempat' => $program->tempat,
            'sasaran' => $program->sasaran_kegiatan,
            'indikator' => $program->indikator_keberhasilan,
            'tanggal_mulai' => $program->tanggal_mulai,
            'tanggal_selesai' => $program->tanggal_selesai,
            'divisis' => $divisiProker,
        ]);
    }

    protected function updateDivisiProgramKerja(Request $request, $programKerjaId)
    {
        // Data baru dari request
        $divisiIdsBaru = $request->input('divisis'); // [1, 3]

        // Data lama dari database
        $divisiIdsLama = DivisiProgramKerja::where('program_kerjas_id', $programKerjaId)
            ->pluck('divisi_pelaksanas_id')
            ->toArray(); // Misalnya: [1, 2, 3]

        // Data yang perlu dihapus (lama tapi tidak ada di baru)
        $divisiIdsUntukDihapus = array_diff($divisiIdsLama, $divisiIdsBaru);

        // Data yang perlu ditambahkan (baru tapi tidak ada di lama)
        $divisiIdsUntukDitambahkan = array_diff($divisiIdsBaru, $divisiIdsLama);

        // Hapus data lama yang di-uncheck
        DivisiProgramKerja::where('program_kerjas_id', $programKerjaId)
            ->whereIn('divisi_pelaksanas_id', $divisiIdsUntukDihapus)
            ->delete();

        // Tambahkan data baru yang di-check
        foreach ($divisiIdsUntukDitambahkan as $divisiId) {
            DivisiProgramKerja::create([
                'program_kerjas_id' => $programKerjaId,
                'divisi_pelaksanas_id' => $divisiId,
            ]);
        }
    }

    public function update(Request $request, $kode_ormawa, $id)
    {
        // dd($request);
        $this->validateRequest($request);

        // dd($request->periode);

        // Cari data berdasarkan ID
        $programKerja = ProgramKerja::find($id);

        // Update data
        $programKerja->update([
            'nama' => $request->nama,
            'tujuan' => json_encode($request->tujuan),
            'deskripsi' => $request->deskripsi,
            'manfaat' => json_encode($request->manfaat),
            'tipe' => $request->tipe,
            'anggaran_dana' => json_encode($request->anggaran),
            'konsep' => $request->konsep,
            'tempat' => $request->tempat,
            'sasaran_kegiatan' => $request->sasaran,
            'indikator_keberhasilan' => $request->indikator,
            'tanggal_mulai' => $request->mulai,
            'tanggal_selesai' => $request->selesai,
            'ormawas_kode' => 'KSMIF',
            'periode' => $request->periode,
        ]);



        $this->updateDivisiProgramKerja($request, $id);

        // Redirect atau Response
        return redirect()->route('dashboard')->with('success', 'Program kerja berhasil diperbaharui.');
    }

    public function show($kode_ormawa, $id)
    {
        // Ambil data program kerja berdasarkan kode ormawa
        $programKerja = ProgramKerja::where('id', $id)->first();

        // Jika program kerja tidak ditemukan, kembalikan error
        if (!$programKerja) {
            return redirect()->back()->with('error', 'Program kerja tidak ditemukan.');
        }

        // Ambil data anggota
        $anggota = User::where('status', 'aktif')->get();

        $jabatans = Jabatan::all();

        // Ambil divisi terkait program kerja
        $divisi = DivisiProgramKerja::with('divisiPelaksana')
            ->where('program_kerjas_id', $programKerja->id)
            ->get()->toArray();

        $ids = array_column($divisi, 'id');

        // Format tanggal mulai
        $tanggal_mulai = Carbon::parse($programKerja->tanggal_mulai)->format('d F Y');

        $ketua = DB::table('struktur_prokers')
            ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->where('struktur_prokers.jabatans_id', 1)
            ->where('divisi_program_kerjas.divisi_pelaksanas_id', 4)
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->select('users.name')
            ->get();

        $anggotaProker = DB::table('struktur_prokers')
            ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->join('divisi_pelaksanas', 'divisi_program_kerjas.divisi_pelaksanas_id', '=', 'divisi_pelaksanas.id')
            ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->select('divisi_pelaksanas.nama AS nama_divisi', 'users.name AS nama_user', 'jabatans.nama AS nama_jabatan')
            ->orderBy('divisi_pelaksanas.nama')
            ->orderByRaw("FIELD(jabatans.nama, 'Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator', 'Wakil Koordinator', 'Anggota')")
            ->get();

        // Ambil aktivitas untuk semua divisi pelaksana yang terkait
        $activities = AktivitasDivisiProgramKerja::where('program_kerjas_id', $programKerja->id)->get();


        // dd($activities->first()->personInCharge->name);

        // dd($programKerja);

        // Periksa apakah tanggal selesai berbeda dengan tanggal mulai
        if ($programKerja->tanggal_selesai && $programKerja->tanggal_selesai != $programKerja->tanggal_mulai) {
            $tanggal_selesai = Carbon::parse($programKerja->tanggal_selesai)->format('d F Y');

            // Kembalikan view dengan semua data
            return view('program-kerja.show', compact('programKerja', 'anggota', 'divisi', 'tanggal_mulai', 'tanggal_selesai', 'ketua', 'anggotaProker', 'jabatans', 'activities', 'ids'));
        }

        // Kembalikan view tanpa tanggal selesai
        return view('program-kerja.show', compact('programKerja', 'anggota', 'divisi', 'tanggal_mulai', 'ketua', 'anggotaProker', 'jabatans', 'activities', 'ids'));
    }

    public function pilihKetua($kode_ormawa, $prokerId, $periode, $userId)
    {
        // Cari ID divisi_program_kerja berdasarkan divisi_pelaksanas_id dan program_kerjas_id
        $id = DB::table('divisi_program_kerjas')
            ->where('divisi_pelaksanas_id', 4)
            ->where('program_kerjas_id', $prokerId)
            ->value('id');

        // Jika ID tidak ditemukan
        if (!$id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi program kerja tidak ditemukan.',
            ], 404);
        }

        // Periksa apakah ada user yang sudah menjabat sebagai ketua (jabatans_id = 1) pada divisi_program_kerjas_id yang sama
        $existingKetua = StrukturProker::where('divisi_program_kerjas_id', $id)
            ->where('jabatans_id', 1)
            ->first();

        // dd($existingKetua);

        // Jika ada, hapus user sebelumnya
        if ($existingKetua) {
            $existingKetua->update(['users_id' => $userId]);

            return response()->json([
                'success' => 'Ketua berhasil diperbarui.',
                'data' => $existingKetua,
            ], 200);
        }

        // Periksa apakah user sudah berada pada divisi_program_kerjas_id yang sama
        $exists = StrukturProker::where('users_id', $userId)
            ->where('divisi_program_kerjas_id', $id)
            ->exists();

        if ($exists) {
            // Jika sudah ada, kembalikan respons JSON dengan pesan error
            return response()->json([
                'status' => 'error',
                'message' => 'User sudah berada di divisi program kerja yang sama.',
            ], 400);
        }

        // Jika tidak ada, tambahkan data baru
        $strukturProker = StrukturProker::create([
            'users_id' => $userId,
            'divisi_program_kerjas_id' => $id,
            'jabatans_id' => 1,
        ]);

        // Kembalikan respons JSON jika berhasil
        return response()->json([
            'status' => 'success',
            'message' => 'Ketua berhasil dipilih.',
            'data' => $strukturProker,
        ], 200);
    }




    public function pilihAnggota(Request $request, $kode_ormawa, $prokerId, $periode)
    {
        // dd($request);
        // $id = DB::table('divisi_program_kerjas')
        //     ->where('divisi_pelaksanas_id', $request->input('divisi'))
        //     ->where('program_kerjas_id', $prokerId)
        //     ->value('id');

        StrukturProker::create([
            'users_id' => $request->input('anggota'),
            'divisi_program_kerjas_id' => $request->input('divisi'),
            'jabatans_id' => $request->input('jabatan'),
        ]);

        return redirect()->route('program-kerja.show', [
            'kode_ormawa' => $kode_ormawa,
            'id' => $prokerId
        ])->with('success', 'Panitia berhasil dipilih.');
    }
}
