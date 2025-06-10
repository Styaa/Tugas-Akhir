@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container-fluid py-4">
        <!-- Welcome Banner & Quick Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <!-- Ormawa Profile -->
                <div class="card bg-primary text-white border-0 rounded-3 shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="display-6 fw-bold mb-1">{{ $ormawas[0]['nama'] }}</h1>
                                <p class="mb-3 opacity-75">{{ $ormawas[0]['kode'] }}</p>
                            </div>
                            {{-- <div class="d-none d-md-block">
                                <img src="{{ asset('images/ormawa_logo.png') }}" alt="Logo" class="img-fluid"
                                    style="max-height: 80px;">
                            </div> --}}
                        </div>

                        <div class="bg-white bg-opacity-10 p-3 mt-4 rounded-3">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-stars me-2"></i>Visi
                            </h5>
                            <p class="mb-0">{{ $ormawas[0]['visi'] }}</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('program-kerja.index', ['kode_ormawa' => $ormawas[0]['kode']]) }}"
                                class="btn btn-light">
                                <i class="bi bi-list-check me-2"></i>Lihat Program Kerja
                            </a>
                            <a href="{{ route('rapat.index', ['kode_ormawa' => $ormawas[0]['kode']]) }}"
                                class="btn btn-outline-light ms-2">
                                <i class="bi bi-calendar-event me-2"></i>Lihat Rapat
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Quick Stats -->
                <div class="row g-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                                <i class="bi bi-calendar-check text-white fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fw-bold mb-1">Program Kerja</h5>
                                            <h3 class="mb-0">{{ $programKerjaCount }}</h3>
                                            <div class="progress mt-2" style="height: 5px;">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: {{ $progressPercentage }}%"
                                                    aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <small class="text-muted">{{ $completedPrograms }} dari {{ $totalPrograms }}
                                                selesai</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                                <i class="bi bi-clipboard-data text-white fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="fw-bold mb-1">Proposal/LPJ Telat</h5>
                                            <h3 class="mb-0">{{ $dokumenTelat }}</h3>
                                            <div class="progress mt-2" style="height: 5px;">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                    style="width: {{ $approvalPercentage }}%"
                                                    aria-valuenow="{{ $approvalPercentage }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <small class="text-muted">{{ $approvedDocuments }} dari {{ $totalDocuments }}
                                                disetujui</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Information -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-journal-check text-white fs-4"></i>
                            </div>
                            <div class="flex-fill ms-4">
                                <div class="fw-bold">Alur Dana Jurusan</div>
                                <div class="text-muted small">Lihat proses pengajuan dana</div>
                            </div>
                            <a href="{{ route('alur-dana.jurusan') }}" title="Lihat alur dana jurusan"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-list-check text-white fs-4"></i>
                            </div>
                            <div class="flex-fill ms-4">
                                <div class="fw-bold">Alur Dana Kemahasiswaan</div>
                                <div class="text-muted small">Lihat proses pengajuan dana</div>
                            </div>
                            <a href="{{ route('alur-dana.kemahasiswaan') }}" title="Lihat alur dana kemahasiswaan"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="bi bi-file-earmark-text text-white fs-4"></i>
                            </div>
                            <div class="flex-fill ms-4">
                                <div class="fw-bold">Buat Rapat Baru</div>
                                <div class="text-muted small">Jadwalkan rapat untuk ormawa</div>
                            </div>
                            <a href="{{ route('rapat.create', ['kode_ormawa' => $ormawas[0]['kode']]) }}"
                                title="Buat rapat baru" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-3">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Upcoming Events -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Kegiatan Mendatang</h5>
                            <a href="{{ route('program-kerja.index', ['kode_ormawa' => $ormawas[0]['kode']]) }}"
                                class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($programKerjaTerdekats) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Kegiatan</th>
                                            <th>Tanggal</th>
                                            <th>Lokasi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($programKerjaTerdekats as $proker)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold">{{ $proker['nama'] }}</div>
                                                    <div class="small text-muted">
                                                        {{ $proker['deskripsi'] ? \Illuminate\Support\Str::limit($proker['deskripsi'], 40) : 'Tidak ada deskripsi' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        @if (is_null($proker['tanggal_mulai']) || !is_string($proker['tanggal_mulai']))
                                                            Tidak ditentukan
                                                        @else
                                                            @php
                                                                try {
                                                                    $startDate = \Carbon\Carbon::parse(
                                                                        $proker['tanggal_mulai'],
                                                                    );
                                                                    echo $startDate->format('d M Y');
                                                                } catch (\Exception $e) {
                                                                    echo 'Format tanggal tidak valid';
                                                                }
                                                            @endphp
                                                        @endif
                                                    </span>
                                                    @if (!is_null($proker['tanggal_selesai']) && is_string($proker['tanggal_selesai']))
                                                        <div class="small text-muted mt-1">
                                                            @php
                                                                try {
                                                                    $endDate = \Carbon\Carbon::parse(
                                                                        $proker['tanggal_selesai'],
                                                                    );
                                                                    echo 'Hingga ' . $endDate->format('d M Y');
                                                                } catch (\Exception $e) {
                                                                    echo 'Tanggal selesai tidak valid';
                                                                }
                                                            @endphp
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $proker['tempat'] ?? 'Belum ditentukan' }}</td>
                                                <td>
                                                    @php
                                                        try {
                                                            $today = \Carbon\Carbon::now();
                                                            $startDate = is_string($proker['tanggal_mulai'])
                                                                ? \Carbon\Carbon::parse($proker['tanggal_mulai'])
                                                                : null;
                                                            $endDate =
                                                                !is_null($proker['tanggal_selesai']) &&
                                                                is_string($proker['tanggal_selesai'])
                                                                    ? \Carbon\Carbon::parse($proker['tanggal_selesai'])
                                                                    : null;

                                                            if (!$startDate) {
                                                                $status = 'Unknown';
                                                                $badgeClass = 'bg-secondary';
                                                            } elseif ($today->lt($startDate)) {
                                                                $status = 'Upcoming';
                                                                $badgeClass = 'bg-primary';
                                                            } elseif (!$endDate || $today->lte($endDate)) {
                                                                $status = 'In Progress';
                                                                $badgeClass = 'bg-success';
                                                            } else {
                                                                $status = 'Completed';
                                                                $badgeClass = 'bg-secondary';
                                                            }
                                                        } catch (\Exception $e) {
                                                            $status = 'Error';
                                                            $badgeClass = 'bg-danger';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="text-muted">Tidak ada kegiatan mendatang</h6>
                                <p class="small text-muted mb-0">Semua kegiatan yang akan datang akan muncul di sini</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Your Work Programs -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Program Kerja Anda</h5>
                            <a href="{{ route('program-kerja.create', ['kode_ormawa' => $ormawas[0]['kode']]) }}"
                                class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-lg me-1"></i>Buat Baru
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($programKerjaUsers) > 0)
                            <div class="row g-3">
                                @foreach ($programKerjaUsers as $programKerjaUser)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <!-- Icon container with fixed width -->
                                                    <div class="rounded p-2 bg-primary bg-opacity-10"
                                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bi bi-clipboard-check text-white"></i>
                                                    </div>

                                                    <!-- Badge with fixed width and text truncation -->
                                                    <span class="badge bg-light text-dark text-truncate"
                                                        style="max-width: 100px;">
                                                        {{ number_format(
                                                            \Carbon\Carbon::parse($programKerjaUser['tanggal_mulai_program_kerja'])->diffInDays(now(), true),
                                                            2,
                                                        ) > 0
                                                            ? number_format(
                                                                    \Carbon\Carbon::parse($programKerjaUser['tanggal_mulai_program_kerja'])->diffInDays(now(), true),
                                                                    2,
                                                                ) . ' hari'
                                                            : 'Hari ini' }}
                                                    </span>
                                                </div>
                                                <h6 class="fw-bold mb-2">{{ $programKerjaUser['nama_program_kerja'] }}
                                                </h6>
                                                <div class="text-muted small mb-3 d-flex justify-content-between">
                                                    <div class="">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                    @php
                                                        try {
                                                            if (
                                                                is_string(
                                                                    $programKerjaUser['tanggal_mulai_program_kerja'],
                                                                )
                                                            ) {
                                                                echo \Carbon\Carbon::parse(
                                                                    $programKerjaUser['tanggal_mulai_program_kerja'],
                                                                )->format('d M Y');
                                                            } else {
                                                                echo 'Tanggal mulai tidak valid';
                                                            }

                                                            if (
                                                                !is_null(
                                                                    $programKerjaUser['tanggal_selesai_program_kerja'],
                                                                ) &&
                                                                is_string(
                                                                    $programKerjaUser['tanggal_selesai_program_kerja'],
                                                                )
                                                            ) {
                                                                echo ' - ' .
                                                                    \Carbon\Carbon::parse(
                                                                        $programKerjaUser[
                                                                            'tanggal_selesai_program_kerja'
                                                                        ],
                                                                    )->format('d M Y');
                                                            }
                                                        } catch (\Exception $e) {
                                                            echo 'Format tanggal tidak valid';
                                                        }
                                                    @endphp
                                                    </div>

                                                    <a href="{{ route('program-kerja.show', ['kode_ormawa' => $ormawas[0]['kode'], 'id' => $programKerjaUser['id_program_kerja']]) }}"
                                                        class="btn btn-sm btn-link p-0">Detail</a>
                                                </div>
                                                {{-- <div class="progress mb-2" style="height: 5px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="small text-muted">65% selesai</span>
                                                    <a href="{{ route('program-kerja.show', ['kode_ormawa' => $ormawas[0]['kode'], 'id' => $programKerjaUser['id_program_kerja']]) }}"
                                                        class="btn btn-sm btn-link p-0">Detail</a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-briefcase text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h6 class="text-muted">Anda belum memiliki program kerja</h6>
                                <a href="{{ route('program-kerja.create', ['kode_ormawa' => $ormawas[0]['kode']]) }}"
                                    class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-lg me-1"></i>Buat Program Kerja
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Divisions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 bg-transparent">
                        <h5 class="mb-0 fw-bold">Divisi Ormawa</h5>
                    </div>
                    <div class="card-body">
                        @if (count($divisiOrmawas) > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($divisiOrmawas as $divisi)
                                    <div class="list-group-item px-0 py-3 d-flex align-items-center border-bottom">
                                        <div class="rounded-circle bg-primary bg-opacity-10 text-white p-2 me-3"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $divisi->nama }}</h6>
                                            <small class="text-muted">{{ $divisi->keterangan }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="bi bi-diagram-3 text-muted" style="font-size: 2rem;"></i>
                                </div>
                                <p class="text-muted">Tidak ada divisi</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Your Activities -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Aktivitas Anda</h5>
                            <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if (count($aktivitasUsers) > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($aktivitasUsers as $aktivitas)
                                    <div class="list-group-item px-3 py-3">
                                        <div class="d-flex align-items-center">
                                            {{-- <img class="rounded-circle me-3" src="{{ asset('images/lg/avatar2.jpg') }}"
                                                alt="profile" width="45" height="45" style="object-fit: cover;"> --}}
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-semibold">{{ $aktivitas->nama }}</h6>
                                                <p class="mb-1 small text-muted">{{ $aktivitas->programKerja->nama }}</p>
                                                @if ($aktivitas->tenggat_waktu)
                                                    @php
                                                        try {
                                                            $deadline = \Carbon\Carbon::parse(
                                                                $aktivitas->tenggat_waktu,
                                                            );
                                                            $isCompleted = $aktivitas->status === 'selesai';
                                                            $isOverdue = $deadline->isPast() && !$isCompleted;
                                                            $daysRemaining = now()->diffInDays($deadline, false);

                                                            // Round the days remaining
                                                            $daysRemaining = round($daysRemaining);
                                                        } catch (\Exception $e) {
                                                            $isOverdue = false;
                                                            $daysRemaining = 0;
                                                        }
                                                    @endphp
                                                    <div class="small {{ $isCompleted ? 'text-success' : ($isOverdue ? 'text-danger' : 'text-primary') }}">
                                                        @if ($isCompleted)
                                                            <i class="bi bi-check-circle-fill me-1"></i>
                                                            Selesai
                                                            @if ($aktivitas->completed_at)
                                                                pada {{ \Carbon\Carbon::parse($aktivitas->completed_at)->format('d M Y') }}
                                                            @endif
                                                        @elseif ($isOverdue)
                                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                                            Terlambat {{ abs($daysRemaining) }} hari
                                                        @else
                                                            <i class="bi bi-clock me-1"></i>
                                                            {{ $daysRemaining }} hari tersisa
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="small text-muted">Deadline belum diatur</div>
                                                @endif
                                            </div>
                                            <div class="ms-2">
                                                @php
                                                    $statusClass = 'bg-secondary';
                                                    if ($aktivitas->status == 'sedang_berjalan') {
                                                        $statusClass = 'bg-primary';
                                                    } elseif ($aktivitas->status == 'selesai') {
                                                        $statusClass = 'bg-success';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }}">
                                                    {{ $aktivitas->status == 'belum_mulai'
                                                        ? 'Not Started'
                                                        : ($aktivitas->status == 'sedang_berjalan'
                                                            ? 'In Progress'
                                                            : 'Completed') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-clipboard-check text-muted" style="font-size: 2rem;"></i>
                                </div>
                                <p class="text-muted">Tidak ada aktivitas saat ini</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Division Activity Metrics -->
                <div class="card shadow-sm">
                    <div class="card-header py-3 bg-transparent">
                        <h5 class="mb-0 fw-bold">Aktivitas Divisi</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-danger bg-opacity-10 p-2 me-3"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-exclamation-triangle text-white"></i>
                                    </div>
                                    <span>Tugas Divisi Kritikal</span>
                                </div>
                                <span class="badge bg-danger rounded-pill">{{ $kritikalTasksCount }}</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 p-2 me-3"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-check-circle text-white"></i>
                                    </div>
                                    <span>Tugas Selesai</span>
                                </div>
                                <span class="badge bg-success rounded-pill">{{ $completedTasksCount }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-3"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-hourglass-split text-white"></i>
                                    </div>
                                    <span>Tugas Overdue</span>
                                </div>
                                <span class="badge bg-warning rounded-pill">{{ $overdueTasksCount }}</span>
                            </li>
                        </ul>

                        {{-- <div class="mt-4">
                            <div id="divisionActivityChart"></div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    <script>
        // Initialize ApexCharts for Division Activity
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                series: [{
                    name: 'Completed',
                    data: [12, 8, 15, 10]
                }, {
                    name: 'In Progress',
                    data: [7, 10, 8, 15]
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    stacked: true,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '60%',
                        borderRadius: 5,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['BPH', 'HUMAS', 'ACARA', 'PUBLIKASI'],
                },
                colors: ['#0d6efd', '#6c757d'],
                fill: {
                    opacity: 1
                },
                legend: {
                    position: 'bottom',
                    offsetY: 0
                }
            };

            var chart = new ApexCharts(document.querySelector("#divisionActivityChart"), options);
            chart.render();

            // Statistics Proker Chart (Donut)
            var options2 = {
                series: [4, 2, 1, 3],
                chart: {
                    width: '100%',
                    type: 'donut',
                },
                labels: ['Completed', 'In Progress', 'Not Started', 'Overdue'],
                colors: ['#28a745', '#0d6efd', '#6c757d', '#dc3545'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%'
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var chart2 = new ApexCharts(document.querySelector("#apex-StatisticProker"), options2);
            chart2.render();
        });
    </script>
@endsection
