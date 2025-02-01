<?php

use App\Http\Controllers\AktivitasDivisiProgramKerjaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiProgramKerjaController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProgramKerjaController;
use App\Http\Controllers\RancanganAnggaranDanaController;
use App\Models\AktivitasDivisiProgramKerja;
use App\Models\DivisiProgramKerja;
use App\Models\StrukturProker;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('post-login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('post-regist');
});

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    // Dashboard Route

    Route::get('/alur-dana/kemahasiswaan', [DashboardController::class, 'alurDanaKemahasiswaan'])->name('alur-dana.kemahasiswaan');
    Route::get('/alur-dana/jurusan', [DashboardController::class, 'alurDanaJurusan'])->name('alur-dana.jurusan');

    // Routes based on Kode Ormawa
    Route::prefix('{kode_ormawa}')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('program-kerja')->name('program-kerja.')->group(function () {
            Route::get('/', [ProgramKerjaController::class, 'index'])->name('index'); // Menampilkan semua program kerja
            Route::post('/', [ProgramKerjaController::class, 'create'])->name('create'); // Membuat program kerja baru
            Route::get('{id}/edit', [ProgramKerjaController::class, 'edit'])->name('edit'); // Mengambil data program kerja untuk form edit
            Route::put('{id}/update', [ProgramKerjaController::class, 'update'])->name('update'); // Mengupdate program kerja
            Route::get('{id}', [ProgramKerjaController::class, 'show'])->name('show'); // Menampilkan detail program kerja
            Route::post('{id}/{periode}/{userId}/pilih-ketua', [ProgramKerjaController::class, 'pilihKetua'])->name('pilih-ketua'); // Memilih ketua program kerja
            Route::post('{id}/{periode}/pilih-anggota', [ProgramKerjaController::class, 'pilihAnggota'])->name('pilih-anggota'); // Memilih ketua program kerja

            Route::resource('rancanganAnggaranDana', RancanganAnggaranDanaController::class);
            Route::get('{id}/proposal/create', [ProgramKerjaController::class, 'createProposal'])->name('proposal.create');
            Route::get('{id}/proposal/progress', [ProgramKerjaController::class, 'progressProposal'])->name('proposal.progress');
            Route::get('{id}/proposal/store', [ProgramKerjaController::class, 'storeProposal'])->name('proposal.store');
            Route::post('{id}/proposal/generate', [ProgramKerjaController::class, 'generateProposal'])->name('proposal.generate');
            Route::get('{id}/lpj/create', [ProgramKerjaController::class, 'createLPJ'])->name('lpj.create');


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
            Route::get('candidate-member', [MemberController::class, 'candidateMembers'])->name('candidate');
            Route::post('candidate-accept', [MemberController::class, 'acceptCandidate'])->name('candidate-accept');
        });
    });
});
