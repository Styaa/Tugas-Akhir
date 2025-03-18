@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        <span id="success-message"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div
                        class="bg-light rounded-top p-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-0">{{ $namaDivisi->nama_divisi }}</h2>
                            <p class="text-muted mb-0">Daftar aktivitas & tugas divisi</p>
                        </div>
                        <a href="{{ route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $prokerId]) }}"
                            class="btn btn-outline-secondary mt-3 mt-md-0">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Program Kerja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Activities Card -->
        <div class="col-xl-9 col-lg-8 col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Daftar Aktivitas</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActivity">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Aktivitas
                    </button>
                </div>
                <div class="card-body">
                    @if ($activities->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-tasks fa-3x text-muted"></i>
                            </div>
                            <h5>Belum ada aktivitas</h5>
                            <p class="text-muted">Mulai dengan menambahkan aktivitas baru untuk divisi ini</p>
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                data-bs-target="#addActivity">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Aktivitas Pertama
                            </button>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="myProjectTable" class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Aktivitas</th>
                                        <th>PIC</th>
                                        <th>Deadline</th>
                                        <th>Prioritas</th>
                                        <th>Status</th>
                                        <th>Dependency</th>
                                        @if (Auth::user()->jabatanOrmawa->id !== 13 || Auth::user()->jabatanProker->id !== 13)
                                            <th>Nilai</th>
                                        @endif
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                        <form
                                            action="{{ route('program-kerja.divisi.aktivitas.update', ['kode_ormawa' => $kode_ormawa, 'id' => $prokerId, 'aktivitas_id' => $activity->id, 'nama_program_kerja' => $prokerNama]) }}"
                                            method="PATCH">
                                            @csrf
                                            @method('PATCH')
                                            <tr data-id="{{ $activity->id }}">
                                                @php
                                                    $activityId = $activity->id;

                                                    // Get priority classes
                                                    $priorityClass = 'bg-info';
                                                    if ($activity->prioritas == 'tinggi') {
                                                        $priorityClass = 'bg-danger';
                                                    } elseif ($activity->prioritas == 'sedang') {
                                                        $priorityClass = 'bg-warning';
                                                    } elseif ($activity->prioritas == 'kritikal') {
                                                        $priorityClass = 'bg-dark';
                                                    }

                                                    // Get status classes
                                                    $statusClass = 'bg-secondary';
                                                    if ($activity->status == 'sedang_berjalan') {
                                                        $statusClass = 'bg-primary';
                                                    } elseif ($activity->status == 'selesai') {
                                                        $statusClass = 'bg-success';
                                                    }

                                                    // Format the date
                                                    $deadline = $activity->tenggat_waktu
                                                        ? date('d M Y', strtotime($activity->tenggat_waktu))
                                                        : '-';
                                                    $isLate =
                                                        $activity->tenggat_waktu &&
                                                        $activity->status != 'selesai' &&
                                                        strtotime($activity->tenggat_waktu) < strtotime('today');
                                                @endphp

                                                <td>
                                                    <input type="text"
                                                        class="form-control bg-transparent border-0 fw-medium update-field"
                                                        value="{{ $activity->nama }}" name="nama" />
                                                </td>
                                                <td>
                                                    <select class="form-select bg-transparent border-0 update-field"
                                                        name="person_in_charge">
                                                        <option value="">Assign User</option>
                                                        @foreach ($anggotaProker as $user)
                                                            <option value="{{ $user->user_id }}"
                                                                {{ $activity->person_in_charge == $user->user_id ? 'selected' : '' }}>
                                                                {{ $user->nama_user }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="position-relative">
                                                        <input type="date"
                                                            class="form-control bg-transparent border-0 update-field"
                                                            value="{{ $activity->tenggat_waktu ? $activity->tenggat_waktu : '' }}"
                                                            name="tenggat_waktu" />
                                                        @if ($isLate)
                                                            <span
                                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                                <small><i class="fas fa-exclamation-triangle"></i></small>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-select bg-transparent border-0 update-field"
                                                        name="prioritas">
                                                        <option value="rendah"
                                                            {{ $activity->prioritas == 'rendah' ? 'selected' : '' }}>
                                                            Low
                                                        </option>
                                                        <option value="sedang"
                                                            {{ $activity->prioritas == 'sedang' ? 'selected' : '' }}>
                                                            Normal
                                                        </option>
                                                        <option value="tinggi"
                                                            {{ $activity->prioritas == 'tinggi' ? 'selected' : '' }}>
                                                            High
                                                        </option>
                                                        <option value="kritikal"
                                                            {{ $activity->prioritas == 'kritikal' ? 'selected' : '' }}>
                                                            Urgent
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select bg-transparent border-0 update-field"
                                                        name="status" data-status="{{ $activity->status }}">
                                                        <option value="belum_mulai"
                                                            {{ $activity->status == 'belum_mulai' ? 'selected' : '' }}>
                                                            Not Started
                                                        </option>
                                                        <option value="sedang_berjalan"
                                                            {{ $activity->status == 'sedang_berjalan' ? 'selected' : '' }}>
                                                            In Progress
                                                        </option>
                                                        <option value="selesai"
                                                            {{ $activity->status == 'selesai' ? 'selected' : '' }}>
                                                            Completed
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select bg-transparent border-0 update-field"
                                                        name="dependency_id">
                                                        <option value="">No Dependency</option>
                                                        @foreach ($activities as $depActivity)
                                                            @if ($depActivity->id != $activity->id)
                                                                <option value="{{ $depActivity->id }}"
                                                                    {{ $depActivity->id == $activity->dependency_id ? 'selected' : '' }}>
                                                                    {{ $depActivity->nama }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                @if (Auth::user()->jabatanOrmawa->id !== 13 || Auth::user()->jabatanProker->id !== 13)
                                                    <td>
                                                        <select class="form-select bg-transparent border-0 update-field"
                                                            name="nilai" id="nilai">
                                                            <option value="">Nilai</option>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ $activity->nilai == $i ? 'selected' : '' }}>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                @endif
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton{{ $activity->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton{{ $activity->id }}">
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#activityDetailModal{{ $activity->id }}">
                                                                    <i class="fas fa-eye me-2"></i>Detail
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editActivityModal{{ $activity->id }}">
                                                                    <i class="fas fa-edit me-2"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteActivityModal{{ $activity->id }}">
                                                                    <i class="fas fa-trash-alt me-2"></i>Hapus
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Division Members Card -->
        <div class="col-xl-3 col-lg-4 col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Anggota Divisi</h5>
                    {{-- <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#addMemberModal">
                        <i class="fas fa-user-plus"></i>
                    </button> --}}
                </div>
                <div class="card-body p-0">
                    @forelse ($anggotaProker as $item)
                        <div class="p-3 d-flex align-items-center border-bottom">
                            <div class="avatar-container me-3">
                                <img class="avatar rounded-circle img-thumbnail"
                                    src="{{ url('/') . '/images/lg/avatar2.jpg' }}" alt="profile"
                                    style="width: 48px; height: 48px; object-fit: cover;">
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="fw-bold mb-0">{{ $item->nama_user }}</h6>
                                <span class="text-muted small">{{ $item->nama_jabatan }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-muted"></i>
                            </div>
                            <h6 class="fw-bold mb-2">Belum ada anggota</h6>
                            <p class="text-muted small mb-3">Tambahkan anggota untuk divisi ini</p>
                            {{-- <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#addMemberModal">
                                <i class="fas fa-user-plus me-2"></i>Tambah Anggota
                            </button> --}}
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Division Stats Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Statistik Divisi</h5>
                </div>
                <div class="card-body">
                    <!-- Progress & Stats -->
                    @php
                        $totalActivities = count($activities);
                        $completedActivities = $activities->where('status', 'selesai')->count();
                        $inProgressActivities = $activities->where('status', 'sedang_berjalan')->count();
                        $notStartedActivities = $activities->where('status', 'belum_mulai')->count();

                        $progressPercentage =
                            $totalActivities > 0 ? round(($completedActivities / $totalActivities) * 100) : 0;
                    @endphp

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Progres Keseluruhan</h6>
                            <span class="badge bg-primary">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $progressPercentage }}%" aria-valuenow="{{ $progressPercentage }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-4">
                            <div class="border rounded p-2 text-center bg-light">
                                <h3 class="mb-0 fw-bold text-success">{{ $completedActivities }}</h3>
                                <span class="small text-muted">Selesai</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 text-center bg-light">
                                <h3 class="mb-0 fw-bold text-primary">{{ $inProgressActivities }}</h3>
                                <span class="small text-muted">Berjalan</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 text-center bg-light">
                                <h3 class="mb-0 fw-bold text-secondary">{{ $notStartedActivities }}</h3>
                                <span class="small text-muted">Belum</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Member Modal Placeholder -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Anggota Divisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form content would go here -->
                    <p class="text-center text-muted">Form untuk menambahkan anggota divisi akan ditampilkan di sini.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Detail Modal Placeholders -->
    @foreach ($activities as $activity)
        <div class="modal fade" id="activityDetailModal{{ $activity->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Aktivitas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="mb-3">{{ $activity->nama }}</h5>
                        <div class="row mb-3">
                            <div class="col-4 text-muted">Status:</div>
                            <div class="col-8">
                                @php
                                    $statusText = 'Belum Mulai';
                                    $statusClass = 'bg-secondary';

                                    if ($activity->status == 'sedang_berjalan') {
                                        $statusText = 'Sedang Berjalan';
                                        $statusClass = 'bg-primary';
                                    } elseif ($activity->status == 'selesai') {
                                        $statusText = 'Selesai';
                                        $statusClass = 'bg-success';
                                    }
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-muted">PIC:</div>
                            <div class="col-8">
                                @php
                                    $picName = 'Belum ditetapkan';
                                    foreach ($anggotaProker as $user) {
                                        if ($user->user_id == $activity->person_in_charge) {
                                            $picName = $user->nama_user;
                                            break;
                                        }
                                    }
                                @endphp
                                {{ $picName }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-muted">Deadline:</div>
                            <div class="col-8">
                                {{ $activity->tenggat_waktu ? date('d M Y', strtotime($activity->tenggat_waktu)) : 'Belum ditetapkan' }}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-muted">Prioritas:</div>
                            <div class="col-8">
                                @php
                                    $priorityText = 'Rendah';
                                    $priorityClass = 'bg-info';

                                    if ($activity->prioritas == 'sedang') {
                                        $priorityText = 'Sedang';
                                        $priorityClass = 'bg-warning';
                                    } elseif ($activity->prioritas == 'tinggi') {
                                        $priorityText = 'Tinggi';
                                        $priorityClass = 'bg-danger';
                                    } elseif ($activity->prioritas == 'kritikal') {
                                        $priorityText = 'Kritikal';
                                        $priorityClass = 'bg-dark';
                                    }
                                @endphp
                                <span class="badge {{ $priorityClass }}">{{ $priorityText }}</span>
                            </div>
                        </div>
                        @if ($activity->dependency_id)
                            <div class="row mb-3">
                                <div class="col-4 text-muted">Dependency:</div>
                                <div class="col-8">
                                    @php
                                        $dependencyName = '';
                                        foreach ($activities as $depActivity) {
                                            if ($depActivity->id == $activity->dependency_id) {
                                                $dependencyName = $depActivity->nama;
                                                break;
                                            }
                                        }
                                    @endphp
                                    {{ $dependencyName }}
                                </div>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-4 text-muted">Nilai:</div>
                            <div class="col-8">
                                @if ($activity->nilai)
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $activity->nilai ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                @else
                                    Belum dinilai
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editActivityModal{{ $activity->id }}" data-bs-dismiss="modal">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/dataTables.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/custom/aktivitas/update-field.js') }}"></script>

    <script>
        // project data table
        $(document).ready(function() {
            // Inisialisasi DataTables dengan Responsive
            var table = $('#myProjectTable')
                .addClass('nowrap')
                .DataTable({
                    responsive: true,
                    columnDefs: [{
                        targets: [-1, -3],
                        className: 'dt-body-right'
                    }]
                });

            // Observer untuk memantau perubahan pada tabel
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    // Cek apakah ada elemen child yang ditambahkan
                    if (mutation.addedNodes.length > 0) {
                        mutation.addedNodes.forEach(node => {
                            if (node.nodeType === 1 && node.classList.contains('child')) {
                                // Dapatkan <tr> parent yang tepat
                                const parentRow = $(node).prev('tr.parent');
                                const parentDataId = parentRow.attr('data-id');

                                if (parentDataId) {
                                    // Tambahkan data-id dari parent ke <tr class="child">
                                    $(node).attr('data-id', parentDataId);
                                    console.log(
                                        `data-id ${parentDataId} ditambahkan ke .child`);
                                }
                            }
                        });
                    }
                });
            });

            // Pantau perubahan pada tabel
            observer.observe(document.querySelector('#myProjectTable tbody'), {
                childList: true,
                subtree: true
            });
        });
    </script>

    {{-- <script>
        // const activityId = row.getAttribute('data-id');

        var updateField =
            `{{ route('program-kerja.divisi.aktivitas.update', ['kode_ormawa' => $kode_ormawa, 'nama_program_kerja' => $prokerNama, 'id' => $namaDivisi->id_divisi, 'aktivitas_id' => $activityId]) }}?periode=$periode`;
    </script> --}}
@endsection
