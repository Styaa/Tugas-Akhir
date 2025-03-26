<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDivisiProgramKerja;
use App\Models\DivisiPelaksana;
use App\Models\DivisiProgramKerja;
use App\Models\Document;
use App\Models\Evaluasi;
use App\Models\IzinRapat;
use App\Models\Jabatan;
use App\Models\Notulen;
use App\Models\ProgramKerja;
use App\Models\RancanganAnggaranBiaya;
use App\Models\Rapat;
use App\Models\RapatPartisipasi;
use App\Models\StrukturProker;
use App\Models\User;
use App\Notifications\EvaluasiSelesaiNotification;
use App\Services\SimpleAdditiveWeightingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;

class ProgramKerjaController extends Controller
{
    //
    protected $sawService;

    public function __construct(SimpleAdditiveWeightingService $sawService)
    {
        $this->sawService = $sawService;
    }

    public function index()
    {
        //
        $divisiPelaksanas = DivisiPelaksana::all();
        $periode = date('Y');
        $user = Auth::user();
        $kode_ormawa = $user->strukturOrmawas()
            ->with('divisiOrmawas.ormawa')
            ->get()
            ->pluck('divisiOrmawas.ormawa.kode')
            ->first();

        $programKerjas = ProgramKerja::where('ormawas_kode', $kode_ormawa)
            ->with(['divisiProgramKerjas.strukturProker', 'strukturProkers.jabatan'])
            ->get()
            ->map(function ($program) {
                // dd($program);
                // Ambil status program kerja berdasarkan tanggal
                $today = \Carbon\Carbon::today();
                $program->status = $today->lt($program->tanggal_mulai) ? 'Belum Dimulai' : ($today->between($program->tanggal_mulai, $program->tanggal_selesai) ? 'Sedang Berlangsung' : 'Selesai');

                // Hitung total hari antara tanggal mulai dan selesai
                $totalDays = \Carbon\Carbon::parse($program->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($program->tanggal_selesai));

                // Hitung hari yang sudah berjalan sejak `created_at`
                $daysPassed = \Carbon\Carbon::parse($program->created_at)->diffInDays($today);

                // Hitung sisa hari menuju tanggal selesai
                $daysLeft = \Carbon\Carbon::parse($program->tanggal_selesai)->diffInDays($today, false);
                $program->days_left = $daysLeft > 0 ? "$daysLeft Hari Lagi" : 'Selesai';

                // Hitung progress dalam persentase
                $progress = $totalDays > 0 ? min(100, max(0, ($daysPassed / $totalDays) * 100)) : 0;
                $program->progress = round($progress, 2);

                // Konversi anggaran dana ke dalam bentuk array
                $program->anggaran_dana = json_decode($program->anggaran_dana, true) ?? [];

                // Ambil penanggung jawab (Ketua Acara) dari struktur proker
                $ketuaAcara = $program->strukturProkers
                    ->where('jabatans_id', '1')
                    ->first();
                // dd($ketuaAcara->user->name);
                $program->ketua_acara = $ketuaAcara ? $ketuaAcara->user->name : 'Belum Ditentukan';

                return $program;
            });

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

    public function create(Request $request, $kode_ormawa)
    {
        $this->validateRequest($request);

        $this->storeProker($request);
        $this->storeDivisi($request);

        // Login user setelah registrasi
        // auth()->login($user);

        return redirect()->route('program-kerja.index', ['kode_ormawa' => $kode_ormawa])->with('success', 'Program kerja berhasil ditambahkan.'); // Ganti dengan route yang sesuai
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
        return response()->json(['success', 'Program kerja berhasil diperbaharui.']);
        // return redirect()->route('dashboard')->with('success', 'Program kerja berhasil diperbaharui.');
    }

    public function show($kode_ormawa, $id)
    {
        // dd(Auth::user()->id);
        // Ambil data program kerja berdasarkan kode ormawa
        $programKerja = ProgramKerja::where('id', $id)->first();

        // Jika program kerja tidak ditemukan, kembalikan error
        if (!$programKerja) {
            return redirect()->back()->with('error', 'Program kerja tidak ditemukan.');
        }

        // Ambil data anggota
        // $anggota = User::where('status', 'aktif')
        //     ->orderBy('name', 'ASC')
        //     ->get();
        $anggota = User::where('status', 'aktif')
            ->whereDoesntHave('strukturProkers', function ($query) use ($id) {
                $query->whereHas('divisiProgramKerja', function ($subQuery) use ($id) {
                    $subQuery->where('program_kerjas_id', $id);
                });
            })
            ->get();

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
            ->where('struktur_prokers.jabatans_id', 2)
            ->where('divisi_program_kerjas.divisi_pelaksanas_id', 6)
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->select('users.name', 'users.id')
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

        // Hitung total pemasukan
        $totalPemasukan = RancanganAnggaranBiaya::where('program_kerjas_id', $id)
            ->where('kategori', 'pemasukan')
            ->sum('total');

        // Hitung total pengeluaran
        $totalPengeluaran = RancanganAnggaranBiaya::where('program_kerjas_id', $id)
            ->where('kategori', 'pengeluaran')
            ->sum('total');

        // Hitung selisih anggaran (pemasukan - pengeluaran)
        $selisih = $totalPemasukan - $totalPengeluaran;

        $files = Document::where('program_kerja_id', $id)->latest()->paginate(10);

        // dd($activities->first()->personInCharge->name);

        // dd($programKerja);

        // Periksa apakah tanggal selesai berbeda dengan tanggal mulai
        if ($programKerja->tanggal_selesai && $programKerja->tanggal_selesai != $programKerja->tanggal_mulai) {
            $tanggal_selesai = Carbon::parse($programKerja->tanggal_selesai)->format('d F Y');

            // Kembalikan view dengan semua data
            return view('program-kerja.show', compact('programKerja', 'files', 'anggota', 'divisi', 'tanggal_mulai', 'tanggal_selesai', 'ketua', 'anggotaProker', 'jabatans', 'activities', 'ids', 'totalPemasukan', 'totalPengeluaran', 'selisih'));
        }

        // Kembalikan view tanpa tanggal selesai
        return view('program-kerja.show', compact('programKerja', 'files', 'anggota', 'divisi', 'tanggal_mulai', 'ketua', 'anggotaProker', 'jabatans', 'activities', 'ids', 'totalPemasukan', 'totalPengeluaran', 'selisih'));
    }

    public function destroy($kode_ormawa, $id)
    {
        try {
            // Start a database transaction to ensure all related data is deleted properly
            DB::beginTransaction();

            $programKerja = ProgramKerja::findOrFail($id);

            // 1. Delete all related documents
            $documents = Document::where('program_kerja_id', $id)->get();
            foreach ($documents as $document) {
                // Delete the physical file if it exists
                if (Storage::exists($document->storage_path)) {
                    Storage::delete($document->storage_path);
                }
                $document->delete();
            }

            // 2. Delete all evaluations related to this program
            Evaluasi::where('program_kerjas_id', $id)->delete();

            // 3. Delete all budget plans (RAB)
            RancanganAnggaranBiaya::where('program_kerjas_id', $id)->delete();

            // 4. Delete all activities for this program
            $divisiIds = DivisiProgramKerja::where('program_kerjas_id', $id)->pluck('id')->toArray();
            AktivitasDivisiProgramKerja::where('program_kerjas_id', $id)->delete();

            // 5. Delete all meeting records related to this program
            Rapat::where('program_kerjas_id', $id)->delete();

            // 6. Delete all meeting participants for this program's meetings
            $rapatIds = Rapat::where('program_kerjas_id', $id)->pluck('id')->toArray();
            if (!empty($rapatIds)) {
                RapatPartisipasi::whereIn('rapat_id', $rapatIds)->delete();

                // Delete meeting permissions/excuses
                IzinRapat::whereIn('rapat_id', $rapatIds)->delete();

                // Delete meeting notes
                Notulen::whereIn('rapats_id', $rapatIds)->delete();
            }

            // 7. Delete all structure members (panitia) for this program
            foreach ($divisiIds as $divisiId) {
                StrukturProker::where('divisi_program_kerjas_id', $divisiId)->delete();
            }

            // 8. Delete all divisions associated with this program
            DivisiProgramKerja::where('program_kerjas_id', $id)->delete();

            // 9. Finally, delete the program itself
            $programKerja->delete();

            // Commit the transaction
            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Program kerja dan semua data terkait berhasil dihapus.');
        } catch (\Exception $e) {
            // Roll back the transaction if any errors occur
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus program kerja: ' . $e->getMessage());
        }
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
        // dd($request->anggotas);
        // $id = DB::table('divisi_program_kerjas')
        //     ->where('divisi_pelaksanas_id', $request->input('divisi'))
        //     ->where('program_kerjas_id', $prokerId)
        //     ->value('id');

        foreach ($request->anggotas as $anggota) {
            StrukturProker::create([
                'users_id' => $anggota,
                'divisi_program_kerjas_id' => $request->input('divisi'),
                'jabatans_id' => $request->input('jabatan'),
            ]);
        }

        return redirect()->route('program-kerja.show', [
            'kode_ormawa' => $kode_ormawa,
            'id' => $prokerId
        ])->with('success', 'Panitia berhasil dipilih.');
    }

    public function createRAB($kode_ormawa, $prokerId)
    {
        $programKerja = ProgramKerja::find($prokerId);
        $divisis = DivisiProgramKerja::where('program_kerjas_id', $prokerId)->get();
        // dd($divisi->first()->divisiPelaksana->nama);
        return view('program-kerja.dokumen.rab.create', compact('programKerja', 'divisis'));
    }

    public function createProposal($kode_ormawa, $id)
    {
        $programKerja = ProgramKerja::findOrFail($id);

        // Hitung jumlah hari dari tanggal mulai hingga tanggal selesai
        $tanggalMulai = Carbon::parse($programKerja->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($programKerja->tanggal_selesai);

        $hariKegiatan = [];
        while ($tanggalMulai <= $tanggalSelesai) {
            $hariKegiatan[] = $tanggalMulai->format('Y-m-d'); // Format tanggal
            $tanggalMulai->addDay(); // Increment hari
        }

        $anggotaProker = DB::table('struktur_prokers')
            ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->join('divisi_pelaksanas', 'divisi_program_kerjas.divisi_pelaksanas_id', '=', 'divisi_pelaksanas.id')
            ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->select('divisi_pelaksanas.nama AS nama_divisi', 'users.name AS nama_user', 'jabatans.nama AS nama_jabatan', 'users.id AS id')
            ->orderBy('divisi_pelaksanas.nama')
            ->orderByRaw("FIELD(jabatans.nama, 'Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator', 'Wakil Koordinator', 'Anggota')")
            ->get();

        return view('program-kerja.dokumen.proposal.create', [
            'programKerja' => $programKerja,
            'kode_ormawa' => $kode_ormawa,
            'anggotaProker' => $anggotaProker,
            'hariKegiatan' => $hariKegiatan,
        ]);
    }

    public function generateProposal(Request $request, $kode_ormawa, $id)
    {
        // Ambil data dari request
        $data = $request->all();

        // Buat instance PHPWord
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Konfigurasi dokumen (layout, margin, dll.)
        $section = $phpWord->addSection([
            'pageSizeW' => 11900, // Ukuran A4
            'pageSizeH' => 16840,
            'marginTop' => 1440, // 2 cm
            'marginRight' => 1440,
            'marginBottom' => 1440,
            'marginLeft' => 1800, // 2.5 cm
        ]);

        // **COVER PAGE**
        $section->addText(
            strtoupper('Proposal Program Kerja'),
            ['name' => 'Cambria', 'size' => 20, 'bold' => true],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );
        $section->addTextBreak(2);
        $section->addText(
            strtoupper($request->program_kerja ?? 'Nama Program Kerja'),
            ['name' => 'Cambria', 'size' => 16, 'bold' => true],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );
        $section->addTextBreak(2);

        // **1. LATAR BELAKANG**
        $section->addText(
            'I. LATAR BELAKANG',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        $section->addText(
            $data['latar_belakang'] ?? 'Belum ada data.',
            ['name' => 'Cambria', 'size' => 12],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'lineHeight' => 1.5]
        );

        // **2. SASARAN**
        $section->addTextBreak(1);
        $section->addText(
            'II. SASARAN',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        $section->addText(
            $data['sasaran'] ?? 'Belum ada data.',
            ['name' => 'Cambria', 'size' => 12],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH]
        );

        // **3. TUJUAN**
        $section->addTextBreak(1);
        $section->addText(
            'III. TUJUAN',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        if (!empty($data['tujuan'])) {
            foreach ($data['tujuan'] as $tujuan) {
                $section->addListItem(
                    $tujuan,
                    0,
                    ['name' => 'Cambria', 'size' => 12],
                    ['listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED]
                );
            }
        } else {
            $section->addText('Belum ada data.', ['name' => 'Cambria', 'size' => 12]);
        }

        // **4. BENTUK KEGIATAN**
        $section->addTextBreak(1);
        $section->addText(
            'IV. BENTUK KEGIATAN',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        $section->addText(
            $data['bentuk_kegiatan'] ?? 'Belum ada data.',
            ['name' => 'Cambria', 'size' => 12]
        );

        // **5. HARI, TANGGAL, DAN TEMPAT**
        $section->addTextBreak(1);
        $section->addText(
            'V. HARI, TANGGAL, DAN TEMPAT',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        $section->addText(
            'Hari, Tanggal: ' . ($data['hari_tanggal'] ?? 'Belum ada data.'),
            ['name' => 'Cambria', 'size' => 12]
        );
        $section->addText(
            'Tempat: ' . ($data['tempat'] ?? 'Belum ada data.'),
            ['name' => 'Cambria', 'size' => 12]
        );

        // **6. RUNDOWN**
        $section->addTextBreak(1);
        $section->addText(
            'VI. RUNDOWN KEGIATAN',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        if (!empty($data['rundown'])) {
            foreach ($data['rundown'] as $tanggal => $rundownItems) {
                $section->addText(
                    \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y'),
                    ['name' => 'Cambria', 'size' => 12, 'bold' => true]
                );
                $table = $section->addTable();
                foreach ($rundownItems['waktu'] as $index => $waktu) {
                    $table->addRow();
                    $table->addCell(2000)->addText($waktu);
                    $table->addCell(8000)->addText($rundownItems['kegiatan'][$index] ?? '');
                }
            }
        } else {
            $section->addText('Belum ada data.', ['name' => 'Cambria', 'size' => 12]);
        }

        // **7. SUSUNAN PANITIA PELAKSANA**
        $section->addTextBreak(1);
        $section->addText(
            'VII. SUSUNAN PANITIA PELAKSANA',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        if (!empty($data['panitia'])) {
            $table = $section->addTable();
            $table->addRow();
            $table->addCell(2000)->addText('Nama', ['bold' => true]);
            $table->addCell(2000)->addText('NRP', ['bold' => true]);
            $table->addCell(2000)->addText('Jabatan', ['bold' => true]);
            foreach ($data['panitia'] as $panitia) {
                $table->addRow();
                $table->addCell(2000)->addText($panitia['nama']);
                $table->addCell(2000)->addText($panitia['nrp']);
                $table->addCell(2000)->addText($panitia['jabatan']);
            }
        }

        // **8. INDIKATOR KEBERHASILAN**
        $section->addTextBreak(1);
        $section->addText(
            'VIII. INDIKATOR KEBERHASILAN',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        $section->addText(
            $data['indikator_keberhasilan'] ?? 'Belum ada data.',
            ['name' => 'Cambria', 'size' => 12]
        );

        // **9. ANGGARAN DANA**
        $section->addTextBreak(1);
        $section->addText(
            'IX. ANGGARAN DANA',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        if (!empty($data['anggaran']['komponen'])) {
            $table = $section->addTable();
            $table->addRow();
            $table->addCell(2000)->addText('Komponen Biaya', ['bold' => true]);
            $table->addCell(1000)->addText('Jumlah', ['bold' => true]);
            $table->addCell(1000)->addText('Satuan', ['bold' => true]);
            $table->addCell(2000)->addText('Harga', ['bold' => true]);
            $table->addCell(2000)->addText('Total', ['bold' => true]);
            foreach ($data['anggaran']['komponen'] as $index => $komponen) {
                $jumlah = $data['anggaran']['jumlah'][$index];
                $harga = $data['anggaran']['harga'][$index];
                $total = $jumlah * $harga;
                $table->addRow();
                $table->addCell(2000)->addText($komponen);
                $table->addCell(1000)->addText($jumlah);
                $table->addCell(1000)->addText($data['anggaran']['satuan'][$index] ?? '-');
                $table->addCell(2000)->addText(number_format($harga, 0, ',', '.'));
                $table->addCell(2000)->addText(number_format($total, 0, ',', '.'));
            }
        }

        // **10. PENUTUP**
        $section->addTextBreak(1);
        $section->addText(
            'X. PENUTUP',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        $section->addText(
            $data['penutup'] ?? 'Belum ada data.',
            ['name' => 'Cambria', 'size' => 12]
        );

        // **LEMBAR PENGESAHAN**
        $section->addTextBreak(1);
        $section->addText(
            'LEMBAR PENGESAHAN',
            ['name' => 'Cambria', 'size' => 12, 'bold' => true]
        );
        if (!empty($data['pengesahan'])) {
            foreach ($data['pengesahan'] as $pengesahan) {
                $section->addText($pengesahan, ['name' => 'Cambria', 'size' => 12]);
            }
        }

        // **SIMPAN FILE**
        $fileName = 'Proposal_' . $kode_ormawa . '.docx';
        $tempFile = storage_path($fileName);

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

    public function progressProposal($kode_ormawa, $id)
    {
        $programKerja = ProgramKerja::findOrFail($id);
        $user = Auth::user();

        return view('program-kerja.dokumen.proposal.progress', compact('programKerja', 'user'));
    }

    public function selesaikan(Request $request, $kode_ormawa, $id)
    {
        try {
            // Wrap in a transaction to ensure all operations complete
            DB::beginTransaction();

            // Get the program kerja
            $programKerja = ProgramKerja::find($id);

            // Update status program kerja
            $programKerja->update([
                'updated_at' => now(),
                'konfirmasi_penyelesaian' => 'Ya',
                'disetujui' => 'Ya', // Mark as approved
                'pengkonfirmasi' => Auth::user()->id,
            ]);

            // Calculate evaluation for all committee members
            $this->sawService->hitungEvaluasiProker($id);

            // Get evaluations results to send in notifications
            $evaluations = Evaluasi::where('program_kerjas_id', $id)
                ->with('user')
                ->get();

            // Get all users who were part of this program
            $users = StrukturProker::whereIn('divisi_program_kerjas_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('divisi_program_kerjas')
                    ->where('program_kerjas_id', $id);
            })->with('user')->get()->pluck('user');

            // Send notification to each user with their evaluation result
            foreach ($users as $user) {
                $userEvaluation = $evaluations->where('user_id', $user->id)->first();

                // dd($user);

                if ($userEvaluation) {
                    // dd($userEvaluation);
                    // Create and send notification
                    Notification::send($user, new EvaluasiSelesaiNotification($programKerja, $userEvaluation));
                }
            }

            DB::commit();

            // Redirect back to the same page with success message
            return redirect()
                ->route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $id])
                ->with('success', 'Program kerja telah diselesaikan dan evaluasi panitia telah dihitung. Notifikasi telah dikirim ke seluruh anggota.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyelesaikan program kerja: ' . $e->getMessage());
        }
    }

    public function evaluasi($id)
    {
        $programKerja = ProgramKerja::findOrFail($id);
        $evaluasi = Evaluasi::where('program_kerjas_id', $id)
            ->with('user')
            ->orderByDesc('score')
            ->get();

        return view('program-kerja.evaluasi', compact('programKerja', 'evaluasi'));
    }
}
