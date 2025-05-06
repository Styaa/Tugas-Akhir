<?php

use App\Http\Controllers\AktivitasDivisiProgramKerjaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiOrmawaController;
use App\Http\Controllers\DivisiProgramKerjaController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LaporanDokumenController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\OrmawaController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\RancanganAnggaranDanaController;
use App\Http\Controllers\RapatController;
use App\Models\AktivitasDivisiProgramKerja;
use App\Models\DivisiOrmawa;
use App\Models\DivisiProgramKerja;
use App\Models\LaporanDokumen;
use App\Models\StrukturProker;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::controller(GoogleController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('post-login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/get-divisi/{ormawa}', [DivisiOrmawaController::class, 'getDivisi'])->name('get-divisi');
    Route::get('/get-ormawa/{fakultas}', [OrmawaController::class, 'getOrmawa'])->name('get-ormawa');

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('post-regist');

    Route::post('/upload-temp-file', [AuthController::class, 'uploadTemp'])->name('upload.temp');
    Route::delete('/delete-temp-file', [AuthController::class, 'deleteTemp'])->name('delete.temp');
});

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/api/notulens/save', [NotulenController::class, 'apiSave'])->name('api.notulens.save');
Route::post('/api/proposals/save', [LaporanDokumenController::class, 'apiSaveProposal'])->name('save-proposal');
Route::post('/lpj', [LaporanDokumenController::class, 'apiSaveLPJ']);

