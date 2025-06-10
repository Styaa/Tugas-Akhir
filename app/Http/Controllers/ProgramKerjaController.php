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
use App\Models\StrukturOrmawa;
use App\Models\StrukturProker;
use App\Models\User;
use App\Notifications\EvaluasiSelesaiNotification;
use App\Notifications\PenilaianAnggotaNotification;
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

        $strukturOrmawa = StrukturOrmawa::with('divisiOrmawas')
            ->where('users_id', $user->id)
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
        return view('dashboard.project-dashboard', compact('programKerjas', 'divisiPelaksanas', 'periode', 'kode_ormawa', 'strukturOrmawa'));
    }

    public function create(Request $request, $kode_ormawa)
    {
        // Validasi input request
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'tujuan' => 'required|array',
            'tujuan.*' => 'string|max:255',
            'deskripsi' => 'required|string|max:255',
            'manfaat' => 'required|array',
            'manfaat.*' => 'string|max:255',
            'tipe' => 'required|in:Internal,Eksternal',
            'anggaran' => 'required|array',
            'anggaran.*' => 'string',
            'konsep' => 'required|in:Online,Offline',
            'tempat' => 'required|string|max:45',
            'sasaran' => 'required|string|max:255',
            'indikator' => 'required|string|max:255',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after_or_equal:mulai',
            'divisis' => 'required|array',
            'divisis.*' => 'integer'
        ]);

        if ($validator->fails()) {
            // Return with errors and set a flash message for the JavaScript to show the modal
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('validation_errors', $validator->errors()->all());
        }

        // Membuat program kerja baru
        $programKerja = ProgramKerja::create([
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
            'ormawas_kode' => $kode_ormawa,
            'periode' => $request->periode,
        ]);

        // Menyimpan divisi yang terlibat dalam program kerja
        $divisiValues = $request->divisis;
        foreach ($divisiValues as $divisi) {
            DivisiProgramKerja::create([
                'program_kerjas_id' => $programKerja->id,
                'divisi_pelaksanas_id' => $divisi,
            ]);
        }

        return redirect()->back()->with('success', 'Program kerja berhasil ditambahkan.');
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
        $divisiIdsBaru = $request->input('divisis');

        $divisiIdsLama = DivisiProgramKerja::where('program_kerjas_id', $programKerjaId)
            ->pluck('divisi_pelaksanas_id')
            ->toArray();

        $divisiIdsUntukDihapus = array_diff($divisiIdsLama, $divisiIdsBaru);

        $divisiIdsUntukDitambahkan = array_diff($divisiIdsBaru, $divisiIdsLama);

        DivisiProgramKerja::where('program_kerjas_id', $programKerjaId)
            ->whereIn('divisi_pelaksanas_id', $divisiIdsUntukDihapus)
            ->delete();

        foreach ($divisiIdsUntukDitambahkan as $divisiId) {
            DivisiProgramKerja::create([
                'program_kerjas_id' => $programKerjaId,
                'divisi_pelaksanas_id' => $divisiId,
            ]);
        }
    }

    public function update(Request $request, $kode_ormawa, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'tujuan' => 'required|array',  // Changed to array
            'tujuan.*' => 'string|max:255',
            'deskripsi' => 'required|string|max:255',
            'manfaat' => 'required|array',  // Changed to array
            'manfaat.*' => 'string|max:255',
            'tipe' => 'required|string|max:255',
            'anggaran' => 'required|array',  // This is correct
            'anggaran.*' => 'string',
            'konsep' => 'required|string|max:45',  // This field is missing in your data
            'tempat' => 'required|string|max:45',
            'sasaran' => 'required|string|max:255',
            'indikator' => 'required|string|max:255',
            'mulai' => 'required|date',
            'selesai' => 'required|date',
            'divisis' => 'required|array',
            'divisis.*' => 'string',
            'periode' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $programKerja = ProgramKerja::find($id);

        $programKerja->update([
            'nama' => $request->nama,
            'tujuan' => json_encode($request->tujuan),
            'deskripsi' => $request->deskripsi,
            'manfaat' => json_encode($request->manfaat),
            'tipe' => $request->tipe,
            'anggaran_dana' => json_encode($request->anggaran),  // Make sure this field name is correct in the DB
            'konsep' => $request->konsep,  // This is missing in your data
            'tempat' => $request->tempat,
            'sasaran_kegiatan' => $request->sasaran,
            'indikator_keberhasilan' => $request->indikator,
            'tanggal_mulai' => $request->mulai,
            'tanggal_selesai' => $request->selesai,
            'ormawas_kode' => $kode_ormawa,
            'periode' => $request->periode,
        ]);

        $this->updateDivisiProgramKerja($request, $id);

        return redirect()->back()->with('success', 'Program kerja berhasil diperbaharui.');
    }

    public function show($kode_ormawa, $id)
    {
        $programKerja = ProgramKerja::where('id', $id)->first();

        if (!$programKerja) {
            return redirect()->back()->with('error', 'Program kerja tidak ditemukan.');
        }

        $anggota = User::where('status', 'aktif')
            ->whereDoesntHave('strukturProkers', function ($query) use ($id) {
                $query->whereHas('divisiProgramKerja', function ($subQuery) use ($id) {
                    $subQuery->where('program_kerjas_id', $id);
                });
            })
            ->get();

        $availableAnggota = User::where('status', 'aktif')
            ->whereHas('strukturOrmawas.divisiOrmawas.ormawa', function ($query) use ($kode_ormawa) {
                $query->where('kode', $kode_ormawa); // atau sesuai nama field kode di tabel ormawas
            })
            ->whereDoesntHave('strukturProkers', function ($query) use ($id) {
                $query->whereHas('divisiProgramKerja', function ($subQuery) use ($id) {
                    $subQuery->where('program_kerjas_id', $id);
                });
            })
            ->get();

        $evaluasiRataRata = DB::table('evaluasis')
            ->select('user_id', DB::raw('AVG(score) as rata_rata_score'))
            ->groupBy('user_id')
            ->pluck('rata_rata_score', 'user_id');

        // dd($evaluasiRataRata);

        $availableAnggota->transform(function ($anggota) use ($evaluasiRataRata) {
            $anggota->rata_rata_score = $evaluasiRataRata[$anggota->id] ?? null;
            return $anggota;
        });

        // dd($availableAnggota);

        $jabatans = Jabatan::all();

        $divisi = DivisiProgramKerja::with('divisiPelaksana')
            ->where('program_kerjas_id', $programKerja->id)
            ->get()->toArray();

        $ids = array_column($divisi, 'id');

        $tanggal_mulai = Carbon::parse($programKerja->tanggal_mulai)->format('d F Y');

        $ketua = DB::table('struktur_prokers')
            ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->where('struktur_prokers.jabatans_id', 2)
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->select('users.name', 'users.id')
            ->get();

        $anggotaProker = DB::table('struktur_prokers')
            ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->join('divisi_pelaksanas', 'divisi_program_kerjas.divisi_pelaksanas_id', '=', 'divisi_pelaksanas.id')
            ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->select('divisi_pelaksanas.nama AS nama_divisi', 'divisi_pelaksanas.id AS divisi_id', 'users.name AS nama_user', 'jabatans.nama AS nama_jabatan', 'users.id AS id_user', 'jabatans.id AS id_jabatan')
            ->orderBy('divisi_pelaksanas.nama')
            ->orderByRaw("FIELD(jabatans.nama, 'Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator', 'Wakil Koordinator', 'Anggota')")
            ->get();

        // dd($anggotaProker);

        $activities = AktivitasDivisiProgramKerja::where('program_kerjas_id', $programKerja->id)->get();

        $totalPemasukan = RancanganAnggaranBiaya::where('program_kerjas_id', $id)
            ->where('kategori', 'pemasukan')
            ->sum('total');

        $totalPengeluaran = RancanganAnggaranBiaya::where('program_kerjas_id', $id)
            ->where('kategori', 'pengeluaran')
            ->sum('total');

        $selisih = $totalPemasukan - $totalPengeluaran;

        $files = Document::where('program_kerja_id', $id)->latest()->paginate(10);

        // Dapatkan jabatan user yang sedang login
        $currentUser = Auth::user();
        $jabatanPenilai = DB::table('struktur_prokers')
            ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->where('struktur_prokers.users_id', $currentUser->id)
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->select('jabatans.id as jabatan_id', 'jabatans.nama as jabatan_nama')
            ->first();

        // Daftar anggota yang dapat dinilai berdasarkan jabatan penilai
        $anggotaUntukDinilai = collect();

        if ($jabatanPenilai) {
            // Jika steering committee (ID: 1) - hanya nilai ketua dan wakil ketua
            if ($jabatanPenilai->jabatan_id == 1) {
                $anggotaUntukDinilai = DB::table('struktur_prokers')
                    ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
                    ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
                    ->join('divisi_pelaksanas', 'divisi_program_kerjas.divisi_pelaksanas_id', '=', 'divisi_pelaksanas.id')
                    ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
                    ->whereIn('struktur_prokers.jabatans_id', [2, 3, 4]) // Ketua, Wakil Ketua, Wakil Ketua II
                    ->where('divisi_program_kerjas.program_kerjas_id', $id)
                    ->select(
                        'struktur_prokers.id',
                        'struktur_prokers.users_id',
                        'struktur_prokers.nilai_atasan',
                        'struktur_prokers.keterangan_nilai',
                        'divisi_pelaksanas.nama AS nama_divisi',
                        'users.name AS nama_user',
                        'jabatans.nama AS nama_jabatan'
                    )
                    ->get();
            }
            // Jika ketua atau wakil ketua (ID: 2, 3, 4) - nilai sekretaris, bendahara, sekretaris & bendahara, koordinator, wakil koordinator
            elseif (in_array($jabatanPenilai->jabatan_id, [2, 3, 4])) {
                $anggotaUntukDinilai = DB::table('struktur_prokers')
                    ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
                    ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
                    ->join('divisi_pelaksanas', 'divisi_program_kerjas.divisi_pelaksanas_id', '=', 'divisi_pelaksanas.id')
                    ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
                    ->whereIn('struktur_prokers.jabatans_id', [5, 6, 7, 8, 9, 10, 11, 12, 13]) // Sekretaris, Bendahara, dan variasinya, Koordinator/Wakil
                    ->where('divisi_program_kerjas.program_kerjas_id', $id)
                    ->select(
                        'struktur_prokers.id',
                        'struktur_prokers.users_id',
                        'struktur_prokers.nilai_atasan',
                        'struktur_prokers.keterangan_nilai',
                        'divisi_pelaksanas.nama AS nama_divisi',
                        'users.name AS nama_user',
                        'jabatans.nama AS nama_jabatan'
                    )
                    ->get();
            }
            // Jika koordinator atau wakil koordinator (ID: 11, 12, 13) - hanya nilai anggota (ID: 14)
            elseif (in_array($jabatanPenilai->jabatan_id, [11, 12, 13])) {
                // Ambil ID divisi yang dikoordinatori
                $divisiYangDikoordinatori = DB::table('struktur_prokers')
                    ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
                    ->where('struktur_prokers.users_id', $currentUser->id)
                    ->where('divisi_program_kerjas.program_kerjas_id', $id)
                    ->select('divisi_program_kerjas.id')
                    ->pluck('id');

                // Ambil anggota dari divisi yang dikoordinatori
                $anggotaUntukDinilai = DB::table('struktur_prokers')
                    ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
                    ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
                    ->join('divisi_pelaksanas', 'divisi_program_kerjas.divisi_pelaksanas_id', '=', 'divisi_pelaksanas.id')
                    ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
                    ->where('struktur_prokers.jabatans_id', 14) // Hanya Anggota
                    ->whereIn('struktur_prokers.divisi_program_kerjas_id', $divisiYangDikoordinatori)
                    ->select(
                        'struktur_prokers.id',
                        'struktur_prokers.users_id',
                        'struktur_prokers.nilai_atasan',
                        'struktur_prokers.keterangan_nilai',
                        'divisi_pelaksanas.nama AS nama_divisi',
                        'users.name AS nama_user',
                        'jabatans.nama AS nama_jabatan'
                    )
                    ->get();
            }
        }

        // Cek apakah semua anggota sudah dinilai (total vs yang sudah dinilai)

        // 1. Ambil semua anggota yang harus dinilai berdasarkan semua jabatan
        $allAnggotaYangHarusDinilai = DB::table('struktur_prokers')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->whereIn('struktur_prokers.jabatans_id', [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]) // Semua kecuali steering committee
            ->count();

        // 2. Ambil semua anggota yang sudah dinilai
        $allAnggotaYangSudahDinilai = DB::table('struktur_prokers')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->where('divisi_program_kerjas.program_kerjas_id', $id)
            ->whereNotNull('struktur_prokers.nilai_atasan')
            ->count();

        // 3. Tentukan apakah semua anggota sudah dinilai
        $allMembersRated = ($allAnggotaYangHarusDinilai > 0 && $allAnggotaYangSudahDinilai == $allAnggotaYangHarusDinilai);

        // 4. Cek apakah notifikasi sudah terkirim
        $notifikasiTerkirim = $programKerja->notifikasi_penilaian_terkirim ?? false;

        // dd(Auth::user()->id);

        $proposalId = DB::table('laporan_dokumens')
            ->where('program_kerja_id', $id)
            ->where('ormawas_kode', $kode_ormawa)
            ->where('tipe', 'proposal')
            ->pluck('id')
            ->first();

        $lpjId = DB::table('laporan_dokumens')
            ->where('program_kerja_id', $id)
            ->where('ormawas_kode', $kode_ormawa)
            ->where('tipe', 'lpj')
            ->pluck('id')
            ->first();

        // Buat array untuk view dengan compact
        $viewVariables = compact(
            'programKerja',
            'files',
            'anggota',
            'availableAnggota',
            'divisi',
            'tanggal_mulai',
            'ketua',
            'anggotaProker',
            'jabatans',
            'activities',
            'ids',
            'totalPemasukan',
            'totalPengeluaran',
            'selisih',
            'anggotaUntukDinilai',
            'allMembersRated',
            'notifikasiTerkirim',
            'kode_ormawa',
            'proposalId',
            'lpjId'
        );

        if ($programKerja->tanggal_selesai && $programKerja->tanggal_selesai != $programKerja->tanggal_mulai) {
            $tanggal_selesai = Carbon::parse($programKerja->tanggal_selesai)->format('d F Y');
            $viewVariables['tanggal_selesai'] = $tanggal_selesai;
        }

        return view('program-kerja.show', $viewVariables);
    }

    public function destroy($kode_ormawa, $id)
    {
        try {
            DB::beginTransaction();

            $programKerja = ProgramKerja::find($id);

            $documents = Document::where('program_kerja_id', $id)->get();
            foreach ($documents as $document) {
                if (Storage::exists($document->storage_path)) {
                    Storage::delete($document->storage_path);
                }
                $document->delete();
            }

            Evaluasi::where('program_kerjas_id', $id)->delete();

            RancanganAnggaranBiaya::where('program_kerjas_id', $id)->delete();

            $divisiIds = DivisiProgramKerja::where('program_kerjas_id', $id)->pluck('id')->toArray();
            AktivitasDivisiProgramKerja::where('program_kerjas_id', $id)->delete();

            Rapat::where('program_kerjas_id', $id)->delete();

            $rapatIds = Rapat::where('program_kerjas_id', $id)->pluck('id')->toArray();
            if (!empty($rapatIds)) {
                RapatPartisipasi::whereIn('rapat_id', $rapatIds)->delete();

                IzinRapat::whereIn('rapat_id', $rapatIds)->delete();

                Notulen::whereIn('rapats_id', $rapatIds)->delete();
            }

            foreach ($divisiIds as $divisiId) {
                StrukturProker::where('divisi_program_kerjas_id', $divisiId)->delete();
            }

            DivisiProgramKerja::where('program_kerjas_id', $id)->delete();

            $programKerja->delete();

            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Program kerja dan semua data terkait berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus program kerja: ' . $e->getMessage());
        }
    }

    public function pilihKetua($kode_ormawa, $prokerId, $periode, $userId)
    {
        // Cari ID divisi_program_kerja berdasarkan divisi_pelaksanas_id dan program_kerjas_id
        $id = DB::table('divisi_program_kerjas')
            ->where('divisi_pelaksanas_id', 1)
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
            ->where('jabatans_id', 2)
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
            'jabatans_id' => 2,
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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'anggotas' => 'required|array',
            'anggotas.*' => 'required|integer',
            'divisi' => 'required|integer',
            'jabatan' => 'required|integer',
        ], [
            'anggotas.required' => 'Anggota harus dipilih',
            'divisi.required' => 'Divisi harus dipilih',
            'jabatan.required' => 'Jabatan harus dipilih',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('validation_errors', $validator->errors()->all());
        }

        // Jika validasi berhasil, buat data struktur proker
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

        $dokumen = DB::table('laporan_dokumens')
            ->where('program_kerja_id', $id)
            ->where('ormawas_kode', $kode_ormawa)
            ->where('tipe', 'proposal')
            ->first();

        return view('program-kerja.dokumen.proposal.create', [
            'programKerja' => $programKerja,
            'kode_ormawa' => $kode_ormawa,
            'anggotaProker' => $anggotaProker,
            'hariKegiatan' => $hariKegiatan,
            'dokumen' => $dokumen,
        ]);
    }

    public function updateBobot(Request $request, $kode_ormawa, $id)
    {
        try {
            $request->validate([
                'bobot_kehadiran' => 'required|numeric|between:0,1',
                'bobot_kontribusi' => 'required|numeric|between:0,1',
                'bobot_tanggung_jawab' => 'required|numeric|between:0,1',
                'bobot_kualitas' => 'required|numeric|between:0,1',
                'bobot_penilaian_atasan' => 'required|numeric|between:0,1',
            ], [
                'bobot_*.required' => 'Semua bobot harus diisi',
                'bobot_*.numeric' => 'Bobot harus berupa angka',
                'bobot_*.between' => 'Bobot harus antara 0 dan 1',
            ]);

            // Validasi total bobot = 1.00
            $total = $request->bobot_kehadiran + $request->bobot_kontribusi +
                $request->bobot_tanggung_jawab + $request->bobot_kualitas +
                $request->bobot_penilaian_atasan;

            if (abs($total - 1.00) > 0.001) {
                return back()->withErrors([
                    'total_bobot' => 'Total semua bobot harus sama dengan 100%. Saat ini: ' .
                        number_format($total * 100, 1) . '%'
                ])->withInput();
            }

            $programKerja = ProgramKerja::where('id', $id)
                ->where('ormawas_kode', $kode_ormawa)
                ->firstOrFail();

            // Check authorization
            $user = Auth::user();
            if ($user->jabatanOrmawa->nama === 'Anggota' && $user->jabatanProker->nama === 'Anggota') {
                return back()->with('error', 'Anda tidak memiliki akses untuk mengatur bobot evaluasi.');
            }

            // Check if program kerja sudah selesai
            if ($programKerja->konfirmasi_penyelesaian === 'Ya') {
                return back()->with('error', 'Tidak dapat mengubah bobot karena program kerja sudah selesai.');
            }

            // dd($request);

            // Update bobot
            $programKerja->update([
                'bobot_kehadiran' => $request->bobot_kehadiran,
                'bobot_kontribusi' => $request->bobot_kontribusi,
                'bobot_tanggung_jawab' => $request->bobot_tanggung_jawab,
                'bobot_kualitas' => $request->bobot_kualitas,
                'bobot_penilaian_atasan' => $request->bobot_penilaian_atasan,
            ]);

            return redirect()->back()->with(
                'success',
                'Bobot evaluasi berhasil diperbarui dan evaluasi telah dihitung ulang.'
            );
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui bobot evaluasi.');
        }
    }

    public function createLPJ($kode_ormawa, $id)
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

        $dokumen = DB::table('laporan_dokumens')
            ->where('program_kerja_id', $id)
            ->where('ormawas_kode', $kode_ormawa)
            ->where('tipe', 'laporan_pertanggungjawaban')
            ->first();

        return view('program-kerja.dokumen.lpj.create', [
            'programKerja' => $programKerja,
            'kode_ormawa' => $kode_ormawa,
            'anggotaProker' => $anggotaProker,
            'hariKegiatan' => $hariKegiatan,
            'dokumen' => $dokumen,
        ]);
    }

    public function progressProposal($kode_ormawa, $id)
    {
        $programKerja = ProgramKerja::findOrFail($id);
        $user = Auth::user();
        $dokumenId = DB::table('laporan_dokumens')
            ->where('program_kerja_id', $id)
            ->where('ormawas_kode', $kode_ormawa)
            ->where('tipe', 'proposal')
            ->pluck('id')
            ->first();

        return view('program-kerja.dokumen.proposal.progress', compact('programKerja', 'user', 'dokumenId'));
    }

    public function selesaikan(Request $request, $kode_ormawa, $id)
    {
        try {
            // Ambil program kerja
            $programKerja = ProgramKerja::findOrFail($id);

            // Periksa apakah semua anggota sudah dinilai
            $allAnggotaYangHarusDinilai = DB::table('struktur_prokers')
                ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
                ->where('divisi_program_kerjas.program_kerjas_id', $id)
                ->whereIn('struktur_prokers.jabatans_id', [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]) // Semua kecuali steering committee
                ->count();

            $allAnggotaYangSudahDinilai = DB::table('struktur_prokers')
                ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
                ->where('divisi_program_kerjas.program_kerjas_id', $id)
                ->whereNotNull('struktur_prokers.nilai_atasan')
                ->count();

            if ($allAnggotaYangHarusDinilai != $allAnggotaYangSudahDinilai) {
                return redirect()
                    ->back()
                    ->with('error', 'Tidak semua anggota sudah dinilai. Harap pastikan semua anggota sudah mendapatkan penilaian.');
            }

            // Mulai transaksi
            DB::beginTransaction();

            // Update status program kerja
            $programKerja->update([
                'updated_at' => now(),
                'konfirmasi_penyelesaian' => 'Ya',
                'disetujui' => 'Ya', // Mark as approved
                'pengkonfirmasi' => Auth::user()->id,
                'tanggal_selesai' => $request->tanggal_selesai,
                'catatan_penyelesaian' => $request->deskripsi,
                'penilaian_selesai' => true,
            ]);

            $anggotaProgram = StrukturProker::whereIn('divisi_program_kerjas_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('divisi_program_kerjas')
                    ->where('program_kerjas_id', $id);
            })->get();

            $penilaianAnggota = $anggotaProgram->mapWithKeys(function ($item) {
                return [$item->users_id => $item->nilai_atasan];
            });

            // Sisipkan data penilaian ke service SAW
            $this->sawService->setPenilaianAtasan($penilaianAnggota);

            // Calculate evaluation for all committee members
            $this->sawService->hitungEvaluasiProker($id);

            // Get evaluations results to send in notifications
            $evaluations = Evaluasi::where('program_kerjas_id', $id)
                ->with('user')
                ->get();

            // Send notification to each user with their evaluation result
            // foreach ($anggotaProgram as $anggota) {
            //     $userEvaluation = $evaluations->where('user_id', $anggota->users_id)->first();

            //     if ($userEvaluation) {
            //         $user = User::find($anggota->users_id);
            //         // Create and send notification
            //         Notification::send($user, new EvaluasiSelesaiNotification($programKerja, $userEvaluation));
            //     }
            // }

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

    public function evaluasi($kode_ormawa, $id)
    {
        // Get the program kerja
        $programKerja = ProgramKerja::findOrFail($id);

        // Ensure program is completed
        if ($programKerja->konfirmasi_penyelesaian != 'Ya') {
            return redirect()->route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $id])
                ->with('error', 'Program kerja belum selesai, tidak dapat melihat evaluasi.');
        }

        // Get evaluations from the evaluasis table
        $anggotaEvaluasi = DB::table('evaluasis as e')
            ->joinSub(
                DB::table('evaluasis as e')
                    ->select(
                        DB::raw('MAX(e.updated_at) as updated_at'),
                        'e.user_id',
                        'e.program_kerjas_id'
                    )
                    ->where('e.program_kerjas_id', $id)
                    ->groupBy('e.user_id', 'e.program_kerjas_id'),
                't1',
                function ($join) {
                    $join->on('e.user_id', '=', 't1.user_id')
                        ->on('e.program_kerjas_id', '=', 't1.program_kerjas_id')
                        ->on('e.updated_at', '=', 't1.updated_at');
                }
            )
            // Add joins for user and program names
            ->leftJoin('users as u', 'e.user_id', '=', 'u.id')
            ->leftJoin('program_kerjas as p', 'e.program_kerjas_id', '=', 'p.id')
            ->select(
                'e.*',
                'u.name as nama_anggota',
                'p.nama as nama_program_kerja',
                'e.score as nilai_akhir'
            )
            ->orderBy('e.score', 'desc')
            ->get();

        // Method 1: Get divisi and jabatan mapping for all users in this program
        $userIds = $anggotaEvaluasi->pluck('user_id')->unique()->toArray();
        $programId = $id; // or use $anggotaEvaluasi->first()->program_kerjas_id

        // Query to get divisi mapping
        $divisiMapping = DB::table('users as u')
            ->join('struktur_prokers as sp', 'sp.users_id', '=', 'u.id')
            ->join('divisi_program_kerjas as dpk', 'sp.divisi_program_kerjas_id', '=', 'dpk.id')
            ->join('divisi_pelaksanas as dp', 'dpk.divisi_pelaksanas_id', '=', 'dp.id')
            ->where('dpk.program_kerjas_id', $programId)
            ->whereIn('u.id', $userIds)
            ->select('u.id as user_id', 'dp.nama as nama_divisi')
            ->pluck('nama_divisi', 'user_id');

        // Query to get jabatan mapping
        $jabatanMapping = DB::table('users as u')
            ->join('struktur_prokers as sp', 'sp.users_id', '=', 'u.id')
            ->join('divisi_program_kerjas as dpk', 'sp.divisi_program_kerjas_id', '=', 'dpk.id')
            ->join('jabatans as j', 'sp.jabatans_id', '=', 'j.id')
            ->where('dpk.program_kerjas_id', $programId)
            ->whereIn('u.id', $userIds)
            ->select('u.id as user_id', 'j.nama as jabatan')
            ->pluck('jabatan', 'user_id');

        // Apply the mappings to your evaluasi data
        $anggotaEvaluasi = $anggotaEvaluasi->map(function ($item) use ($divisiMapping, $jabatanMapping) {
            $item->nama_divisi = $divisiMapping[$item->user_id] ?? null;
            $item->jabatan = $jabatanMapping[$item->user_id] ?? null;
            return $item;
        });

        // dd($anggotaEvaluasi);

        // $anggotaEvaluasi = DB::table('users as u')
        //     ->select([
        //         'u.id as user_id',
        //         'u.name as nama_anggota',
        //         'dp.nama as nama_divisi',
        //         'j.nama as jabatan',
        //         'p.nama as nama_program_kerja',
        //         'e.kehadiran',
        //         'e.kontribusi',
        //         'e.tanggung_jawab',
        //         'e.kualitas',
        //         'e.penilaian_atasan',
        //         'e.kehadiran_normalized',
        //         'e.kontribusi_normalized',
        //         'e.tanggung_jawab_normalized',
        //         'e.kualitas_normalized',
        //         'e.score as nilai_akhir',
        //         'sp.keterangan_nilai'
        //     ])
        //     ->join('evaluasis as e', 'e.user_id', '=', 'u.id')
        //     ->join('struktur_prokers as sp', 'sp.users_id', '=', 'u.id')
        //     ->join('divisi_program_kerjas as dpk', 'sp.divisi_program_kerjas_id', '=', 'dpk.id')
        //     ->join('divisi_pelaksanas as dp', 'dpk.divisi_pelaksanas_id', '=', 'dp.id')
        //     ->join('jabatans as j', 'sp.jabatans_id', '=', 'j.id')
        //     ->join('program_kerjas as p', 'dpk.program_kerjas_id', '=', 'p.id')
        //     ->where('e.program_kerjas_id', $id)
        //     ->where('dpk.program_kerjas_id', $id)
        //     // ->groupBy([
        //     //     'u.id', 'u.name', 'dp.nama', 'j.nama', 'e.kehadiran', 'e.kontribusi',
        //     //     'e.tanggung_jawab', 'e.kualitas', 'e.penilaian_atasan',
        //     //     'e.kehadiran_normalized', 'e.kontribusi_normalized',
        //     //     'e.tanggung_jawab_normalized', 'e.kualitas_normalized',
        //     //     'sp.keterangan_nilai', 'p.nama', 'e.score'
        //     // ])
        //     ->orderBy('nilai_akhir', 'desc')
        //     ->orderBy('e.updated_at', 'desc')
        //     ->distinct('u.id')
        //     ->get();

        // dd($anggotaEvaluasi);

        // Get ketua (leader) information
        $ketua = DB::table('struktur_prokers as sp')
            ->join('users as u', 'sp.users_id', '=', 'u.id')
            ->join('divisi_program_kerjas as dpk', 'sp.divisi_program_kerjas_id', '=', 'dpk.id')
            ->join('jabatans as j', 'sp.jabatans_id', '=', 'j.id')
            ->where('dpk.program_kerjas_id', $id)
            ->where('j.nama', 'Ketua')
            ->select('u.name', 'u.id')
            ->first();

        return view('program-kerja.evaluasi', [
            'programKerja' => $programKerja,
            'anggotaEvaluasi' => $anggotaEvaluasi,
            'ketua' => $ketua,
            'kode_ormawa' => $kode_ormawa
        ]);
    }

    public function nilaiAnggota(Request $request, $kode_ormawa, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'struktur_id' => 'required|array',
                'nilai' => 'required|array',
                'nilai.*' => 'required|numeric|min:1|max:100'
            ]);

            // Mulai transaksi
            DB::beginTransaction();

            // Simpan penilaian untuk setiap anggota
            foreach ($request->struktur_id as $index => $strukturId) {
                // Update nilai di struktur_prokers
                StrukturProker::where('id', $strukturId)
                    ->update([
                        'nilai_atasan' => $request->nilai[$index],
                        'penilai_id' => Auth::user()->id,
                    ]);
            }

            DB::commit();

            return redirect()
                ->route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $id])
                ->with('success', 'Penilaian anggota berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan penilaian: ' . $e->getMessage());
        }
    }

    public function kirimNotifikasiPenilaian($kode_ormawa, $id)
    {
        try {
            // Ambil program kerja
            $programKerja = ProgramKerja::findOrFail($id);

            // Cek apakah notifikasi sudah pernah dikirim
            if ($programKerja->notifikasi_penilaian_terkirim == 'true') {
                return response()->json([
                    'success' => false,
                    'message' => 'Notifikasi penilaian sudah pernah dikirim sebelumnya.'
                ]);
            }

            // Ambil semua koordinator dan wakil koordinator di program kerja ini
            $koordinatorUsers = DB::table('struktur_prokers')
                ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
                ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
                ->whereIn('struktur_prokers.jabatans_id', [11, 12, 13]) // ID untuk Koordinator, Wakil Koordinator, Wakil Koordinator II
                ->where('divisi_program_kerjas.program_kerjas_id', $id)
                ->select('users.*')
                ->distinct()
                ->get();

            // URL untuk halaman penilaian
            $url = route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $id]);

            // Kirim notifikasi ke setiap koordinator/wakil koordinator
            foreach ($koordinatorUsers as $user) {
                $userObj = User::find($user->id);
                Notification::send($userObj, new PenilaianAnggotaNotification($programKerja, $url));
            }

            // Update status notifikasi terkirim
            $programKerja->update([
                'notifikasi_penilaian_terkirim' => 'true'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi penilaian telah dikirim ke ' . $koordinatorUsers->count() . ' koordinator/wakil koordinator.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim notifikasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
