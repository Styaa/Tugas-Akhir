@extends('layouts.app')

@section('title', __('Alur Dana Kemahasiswaan'))

@section('content')
    <div class="container my-5">
        <!-- Header section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <h3 class="fw-bold">
                            Panduan Pengurusan Laporan Pertanggungjawaban dengan
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
                            <a href="{{ route('program-kerja.lpj.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id, 'dokumenId' => $dokumenId]) }}"
                                class="btn btn-primary">
                                <i class="bi bi-file-earmark-text me-1"></i> Buat LPJ
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
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Langkah-Langkah Alur Dana Kemahasiswaan</h5>
                            <button class="btn btn-outline-primary btn-sm" id="saveProgressBtn">
                                <i class="bi bi-save me-1"></i> Simpan Progress
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @foreach ($steps as $step)
                                    @php
                                        $stepProgress = $progress[$step['step_number']] ?? null;
                                        $status = $stepProgress['status'] ?? 'belum_mulai';
                                        $isCompleted = $status === 'selesai';
                                        $isInProgress = $status === 'sedang_dikerjakan';
                                        $isNotStarted = $status === 'belum_mulai';
                                        $dokumenId = $stepProgress['dokumen_id'] ?? null;
                                        $catatan = $stepProgress['catatan'] ?? null;

                                        $statusClass = $isCompleted
                                            ? 'step-completed'
                                            : ($isInProgress
                                                ? 'step-in-progress'
                                                : 'step-not-started');
                                        $iconClass = $isCompleted
                                            ? 'bg-success'
                                            : ($isInProgress
                                                ? 'bg-warning'
                                                : 'bg-secondary');
                                        $badgeClass = $isCompleted
                                            ? 'bg-success'
                                            : ($isInProgress
                                                ? 'bg-warning'
                                                : 'bg-secondary');
                                        $badgeText = $isCompleted
                                            ? 'Selesai'
                                            : ($isInProgress
                                                ? 'Sedang Dikerjakan'
                                                : 'Belum Mulai');

                                        // Checkbox hanya enabled untuk langkah yang sedang dikerjakan
                                        $checkboxEnabled = $isInProgress;

                                        // Jika langkah 1, selalu enabled untuk memulai
                                        if ($step['step_number'] === 1 && $isNotStarted) {
                                            $checkboxEnabled = true;
                                        }
                                    @endphp

                                    <div class="timeline-item {{ $statusClass }}" id="step-{{ $step['step_number'] }}">
                                        <div
                                            class="timeline-icon {{ $iconClass }} text-white d-flex align-items-center justify-content-center">
                                            <i class="bi {{ $step['icon'] }}"></i>
                                        </div>
                                        <div class="card timeline-card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="fw-bold">{{ $step['step_number'] }}. {{ $step['nama'] }}
                                                    </h6>
                                                    <div>
                                                        <span
                                                            class="step-loading spinner-border spinner-border-sm text-primary me-2"
                                                            role="status" style="display: none;">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </span>
                                                        <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                                    </div>
                                                </div>
                                                <p class="text-muted">{{ $step['deskripsi'] }}</p>

                                                @if ($step['step_number'] === 1)
                                                    <div class="mb-3">
                                                        <a href="{{ route('program-kerja.proposal.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id, 'dokumenId' => $dokumenId]) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="bi bi-pencil-square me-1"></i> Buat Proposal
                                                        </a>
                                                    </div>
                                                @endif

                                                @if ($step['step_number'] === 2)
                                                    <div class="mb-3">
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
                                                        <a href="{{ $mailtoLink }}" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-send me-1"></i> Ajukan Proposal
                                                        </a>
                                                    </div>
                                                @endif

                                                @if ($step['step_number'] === 3)
                                                    <div class="alert alert-light border mt-2 mb-3">
                                                        <ul class="mb-0 ps-3">
                                                            <li><strong>Non-Revisi:</strong> Proposal langsung
                                                                ditandatangani oleh Sekretaris, Ketua Acara, dan Ketua
                                                                KSM/KMM.</li>
                                                            <li><strong>Revisi:</strong> Proposal dikembalikan untuk
                                                                diperbaiki dan diaudit ulang.</li>
                                                        </ul>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input audit-option" type="radio"
                                                                name="auditResult" id="nonRevisiOption" value="non-revisi"
                                                                {{ $isInProgress ? '' : 'disabled' }}
                                                                {{ $catatan === 'non-revisi' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="nonRevisiOption">Non-Revisi</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input audit-option" type="radio"
                                                                name="auditResult" id="revisiOption" value="revisi"
                                                                {{ $isInProgress ? '' : 'disabled' }}
                                                                {{ $catatan === 'revisi' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="revisiOption">Revisi</label>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($step['requires_upload'])
                                                    <div class="mb-3">
                                                        @if ($dokumenId)
                                                            <button class="btn btn-outline-success btn-sm" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#dokumenInfo{{ $step['step_number'] }}"
                                                                aria-expanded="false">
                                                                <i class="bi bi-file-earmark-check me-1"></i> Lihat Bukti
                                                                Terunggah
                                                            </button>

                                                            <div class="collapse mt-2"
                                                                id="dokumenInfo{{ $step['step_number'] }}">
                                                                <div class="card card-body">
                                                                    <p class="mb-1"><strong>Dokumen ID:</strong>
                                                                        {{ $dokumenId }}</p>
                                                                    <p class="mb-1"><strong>Status:</strong>
                                                                        {{ $badgeText }}</p>
                                                                    <p class="mb-1"><strong>Catatan:</strong>
                                                                        {{ $catatan ?: 'Tidak ada catatan' }}</p>
                                                                    @if (isset($stepProgress['completed_at']))
                                                                        <p class="mb-1"><strong>Tanggal:</strong>
                                                                            {{ date('d M Y H:i', strtotime($stepProgress['completed_at'])) }}
                                                                        </p>
                                                                    @endif
                                                                    <a href="#" class="btn btn-sm btn-primary mt-2"
                                                                        target="_blank">
                                                                        <i class="bi bi-download me-1"></i> Unduh Dokumen
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm upload-doc-btn"
                                                                data-step="{{ $step['step_number'] }}"
                                                                data-bs-toggle="modal" data-bs-target="#uploadDocModal"
                                                                {{ $isInProgress ? '' : 'disabled' }}>
                                                                <i class="bi bi-upload me-1"></i> Upload Bukti
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif

                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    @if ($catatan && $step['step_number'] !== 3)
                                                        <div class="small text-muted">
                                                            <i class="bi bi-info-circle me-1"></i> {{ $catatan }}
                                                        </div>
                                                    @else
                                                        <div class="step-notes-container">
                                                            @if ($isInProgress)
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="step{{ $step['step_number'] }}Notes"
                                                                    placeholder="Catatan (opsional)"
                                                                    value="{{ $catatan }}">
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div class="form-check">
                                                        <input class="form-check-input step-checkbox" type="checkbox"
                                                            id="step{{ $step['step_number'] }}Checkbox"
                                                            data-step="{{ $step['step_number'] }}"
                                                            {{ $isCompleted ? 'checked' : '' }}
                                                            {{ $checkboxEnabled ? '' : 'disabled' }}>
                                                        <label class="form-check-label"
                                                            for="step{{ $step['step_number'] }}Checkbox">
                                                            Tandai Selesai
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                            <h5 class="fw-bold mb-0">Visualisasi Alur Dana</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="alur-visualization">
                                <div class="row">
                                    @foreach ($steps as $step)
                                        @php
                                            $stepProgress = $progress[$step['step_number']] ?? null;
                                            $status = $stepProgress['status'] ?? 'belum_mulai';
                                            $isCompleted = $status === 'selesai';
                                            $isInProgress = $status === 'sedang_dikerjakan';

                                            $stepClass = $isCompleted
                                                ? 'bg-success'
                                                : ($isInProgress
                                                    ? 'bg-warning'
                                                    : 'bg-secondary');
                                        @endphp
                                        <div class="col-md-3 mb-3">
                                            <div class="card h-100 alur-step-card {{ $stepClass }} text-white">
                                                <div class="card-body text-center">
                                                    <div class="step-number">{{ $step['step_number'] }}</div>
                                                    <div class="step-icon mb-2">
                                                        <i class="bi {{ $step['icon'] }} fs-3"></i>
                                                    </div>
                                                    <h6 class="card-title">{{ $step['nama'] }}</h6>
                                                    <div class="step-status">
                                                        @if ($isCompleted)
                                                            <span class="badge bg-light text-success">
                                                                <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                                            </span>
                                                        @elseif($isInProgress)
                                                            <span class="badge bg-light text-warning">
                                                                <i class="bi bi-hourglass-split me-1"></i> Sedang
                                                                Dikerjakan
                                                            </span>
                                                        @else
                                                            <span class="badge bg-light text-secondary">
                                                                <i class="bi bi-clock me-1"></i> Belum Mulai
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
        <!-- Step-by-Step Alur Dana Kemahasiswaan -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Langkah-Langkah Alur Dana Jurusan</h5>
                            <button class="btn btn-outline-primary btn-sm" id="saveProgressBtn">
                                <i class="bi bi-save me-1"></i> Simpan Progress
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @foreach ($steps as $step)
                                    @php
                                        $stepProgress = $progress[$step['step_number']] ?? null;
                                        $status = $stepProgress['status'] ?? 'belum_mulai';
                                        $isCompleted = $status === 'selesai';
                                        $isInProgress = $status === 'sedang_dikerjakan';
                                        $isNotStarted = $status === 'belum_mulai';
                                        $dokumenId = $stepProgress['dokumen_id'] ?? null;
                                        $catatan = $stepProgress['catatan'] ?? null;

                                        $statusClass = $isCompleted
                                            ? 'step-completed'
                                            : ($isInProgress
                                                ? 'step-in-progress'
                                                : 'step-not-started');
                                        $iconClass = $isCompleted
                                            ? 'bg-success'
                                            : ($isInProgress
                                                ? 'bg-warning'
                                                : 'bg-secondary');
                                        $badgeClass = $isCompleted
                                            ? 'bg-success'
                                            : ($isInProgress
                                                ? 'bg-warning'
                                                : 'bg-secondary');
                                        $badgeText = $isCompleted
                                            ? 'Selesai'
                                            : ($isInProgress
                                                ? 'Sedang Dikerjakan'
                                                : 'Belum Mulai');

                                        // Checkbox hanya enabled untuk langkah yang sedang dikerjakan
                                        $checkboxEnabled = $isInProgress;

                                        // Jika langkah 1, selalu enabled untuk memulai
                                        if ($step['step_number'] === 1 && $isNotStarted) {
                                            $checkboxEnabled = true;
                                        }
                                    @endphp

                                    <div class="timeline-item {{ $statusClass }}" id="step-{{ $step['step_number'] }}">
                                        <div
                                            class="timeline-icon {{ $iconClass }} text-white d-flex align-items-center justify-content-center">
                                            <i class="bi {{ $step['icon'] }}"></i>
                                        </div>
                                        <div class="card timeline-card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="fw-bold">{{ $step['step_number'] }}. {{ $step['nama'] }}
                                                    </h6>
                                                    <div>
                                                        <span
                                                            class="step-loading spinner-border spinner-border-sm text-primary me-2"
                                                            role="status" style="display: none;">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </span>
                                                        <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                                    </div>
                                                </div>
                                                <p class="text-muted">{{ $step['deskripsi'] }}</p>

                                                @if ($step['step_number'] === 1)
                                                    <div class="mb-3">
                                                        <a href="{{ route('program-kerja.proposal.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id, 'dokumenId' => $dokumenId]) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="bi bi-pencil-square me-1"></i> Buat Proposal
                                                        </a>
                                                    </div>
                                                @endif

                                                @if ($step['step_number'] === 2)
                                                    <div class="mb-3">
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
                                                        <a href="{{ $mailtoLink }}" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-send me-1"></i> Ajukan Proposal
                                                        </a>
                                                    </div>
                                                @endif

                                                @if ($step['step_number'] === 3)
                                                    <div class="alert alert-light border mt-2 mb-3">
                                                        <ul class="mb-0 ps-3">
                                                            <li><strong>Non-Revisi:</strong> Proposal langsung
                                                                ditandatangani oleh Sekretaris, Ketua Acara, dan Ketua
                                                                KSM/KMM.</li>
                                                            <li><strong>Revisi:</strong> Proposal dikembalikan untuk
                                                                diperbaiki dan diaudit ulang.</li>
                                                        </ul>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input audit-option" type="radio"
                                                                name="auditResult" id="nonRevisiOption" value="non-revisi"
                                                                {{ $isInProgress ? '' : 'disabled' }}
                                                                {{ $catatan === 'non-revisi' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="nonRevisiOption">Non-Revisi</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input audit-option" type="radio"
                                                                name="auditResult" id="revisiOption" value="revisi"
                                                                {{ $isInProgress ? '' : 'disabled' }}
                                                                {{ $catatan === 'revisi' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="revisiOption">Revisi</label>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($step['requires_upload'])
                                                    <div class="mb-3">
                                                        @if ($dokumenId)
                                                            <button class="btn btn-outline-success btn-sm" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#dokumenInfo{{ $step['step_number'] }}"
                                                                aria-expanded="false">
                                                                <i class="bi bi-file-earmark-check me-1"></i> Lihat Bukti
                                                                Terunggah
                                                            </button>

                                                            <div class="collapse mt-2"
                                                                id="dokumenInfo{{ $step['step_number'] }}">
                                                                <div class="card card-body">
                                                                    <p class="mb-1"><strong>Dokumen ID:</strong>
                                                                        {{ $dokumenId }}</p>
                                                                    <p class="mb-1"><strong>Status:</strong>
                                                                        {{ $badgeText }}</p>
                                                                    <p class="mb-1"><strong>Catatan:</strong>
                                                                        {{ $catatan ?: 'Tidak ada catatan' }}</p>
                                                                    @if (isset($stepProgress['completed_at']))
                                                                        <p class="mb-1"><strong>Tanggal:</strong>
                                                                            {{ date('d M Y H:i', strtotime($stepProgress['completed_at'])) }}
                                                                        </p>
                                                                    @endif
                                                                    <a href="#" class="btn btn-sm btn-primary mt-2"
                                                                        target="_blank">
                                                                        <i class="bi bi-download me-1"></i> Unduh Dokumen
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-sm upload-doc-btn"
                                                                data-step="{{ $step['step_number'] }}"
                                                                data-bs-toggle="modal" data-bs-target="#uploadDocModal"
                                                                {{ $isInProgress ? '' : 'disabled' }}>
                                                                <i class="bi bi-upload me-1"></i> Upload Bukti
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endif

                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    @if ($catatan && $step['step_number'] !== 3)
                                                        <div class="small text-muted">
                                                            <i class="bi bi-info-circle me-1"></i> {{ $catatan }}
                                                        </div>
                                                    @else
                                                        <div class="step-notes-container">
                                                            @if ($isInProgress)
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="step{{ $step['step_number'] }}Notes"
                                                                    placeholder="Catatan (opsional)"
                                                                    value="{{ $catatan }}">
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div class="form-check">
                                                        <input class="form-check-input step-checkbox" type="checkbox"
                                                            id="step{{ $step['step_number'] }}Checkbox"
                                                            data-step="{{ $step['step_number'] }}"
                                                            {{ $isCompleted ? 'checked' : '' }}
                                                            {{ $checkboxEnabled ? '' : 'disabled' }}>
                                                        <label class="form-check-label"
                                                            for="step{{ $step['step_number'] }}Checkbox">
                                                            Tandai Selesai
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                            <h5 class="fw-bold mb-0">Visualisasi Alur Dana</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="alur-visualization">
                                <div class="row">
                                    @foreach ($steps as $step)
                                        @php
                                            $stepProgress = $progress[$step['step_number']] ?? null;
                                            $status = $stepProgress['status'] ?? 'belum_mulai';
                                            $isCompleted = $status === 'selesai';
                                            $isInProgress = $status === 'sedang_dikerjakan';

                                            $stepClass = $isCompleted
                                                ? 'bg-success'
                                                : ($isInProgress
                                                    ? 'bg-warning'
                                                    : 'bg-secondary');
                                        @endphp
                                        <div class="col-md-3 mb-3">
                                            <div class="card h-100 alur-step-card {{ $stepClass }} text-white">
                                                <div class="card-body text-center">
                                                    <div class="step-number">{{ $step['step_number'] }}</div>
                                                    <div class="step-icon mb-2">
                                                        <i class="bi {{ $step['icon'] }} fs-3"></i>
                                                    </div>
                                                    <h6 class="card-title">{{ $step['nama'] }}</h6>
                                                    <div class="step-status">
                                                        @if ($isCompleted)
                                                            <span class="badge bg-light text-success">
                                                                <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                                            </span>
                                                        @elseif($isInProgress)
                                                            <span class="badge bg-light text-warning">
                                                                <i class="bi bi-hourglass-split me-1"></i> Sedang
                                                                Dikerjakan
                                                            </span>
                                                        @else
                                                            <span class="badge bg-light text-secondary">
                                                                <i class="bi bi-clock me-1"></i> Belum Mulai
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Upload Document Modal -->
    <div class="modal fade" id="uploadDocModal" tabindex="-1" aria-labelledby="uploadDocModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadDocModalLabel">Upload Bukti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadDocForm" class="upload-doc-form">
                        @csrf
                        <input type="hidden" id="stepNumberInput" name="step_number" value="">

                        <div class="mb-3">
                            <label for="docFile" class="form-label">Pilih File</label>
                            <input class="form-control" type="file" id="docFile" name="dokumen" required>
                            <div class="form-text">Format yang didukung: PDF, JPG, PNG (Maks. 5MB)</div>
                        </div>

                        <div class="mb-3">
                            <label for="docDescription" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="docDescription" name="deskripsi" rows="3"
                                placeholder="Jelaskan singkat mengenai dokumen ini..."></textarea>
                        </div>

                        <div class="alert alert-success d-none" id="uploadSuccessAlert">
                            <i class="bi bi-check-circle me-1"></i> Dokumen berhasil diunggah!
                        </div>

                        <div class="alert alert-danger d-none" id="uploadErrorAlert">
                            <i class="bi bi-exclamation-triangle me-1"></i> <span id="errorMessage">Terjadi kesalahan saat
                                mengunggah.</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" form="uploadDocForm" class="btn btn-primary" id="uploadDocBtn">
                        <i class="bi bi-upload me-1"></i> Unggah
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script>
        // Define URLs for AJAX requests
        const updateStepUrl =
            "{{ route('program-kerja.lpj.update-step', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}";
        const uploadBuktiUrl =
            "{{ route('program-kerja.lpj.upload-bukti', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}";
        const getProgressUrl =
            "{{ route('program-kerja.lpj.progress', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}";
        const csrfToken = "{{ csrf_token() }}";

        document.addEventListener('DOMContentLoaded', function() {
            // Handle step checkboxes
            const stepCheckboxes = document.querySelectorAll('.step-checkbox');

            stepCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const stepNumber = parseInt(this.getAttribute('data-step'));
                    const status = this.checked ? 'selesai' : 'sedang_dikerjakan';
                    const catatanInput = document.querySelector(`#step${stepNumber}Notes`);
                    const catatan = catatanInput ? catatanInput.value : '';

                    // Audit option for step 3
                    let auditResult = '';
                    if (stepNumber === 3) {
                        const nonRevisiOption = document.getElementById('nonRevisiOption');
                        const revisiOption = document.getElementById('revisiOption');

                        if (nonRevisiOption && nonRevisiOption.checked) {
                            auditResult = 'non-revisi';
                        } else if (revisiOption && revisiOption.checked) {
                            auditResult = 'revisi';
                        }

                        if (status === 'selesai' && !auditResult) {
                            showToast('Pilih hasil audit (Non-Revisi atau Revisi) terlebih dahulu',
                                'danger');
                            this.checked = false;
                            return;
                        }
                    }

                    // Tampilkan loading
                    showLoading(stepNumber, true);

                    // Kirim request AJAX untuk update status
                    fetch(updateStepUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                step_number: stepNumber,
                                status: status,
                                catatan: stepNumber === 3 ? auditResult : catatan
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response
                                    .statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Update UI
                                if (status === 'selesai') {
                                    markStepAsCompleted(stepNumber);

                                    // Aktifkan langkah berikutnya jika ada
                                    const nextStep = stepNumber + 1;
                                    const nextStepElement = document.querySelector(
                                        `#step-${nextStep}`);
                                    if (nextStepElement) {
                                        activateNextStep(nextStep);
                                    }
                                } else {
                                    markStepAsInProgress(stepNumber);
                                }

                                // Update progress bar
                                updateProgressBar();

                                // Tampilkan toast sukses
                                showToast('Status langkah berhasil diperbarui', 'success');
                            } else {
                                // Kembalikan status checkbox jika gagal
                                this.checked = !this.checked;

                                // Tampilkan toast error
                                showToast('Gagal memperbarui status: ' + (data.message ||
                                    'Terjadi kesalahan'), 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);

                            // Kembalikan status checkbox jika gagal
                            this.checked = !this.checked;

                            // Tampilkan toast error
                            showToast('Terjadi kesalahan saat memperbarui status', 'danger');
                        })
                        .finally(() => {
                            showLoading(stepNumber, false);
                        });
                });
            });

            // Function untuk menampilkan loading pada langkah
            function showLoading(stepNumber, isLoading) {
                const stepElement = document.querySelector(`#step-${stepNumber}`);
                if (!stepElement) return;

                const checkbox = stepElement.querySelector('.step-checkbox');
                if (checkbox) {
                    checkbox.disabled = isLoading;
                }

                const loadingSpinner = stepElement.querySelector('.step-loading');
                if (loadingSpinner) {
                    loadingSpinner.style.display = isLoading ? 'inline-block' : 'none';
                }
            }

            // Function untuk menandai langkah sebagai selesai
            function markStepAsCompleted(stepNumber) {
                const stepElement = document.getElementById('step-' + stepNumber);
                if (stepElement) {
                    // Update step styling
                    stepElement.classList.remove('step-in-progress', 'step-not-started');
                    stepElement.classList.add('step-completed');

                    // Update icon
                    const icon = stepElement.querySelector('.timeline-icon');
                    if (icon) {
                        icon.classList.remove('bg-warning', 'bg-secondary');
                        icon.classList.add('bg-success');
                    }

                    // Update badge
                    const badge = stepElement.querySelector('.badge');
                    if (badge) {
                        badge.classList.remove('bg-warning', 'bg-secondary');
                        badge.classList.add('bg-success');
                        badge.textContent = 'Selesai';
                    }

                    // Hide any note input
                    const noteInput = stepElement.querySelector(`#step${stepNumber}Notes`);
                    if (noteInput) {
                        const noteValue = noteInput.value;
                        const noteContainer = noteInput.parentElement;
                        if (noteValue) {
                            noteContainer.innerHTML =
                                `<div class="small text-muted"><i class="bi bi-info-circle me-1"></i> ${noteValue}</div>`;
                        } else {
                            noteContainer.innerHTML = '';
                        }
                    }

                    // Disable the checkbox
                    const checkbox = stepElement.querySelector('.step-checkbox');
                    if (checkbox) {
                        checkbox.disabled = true;
                        checkbox.checked = true;
                    }

                    // Disable audit options if step 3
                    if (stepNumber === 3) {
                        const auditOptions = stepElement.querySelectorAll('.audit-option');
                        auditOptions.forEach(option => {
                            option.disabled = true;
                        });
                    }

                    // Update visualization
                    updateStepVisualization(stepNumber, 'selesai');
                }
            }

            // Function untuk aktivasi step berikutnya yang sudah diperbaiki
            function activateNextStep(stepNumber) {
                console.log('Activating next step:', stepNumber); // Debug log

                const nextStepElement = document.getElementById('step-' + stepNumber);
                if (nextStepElement) {
                    console.log('Found next step element:', nextStepElement); // Debug log

                    // Pastikan langkah berikutnya belum aktif (hindari duplikasi)
                    if (nextStepElement.classList.contains('step-not-started')) {
                        // Update step status di server
                        fetch(updateStepUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    step_number: stepNumber,
                                    status: 'sedang_dikerjakan',
                                    catatan: ''
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Server successfully updated next step status'); // Debug log

                                    // Update step styling
                                    nextStepElement.classList.remove('step-not-started');
                                    nextStepElement.classList.add('step-in-progress');

                                    // Update icon
                                    const icon = nextStepElement.querySelector('.timeline-icon');
                                    if (icon) {
                                        icon.classList.remove('bg-secondary');
                                        icon.classList.add('bg-warning');
                                    }

                                    // Update badge
                                    const badge = nextStepElement.querySelector('.badge');
                                    if (badge) {
                                        badge.classList.remove('bg-secondary');
                                        badge.classList.add('bg-warning');
                                        badge.textContent = 'Sedang Dikerjakan';
                                    }

                                    // Enable checkbox
                                    const checkbox = nextStepElement.querySelector('.step-checkbox');
                                    if (checkbox) {
                                        checkbox.disabled = false;
                                    }

                                    // Enable upload buttons
                                    const uploadBtn = nextStepElement.querySelector('.upload-doc-btn');
                                    if (uploadBtn) {
                                        uploadBtn.disabled = false;
                                    }

                                    // Enable audit options if step 3
                                    if (stepNumber === 3) {
                                        const auditOptions = nextStepElement.querySelectorAll('.audit-option');
                                        auditOptions.forEach(option => {
                                            option.disabled = false;
                                        });
                                    }

                                    // Add note input if doesn't exist
                                    const noteContainer = nextStepElement.querySelector(
                                        '.step-notes-container');
                                    if (noteContainer && !noteContainer.querySelector('input')) {
                                        noteContainer.innerHTML =
                                            `<input type="text" class="form-control form-control-sm" id="step${stepNumber}Notes" placeholder="Catatan (opsional)" value="">`;
                                    }

                                    // Highlight the step
                                    highlightStep(nextStepElement);

                                    // Update visualization
                                    updateStepVisualization(stepNumber, 'sedang_dikerjakan');

                                    // Update progress bar
                                    updateProgressBar();
                                } else {
                                    console.error('Failed to update next step status:', data.message);
                                    showToast('Gagal mengaktifkan langkah berikutnya: ' + data.message,
                                        'danger');
                                }
                            })
                            .catch(error => {
                                console.error('Error activating next step:', error);
                                showToast('Terjadi kesalahan saat mengaktifkan langkah berikutnya', 'danger');
                            });
                    } else {
                        console.log('Next step is already active or completed'); // Debug log
                    }
                } else {
                    console.log('No next step element found'); // Debug log
                }
            }

            // Fungsi tambahan untuk debugging
            function inspectStepState() {
                const steps = document.querySelectorAll('.timeline-item');
                steps.forEach(step => {
                    const stepNumber = step.id.replace('step-', '');
                    const status = step.classList.contains('step-completed') ?
                        'completed' :
                        (step.classList.contains('step-in-progress') ?
                            'in-progress' :
                            'not-started');

                    const checkbox = step.querySelector('.step-checkbox');
                    const checkboxState = checkbox ?
                        `checked: ${checkbox.checked}, disabled: ${checkbox.disabled}` :
                        'not found';

                    console.log(`Step ${stepNumber}: ${status}, Checkbox: ${checkboxState}`);
                });
            }

            // Opsional: Tambahkan fungsi inspeksi untuk debugging
            window.inspectStepState = inspectStepState;

            // Function untuk menandai langkah sebagai sedang dikerjakan
            function markStepAsInProgress(stepNumber) {
                const stepElement = document.getElementById('step-' + stepNumber);
                if (stepElement) {
                    // Update step styling
                    stepElement.classList.remove('step-completed', 'step-not-started');
                    stepElement.classList.add('step-in-progress');

                    // Update icon
                    const icon = stepElement.querySelector('.timeline-icon');
                    if (icon) {
                        icon.classList.remove('bg-success', 'bg-secondary');
                        icon.classList.add('bg-warning');
                    }

                    // Update badge
                    const badge = stepElement.querySelector('.badge');
                    if (badge) {
                        badge.classList.remove('bg-success', 'bg-secondary');
                        badge.classList.add('bg-warning');
                        badge.textContent = 'Sedang Dikerjakan';
                    }

                    // Update visualization
                    updateStepVisualization(stepNumber, 'sedang_dikerjakan');
                }
            }

            // Function to highlight a step with a brief animation
            function highlightStep(stepElement) {
                stepElement.style.transition = 'all 0.3s ease';
                stepElement.style.boxShadow = '0 0 0 3px rgba(13, 110, 253, 0.25)';

                setTimeout(() => {
                    stepElement.style.boxShadow = 'none';
                }, 800);

                // Scroll to this step
                stepElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            // Function to update step visualization
            function updateStepVisualization(stepNumber, status) {
                const stepCard = document.querySelector(
                    `.alur-visualization .row > div:nth-child(${stepNumber}) .alur-step-card`);
                if (stepCard) {
                    // Remove all status classes
                    stepCard.classList.remove('bg-success', 'bg-warning', 'bg-secondary');

                    // Add appropriate class based on status
                    if (status === 'selesai') {
                        stepCard.classList.add('bg-success');

                        // Update badge
                        const badge = stepCard.querySelector('.step-status .badge');
                        if (badge) {
                            badge.className = 'badge bg-light text-success';
                            badge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Selesai';
                        }
                    } else if (status === 'sedang_dikerjakan') {
                        stepCard.classList.add('bg-warning');

                        // Update badge
                        const badge = stepCard.querySelector('.step-status .badge');
                        if (badge) {
                            badge.className = 'badge bg-light text-warning';
                            badge.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Sedang Dikerjakan';
                        }
                    } else {
                        stepCard.classList.add('bg-secondary');

                        // Update badge
                        const badge = stepCard.querySelector('.step-status .badge');
                        if (badge) {
                            badge.className = 'badge bg-light text-secondary';
                            badge.innerHTML = '<i class="bi bi-clock me-1"></i> Belum Mulai';
                        }
                    }
                }
            }

            // Function to update progress bar
            function updateProgressBar() {
                // Get latest progress data
                // Hitung jumlah langkah yang selesai dan sedang dikerjakan
                const totalSteps = document.querySelectorAll('.timeline-item').length;
                const completedSteps = document.querySelectorAll('.step-completed').length;
                const inProgressSteps = document.querySelectorAll('.step-in-progress').length;

                // Hitung persentase
                const completedPercentage = (completedSteps / totalSteps) * 100;
                const inProgressPercentage = (inProgressSteps / totalSteps) * 100;

                const progressBar = document.querySelector('.progress-bar.bg-success');
                const progressBarInProgress = document.querySelector('.progress-bar.bg-warning');

                if (progressBar && progressBarInProgress) {
                    progressBar.style.width = completedPercentage + '%';
                    progressBar.setAttribute('aria-valuenow', completedSteps);

                    progressBarInProgress.style.width = inProgressPercentage + '%';
                    progressBarInProgress.setAttribute('aria-valuenow', inProgressSteps);

                    // Update text counters
                    const completedStepsText = document.querySelector(
                        '.progress-tracker .small.text-muted span:first-child');
                    const inProgressStepsText = document.querySelector(
                        '.progress-tracker .small.text-muted span:nth-child(2)');
                    const remainingStepsText = document.querySelector(
                        '.progress-tracker .small.text-muted span:last-child');

                    if (completedStepsText) completedStepsText.textContent = completedSteps + ' langkah selesai';
                    if (inProgressStepsText) inProgressStepsText.textContent = inProgressSteps +
                        ' sedang dikerjakan';
                    if (remainingStepsText) remainingStepsText.textContent = (totalSteps - completedSteps -
                        inProgressSteps) + ' belum dimulai';

                    // Update persentase keseluruhan
                    const percentageDisplay = document.querySelector('.progress-tracker .badge');
                    if (percentageDisplay) {
                        const overallPercentage = Math.round(completedPercentage);
                        percentageDisplay.textContent = overallPercentage + '% Selesai';
                    }
                }
            }

            // Custom Toast Notification Function
            function showToast(message, type = 'info') {
                // Check if toast container exists, if not create it
                let toastContainer = document.querySelector('.toast-container');
                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                    document.body.appendChild(toastContainer);
                }

                // Create toast element
                const toastId = 'toast-' + Date.now();
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type} border-0`;
                toast.id = toastId;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');

                // Set toast content
                toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

                // Add toast to container
                toastContainer.appendChild(toast);

                // Initialize and show Bootstrap toast
                if (typeof bootstrap !== 'undefined' && typeof bootstrap.Toast !== 'undefined') {
                    const bsToast = new bootstrap.Toast(toast, {
                        autohide: true,
                        delay: 3000
                    });
                    bsToast.show();

                    // Remove toast from DOM after it's hidden
                    toast.addEventListener('hidden.bs.toast', function() {
                        this.remove();
                    });
                } else {
                    // Fallback if Bootstrap Toast is not available
                    toast.style.display = 'block';
                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }
            }

            // Init: Periksa status checkbox pada saat halaman dimuat
            initializeCheckboxStates();

            function initializeCheckboxStates() {
                // Pastikan semua checkbox yang seharusnya aktif telah aktif
                const stepItems = document.querySelectorAll('.timeline-item');

                stepItems.forEach(item => {
                    const stepNumber = parseInt(item.id.replace('step-', ''));
                    const isCompleted = item.classList.contains('step-completed');
                    const isInProgress = item.classList.contains('step-in-progress');

                    const checkbox = item.querySelector('.step-checkbox');
                    if (checkbox) {
                        if (isCompleted) {
                            checkbox.checked = true;
                            checkbox.disabled = true;
                        } else if (isInProgress) {
                            checkbox.disabled = false;
                        } else {
                            checkbox.disabled = true;
                        }
                    }
                });
            }
        });
    </script>

    <style>
        /* Timeline styling */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 30px;
            top: 20px;
            height: calc(100% - 40px);
            width: 2px;
            background-color: #dee2e6;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-icon {
            position: absolute;
            left: -17px;
            top: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            z-index: 2;
        }

        .timeline-card {
            margin-left: 15px;
            border-radius: 0.5rem;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        /* Step status styles */
        .step-completed .timeline-card {
            border-left-color: #198754;
            /* Bootstrap success color */
        }

        .step-in-progress .timeline-card {
            border-left-color: #ffc107;
            /* Bootstrap warning color */
        }

        .step-not-started .timeline-card {
            border-left-color: #6c757d;
            /* Bootstrap secondary color */
        }

        /* Checkbox styling */
        .form-check-input.step-checkbox {
            cursor: pointer;
            width: 20px;
            height: 20px;
        }

        .form-check-input.step-checkbox:checked {
            background-color: #198754;
            border-color: #198754;
        }

        .form-check-label {
            cursor: pointer;
            padding-left: 5px;
            font-weight: 500;
        }

        /* Upload button styling */
        .upload-doc-btn {
            transition: all 0.3s;
        }

        .upload-doc-btn:not(:disabled):hover {
            background-color: #0d6efd;
            color: white;
        }

        /* Animation styles */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .timeline-item {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Step completion visual effects */
        .step-completed .timeline-icon {
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.2);
        }

        .step-in-progress .timeline-icon {
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2);
        }

        /* Save progress button styling */
        #saveProgressBtn {
            transition: all 0.3s;
        }

        #saveProgressBtn:hover {
            background-color: #0d6efd;
            color: white;
        }

        /* Add a subtle hover effect to the cards */
        .timeline-card:hover {
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
        }

        /* Alur visualization styles */
        .alur-visualization {
            padding: 1rem 0;
        }

        .alur-step-card {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .alur-step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .step-notes-container {
            max-width: 250px;
        }
    </style>

@endsection
