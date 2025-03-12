<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    //

    public function storeTemporaryFile(Request $request, $kode_ormawa, $id)
    {
        // Log detail request untuk debugging
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
                $tempFilename = 'temp_' . Str::uuid() . '.' . $file->getClientOriginalExtension();

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

    /**
     * Hapus file dari temporary storage
     */
    public function deleteTemporaryFile(Request $request)
    {
        try {
            $tempFilename = $request->getContent();

            // Cek apakah file ada di session
            $tempFiles = $request->session()->get('temp_files', []);

            if (!isset($tempFiles[$tempFilename])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File temporary tidak ditemukan'
                ], 404);
            }

            $fileInfo = $tempFiles[$tempFilename];

            // Hapus file dari storage
            if (Storage::disk('public')->exists($fileInfo['temp_path'])) {
                Storage::disk('public')->delete($fileInfo['temp_path']);
            }

            // Hapus informasi file dari session
            unset($tempFiles[$tempFilename]);
            $request->session()->put('temp_files', $tempFiles);

            Log::info('Temporary file deleted', [
                'temp_filename' => $tempFilename
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'File temporary berhasil dihapus',
                'temp_file' => $tempFilename
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting temporary file', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus file temporary: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proses file dari temporary storage ke penyimpanan permanen dan database
     */
    public function storeFromTemporary(Request $request, $kode_ormawa, $id)
    {
        try {
            // Validasi program kerja
            $programKerja = ProgramKerja::findOrFail($id);

            // Dapatkan daftar file temporary dari request
            $tempFiles = json_decode($request->input('temp_files'), true);

            if (empty($tempFiles)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada file yang ditemukan'
                ], 400);
            }

            // Dapatkan informasi file dari session
            $tempFilesInfo = $request->session()->get('temp_files', []);

            // dd($tempFilesInfo);

            // Proses setiap file
            $uploadedFiles = [];

            foreach ($tempFiles as $tempFilename) {
                // Cek apakah informasi file ada di session
                if (!isset($tempFilesInfo[$tempFilename])) {
                    continue;
                }

                $fileInfo = $tempFilesInfo[$tempFilename];

                // Pindahkan file dari temporary ke penyimpanan permanen
                $newPath = 'program-kerja-files/' . Str::uuid() . '.' . $fileInfo['extension'];

                if (Storage::disk('public')->exists($fileInfo['temp_path'])) {
                    // Pindahkan file
                    Storage::disk('public')->move($fileInfo['temp_path'], $newPath);

                    // Buat record di database
                    $fileRecord = Document::create([
                        'program_kerja_id' => $id,
                        'original_name' => $fileInfo['original_name'],
                        'storage_path' => $newPath,
                        'extension' => $fileInfo['extension'],
                        'size' => $fileInfo['size'],
                        'category' => $request->input('file_category', 'dokumen'),
                        'visibility' => $request->input('file_visibility', 'committee'),
                        'description' => $request->input('description'),
                        'tags' => json_encode($request->input('tags', [])),
                        'uploaded_by' => Auth::id(),
                    ]);

                    $uploadedFiles[] = $fileRecord;

                    Log::info('File moved from temporary to permanent storage', [
                        'file_id' => $fileRecord->id,
                        'original_name' => $fileInfo['original_name']
                    ]);
                }

                // Hapus informasi file dari session
                unset($tempFilesInfo[$tempFilename]);
            }

            // Update session
            $request->session()->put('temp_files', $tempFilesInfo);

            if (count($uploadedFiles) > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => count($uploadedFiles) . ' file berhasil diupload',
                    'files' => $uploadedFiles
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada file valid yang diupload'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error storing from temporary', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeFiles(Request $request, $kode_ormawa, $id)
    {
        // Log request untuk debugging
        Log::info('File upload request received', [
            'request_all' => $request->all(),
            'has_file' => $request->hasFile('file'),
            'has_files' => $request->hasFile('files'),
            'content_type' => $request->header('Content-Type')
        ]);

        try {
            // Validasi program kerja
            $programKerja = ProgramKerja::findOrFail($id);

            // Cara 1: FilePond mengirim dengan xhr custom (menggunakan 'file' sebagai nama field)
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Validasi file
                if (!$this->isValidFile($file)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Format file tidak didukung atau terlalu besar'
                    ], 400);
                }

                // Simpan file
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $storagePath = $file->store('program-kerja-files', 'public');

                // Ambil metadata dari request
                $category = $request->input('file_category', 'dokumen');
                $visibility = $request->input('file_visibility', 'committee');
                $description = $request->input('description');
                $tags = $request->input('tags');

                if (is_string($tags) && is_array(json_decode($tags, true))) {
                    $tags = json_decode($tags, true);
                }

                // Simpan metadata ke database
                $fileRecord = Document::create([
                    'program_kerja_id' => $id,
                    'original_name' => $originalName,
                    'storage_path' => $storagePath,
                    'extension' => $extension,
                    'size' => $size,
                    'category' => $category,
                    'visibility' => $visibility,
                    'description' => $description,
                    'tags' => json_encode($tags ?? []),
                    'uploaded_by' => Auth::id(),
                ]);

                Log::info('File saved successfully', [
                    'file_id' => $fileRecord->id,
                    'original_name' => $originalName
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'File berhasil diupload',
                    'file_id' => $fileRecord->id
                ]);
            }

            // Cara 2: Form biasa dengan multiple file upload (menggunakan 'files[]' sebagai nama field)
            else if ($request->hasFile('files')) {
                $uploadedFiles = [];
                $files = $request->file('files');

                foreach ($files as $file) {
                    // Validasi file
                    if (!$this->isValidFile($file)) {
                        continue;
                    }

                    // Simpan file
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $storagePath = $file->store('program-kerja-files', 'public');

                    // Simpan metadata ke database
                    $fileRecord = Document::create([
                        'program_kerja_id' => $id,
                        'original_name' => $originalName,
                        'storage_path' => $storagePath,
                        'extension' => $extension,
                        'size' => $size,
                        'category' => $request->input('file_category', 'dokumen'),
                        'visibility' => $request->input('file_visibility', 'committee'),
                        'description' => $request->input('description'),
                        'tags' => json_encode($request->input('tags', [])),
                        'uploaded_by' => Auth::id(),
                    ]);

                    $uploadedFiles[] = $fileRecord;
                }

                if (count($uploadedFiles) > 0) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'File berhasil diupload',
                        'files' => $uploadedFiles
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tidak ada file valid yang diupload'
                    ], 400);
                }
            }

            // No files found
            else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada file yang ditemukan'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error storing file', [
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

    // private function processFile($file, $programKerjaId, Request $request)
    // {
    //     $originalName = $file->getClientOriginalName();
    //     $extension = $file->getClientOriginalExtension();
    //     $size = $file->getSize();

    //     dd($originalName);

    //     // Simpan file ke storage
    //     $storagePath = $file->store('program-kerja-files', 'public');

    //     // Buat record file di database
    //     return Document::create([
    //         'program_kerja_id' => $programKerjaId,
    //         'original_name' => $originalName,
    //         'storage_path' => $storagePath,
    //         'extension' => $extension,
    //         'size' => $size,
    //         'category' => $request->input('file_category', 'dokumen'), // Default jika tidak ada
    //         'visibility' => $request->input('file_visibility', 'committee'), // Default jika tidak ada
    //         'description' => $request->input('description'),
    //         'tags' => json_encode($request->input('tags', [])),
    //         'uploaded_by' => Auth::id(),
    //     ]);
    // }

    public function showUploadForm($kode_ormawa, $id)
    {
        $programKerja = ProgramKerja::findOrFail($id);

        return view('program-kerja.dokumen.upload-file', [
            'kode_ormawa' => $kode_ormawa,
            'id' => $id,
            'programKerja' => $programKerja,
        ]);
    }

    public function downloadFile($kode_ormawa, $id, $file_id)
    {
        $file = Document::findOrFail($file_id);

        // Cek apakah user memiliki akses ke file
        // Implementasi logika akses sesuai dengan kebutuhan aplikasi

        return response()->download(storage_path('app/public/' . $file->storage_path), $file->original_name);
    }

    /**
     * Preview file.
     *
     * @param string $kode_ormawa
     * @param int $id
     * @param int $file_id
     * @return \Illuminate\Http\Response
     */
    public function previewFile($kode_ormawa, $id, $file_id)
    {
        $file = Document::findOrFail($file_id);

        // Cek apakah user memiliki akses ke file
        // Implementasi logika akses sesuai dengan kebutuhan aplikasi

        $path = storage_path('app/public/' . $file->storage_path);

        return response()->file($path);
    }

    public function deleteFile($kode_ormawa, $id, $file_id)
    {
        $file = Document::findOrFail($file_id);

        // Cek hak akses: hanya pembuat file atau admin yang dapat menghapus
        if (auth()->id() != $file->uploaded_by && !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk menghapus file ini.');
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($file->storage_path);

        // Hapus record dari database
        $file->delete();

        return redirect()->route('program-kerja.show', [
            'kode_ormawa' => $kode_ormawa,
            'id' => $id
        ])->with('success', 'File berhasil dihapus.');
    }
}
