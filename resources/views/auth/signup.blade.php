@extends('layouts.login')

@section('title', __('Sign Up'))


@section('content')
    <!-- main body area -->
    <div class="main p-2 py-3 p-xl-5">
        <!-- Body: Body -->
        <div class="body d-flex p-0 p-xl-5">
            <div class="container-xxl">

                <div class="row g-0">
                    <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
                        <div style="max-width: 25rem;">
                            <div class="text-center mb-5">
                                <svg width="4rem" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                    <path
                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                    <path
                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                </svg>
                            </div>
                            <div class="mb-5">
                                <h2 class="color-900 text-center">My-Task Let's Management Better</h2>
                            </div>
                            <!-- Image block -->
                            <div class="">
                                <img src="{{ url('/') . '/images/login-img.svg' }}" alt="online-study">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                        <div class="w-100 p-4 p-md-5 card border-0 bg-dark text-light" style="max-width: 42rem;">
                            <h3 class="text-center">Form Pendaftaran</h3>

                            <!-- Progress Bar -->
                            <div class="progress mt-3">
                                <div class="progress-bar" role="progressbar" style="width: 33%;" id="progress-bar">Step 1
                                </div>
                            </div>

                            <!-- Form -->
                            <form class="row g-3 p-0 p-4" method="POST" action="{{ route('post-regist') }}"
                                enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                <!-- Step 1 -->
                                <div class="step" id="step-1">
                                    <h5 class="mt-4">Step 1: Informasi Pribadi</h5>
                                    <div class="row">
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Masukkan nama lengkap" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">NRP</label>
                                            <input type="text" name="nrp" class="form-control"
                                                placeholder="Masukkan NRP" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="contoh@email.com" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Jurusan</label>
                                            <input type="text" name="jurusan" class="form-control"
                                                placeholder="Masukkan jurusan" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">ID Line</label>
                                            <input type="text" name="id_line" class="form-control"
                                                placeholder="Masukkan ID Line" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Nomor HP</label>
                                            <input type="text" name="no_hp" class="form-control"
                                                placeholder="Masukkan nomor HP" required>
                                        </div>
                                        <div class="col-6 mt-2">
                                            <label class="form-label">Fakultas</label>
                                            <select class="form-select" id="registrasi-select-fakultas" name="fakultas"
                                                data-placeholder="Pilih Fakultas Anda" required>
                                                <option value="">Pilih Fakultas Anda
                                                </option>
                                                @foreach ($fakultas as $item)
                                                    <option value="{{ $item['nama_fakultas'] }}">
                                                        {{ $item['nama_fakultas'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary mt-3 next-step">Next</button>
                                </div>

                                <!-- Step 2 -->
                                <div class="step d-none" id="step-2">
                                    <h5 class="mt-4">Step 2: Buat Password</h5>
                                    <div class="row mb-4">
                                        <div class="col-6">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Minimal 8 karakter" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                placeholder="Ulangi password" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Upload CV</label>
                                        <div class="file-upload-container">
                                            <input type="file" id="cv-input" class="filepond" name="cv"
                                                data-max-file-size="10MB" data-max-files="5" required />
                                            <small class="text-muted d-block mt-2">Format yang didukung: PDF, DOC, DOCX,
                                                XLS,
                                                XLSX, PPT, PPTX, JPG, PNG (Maks. 10MB)</small>
                                        </div>
                                        @error('files')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Upload Portofolio</label>
                                        <div class="file-upload-container">
                                            <input type="file" id="porto-input" class="filepond" name="porto"
                                                multiple data-max-file-size="10MB" data-max-files="5" />
                                            <small class="text-muted d-block mt-2">Format yang didukung: PDF, DOC, DOCX,
                                                XLS,
                                                XLSX, PPT, PPTX, JPG, PNG (Maks. 10MB)</small>
                                        </div>
                                        @error('files')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="button" class="btn btn-secondary mt-3 prev-step">Previous</button>
                                    <button type="button" class="btn btn-primary mt-3 next-step">Next</button>
                                </div>

                                <!-- Step 3 -->
                                <div class="step d-none" id="step-3">
                                    <h5 class="mt-4">Step 3: Pilih Ormawa</h5>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">Pilihan Ormawa 1</label>
                                                <select name="pilihan_ormawa_1" id="ormawa1" class="form-select"
                                                    required>
                                                    <option value="" selected>Pilih Ormawa</option>
                                                    @foreach ($ormawas as $ormawa)
                                                        <option value="{{ $ormawa->kode }}">{{ $ormawa->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Pilihan Ormawa 2</label>
                                                <select name="pilihan_ormawa_2" id="ormawa2" class="form-select">
                                                    <option value="" selected>Pilih Ormawa</option>
                                                    @foreach ($ormawas as $ormawa)
                                                        <option value="{{ $ormawa->kode }}">{{ $ormawa->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Dropdown Divisi akan muncul di sini setelah memilih Ormawa -->
                                            <div id="divisi-container1" class="mt-3 col-6"></div>
                                            <div id="divisi-container2" class="mt-3 col-6"></div>
                                        </div>

                                        <!-- Dropdown yang akan diisi oleh JavaScript -->
                                        <select name="divisi_ormawa_1_1" id="divisi1_1"
                                            class="form-select d-none"></select>
                                        <select name="divisi_ormawa_1_2" id="divisi1_2"
                                            class="form-select d-none"></select>

                                        <select name="divisi_ormawa_2_1" id="divisi2_1"
                                            class="form-select d-none"></select>
                                        <select name="divisi_ormawa_2_2" id="divisi2_2"
                                            class="form-select d-none"></select>
                                    </div>

                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                        <label class="form-check-label" for="termsCheck">
                                            Saya menyetujui <a href="#" class="text-primary">Syarat & Ketentuan</a>
                                        </label>
                                    </div>

                                    <button type="button" class="btn btn-secondary mt-3 prev-step">Previous</button>
                                    <button type="submit" class="btn btn-success mt-3">Submit</button>
                                </div>
                            </form>

                            <!-- Tombol untuk kembali ke login -->
                            <div class="text-center mt-4">
                                <p>Sudah memiliki akun? <a href="{{ route('login') }}" class="text-light fw-bold">Login
                                        di
                                        sini</a></p>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Row -->

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="{{ asset('assets/filepond/filepond.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verifikasi elemen ada sebelum inisialisasi
            const cvInput = document.getElementById('cv-input');
            const portoInput = document.getElementById('porto-input');

            if (!cvInput || !portoInput) {
                console.error('Input file tidak ditemukan');
                return;
            }

            // Verifikasi FilePond tersedia
            if (typeof FilePond === 'undefined') {
                console.error('FilePond tidak tersedia. Periksa URL library.');
                return;
            }

            // Verifikasi plugin tersedia
            if (typeof FilePondPluginFileValidateType === 'undefined' ||
                typeof FilePondPluginFileValidateSize === 'undefined' ||
                typeof FilePondPluginImagePreview === 'undefined' ||
                typeof FilePondPluginFilePoster === 'undefined') {
                console.error('Plugin FilePond tidak tersedia.');
                return;
            }

            // Register FilePond plugins
            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize,
                FilePondPluginImagePreview,
                FilePondPluginFilePoster
            );

            // Simpan daftar file yang sudah diupload ke temporary storage
            window.uploadedCVFiles = [];
            window.uploadedPortoFiles = [];

            // Definisi route untuk upload dan delete
            const uploadRoute = '{{ route('upload.temp') }}'; // Sesuaikan dengan route Anda
            const deleteRoute = '{{ route('delete.temp') }}'; // Sesuaikan dengan route Anda

            // Konfigurasi dasar yang sama untuk kedua FilePond
            const commonConfig = {
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
                labelFileTypeNotAllowed: 'Format file tidak didukung',
                fileValidateTypeLabelExpectedTypes: 'File yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG',
                labelMaxFileSizeExceeded: 'File terlalu besar',
                labelMaxFileSize: 'Ukuran maksimal file adalah {filesize}',
            };

            // Fungsi pemrosesan file
            function processFile(file, fileType, uploadedFiles, load, error, progress) {
                console.log(`Processing ${fileType} file:`, file.name);

                // Periksa apakah CSRF token tersedia
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (!csrfToken) {
                    console.error(
                        'CSRF token tidak ditemukan! Tambahkan <meta name="csrf-token" content="{{ csrf_token() }}"> di head.'
                    );
                    error('CSRF token tidak tersedia');
                    return;
                }

                // Buat FormData untuk kirim file
                const formData = new FormData();
                formData.append('file', file, file.name);
                formData.append('file_type', fileType);
                formData.append('_token', csrfToken);

                // Buat XHR request
                const xhr = new XMLHttpRequest();

                xhr.upload.onprogress = (e) => {
                    progress(e.lengthComputable, e.loaded, e.total);
                };

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === 'success') {
                                uploadedFiles.push(response.temp_file);
                                console.log(`${fileType} uploaded:`, response.temp_file);
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
                xhr.open('POST', uploadRoute);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.send(formData);

                // Return abort function
                return {
                    abort: () => {
                        xhr.abort();
                    }
                };
            }

            // Fungsi revert file
            function revertFile(uniqueFileId, fileType, uploadedFiles, load, error) {
                console.log(`Reverting ${fileType} file:`, uniqueFileId);

                // Dapatkan CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                if (!csrfToken) {
                    error('CSRF token tidak tersedia');
                    return;
                }

                // Kirim request ke server untuk menghapus file
                fetch(deleteRoute, {
                        method: 'POST', // Gunakan POST dengan _method=DELETE
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            file_path: uniqueFileId,
                            file_type: fileType,
                            _method: 'DELETE'
                        })
                    })
                    .then(response => {
                        // Log response untuk debugging
                        console.log('Response status:', response.status);

                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(
                                    `Server responded with status: ${response.status}, message: ${text}`
                                    );
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Revert response:', data);

                        // Hapus dari daftar file yang sudah diupload
                        const index = uploadedFiles.findIndex(file => file === uniqueFileId);
                        if (index !== -1) {
                            uploadedFiles.splice(index, 1);
                            console.log(`${fileType} file removed:`, uniqueFileId);
                        }

                        load();
                    })
                    .catch(err => {
                        console.error('Error details:', err);
                        error(err.message);
                    });
            }

            // Konfigurasi untuk upload CV
            const cvPond = FilePond.create(cvInput, {
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
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort) =>
                        processFile(file, 'cv', uploadedCVFiles, load, error, progress),
                    revert: (uniqueFileId, load, error) =>
                        revertFile(uniqueFileId, 'cv', uploadedCVFiles, load, error)
                }
            });

            // Konfigurasi untuk upload Portofolio
            const portfolioPond = FilePond.create(portoInput, {
                ...commonConfig,
                allowMultiple: true,
                maxFiles: 5,
                labelIdle: 'Seret & lepas portofolio disini atau <span class="filepond--label-action">Pilih File</span>',
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort) =>
                        processFile(file, 'portfolio', uploadedPortoFiles, load, error, progress),
                    revert: (uniqueFileId, load, error) =>
                        revertFile(uniqueFileId, 'portfolio', uploadedPortoFiles, load, error)
                }
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                // Tambahkan data file ke form sebelum submit
                const cvFilesInput = document.createElement('input');
                cvFilesInput.type = 'hidden';
                cvFilesInput.name = 'cv_files';
                cvFilesInput.value = JSON.stringify(uploadedCVFiles);
                this.appendChild(cvFilesInput);

                const portoFilesInput = document.createElement('input');
                portoFilesInput.type = 'hidden';
                portoFilesInput.name = 'porto_files';
                portoFilesInput.value = JSON.stringify(uploadedPortoFiles);
                this.appendChild(portoFilesInput);

                // Validasi form sebelum submit
                if (document.querySelector('input[name="cv"]').required && uploadedCVFiles.length === 0) {
                    e.preventDefault();
                    alert('Silakan upload CV Anda');
                    return false;
                }
            });
        });

        let currentStep = 1;

        document.querySelectorAll(".next-step").forEach(button => {
            button.addEventListener("click", function() {
                console.log("Attempting to validate step", currentStep);

                try {
                    if (validateStep(currentStep)) {
                        console.log("Step", currentStep, "validated successfully");

                        // Khusus Step 2: Validasi Password dan Confirm Password
                        if (currentStep === 2) {
                            let password = document.querySelector("input[name='password']").value;
                            let confirmPassword = document.querySelector(
                                "input[name='password_confirmation']").value;

                            if (password !== confirmPassword) {
                                alert("Password dan Konfirmasi Password harus sama!");
                                return; // Hentikan proses jika tidak sama
                            }
                        }

                        document.getElementById("step-" + currentStep).classList.add("d-none");
                        currentStep++;
                        document.getElementById("step-" + currentStep).classList.remove("d-none");
                        updateProgressBar();
                        console.log("Moved to step", currentStep);
                    } else {
                        console.log("Validation failed for step", currentStep);
                    }
                } catch (error) {
                    console.error("Error in next-step handler:", error);
                }
            });
        });

        document.querySelectorAll(".prev-step").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("step-" + currentStep).classList.add("d-none");
                currentStep--;
                document.getElementById("step-" + currentStep).classList.remove("d-none");
                updateProgressBar();
            });
        });

        function updateProgressBar() {
            let progress = (currentStep / 3) * 100;
            document.getElementById("progress-bar").style.width = progress + "%";
            document.getElementById("progress-bar").textContent = "Step " + currentStep;
        }

        function validateStep(step) {
            let isValid = true;

            // Seleksi input dan select yang perlu divalidasi, kecuali FilePond input
            const inputs = document.querySelectorAll("#step-" + step + " input:not(.filepond), #step-" + step + " select");

            inputs.forEach(input => {
                // Lewati input yang tersembunyi atau input FilePond
                if (input.type === 'file' || input.classList.contains('filepond') ||
                    input.parentElement.classList.contains('filepond--root')) {
                    return;
                }

                // Lewati checkbox jika step bukan 3
                if (input.type === 'checkbox' && step !== 3) {
                    return;
                }

                // Validasi hanya jika input punya atribut required
                if (input.hasAttribute('required') && !input.value) {
                    isValid = false;
                    input.classList.add("is-invalid");
                } else {
                    input.classList.remove("is-invalid");
                }
            });

            // Khusus untuk step 2, validasi password
            if (step === 2) {
                let password = document.querySelector("input[name='password']").value;
                let confirmPassword = document.querySelector("input[name='password_confirmation']").value;

                if (password !== confirmPassword) {
                    alert("Password dan Konfirmasi Password harus sama!");
                    isValid = false;
                }

                // Validasi CV upload jika diperlukan
                if (document.querySelector('input[name="cv"]').hasAttribute('required') &&
                    window.uploadedCVFiles && window.uploadedCVFiles.length === 0) {
                    alert("Silakan upload CV Anda");
                    isValid = false;
                }
            }

            return isValid;
        }

        function fetchDivisi(ormawa, containerId, selectId1, selectId2) {
            let container = document.getElementById(containerId);
            let selectDivisi1 = document.getElementById(selectId1);
            let selectDivisi2 = document.getElementById(selectId2);

            container.innerHTML = ""; // Kosongkan kontainer sebelumnya
            selectDivisi1.innerHTML = `<option value="" selected>Pilih Divisi 1</option>`; // Reset dropdown
            selectDivisi2.innerHTML = `<option value="" selected>Pilih Divisi 2</option>`; // Reset dropdown

            if (ormawa) {
                fetch(`/auth/get-divisi/${encodeURIComponent(ormawa)}`) // Panggil route API Laravel
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Debugging

                        if (data.length > 0) {
                            // Buat dropdown untuk dua pilihan divisi
                            let divisiDropdownHtml = `
                        <label class="form-label mt-2">Pilih Divisi 1</label>
                        <select name="divisi_${containerId}_1" id="${selectId1}" class="form-select" required>
                    `;

                            let divisiDropdownHtml2 = `
                        <label class="form-label mt-2">Pilih Divisi 2</label>
                        <select name="divisi_${containerId}_2" id="${selectId2}" class="form-select">
                        <option value="">Tidak Memilih</option>
                    `;

                            data.forEach(divisi => {
                                divisiDropdownHtml += `<option value="${divisi.id}">${divisi.nama}</option>`;
                                divisiDropdownHtml2 += `<option value="${divisi.id}">${divisi.nama}</option>`;
                            });

                            divisiDropdownHtml += `</select>`;
                            divisiDropdownHtml2 += `</select>`;

                            container.innerHTML = divisiDropdownHtml + divisiDropdownHtml2;
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }
        }

        // Event listener untuk Pilihan Ormawa 1
        document.getElementById("ormawa1").addEventListener("change", function() {
            fetchDivisi(this.value, "divisi-container1", "divisi1_1", "divisi1_2");
        });

        // Event listener untuk Pilihan Ormawa 2
        document.getElementById("ormawa2").addEventListener("change", function() {
            fetchDivisi(this.value, "divisi-container2", "divisi2_1", "divisi2_2");
        });

        document.getElementById("registrasi-select-fakultas").addEventListener("change", function() {
            const selectedFakultas = this.value;
            const ormawa1Select = document.getElementById("ormawa1");
            const ormawa2Select = document.getElementById("ormawa2");

            console.log(selectedFakultas);

            if (selectedFakultas) {
                // Reset dropdown ormawa
                ormawa1Select.innerHTML = '<option value="" selected>Pilih Ormawa</option>';
                ormawa2Select.innerHTML = '<option value="" selected>Pilih Ormawa</option>';

                // Reset container divisi
                document.getElementById("divisi-container1").innerHTML = "";
                document.getElementById("divisi-container2").innerHTML = "";

                // Fetch ormawa berdasarkan fakultas
                fetch(`/auth/get-ormawa/${encodeURIComponent(selectedFakultas)}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        console.log("Ormawa filtered by fakultas:", data);

                        if (data.length > 0) {
                            // Tambahkan opsi ormawa ke dropdown
                            data.forEach(ormawa => {
                                // Tambahkan ke dropdown ormawa 1
                                const option1 = document.createElement("option");
                                option1.value = ormawa.kode;
                                option1.textContent = ormawa.nama;
                                ormawa1Select.appendChild(option1);

                                // Tambahkan ke dropdown ormawa 2
                                const option2 = document.createElement("option");
                                option2.value = ormawa.kode;
                                option2.textContent = ormawa.nama;
                                ormawa2Select.appendChild(option2);
                            });
                        } else {
                            // Jika tidak ada ormawa yang sesuai dengan fakultas
                            const noOption1 = document.createElement("option");
                            noOption1.value = "";
                            noOption1.textContent = "Tidak ada ormawa untuk fakultas ini";
                            noOption1.disabled = true;
                            ormawa1Select.appendChild(noOption1);

                            const noOption2 = document.createElement("option");
                            noOption2.value = "";
                            noOption2.textContent = "Tidak ada ormawa untuk fakultas ini";
                            noOption2.disabled = true;
                            ormawa2Select.appendChild(noOption2);
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching ormawa:", error);
                        alert("Terjadi kesalahan saat memuat data ormawa");
                    });
            } else {
                // Jika tidak ada fakultas yang dipilih, tampilkan semua ormawa
                // Kita perlu mengambil semua data ormawa dari server
                fetch('/auth/get-all-ormawa')
                    .then(response => response.json())
                    .then(data => {
                        ormawa1Select.innerHTML = '<option value="" selected>Pilih Ormawa</option>';
                        ormawa2Select.innerHTML = '<option value="" selected>Pilih Ormawa</option>';

                        data.forEach(ormawa => {
                            // Tambahkan ke dropdown ormawa 1
                            const option1 = document.createElement("option");
                            option1.value = ormawa.kode;
                            option1.textContent = ormawa.nama;
                            ormawa1Select.appendChild(option1);

                            // Tambahkan ke dropdown ormawa 2
                            const option2 = document.createElement("option");
                            option2.value = ormawa.kode;
                            option2.textContent = ormawa.nama;
                            ormawa2Select.appendChild(option2);
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching all ormawa:", error);
                    });
            }
        });
    </script>
@endsection
