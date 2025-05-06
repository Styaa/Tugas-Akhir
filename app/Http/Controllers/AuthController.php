<?php

namespace App\Http\Controllers;

use App\Models\DivisiOrmawa;
use App\Models\StrukturOrmawa;
use App\Models\User;
use App\Notifications\DeadlineReminder;
use Illuminate\Http\Request;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('auth.signin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        // Periksa apakah user ditemukan dan statusnya tidak aktif
        if ($user && $user->status != 'aktif') {
            return back()->withErrors([
                'login_gagal' => 'Akun Anda masih dalam proses penerimaan.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $kodeOrmawa = $user->strukturOrmawas()
                ->with('divisiOrmawas.ormawa')
                ->get()
                ->pluck('divisiOrmawas.ormawa.kode')
                ->first();

            $periode = StrukturOrmawa::where('users_id', $user->id)->get()->pluck('periodes_periode');

            return redirect()->route('dashboard', ['kode_ormawa' => $kodeOrmawa]) . "?periode=$periode";
        }

        // dd(Hash::make('123456789'));


        return back()->withErrors([
            'login_gagal' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('auth/login');
    }

    public function uploadTemp(Request $request)
    {
        Log::info('Temporary file upload request received', [
            'request_all' => $request->all(),
            'has_file' => $request->hasFile('file'),
            'content_type' => $request->header('Content-Type'),
            'method' => $request->method(),
            'path' => $request->path(),
            'url' => $request->url(),
            'input_keys' => array_keys($request->all()),
            'files_keys' => array_keys($request->allFiles()),
        ]);

        try {
            // Cek parameter file dari FilePond
            // FilePond mengirim file dengan nama parameter 'file'
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                Log::info('File found in request', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ]);

                // Validasi file
                if (!$this->isValidFile($file)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Format file tidak didukung atau terlalu besar'
                    ], 400);
                }

                // Buat nama unik untuk file temporary
                $tempFilename = 'tempUser_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

                // Simpan file ke folder temporary
                $path = $file->storeAs('temp', $tempFilename, 'public');

                // Simpan informasi file di session untuk digunakan nanti
                $fileInfo = [
                    'temp_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'timestamp' => now()->timestamp,
                ];

                // Simpan informasi file di temp_files session
                $tempFiles = $request->session()->get('temp_files', []);
                $tempFiles[$tempFilename] = $fileInfo;
                $request->session()->put('temp_files', $tempFiles);

                Log::info('File saved to temporary storage', [
                    'temp_filename' => $tempFilename,
                    'original_name' => $file->getClientOriginalName()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'File berhasil diupload ke temporary storage',
                    'temp_file' => $tempFilename
                ]);
            }

            // FilePond mungkin juga mengirim dengan nama parameter yang berbeda
            // Cek semua file yang ada di request
            $allFiles = $request->allFiles();
            if (!empty($allFiles)) {
                // Ambil file pertama yang ditemukan
                $inputName = array_key_first($allFiles);
                $file = $request->file($inputName);

                Log::info('File found with different parameter name', [
                    'parameter_name' => $inputName,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ]);

                // Validasi file
                if (!$this->isValidFile($file)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Format file tidak didukung atau terlalu besar'
                    ], 400);
                }

                // Proses file (sama seperti di atas)
                $tempFilename = 'temp_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('temp', $tempFilename, 'public');

                // Simpan informasi file di session
                $fileInfo = [
                    'temp_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'timestamp' => now()->timestamp,
                ];

                $tempFiles = $request->session()->get('temp_files', []);
                $tempFiles[$tempFilename] = $fileInfo;
                $request->session()->put('temp_files', $tempFiles);

                Log::info('File saved to temporary storage (alternative method)', [
                    'temp_filename' => $tempFilename,
                    'original_name' => $file->getClientOriginalName()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'File berhasil diupload ke temporary storage',
                    'temp_file' => $tempFilename
                ]);
            }

            // Jika request adalah JSON dan berisi raw file
            if ($request->isJson() || $request->expectsJson()) {
                Log::info('Request is JSON, checking for raw file data');
                // Implementasi ini perlu disesuaikan dengan format file yang dikirim
                // ...
            }

            // Tidak ada file yang ditemukan
            Log::warning('No file found in the request');
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada file yang ditemukan'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error storing temporary file', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteTemp(Request $request)
    {
        try {
            $filePath = 'temp/' . $request->input('file_path');
            $fileType = $request->input('file_type', 'unknown');

            if (!$filePath) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Path file tidak valid'
                ], 400);
            }

            \Log::info('Attempting to delete file:', ['path' => $filePath, 'type' => $fileType]);

            // Periksa apakah file ada di storage
            if (Storage::exists($filePath)) {
                // Hapus file dari storage
                Storage::delete($filePath);

                // Hapus informasi file dari session
                $tempFiles = session('temp_files', []);
                unset($tempFiles[$filePath]);
                session(['temp_files' => $tempFiles]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'File berhasil dihapus'
                ]);
            }

            // Coba periksa juga di storage public
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);

                $tempFiles = session('temp_files', []);
                unset($tempFiles[$filePath]);
                session(['temp_files' => $tempFiles]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'File berhasil dihapus dari storage public'
                ]);
            }

            // Jika file tidak ditemukan di kedua lokasi
            return response()->json([
                'status' => 'warning',
                'message' => 'File tidak ditemukan di storage'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting temporary file:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function isValidFile($file)
    {
        // Tipe file yang diizinkan
        $allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'image/jpeg',
            'image/png'
        ];

        // Validasi tipe file
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return false;
        }

        // Validasi ukuran file (10MB)
        if ($file->getSize() > 10 * 1024 * 1024) {
            return false;
        }

        return true;
    }
}
