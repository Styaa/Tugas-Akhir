<?php

namespace App\Http\Controllers;

use App\Models\AktivitasDivisiProgramKerja;
use App\Models\DivisiProgramKerja;
use App\Models\Jabatan;
use App\Models\ProgramKerja;
use App\Models\RegistrasiOrmawas;
use App\Models\StrukturOrmawa;
use App\Models\StrukturProker;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    //
    public function candidateMembers(Request $request, $kode_ormawa)
    {
        $candidate = User::whereHas('registrations', function ($query) use ($kode_ormawa) {
            $query->where('ormawas_kode', $kode_ormawa)
                  ->where('status', 'waiting');
        })
        ->with(['registrations' => function($query) use ($kode_ormawa) {
            $query->where('ormawas_kode', $kode_ormawa)
                  ->where('status', 'waiting');
        }, 'registrations.divisi1', 'registrations.divisi2'])
        ->get();

        // dd($candidate);


        // dd($candidate);

        return view('our-member.candidate-members', compact('candidate'));
    }

    public function acceptCandidate(Request $request, $kode_ormawa)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'divisi_selected' => 'required'
        ]);

        $userId = $request->input('user_id');
        $users = User::find($userId);
        if ($users) {
            // Contoh: Ubah status pengguna atau logika lainnya
            $users->status = 'aktif';
            $users->save();
        }

        // Update status registrasi_ormawas menjadi accepted untuk ormawa_kode yang sesuai
        RegistrasiOrmawas::where('users_id', $request->user_id)
            ->where('ormawas_kode', $kode_ormawa)
            ->update(['status' => 'accepted']);

        // Update status registrasi_ormawas menjadi rejected untuk ormawa_kode lain
        RegistrasiOrmawas::where('users_id', $request->user_id)
            ->where('ormawas_kode', '!=', $kode_ormawa)
            ->update(['status' => 'rejected']);

        $periode = DB::table('periodes')
            ->orderBy('periode', 'DESC')
            ->first();

        StrukturOrmawa::create([
            'divisi_ormawas_id' => $request->divisi_selected, //Masih perlu penyesuaian berdasarkan input user
            'users_id' => $request->user_id, // ID user yang diterima
            'periodes_periode' => $periode->periode, //now()->year //Untuk Mendapatkan periode saat ini
            'jabatan_id' => 13,
        ]);

        // Kembalikan respons
        return response()->json([
            'success' => true,
            'message' => 'User has been accepted and activated successfully.',
        ]);
    }

    public function rejectCandidate(Request $request, $kode_ormawa)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $userId = $request->input('user_id');

        // Update status registrasi_ormawas menjadi rejected untuk ormawa_kode yang sesuai
        RegistrasiOrmawas::where('users_id', $userId)
            ->where('ormawas_kode', $kode_ormawa)
            ->update([
                'status' => 'rejected'
            ]);

        // Jika ingin menyimpan alasan penolakan, pastikan tabel registrasi_ormawas memiliki kolom rejection_reason

        // Kembalikan respons
        return response()->json([
            'success' => true,
            'message' => 'Candidate has been rejected successfully.',
        ]);
    }

    public function allMembers($kode_ormawa)
    {
        $anggotas = User::whereHas('strukturOrmawas.divisiOrmawas.ormawa', function ($query) use ($kode_ormawa) {
            $query->where('kode', $kode_ormawa);
        })
            ->with(['strukturOrmawas.divisiOrmawas.ormawa', 'strukturOrmawas.jabatan'])
            ->orderBy('name', 'ASC')
            ->get();

        // dd($anggotas[0]->strukturOrmawas[0]);

        return view('our-member.members', compact('anggotas'));
    }

    public function show($kode_ormawa, Request $request)
    {
        // dd(Auth::user()->jabatan);
        $id_member = $request->id_member;

        $anggotaOrmawa = User::find($id_member);

        // dd($request);

        $aktivitasUsers = AktivitasDivisiProgramKerja::with('programKerja')
            ->where('person_in_charge', $id_member)
            ->get();

        $programKerjaUsers = ProgramKerja::whereHas('divisiProgramKerjas.strukturProker', function ($query) use ($id_member) {
            $query->where('users_id', $id_member);
        })->get()->map(function ($programKerja) {
            $ketuaAcara = $programKerja->strukturProkers
                ->where('jabatans_id', '2')
                ->first();
            $programKerja->ketua_acara = $ketuaAcara ? $ketuaAcara->user->name : 'Belum Ditentukan';
            return [
                'id_program_kerja' => $programKerja->id,
                'nama_program_kerja' => $programKerja->nama,
                'tipe_program_kerja' => $programKerja->tipe,
                'deskripsi_program_kerja' => $programKerja->deskripsi,
                'ketua_acara' => $programKerja->ketua_acara,
                'tanggal_mulai_program_kerja' => Carbon::parse($programKerja->tanggal_mulai)->translatedFormat('d F Y'), // Contoh: 12 Maret 2023
                'tanggal_selesai_program_kerja' => Carbon::parse($programKerja->tanggal_selesai)->translatedFormat('d F Y'),
            ];
        });

        $divisiUser = StrukturOrmawa::with(['divisiOrmawas', 'jabatan'])
            ->where('users_id', $id_member)
            ->where('periodes_periode', $request->periode)
            ->first();

        // dd($programKerjaUsers[0]['id_program_kerja']);

        // dd($divisiUser->divisiOrmawas->nama);

        return view('our-member.member-profile', compact('anggotaOrmawa', 'aktivitasUsers', 'programKerjaUsers', 'divisiUser'));
    }

    public function manage($kode_ormawa, $prokerId)
    {
        // Ambil data program kerja
        $programKerja = ProgramKerja::findOrFail($prokerId);

        // Cek apakah user memiliki akses ke program kerja ini
        // Contoh: hanya ketua/wakil/koordinator yang bisa mengelola anggota
        $userPosition = $this->getUserPositionInProker($prokerId, Auth::id());
        if (!in_array($userPosition, [2, 3, 11])) { // ID untuk Ketua, Wakil Ketua, Koordinator
            return redirect()
                ->back()
                ->with('error', 'Anda tidak memiliki akses untuk mengelola anggota');
        }

        // Ambil data divisi program kerja
        $divisiProker = DivisiProgramKerja::where('program_kerjas_id', $prokerId)
            ->join('divisi_pelaksanas', 'divisi_program_kerjas.divisi_pelaksanas_id', '=', 'divisi_pelaksanas.id')
            ->select('divisi_program_kerjas.id', 'divisi_pelaksanas.nama')
            ->get();

        // Ambil data anggota program kerja berdasarkan divisi
        $anggotaByDivisi = [];
        foreach ($divisiProker as $divisi) {
            $anggota = DB::table('struktur_prokers')
                ->join('users', 'struktur_prokers.users_id', '=', 'users.id')
                ->join('jabatans', 'struktur_prokers.jabatans_id', '=', 'jabatans.id')
                ->where('struktur_prokers.divisi_program_kerjas_id', $divisi->id)
                ->select(
                    'struktur_prokers.id',
                    'users.id as user_id',
                    'users.name',
                    'users.nrp',
                    'jabatans.id as jabatan_id',
                    'jabatans.nama as jabatan'
                )
                ->get();

            $anggotaByDivisi[$divisi->id] = [
                'nama_divisi' => $divisi->nama,
                'anggota' => $anggota
            ];
        }

        // Ambil data jabatan untuk dropdown
        $jabatanList = Jabatan::all();

        // Ambil daftar user yang belum ada di proker ini untuk opsi penambahan
        $existingUserIds = StrukturProker::where('divisi_program_kerjas_id', $divisi->id)
            ->pluck('users_id')
            ->toArray();

        $availableUsers = User::where('status', 'aktif')
            ->whereDoesntHave('strukturProkers', function ($query) use ($prokerId) {
                $query->whereHas('divisiProgramKerja', function ($subQuery) use ($prokerId) {
                    $subQuery->where('program_kerjas_id', $prokerId);
                });
            })
            ->get();

        // dd($divisiProker);

        return view('program-kerja.anggota.kelola', [
            'programKerja' => $programKerja,
            'divisiProker' => $divisiProker,
            'anggotaByDivisi' => $anggotaByDivisi,
            'jabatanList' => $jabatanList,
            'availableUsers' => $availableUsers,
            'kode_ormawa' => $kode_ormawa,
            'programKerjaSelesai' => false // Sesuaikan dengan logika status proker
        ]);
    }

    /**
     * Update jabatan anggota proker
     */
    public function update(Request $request, $kode_ormawa, $prokerId, $anggotaId)
    {
        // Validasi input
        $validated = $request->validate([
            'jabatan_id' => 'required|exists:jabatans,id',
            'divisi_id' => 'required|exists:divisi_pelaksanas,id',
        ]);

        // Cek apakah user memiliki akses untuk mengubah
        $userPosition = $this->getUserPositionInProker($prokerId, Auth::id());
        if (!in_array($userPosition, [2, 3, 11])) { // ID untuk Ketua, Wakil Ketua, Koordinator
            return redirect()
                ->back()
                ->with('error', 'Anda tidak memiliki akses untuk mengelola anggota');
        }

        // Cari data struktur proker untuk user ini
        $strukturProker = StrukturProker::where('users_id', $anggotaId)
            ->whereHas('divisiProgramKerja', function ($query) use ($prokerId) {
                $query->where('program_kerjas_id', $prokerId);
            })
            ->first();

        // Cek jika struktur proker tidak ditemukan
        if (!$strukturProker) {
            return redirect()
                ->back()
                ->with('error', 'Data anggota tidak ditemukan');
        }

        // Cari divisi program kerja berdasarkan divisi pelaksana yang dipilih
        $divisiProgramKerja = DivisiProgramKerja::where('program_kerjas_id', $prokerId)
            ->where('divisi_pelaksanas_id', $validated['divisi_id'])
            ->first();

        if (!$divisiProgramKerja) {
            return redirect()
                ->back()
                ->with('error', 'Divisi tidak ditemukan dalam program kerja ini');
        }

        // Cek apakah divisi berubah
        $divisiChanged = $strukturProker->divisi_program_kerjas_id != $divisiProgramKerja->id;

        // Jika divisi berubah, cek apakah anggota sudah ada di divisi tujuan
        if ($divisiChanged) {
            $existingMember = StrukturProker::where('users_id', $anggotaId)
                ->where('divisi_program_kerjas_id', $divisiProgramKerja->id)
                ->first();

            if ($existingMember) {
                return redirect()
                    ->back()
                    ->with('error', 'Anggota sudah terdaftar dalam divisi tujuan');
            }

            // Update data divisi dan jabatan
            $strukturProker->update([
                'divisi_program_kerjas_id' => $divisiProgramKerja->id,
                'jabatans_id' => $validated['jabatan_id']
            ]);

            return redirect()
                ->back()
                ->with('success', 'Jabatan dan divisi anggota berhasil diperbarui');
        } else {
            // Jika hanya jabatan yang berubah, update jabatan saja
            $strukturProker->update([
                'jabatans_id' => $validated['jabatan_id']
            ]);

            return redirect()
                ->back()
                ->with('success', 'Jabatan anggota berhasil diperbarui');
        }
    }

    /**
     * Tambah anggota baru ke proker
     */
    public function store(Request $request, $kode_ormawa, $prokerId)
    {
        // Validasi input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'divisi_id' => 'required|exists:divisi_program_kerjas,id',
            'jabatan_id' => 'required|exists:jabatans,id',
        ]);

        // Cek apakah user sudah ada di proker ini
        $existingMember = StrukturProker::where('users_id', $validated['user_id'])
            ->where('divisi_program_kerjas_id', $validated['divisi_id'])
            ->first();

        if ($existingMember) {
            return redirect()
                ->back()
                ->with('error', 'Anggota sudah terdaftar dalam divisi ini');
        }

        // Cek apakah user memiliki akses untuk menambah
        $userPosition = $this->getUserPositionInProker($prokerId, Auth::id());
        if (!in_array($userPosition, [2, 3, 11])) { // ID untuk Ketua, Wakil Ketua, Koordinator
            return redirect()
                ->back()
                ->with('error', 'Anda tidak memiliki akses untuk mengelola anggota');
        }

        // Tambahkan anggota baru
        StrukturProker::create([
            'users_id' => $validated['user_id'],
            'divisi_program_kerjas_id' => $validated['divisi_id'],
            'jabatans_id' => $validated['jabatan_id']
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()
            ->back()
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    /**
     * Hapus anggota dari proker
     */
    public function destroy($kode_ormawa, $prokerId, $anggotaId)
    {
        // Validasi input dari form jika ada
        $request = request();
        $divisiId = $request->input('divisi_id');

        // Ambil data struktur proker berdasarkan user_id dan divisi_id jika ada
        $query = StrukturProker::where('users_id', $anggotaId)
            ->whereHas('divisiProgramKerja', function ($query) use ($prokerId) {
                $query->where('program_kerjas_id', $prokerId);
            });

        // Filter berdasarkan divisi jika divisiId disediakan
        if ($divisiId) {
            $query->where('divisi_program_kerjas_id', $divisiId);
        }

        $strukturProker = $query->first();

        if (!$strukturProker) {
            return redirect()
                ->back()
                ->with('error', 'Data anggota tidak ditemukan');
        }

        // Cek apakah user memiliki akses untuk menghapus
        $userPosition = $this->getUserPositionInProker($prokerId, Auth::id());
        if (!in_array($userPosition, [2, 3, 11])) { // ID untuk Ketua, Wakil Ketua, Koordinator
            return redirect()
                ->back()
                ->with('error', 'Anda tidak memiliki akses untuk mengelola anggota');
        }

        // Ambil nama anggota untuk pesan konfirmasi
        $anggota = User::find($strukturProker->users_id);
        $namaAnggota = $anggota ? $anggota->name : 'Anggota';

        // Hapus anggota
        $strukturProker->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()
            ->back()
            ->with('success', "Anggota $namaAnggota berhasil dihapus dari program kerja");
    }

    /**
     * Helper method untuk mendapatkan posisi user dalam proker
     */
    private function getUserPositionInProker($prokerId, $userId)
    {
        $userProker = DB::table('struktur_prokers')
            ->join('divisi_program_kerjas', 'struktur_prokers.divisi_program_kerjas_id', '=', 'divisi_program_kerjas.id')
            ->where('divisi_program_kerjas.program_kerjas_id', $prokerId)
            ->where('struktur_prokers.users_id', $userId)
            ->select('struktur_prokers.jabatans_id')
            ->first();

        return $userProker ? $userProker->jabatans_id : null;
    }
}
