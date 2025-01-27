@extends('layouts.app')

@section('title', __('Alur Dana Jurusan'))

@section('content')
    <div class="container my-5">
        <h3 class="text-center fw-bold">Panduan Pengurusan Proposal dengan Dana Jurusan</h3>
        <p class="text-center">Ikuti langkah-langkah berikut untuk mengelola proposal sesuai alur dana jurusan.</p>

        <!-- Step-by-Step Alur -->
        <div class="mt-5">
            <h5 class="fw-bold">Step-by-Step Alur</h5>
            <div class="timeline">
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">1. Mengajukan Proposal</h6>
                        <p>Ajukan proposal untuk diaudit oleh AD BEM FT dan DPM FT.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-search"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">2. Audit Proposal</h6>
                        <p>Proposal diaudit oleh AD BEM FT dan DPM FT.</p>
                        <ul>
                            <li><strong>Non-Revisi:</strong> Lanjut ke tanda tangan Sekretaris dan Ketua Acara.</li>
                            <li><strong>Revisi:</strong> Proposal dikembalikan untuk diperbaiki dan diaudit ulang.</li>
                        </ul>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-pen"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">3. Tanda Tangan Sekretaris dan Ketua Acara</h6>
                        <p>Proposal ditandatangani oleh Sekretaris dan Ketua Acara sebelum dilanjutkan ke Ketua KSM/KMM.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">4. Tanda Tangan Ketua KSM/KMM</h6>
                        <p>Proposal ditandatangani oleh Ketua KSM/KMM dan diteruskan ke Gubernur FT.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">5. Tanda Tangan Gubernur FT</h6>
                        <p>Proposal ditandatangani oleh Gubernur FT sebelum diteruskan ke Wakil Dekan.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">6. Tanda Tangan Wakil Dekan</h6>
                        <p>Proposal ditandatangani oleh Wakil Dekan dan dikembalikan ke ORMAWA.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">7. Arsip</h6>
                        <p>Proposal disimpan di Arsip BEM FT sebagai catatan dokumen.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">8. Selesai</h6>
                        <p>Proses pengurusan proposal selesai.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gambar Alur -->
        <div class="mt-5 text-center">
            <h5 class="fw-bold">Visualisasi Alur Dana Jurusan</h5>
            <img src="{{ asset('images/alur_dana_jurusan.png') }}" alt="Alur Dana Jurusan" class="img-fluid mt-3">
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
@endsection
