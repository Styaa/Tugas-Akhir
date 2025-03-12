@extends('layouts.app')

@section('title', __('Alur Dana Kemahasiswaan'))

@section('content')
    <div class="container my-5">
        @php
            $sumberDana = json_decode($programKerja->anggaran_dana, true);
            $isDanaKemahasiswaan = in_array('Dana Kemahasiswaan', $sumberDana);

            // Menghitung progres
            $totalSteps = $isDanaKemahasiswaan ? 8 : 9;
            $completedSteps = 0;
            $inProgressSteps = 1; // Asumsi langkah 1 sedang dikerjakan
            $progressPercentage = ($completedSteps / $totalSteps) * 100;
        @endphp

        <!-- Header section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <h3 class="fw-bold">
                            Panduan Pengurusan Proposal/LPJ dengan
                            <span
                                class="text-primary">{{ $isDanaKemahasiswaan ? 'Dana Kemahasiswaan' : 'Dana Jurusan' }}</span>
                        </h3>
                        <p class="text-muted">Ikuti langkah-langkah berikut untuk mengelola proposal atau LPJ sesuai alur
                            dana.</p>

                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Program Kerja
                            </a>
                            <a href="{{ route('program-kerja.proposal.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                class="btn btn-primary">
                                <i class="bi bi-file-earmark-text me-1"></i> Buat Proposal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress tracker -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="progress-tracker">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 fw-bold">Progress Pengurusan</h6>
                        <span class="badge bg-primary">{{ number_format($progressPercentage, 0) }}% Selesai</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ ($completedSteps / $totalSteps) * 100 }}%;"
                            aria-valuenow="{{ $completedSteps }}" aria-valuemin="0" aria-valuemax="{{ $totalSteps }}">
                        </div>
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ ($inProgressSteps / $totalSteps) * 100 }}%;"
                            aria-valuenow="{{ $inProgressSteps }}" aria-valuemin="0" aria-valuemax="{{ $totalSteps }}">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2 small text-muted">
                        <span>{{ $completedSteps }} langkah selesai</span>
                        <span>{{ $inProgressSteps }} sedang dikerjakan</span>
                        <span>{{ $totalSteps - $completedSteps - $inProgressSteps }} belum dimulai</span>
                    </div>
                </div>
            </div>
        </div>

        @if ($isDanaKemahasiswaan)
            <!-- Step-by-Step Alur Dana Kemahasiswaan -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="fw-bold mb-0">Langkah-Langkah Alur Dana Kemahasiswaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <!-- Step 1: Membuat Proposal -->
                                <div class="timeline-item step-in-progress">
                                    <div
                                        class="timeline-icon bg-warning text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-pencil-square"></i>
                                    </div>
                                    <div class="card timeline-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold">1. Membuat Proposal</h6>
                                                <span class="badge bg-warning">Sedang Dikerjakan</span>
                                            </div>
                                            <p class="text-muted">Buat proposal kegiatan yang akan diajukan untuk
                                                mendapatkan dana.</p>
                                            <a href="{{ route('program-kerja.proposal.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                                class="btn btn-primary btn-sm">Buat Proposal</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2: Mengajukan Proposal -->
                                <div class="timeline-item step-not-started">
                                    <div
                                        class="timeline-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-send"></i>
                                    </div>
                                    <div class="card timeline-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold">2. Mengajukan Proposal</h6>
                                                <span class="badge bg-secondary">Belum Mulai</span>
                                            </div>
                                            <p class="text-muted">Ajukan proposal ke BEM FT untuk diaudit oleh BEM FT dan
                                                DPM FT.</p>
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
                                                    'Mohon konfirmasi jika ada hal yang perlu kami lengkapi. Terima kasih atas waktu dan bantuannya.',
                                                    '',
                                                    'Hormat kami,',
                                                    "{$user->name}",
                                                ];

                                                $body = implode("\n", $bodyLines);
                                                $mailtoLink =
                                                    "mailto:{$emailTujuan}?subject=" .
                                                    rawurlencode($subject) .
                                                    '&body=' .
                                                    rawurlencode($body);
                                            @endphp
                                            <a href="{{ $mailtoLink }}" class="btn btn-primary btn-sm">Ajukan
                                                Proposal</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Audit Proposal -->
                                <div class="timeline-item step-not-started">
                                    <div
                                        class="timeline-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <div class="card timeline-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold">3. Audit Proposal</h6>
                                                <span class="badge bg-secondary">Belum Mulai</span>
                                            </div>
                                            <p class="text-muted">Proposal diaudit oleh BEM FT dan DPM FT. Jika tidak ada
                                                revisi, lanjut ke langkah berikutnya.</p>
                                            <div class="alert alert-light border mt-2 mb-0">
                                                <ul class="mb-0 ps-3">
                                                    <li><strong>Non-Revisi:</strong> Proposal langsung ditandatangani oleh
                                                        Sekretaris, Ketua Acara, dan Ketua KSM/KMM.</li>
                                                    <li><strong>Revisi:</strong> Proposal dikembalikan untuk diperbaiki dan
                                                        diaudit ulang.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4-8: Langkah Lainnya -->
                                <!-- Langkah 4 -->
                                <div class="timeline-item step-not-started">
                                    <div
                                        class="timeline-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-pen"></i>
                                    </div>
                                    <div class="card timeline-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold">4. Tanda Tangan Pimpinan DPM FT</h6>
                                                <span class="badge bg-secondary">Belum Mulai</span>
                                            </div>
                                            <p class="text-muted">Setelah disetujui, proposal ditandatangani oleh Pimpinan
                                                DPM FT dan dikembalikan ke ORMAWA.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Langkah 5 -->
                                <div class="timeline-item step-not-started">
                                    <div
                                        class="timeline-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                    <div class="card timeline-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold">5. Tanda Tangan Gubernur FT</h6>
                                                <span class="badge bg-secondary">Belum Mulai</span>
                                            </div>
                                            <p class="text-muted">Proposal ditandatangani oleh Gubernur FT dan dikembalikan
                                                ke ORMAWA.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Langkah 6 -->
                                <div class="timeline-item step-not-started">
                                    <div
                                        class="timeline-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cash"></i>
                                    </div>
                                    <div class="card timeline-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold">6. Pengajuan BS ke AD BEM FT</h6>
                                                <span class="badge bg-secondary">Belum Mulai</span>
                                            </div>
                                            <p class="text-muted">ORMAWA mengajukan BS (Bon Sementara) ke AD BEM FT.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Langkah 7 -->
                                <div class="timeline-item step-not-started">
                                    <div
                                        class="timeline-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-archive"></i>
                                    </div>
                                    <div class="card timeline-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold">7. Arsip</h6>
                                                <span class="badge bg-secondary">Belum Mulai</span>
                                            </div>
                                            <p class="text-muted">Proposal disimpan di Arsip DPM FT dan Arsip BEM FT untuk
                                                catatan dokumen.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Langkah 8 -->
                                <div class="timeline-item step-not-started">
                                    <div
                                        class="timeline-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-bank"></i>
                                    </div>
                                    <div class="card timeline-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="fw-bold">8. Transfer Dana</h6>
                                                <span class="badge bg-secondary">Belum Mulai</span>
                                            </div>
                                            <p class="text-muted">Setelah proses selesai, dana ditransfer ke rekening
                                                Bendahara Acara.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visualisasi Alur -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent">
                            <h5 class="fw-bold mb-0">Visualisasi Alur Dana Jurusan</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('images/alur_dana_jurusan.png') }}" alt="Alur Dana Jurusan"
                                class="img-fluid alur-image">
                            <a href="{{ asset('images/alur_dana_jurusan.png') }}" class="btn btn-outline-primary mt-3"
                                target="_blank">
                                <i class="bi bi-arrows-fullscreen me-1"></i> Lihat Gambar Penuh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Tips & FAQ Section -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="fw-bold mb-0">Tips Pengurusan Dana</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3"
                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-lightbulb"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Persiapkan dokumen dengan lengkap</h6>
                                <p class="mb-0 text-muted">Pastikan proposal, RAB, dan semua dokumen pendukung sudah
                                    dipersiapkan sebelum memulai proses pengurusan.</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3"
                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Alokasikan waktu yang cukup</h6>
                                <p class="mb-0 text-muted">Proses pengurusan dana bisa memakan waktu 1-2 minggu, rencanakan
                                    kegiatan dengan memperhitungkan waktu pengurusan.</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-2 me-3"
                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold">Jaga komunikasi</h6>
                                <p class="mb-0 text-muted">Pertahankan komunikasi yang baik dengan pihak terkait untuk
                                    memperlancar proses pengurusan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="fw-bold mb-0">FAQ</h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item border-0 mb-2">
                                <h2 class="accordion-header" id="faqOne">
                                    <button class="accordion-button collapsed shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        Berapa lama proses pengurusan dana?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="faqOne"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Proses pengurusan dana biasanya memakan waktu sekitar 1-2 minggu, tergantung
                                        kesiapan dokumen dan ketersediaan pihak yang perlu menandatangani dokumen.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-2">
                                <h2 class="accordion-header" id="faqTwo">
                                    <button class="accordion-button collapsed shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Apa yang harus dilakukan jika proposal ditolak?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Jika proposal ditolak, perbaiki sesuai masukan dari auditor, kemudian ajukan
                                        kembali. Pastikan semua ketentuan dan syarat terpenuhi pada revisi.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0">
                                <h2 class="accordion-header" id="faqThree">
                                    <button class="accordion-button collapsed shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Bagaimana cara memperbarui status proposal?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted">
                                        Status proposal akan diperbarui oleh sistem setelah ada konfirmasi dari pihak
                                        terkait. Jika perlu memperbarui status secara manual, hubungi administrator sistem.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animations for timeline items
            const timelineItems = document.querySelectorAll('.timeline-item');

            timelineItems.forEach((item, index) => {
                // Add a slight delay for each item to create a cascading effect
                setTimeout(() => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        item.style.transition = 'all 0.3s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 50);
            });

            // Initialize tooltips if Bootstrap 5 is used
            if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });
    </script>
@endsection