Route::middleware(['auth'])->group(function () {
    // Dashboard Route

    Route::get('/alur-dana/kemahasiswaan', [DashboardController::class, 'alurDanaKemahasiswaan'])->name('alur-dana.kemahasiswaan');
    Route::get('/alur-dana/jurusan', [DashboardController::class, 'alurDanaJurusan'])->name('alur-dana.jurusan');

    Route::get('/events', [EventController::class, 'getEvents'])->name('events.get');

    Route::get('/get-divisions/{programKerjaId}', function ($programKerjaId) {
        $divisions = DivisiProgramKerja::where('program_kerjas_id', $programKerjaId)
            ->with('divisiPelaksana') // Pastikan relasi dimuat
            ->get();
        return response()->json($divisions);
    });

    Route::get('/get-divisions/{programId}', [RapatController::class, 'getDivisions']);
    Route::get('/get-division-members/{divisionId}', [RapatController::class, 'getDivisionMembers']);
    Route::get('/get-program-members/{programId}', [RapatController::class, 'getProgramMembers']);
    Route::get('/get-division-program-members/{divisionProgramId}', [RapatController::class, 'getDivisionProgramMembers']);

    // Routes based on Kode Ormawa
    Route::prefix('{kode_ormawa}')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/kalender', [RapatController::class, 'kalender'])->name('kalender');

        Route::prefix('rapat')->name('rapat.')->group(function () {
            Route::get('/all', [RapatController::class, 'index'])->name('index');
            Route::get('/create', [RapatController::class, 'create'])->name('create');
            Route::post('/izin', [RapatController::class, 'izin'])->name('izin');
            Route::get('/show', [RapatController::class, 'show'])->name('show');
            Route::post('/store', [RapatController::class, 'store'])->name('store');
            Route::get('/perizinan', [RapatController::class, 'perizinan'])->name('perizinan');

            Route::post('/absensi', [RapatController::class, 'absensi'])->name('absensi');
            Route::post('/izin/{id_rapat}', [RapatController::class, 'storeIzin'])->name('izin.store');
            Route::patch('/izin/{id_izin}/update', [RapatController::class, 'updateIzin'])->name('izin.update');

            Route::get('/tulis/notulensi', [RapatController::class, 'tulisNotulensi'])->name('tulis_notulensi');

            route::prefix('notulen')->name('notulen.')->group(function () {
                Route::get('/all', [NotulenController::class, 'index'])->name('index');
                Route::get('/create', [NotulenController::class, 'create'])->name('create');
                Route::post('/store', [NotulenController::class, 'store'])->name('store');
                Route::get('/{id}', [NotulenController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [NotulenController::class, 'edit'])->name('edit');
                Route::put('/{id}/update', [NotulenController::class, 'update'])->name('update');
                Route::delete('/{id}/destroy', [NotulenController::class, 'destroy'])->name('destroy');
            });
        });

        Route::resource('divisi', DivisiOrmawa::class);

        Route::prefix('program-kerja')->name('program-kerja.')->group(function () {
            Route::get('/', [ProgramKerjaController::class, 'index'])->name('index'); // Menampilkan semua program kerja
            Route::post('/', [ProgramKerjaController::class, 'create'])->name('create'); // Membuat program kerja baru
            Route::get('{id}/edit', [ProgramKerjaController::class, 'edit'])->name('edit'); // Mengambil data program kerja untuk form edit
            Route::put('{id}/update', [ProgramKerjaController::class, 'update'])->name('update'); // Mengupdate program kerja
            Route::get('{id}', [ProgramKerjaController::class, 'show'])->name('show'); // Menampilkan detail program kerja
            Route::delete('{id}/destroy', [ProgramKerjaController::class, 'destroy'])->name('destroy');
            Route::post('{id}/{periode}/{userId}/pilih-ketua', [ProgramKerjaController::class, 'pilihKetua'])->name('pilih-ketua'); // Memilih ketua program kerja
            Route::post('{id}/{periode}/pilih-anggota', [ProgramKerjaController::class, 'pilihAnggota'])->name('pilih-anggota'); // Memilih ketua program kerja

            Route::get('/{id}/evaluasi', [ProgramKerjaController::class, 'evaluasi'])->name('evaluasi');

            Route::post('{id}/nilai-anggota', [ProgramKerjaController::class, 'nilaiAnggota'])
                ->name('nilai-anggota');
            Route::post('{id}/kirim-notifikasi', [ProgramKerjaController::class, 'kirimNotifikasiPenilaian'])
                ->name('kirim-notifikasi');

            Route::get('{prokerId}/anggota/manage', [MemberController::class, 'manage'])
                ->name('anggota.manage');

            // Route untuk mengupdate jabatan/divisi anggota
            Route::put('{prokerId}/anggota/{anggotaId}/update', [MemberController::class, 'update'])
                ->name('anggota.update');

            // Route untuk menghapus anggota dari program kerja (opsional)
            Route::delete('{prokerId}/anggota/{anggotaId}/delete', [MemberController::class, 'destroy'])
                ->name('anggota.destroy');

            Route::resource('rancanganAnggaranDana', RancanganAnggaranDanaController::class);
            Route::get('{id}/proposal/create', [ProgramKerjaController::class, 'createProposal'])->name('proposal.create');
            Route::get('{id}/proposal/store', [ProgramKerjaController::class, 'storeProposal'])->name('proposal.store');
            Route::post('{id}/proposal/generate', [ProgramKerjaController::class, 'generateProposal'])->name('proposal.generate');
            Route::get('{id}/lpj/create', [ProgramKerjaController::class, 'createLPJ'])->name('lpj.create');

            Route::get('{id}/proposal/progress', [LaporanDokumenController::class, 'progressProposal'])->name('proposal.progress');
            Route::post('{id}/proposal/update-step', [LaporanDokumenController::class, 'updateStep'])->name('proposal.update-step');
            Route::post('{id}/proposal/upload-bukti', [LaporanDokumenController::class, 'uploadBukti'])->name('proposal.upload-bukti');

            Route::prefix('{id}/files')->name('files.')->group(function () {
                Route::get('/upload', [DocumentController::class, 'showUploadForm'])->name('upload');
                Route::post('/store', [DocumentController::class, 'storeFiles'])->name('store');
                Route::post('/temp', [DocumentController::class, 'storeTemporaryFile'])->name('temp');
                Route::delete('/temp', [DocumentController::class, 'deleteTemporaryFile'])->name('temp.delete');
                Route::post('/store-from-temp', [DocumentController::class, 'storeFromTemporary'])->name('store-from-temp');
                Route::get('/download/{file_id}', [DocumentController::class, 'downloadFile'])->name('download');
                Route::get('/preview/{file_id}', [DocumentController::class, 'previewFile'])->name('preview');
                Route::delete('/delete/{file_id}', [DocumentController::class, 'deleteFile'])->name('delete');
            });

            Route::post('/{id}/selesaikan', [ProgramKerjaController::class, 'selesaikan'])
                ->name('selesaikan');

            // Tambahkan juga route untuk melihat hasil evaluasi
            Route::get('/{id}/evaluasi', [ProgramKerjaController::class, 'evaluasi'])
                ->name('evaluasi');


            // Divisi Program Kerja Routes
            Route::prefix('{nama_program_kerja}/divisi')->name('divisi.')->group(function () {
                Route::get('/', [DivisiProgramKerjaController::class, 'index'])->name('index'); // Menampilkan divisi program kerja
                Route::get('{id}', [DivisiProgramKerjaController::class, 'show'])->name('show'); // Menampilkan detail divisi program kerja

                // Struktur Program Kerja Routes
                // Route::prefix('{nama_divisi}/struktur')->name('struktur-divisi.')->group(function () {
                //     Route::get('/', [StrukturProker::class, 'index'])->name('index'); // Menampilkan struktur divisi
                //     Route::post('tambah-panitia', [StrukturProker::class, 'tambahPanitia'])->name('tambah-panitia'); // Menambah panitia
                // });

                Route::prefix('{id}/aktivitas')->name('aktivitas.')->group(function () {
                    Route::get('/', [AktivitasDivisiProgramKerjaController::class, 'index'])->name('index'); // Menampilkan aktivitas divisi
                    Route::post('/', [AktivitasDivisiProgramKerjaController::class, 'store'])->name('store'); // Menyimpan aktivitas divisi
                    Route::patch('/{aktivitas_id}/update', [AktivitasDivisiProgramKerjaController::class, 'update'])->name('update');
                });
            });
        });

        // Member Routes
        Route::prefix('our-member')->name('our-member.')->group(function () {
            Route::get('members', [MemberController::class, 'allMembers'])->name('members');
            Route::get('member-profile', [MemberController::class, 'show'])->name('member-profile');
            Route::get('candidate-member', [MemberController::class, 'candidateMembers'])->name('candidate');
            Route::post('candidate-accept', [MemberController::class, 'acceptCandidate'])->name('candidate-accept');
            Route::post('candidate-reject', [MemberController::class, 'rejectCandidate'])->name('candidate-reject');
        });
    });
});
