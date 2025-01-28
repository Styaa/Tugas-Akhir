@extends('layouts.app')

@section('title', __('Alur Dana Kemahasiswaan'))

@section('content')
    <div class="container my-5">
        @php
            $sumberDana = json_decode($programKerja->anggaran_dana, true);
        @endphp
        @if (in_array('Dana Kemahasiswaan', $sumberDana))
            <h3 class="text-center fw-bold">Panduan Pengurusan Proposal/LPJ dengan Dana Kemahasiswaan</h3>
            <p class="text-center">Ikuti langkah-langkah berikut untuk mengelola proposal atau LPJ sesuai alur dana
                kemahasiswaan.</p>

            <!-- Step-by-Step Alur -->
            <div class="mt-5">
                <h5 class="fw-bold">Step-by-Step Alur</h5>
                <div class="timeline">

                    <!-- Step 1: Membuat Proposal -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">1. Membuat Proposal</h6>
                            <p>Buat proposal kegiatan yang akan diajukan untuk mendapatkan dana.</p>
                            <span class="badge bg-warning">Sedang Dikerjakan</span>
                            <br>
                            <a href="{{ route('program-kerja.proposal.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                class="btn btn-primary btn-sm mt-2">Buat Proposal</a>
                        </div>
                    </div>

                    <!-- Step 2: Mengajukan Proposal -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-send"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">2. Mengajukan Proposal</h6>
                            <p>Ajukan proposal ke BEM FT untuk diaudit oleh BEM FT dan DPM FT.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                            <br>
                            @php
                                $emailTujuan = 'adbemft@gmail.com,auditdpmft@gmail.com';
                                $subject = "Proposal_{$kode_ormawa}_{$programKerja->nama}";
                                $bodyLines = [
                                    'Yth. Tim Audit BEM FT & DPM FT,',
                                    'Fakultas Teknik - Universitas Surabaya',
                                    '',
                                    'Dengan hormat,',
                                    "Saya {$user->name} ({$user->nrp}) dari {$kode_ormawa}, mengajukan permohonan audit untuk proposal {$programKerja->nama} yang terlampir. Kami berharap dapat menerima masukan dan saran agar proposal ini sesuai dengan ketentuan yang berlaku.",
                                    '',
                                    'Mohon konfirmasi jika ada hal yang perlu kami lengkapi.
                                Terima kasih atas waktu dan bantuannya.',
                                    '',
                                    'Hormat kami,',
                                    "{$user->name}",
                                ];

                                $body = implode("\n", $bodyLines); // Gabungkan array dengan newline

                                $mailtoLink =
                                    "mailto:{$emailTujuan}?subject=" .
                                    rawurlencode($subject) .
                                    '&body=' .
                                    rawurlencode($body);
                            @endphp
                            <a href="{{ $mailtoLink }}" class="btn btn-primary btn-sm mt-2">Ajukan Proposal</a>
                        </div>
                    </div>

                    <!-- Step 3: Audit Proposal -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-search"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">3. Audit Proposal</h6>
                            <p>Proposal diaudit oleh BEM FT dan DPM FT. Jika tidak ada revisi, lanjut ke langkah berikutnya.
                            </p>
                            <ul>
                                <li><strong>Non-Revisi:</strong> Proposal langsung ditandatangani oleh Sekretaris, Ketua
                                    Acara,
                                    dan Ketua KSM/KMM.</li>
                                <li><strong>Revisi:</strong> Proposal dikembalikan untuk diperbaiki dan diaudit ulang.</li>
                            </ul>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 4: Tanda Tangan Pimpinan DPM FT -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-pen"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">4. Tanda Tangan Pimpinan DPM FT</h6>
                            <p>Setelah disetujui, proposal ditandatangani oleh Pimpinan DPM FT dan dikembalikan ke ORMAWA.
                            </p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 5: Tanda Tangan Gubernur FT -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">5. Tanda Tangan Gubernur FT</h6>
                            <p>Proposal ditandatangani oleh Gubernur FT dan dikembalikan ke ORMAWA.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 6: Pengajuan BS ke AD BEM FT -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-cash"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">6. Pengajuan BS ke AD BEM FT</h6>
                            <p>ORMAWA mengajukan BS (Bon Sementara) ke AD BEM FT.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 7: Arsip -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-archive"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">7. Arsip</h6>
                            <p>Proposal disimpan di Arsip DPM FT dan Arsip BEM FT untuk catatan dokumen.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 8: Transfer Dana -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-bank"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">8. Transfer Dana</h6>
                            <p>Setelah proses selesai, dana ditransfer ke rekening Bendahara Acara.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Gambar Alur -->
            <div class="mt-5 text-center">
                <h5 class="fw-bold">Visualisasi Alur Dana Kemahasiswaan</h5>
                <img src="{{ asset('images/alur_dana_kemahasiswaan.png') }}" alt="Alur Dana Kemahasiswaan"
                    class="img-fluid mt-3">
            </div>
        @else
            <h3 class="text-center fw-bold">Panduan Pengurusan Proposal/LPJ dengan Dana Jurusan</h3>
            <p class="text-center">Ikuti langkah-langkah berikut untuk mengelola proposal atau LPJ sesuai alur dana jurusan.
            </p>

            <!-- Step-by-Step Alur -->
            <div class="mt-5">
                <h5 class="fw-bold">Step-by-Step Alur</h5>
                <div class="timeline">

                    <!-- Step 1: Membuat Proposal -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">1. Membuat Proposal</h6>
                            <p>Buat proposal kegiatan yang akan diajukan untuk mendapatkan dana.</p>
                            <span class="badge bg-warning">Sedang Dikerjakan</span>
                            <br>
                            <a href="{{ route('program-kerja.proposal.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                class="btn btn-primary btn-sm mt-2">Buat Proposal</a>
                        </div>
                    </div>

                    <!-- Step 2: Audit oleh AD BEM FT & DPM FT -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-search"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">2. Audit Proposal</h6>
                            <p>Proposal diaudit oleh AD BEM FT. Jika tidak ada revisi, lanjut ke langkah
                                berikutnya.</p>
                            <ul>
                                <li><strong>Non-Revisi:</strong> Proposal langsung diteruskan ke Sekretaris dan Ketua Acara.
                                </li>
                                <li><strong>Revisi:</strong> Proposal dikembalikan untuk diperbaiki dan diaudit ulang.</li>
                            </ul>
                            <span class="badge bg-secondary">Belum Mulai</span>
                            <br>
                            @php
                                $emailTujuan = 'adbemft@gmail.com';
                                $subject = "Proposal_{$kode_ormawa}_{$programKerja->nama}";
                                $bodyLines = [
                                    'Yth. Tim Audit BEM FT,',
                                    'Fakultas Teknik - Universitas Surabaya',
                                    '',
                                    'Dengan hormat,',
                                    "Saya {$user->name} ({$user->nrp}) dari {$kode_ormawa}, mengajukan permohonan audit untuk proposal {$programKerja->nama} yang terlampir. Kami berharap dapat menerima masukan dan saran agar proposal ini sesuai dengan ketentuan yang berlaku.",
                                    '',
                                    'Mohon konfirmasi jika ada hal yang perlu kami lengkapi.
                                    Terima kasih atas waktu dan bantuannya.',
                                    '',
                                    'Hormat kami,',
                                    "{$user->name}",
                                ];

                                $body = implode("\n", $bodyLines); // Gabungkan array dengan newline

                                $mailtoLink =
                                    "mailto:{$emailTujuan}?subject=" .
                                    rawurlencode($subject) .
                                    '&body=' .
                                    rawurlencode($body);
                            @endphp
                            <a href="{{ $mailtoLink }}" class="btn btn-primary btn-sm mt-2">Ajukan Audit Proposal</a>
                        </div>
                    </div>

                    <!-- Step 3: Tanda Tangan Sekretaris dan Ketua Acara -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-pen"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">3. Tanda Tangan Sekretaris dan Ketua Acara</h6>
                            <p>Proposal ditandatangani oleh Sekretaris dan Ketua Acara sebelum diajukan ke Ketua KSM/KMM.
                            </p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 4: Tanda Tangan Ketua KSM/KMM -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">4. Tanda Tangan Ketua KSM/KMM</h6>
                            <p>Proposal disetujui dan ditandatangani oleh Ketua KSM/KMM sebelum diajukan ke Gubernur FT.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 5: Tanda Tangan Gubernur FT -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">5. Tanda Tangan Gubernur FT</h6>
                            <p>Proposal disetujui oleh Gubernur FT sebelum dikembalikan ke ORMAWA.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 6: Tanda Tangan Ketua Jurusan -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">6. Tanda Tangan Ketua Jurusan</h6>
                            <p>Proposal disetujui oleh Ketua Jurusan sebelum diajukan ke Wakil Dekan.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 7: Tanda Tangan Wakil Dekan -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-award"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">7. Tanda Tangan Wakil Dekan</h6>
                            <p>Proposal diperiksa oleh Wakil Dekan sebelum dikembalikan ke ORMAWA.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 8: Arsip BEM FT -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-archive"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">8. Arsip BEM FT</h6>
                            <p>Proposal disimpan di Arsip BEM FT sebagai dokumen resmi.</p>
                            <span class="badge bg-secondary">Belum Mulai</span>
                        </div>
                    </div>

                    <!-- Step 9: Selesai -->
                    <div class="timeline-item d-flex align-items-start mb-4">
                        <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                            style="width: 30px; height: 30px;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold">9. Selesai</h6>
                            <p>Proses pengurusan dana jurusan selesai.</p>
                            <span class="badge bg-success">Selesai</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Gambar Alur -->
            <div class="mt-5 text-center">
                <h5 class="fw-bold">Visualisasi Alur Dana Jurusan</h5>
                <img src="{{ asset('images/alur_dana_jurusan.png') }}" alt="Alur Dana Jurusan" class="img-fluid mt-3">
            </div>
        @endif
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
@endsection
