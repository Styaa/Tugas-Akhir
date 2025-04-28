<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Fakultas;
use App\Models\Ormawa;
use App\Models\RegistrasiOrmawas;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $ormawas = Ormawa::all();
        $fakultas = Fakultas::all();
        return view('auth.signup', compact('ormawas', 'fakultas'));
    }

    public function register(Request $request)
    {
        // dd($request->all());
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|same:password',
            'nrp' => 'required|string|max:20',
            'jurusan' => 'required|string|max:100',
            'id_line' => 'required|string|max:50',
            'no_hp' => 'required|string|max:15',
            'pilihan_ormawa_1' => 'required|string|exists:ormawas,kode',
            'pilihan_ormawa_2' => 'nullable|string|exists:ormawas,kode|different:pilihan_ormawa_1',
        ]);

        if ($validator->fails()) {
            dd($validator->errors());
            return back()->withErrors($validator)
                        ->withInput()
                        ->with('error', 'Registrasi gagal! Silakan periksa kembali data yang Anda masukkan.');
        }

        // Double-check password match
        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors(['password' => 'Password dan Konfirmasi Password harus sama.'])
                        ->withInput()
                        ->with('error', 'Password dan Konfirmasi Password tidak sama!');
        }

        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nrp' => $request->nrp,
                'jurusan' => $request->jurusan,
                'id_line' => $request->id_line,
                'no_hp' => $request->no_hp,
            ]);

            // Save organization registration for first choice
            if ($request->filled('pilihan_ormawa_1')) {
                RegistrasiOrmawas::create([
                    'users_id' => $user->id,
                    'ormawas_kode' => $request->pilihan_ormawa_1,
                    'pilihan_divisi_1' => $request['divisi_divisi-container1_1'],
                    'pilihan_divisi_2' => $request['divisi_divisi-container1_2'],
                    'status' => 'waiting',
                ]);
            }

            // Save organization registration for second choice (if provided)
            if ($request->filled('pilihan_ormawa_2')) {
                RegistrasiOrmawas::create([
                    'users_id' => $user->id,
                    'ormawas_kode' => $request->pilihan_ormawa_2,
                    'pilihan_divisi_1' => $request['divisi_divisi-container2_1'],
                    'pilihan_divisi_2' => $request['divisi_divisi-container2_2'],
                    'status' => 'waiting',
                ]);
            }

            // Process uploaded files (CV and portfolio)
            if ($request->filled('cv_files')) {
                $this->processCVFiles($user, $request->cv_files);
            }

            if ($request->filled('porto_files')) {
                $this->processPortfolioFiles($user, $request->porto_files);
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda sedang dalam proses verifikasi. Silakan cek email untuk informasi lebih lanjut.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi nanti.');
        }
    }

    private function processCVFiles($user, $cvFiles)
    {
        try {
            $files = json_decode($cvFiles, true);
            if (empty($files)) {
                return;
            }

            // Dapatkan informasi file dari session
            $tempFilesInfo = session()->get('temp_files', []);

            // Ambil hanya file pertama karena CV seharusnya hanya satu file
            $cvFilePath = $files[0];

            if (!isset($tempFilesInfo[$cvFilePath])) {
                Log::warning('CV file info not found in session', [
                    'user_id' => $user->id,
                    'file_path' => $cvFilePath
                ]);
                return;
            }

            $fileInfo = $tempFilesInfo[$cvFilePath];

            // Buat direktori jika belum ada
            $directory = 'user-files/cv/' . $user->id;
            Storage::disk('public')->makeDirectory($directory);

            // Pindahkan file dari temporary ke penyimpanan permanen
            $newPath = $directory . '/' . Str::uuid() . '.' . $fileInfo['extension'];

            if (Storage::disk('public')->exists($fileInfo['temp_path'])) {
                // Pindahkan file
                Storage::disk('public')->move($fileInfo['temp_path'], $newPath);

                // Buat record di database
                $document = Document::create([
                    'program_kerja_id' => null, // CV tidak terkait dengan program kerja
                    'original_name' => $fileInfo['original_name'],
                    'storage_path' => $newPath,
                    'extension' => $fileInfo['extension'],
                    'size' => $fileInfo['size'],
                    'category' => 'cv',
                    'visibility' => 'committee', // Hanya committee yang bisa melihat
                    'description' => 'CV for user ' . $user->name,
                    'tags' => json_encode(['cv', 'registration', 'user-' . $user->id]),
                    'uploaded_by' => $user->id,
                ]);

                // Update user dengan dokumen CV
                $user->cv_document_id = $document->id;
                $user->save();

                Log::info('CV file processed successfully', [
                    'user_id' => $user->id,
                    'document_id' => $document->id
                ]);

                // Hapus informasi file dari session
                unset($tempFilesInfo[$cvFilePath]);
                session()->put('temp_files', $tempFilesInfo);
            } else {
                Log::warning('CV temporary file not found', [
                    'user_id' => $user->id,
                    'temp_path' => $fileInfo['temp_path']
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error processing CV files', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function processPortfolioFiles($user, $portfolioFiles)
    {
        try {
            $files = json_decode($portfolioFiles, true);
            if (empty($files)) {
                return;
            }

            // Dapatkan informasi file dari session
            $tempFilesInfo = session()->get('temp_files', []);

            // Buat direktori jika belum ada
            $directory = 'user-files/portfolio';
            Storage::disk('public')->makeDirectory($directory);

            foreach ($files as $filePath) {
                // Cek apakah informasi file ada di session
                if (!isset($tempFilesInfo[$filePath])) {
                    continue;
                }

                $fileInfo = $tempFilesInfo[$filePath];

                // Pindahkan file dari temporary ke penyimpanan permanen
                $newPath = $directory . '/' . Str::uuid() . '.' . $fileInfo['extension'];

                if (Storage::disk('public')->exists($fileInfo['temp_path'])) {
                    // Pindahkan file
                    Storage::disk('public')->move($fileInfo['temp_path'], $newPath);

                    // Buat record di database sesuai dengan struktur tabel dokumen
                    $document = Document::create([
                        'program_kerja_id' => null, // Portfolio tidak terkait dengan program kerja
                        'original_name' => $fileInfo['original_name'],
                        'storage_path' => $newPath,
                        'extension' => $fileInfo['extension'],
                        'size' => $fileInfo['size'],
                        'category' => 'portfolio',
                        'visibility' => 'committee', // Hanya committee yang bisa melihat
                        'description' => 'Portfolio for user ' . $user->name,
                        'tags' => json_encode(['portfolio', 'registration', 'user-' . $user->id]),
                        'uploaded_by' => $user->id,
                    ]);

                    Log::info('Portfolio file processed successfully', [
                        'user_id' => $user->id,
                        'document_id' => $document->id
                    ]);

                    // Hapus informasi file dari session
                    unset($tempFilesInfo[$filePath]);
                } else {
                    Log::warning('Portfolio temporary file not found', [
                        'user_id' => $user->id,
                        'temp_path' => $fileInfo['temp_path']
                    ]);
                }
            }

            // Update session
            session()->put('temp_files', $tempFilesInfo);
        } catch (\Exception $e) {
            Log::error('Error processing portfolio files', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
