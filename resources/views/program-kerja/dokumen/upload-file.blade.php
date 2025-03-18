@extends('layouts.app')

@section('title', __('Upload Dokumen Program Kerja'))

@section('js_head')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        /* Custom styles untuk FilePond */
        .filepond--panel-root {
            background-color: #f8f9fa;
            border: 1px dashed #ced4da;
        }

        .filepond--drop-label {
            color: #6c757d;
        }

        .filepond--item-panel {
            background-color: #e9ecef;
        }

        .filepond--label-action {
            text-decoration-color: #0d6efd;
        }

        /* Style untuk preview file */
        .filepond--file-info-main {
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header py-3 px-0 d-flex align-items-center justify-content-between">
                            <h3 class="fw-bold flex-fill px-3">Upload Dokumen Program Kerja</h3>
                            <a href="{{ route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $id]) }}"
                                class="btn btn-outline-secondary me-3">
                                <i class="icofont-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h5 class="fw-bold">{{ $programKerja->nama }}</h5>
                                <p class="text-muted">{{ $programKerja->deskripsi }}</p>
                            </div>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form
                                action="{{ route('program-kerja.files.store-from-temp', ['kode_ormawa' => $kode_ormawa, 'id' => $id]) }}"
                                method="POST" enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                <input type="hidden" name="program_kerja_id" value="{{ $id }}">
                                <input type="hidden" name="kode_ormawa" value="{{ $kode_ormawa }}">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="file_category" class="form-label">Kategori Dokumen</label>
                                            <select class="form-select @error('file_category') is-invalid @enderror"
                                                id="file_category" name="file_category" required>
                                                <option value="" selected disabled>Pilih Kategori</option>
                                                <option value="dokumentasi">Dokumentasi</option>
                                                <option value="pendukung">Dokumen Pendukung</option>
                                                <option value="keuangan">Laporan Keuangan</option>
                                                <option value="evaluasi">Evaluasi</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                            @error('file_category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="file_visibility" class="form-label">Visibilitas</label>
                                            <select class="form-select @error('file_visibility') is-invalid @enderror"
                                                id="file_visibility" name="file_visibility" required>
                                                <option value="" selected disabled>Pilih Visibilitas</option>
                                                <option value="coordinator">Koor/Wakil Koordinator</option>
                                                <option value="committee">Panitia Proker</option>
                                                <option value="organization">Semua Anggota Ormawa</option>
                                            </select>
                                            @error('file_visibility')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Upload Dokumen</label>
                                    <div class="file-upload-container">
                                        <input type="file" class="filepond" name="files[]" multiple
                                            data-max-file-size="10MB" data-max-files="5" required />
                                        <small class="text-muted d-block mt-2">Format yang didukung: PDF, DOC, DOCX, XLS,
                                            XLSX, PPT, PPTX, JPG, PNG (Maks. 10MB)</small>
                                    </div>
                                    @error('files')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3"></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tag (Opsional)</label>
                                    <select class="form-select" id="tags" name="tags[]" multiple>
                                        <option value="penting">Penting</option>
                                        <option value="laporan">Laporan</option>
                                        <option value="revisi">Revisi</option>
                                        <option value="final">Final</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                    <small class="text-muted">Pilih tag untuk mempermudah pencarian file</small>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="{{ route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $id]) }}"
                                        class="btn btn-outline-secondary">Batal</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icofont-upload-alt me-2"></i>Upload File
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/filepond/filepond.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Konfigurasi Select2
            $('#tags').select2({
                theme: "bootstrap-5",
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: "Pilih atau masukkan tag baru"
            });

            // Tambahkan debugging untuk melihat request FilePond
            console.log('Initializing FilePond with debugging...');

            // Simpan daftar file yang sudah diupload ke temporary storage
            let uploadedFiles = [];

            // Register FilePond plugins
            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize,
                FilePondPluginImagePreview,
                FilePondPluginFilePoster
            );

            // Create FilePond instance
            const pond = FilePond.create(document.querySelector('.filepond'), {
                allowMultiple: true,
                maxFiles: 5,
                maxFileSize: '10MB',
                acceptedFileTypes: [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'image/jpeg',
                    'image/png'
                ],
                labelIdle: 'Seret & lepas file disini atau <span class="filepond--label-action">Pilih File</span>',
                labelFileTypeNotAllowed: 'Format file tidak didukung',
                fileValidateTypeLabelExpectedTypes: 'File yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG',
                labelMaxFileSizeExceeded: 'File terlalu besar',
                labelMaxFileSize: 'Ukuran maksimal file adalah {filesize}',

                // Konfigurasi server untuk upload temporary
                server: {
                    // Event dijalankan sebelum upload file
                    process: function(fieldName, file, metadata, load, error, progress, abort, transfer,
                        options) {
                        console.log('FilePond processing file:', file.name);

                        // Buat FormData untuk kirim file
                        const formData = new FormData();
                        formData.append('file', file, file.name);
                        formData.append('_token', '{{ csrf_token() }}');

                        // Log FormData content
                        console.log('FormData entries:');
                        for (let pair of formData.entries()) {
                            console.log(pair[0], pair[1] instanceof File ? 'File: ' + pair[1].name :
                                pair[1]);
                        }

                        // Buat XHR request manual untuk detail debugging
                        const xhr = new XMLHttpRequest();

                        // Log semua event XHR
                        xhr.upload.onprogress = (e) => {
                            console.log('Upload progress:', Math.round(e.loaded / e.total * 100) +
                                '%');
                            progress(e.lengthComputable, e.loaded, e.total);
                        };

                        xhr.onload = function() {
                            console.log('XHR response status:', xhr.status);
                            console.log('XHR response text:', xhr.responseText);

                            if (xhr.status >= 200 && xhr.status < 300) {
                                try {
                                    const response = JSON.parse(xhr.responseText);
                                    console.log('Parsed response:', response);

                                    if (response.status === 'success') {
                                        uploadedFiles.push(response.temp_file);
                                        console.log('File uploaded to temp storage:', response
                                            .temp_file);
                                        load(response.temp_file);
                                    } else {
                                        console.error('Server returned error:', response.message);
                                        error(response.message);
                                    }
                                } catch (e) {
                                    console.error('Error parsing response:', e);
                                    error('Error parsing server response');
                                }
                            } else {
                                console.error('XHR error - HTTP status:', xhr.status);
                                error('Upload failed with status ' + xhr.status);
                            }
                        };

                        xhr.onerror = function() {
                            console.error('XHR network error');
                            error('Network error occurred');
                        };

                        // Open and send the request
                        xhr.open('POST',
                            '{{ route('program-kerja.files.temp', ['kode_ormawa' => $kode_ormawa, 'id' => $id]) }}'
                        );
                        // Don't set Content-Type header - browser will set it with boundary for multipart/form-data
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        xhr.send(formData);

                        // Return abort function
                        return {
                            abort: () => {
                                xhr.abort();
                                abort();
                            }
                        };
                    },

                    // Revert (hapus file dari temporary storage)
                    revert: function(uniqueFileId, load, error) {
                        console.log('Reverting file:', uniqueFileId);

                        fetch('{{ route('program-kerja.files.temp.delete', ['kode_ormawa' => $kode_ormawa, 'id' => $id]) }}', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: uniqueFileId
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Revert response:', data);

                                // Hapus dari daftar file yang sudah diupload
                                const index = uploadedFiles.findIndex(file => file ===
                                    uniqueFileId);
                                if (index !== -1) {
                                    uploadedFiles.splice(index, 1);
                                    console.log('File removed from temp storage:', uniqueFileId);
                                }

                                load();
                            })
                            .catch(err => {
                                console.error('Error reverting file:', err);
                                error(err.message);
                            });
                    }
                }
            });

            // Handle form submission
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Check if we have any files
                if (uploadedFiles.length === 0) {
                    alert('Silakan pilih file untuk diupload');
                    return;
                }

                // Validate other form fields
                const category = document.getElementById('file_category').value;
                const visibility = document.getElementById('file_visibility').value;

                if (!category || category === '') {
                    alert('Silakan pilih kategori dokumen');
                    return;
                }

                if (!visibility || visibility === '') {
                    alert('Silakan pilih visibilitas dokumen');
                    return;
                }

                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="icofont-spinner icofont-spin me-2"></i>Mengupload...';

                // Create a FormData object
                const formData = new FormData(this);

                // Add the file list
                formData.append('temp_files', JSON.stringify(uploadedFiles));

                // For debugging - log form data content
                console.log('Submit FormData entries:');
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }

                // Send the form to the server
                fetch("{{ route('program-kerja.files.store-from-temp', ['kode_ormawa' => $kode_ormawa, 'id' => $id]) }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Form submit response:', data);

                        if (data.status === 'success') {
                            alert('File berhasil diupload!');
                            window.location.href =
                                "{{ route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $id]) }}";
                        } else {
                            alert('Error: ' + data.message);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengupload file');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
            });
        });
    </script>

@endsection
