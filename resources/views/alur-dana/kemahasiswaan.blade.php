@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container my-5">
        <h3 class="text-center fw-bold">Panduan Pengurusan Proposal/LPJ dengan Dana Kemahasiswaan</h3>
        <p class="text-center">Ikuti langkah-langkah berikut untuk mengelola proposal atau LPJ sesuai alur dana
            kemahasiswaan.</p>

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
                        <p>Ajukan proposal ke BEM FT untuk diaudit oleh BEM FT dan DPM FT.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-search"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">2. Audit Proposal</h6>
                        <p>Proposal diaudit oleh BEM FT dan DPM FT. Jika tidak ada revisi, lanjut ke langkah berikutnya.</p>
                        <ul>
                            <li><strong>Non-Revisi:</strong> Proposal langsung ditandatangani oleh Sekretaris, Ketua Acara,
                                dan Ketua KSM/KMM.</li>
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
                        <h6 class="fw-bold">3. Tanda Tangan Pimpinan DPM FT</h6>
                        <p>Setelah disetujui, proposal ditandatangani oleh Pimpinan DPM FT dan dikembalikan ke ORMAWA.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">4. Tanda Tangan Gubernur FT</h6>
                        <p>Proposal ditandatangani oleh Gubernur FT dan dikembalikan ke ORMAWA.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-cash"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">5. Pengajuan BS ke AD BEM FT</h6>
                        <p>ORMAWA mengajukan BS (Bon Sementara) ke AD BEM FT.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-archive"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">6. Arsip</h6>
                        <p>Proposal disimpan di Arsip DPM FT dan Arsip BEM FT untuk catatan dokumen.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">7. Dana Ditandatangani oleh Gubernur FT</h6>
                        <p>BS ditandatangani oleh Gubernur FT sebelum disetujui oleh Wakil Dekan.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-bank"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">8. Transfer Dana</h6>
                        <p>Setelah proses selesai, dana ditransfer ke rekening Bendahara Acara.</p>
                    </div>
                </div>
                <div class="timeline-item d-flex align-items-start mb-4">
                    <div class="timeline-icon bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold">9. Selesai</h6>
                        <p>Proses pengurusan dana kemahasiswaan selesai.</p>
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
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
@endsection
