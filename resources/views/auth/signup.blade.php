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
                            <form class="row g-3 p-0 p-4" method="POST" action="{{ route('post-regist') }}">
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
                                    </div>
                                    <button type="button" class="btn btn-primary mt-3 next-step">Next</button>
                                </div>

                                <!-- Step 2 -->
                                <div class="step d-none" id="step-2">
                                    <h5 class="mt-4">Step 2: Buat Password</h5>
                                    <div class="row">
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
                                <p>Sudah memiliki akun? <a href="{{ route('login') }}" class="text-light fw-bold">Login di
                                        sini</a></p>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Row -->

            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;

        document.querySelectorAll(".next-step").forEach(button => {
            button.addEventListener("click", function() {
                if (validateStep(currentStep)) {
                    // Khusus Step 2: Validasi Password dan Confirm Password
                    if (currentStep === 2) {
                        let password = document.querySelector("input[name='password']").value;
                        let confirmPassword = document.querySelector("input[name='password_confirmation']")
                            .value;

                        if (password !== confirmPassword) {
                            alert("Password dan Konfirmasi Password harus sama!");
                            return; // Hentikan proses jika tidak sama
                        }
                    }

                    document.getElementById("step-" + currentStep).classList.add("d-none");
                    currentStep++;
                    document.getElementById("step-" + currentStep).classList.remove("d-none");
                    updateProgressBar();
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
            document.querySelectorAll("#step-" + step + " input, #step-" + step + " select").forEach(input => {
                if (!input.value) {
                    isValid = false;
                    input.classList.add("is-invalid");
                } else {
                    input.classList.remove("is-invalid");
                }
            });

            if (step === 2) {
                let password = document.querySelector("input[name='password']").value;
                let confirmPassword = document.querySelector("input[name='password_confirmation']").value;
                if (password !== confirmPassword) {
                    alert("Password dan Konfirmasi Password harus sama!");
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
    </script>
@endsection
