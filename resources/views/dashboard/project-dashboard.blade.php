@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <!-- Alert for success messages -->
    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        <div class="d-flex align-items-center">
            <i class="icofont-check-circled me-2 fs-5"></i>
            <span id="success-message"></span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!-- Main Content -->
    <div class="body py-3">
        <div class="container-xxl">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div>
                                    <h2 class="fw-bold text-primary mb-1">Program Kerja</h2>
                                    <h5 class="text-muted mb-0">
                                        {{ $strukturOrmawa->divisiOrmawas->ormawa->nama }} -
                                        Periode {{ $strukturOrmawa->periodes_periode }}
                                    </h5>
                                </div>
                                <div class="d-flex align-items-center mt-3 mt-md-0">
                                    @if (Auth::user()->jabatanOrmawa->nama === 'Ketua' || Auth::user()->jabatanOrmawa->nama === 'Wakil Ketua')
                                        <button type="button" class="btn btn-primary px-4 d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#createproject">
                                            <i class="icofont-plus-circle me-2 fs-5"></i>
                                            <span>Create Project</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Cards -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content">
                        <div class="row g-4">
                            @foreach ($programKerjas as $program)
                                <div class="col-lg-4 col-md-6">
                                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                                        <div class="card-body p-4">
                                            <!-- Card Header -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="project-icon bg-primary bg-opacity-10 text-white rounded-circle p-3 me-3">
                                                        <i class="icofont-paint fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('program-kerja.show', ['id' => $program->id, 'kode_ormawa' => $kode_ormawa]) }}?periode={{ $periode }}"
                                                            class="text-decoration-none">
                                                            <h5 class="mb-1 fw-bold text-primary">{{ $program->nama }}
                                                            </h5>
                                                        </a>
                                                        <p class="mb-0 text-muted small">
                                                            {{ Str::limit($program->deskripsi, 60) }}</p>
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light rounded-circle" type="button"
                                                        data-bs-toggle="dropdown">
                                                        <i class="icofont-ui-settings"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <button
                                                                class="dropdown-item d-flex align-items-center edit-button"
                                                                data-bs-toggle="modal" data-id="{{ $program->id }}"
                                                                data-kode="{{ $kode_ormawa }}">
                                                                <i class="icofont-edit text-primary me-2"></i> Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item d-flex align-items-center"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteproject{{ $program->id }}">
                                                                <i class="icofont-ui-delete text-danger me-2"></i>
                                                                Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Team Members -->
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0 text-muted">Team Members</h6>
                                                    <span class="badge bg-primary bg-opacity-10 py-1 px-2">
                                                        {{ $program->tipe }}
                                                    </span>
                                                </div>
                                                <div class="avatar-list avatar-list-stacked">
                                                    <img class="avatar rounded-circle sm"
                                                        src="{{ url('/') . '/images/xs/' }}" alt="">
                                                    <span class="avatar rounded-circle text-center pointer sm bg-light"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#addUser{{ $program->id }}">
                                                        <i class="icofont-ui-add text-primary"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Project Details -->
                                            <div class="row g-3 mb-4">
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-circle bg-light rounded-circle p-1 me-2">
                                                            <i class="icofont-paper-clip text-primary small"></i>
                                                        </div>
                                                        <span class="text-muted small">{{ $program->lampiran_count }}
                                                            Files</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-circle bg-light rounded-circle p-1 me-2">
                                                            <i class="icofont-group-students text-primary small"></i>
                                                        </div>
                                                        <span class="text-muted small">{{ $program->ketua_acara }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-circle bg-light rounded-circle p-1 me-2">
                                                            <i class="icofont-sand-clock text-primary small"></i>
                                                        </div>
                                                        <span class="text-muted small">{{ $program->hari_tersisa }}
                                                            Days Left</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <div class="icon-circle bg-light rounded-circle p-1 me-2">
                                                            <i class="icofont-ui-text-chat text-primary small"></i>
                                                        </div>
                                                        <span class="text-muted small">{{ $program->komentar_count }}
                                                            Comments</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Progress -->
                                            <div>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">Progress</h6>
                                                    <span
                                                        class="badge {{ $program->progress < 50 ? 'bg-danger' : ($program->progress < 75 ? 'bg-warning' : 'bg-success') }} py-1 px-2">
                                                        {{ $program->progress }}%
                                                    </span>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar {{ $program->progress < 50 ? 'bg-danger' : ($program->progress < 75 ? 'bg-warning' : 'bg-success') }}"
                                                        role="progressbar" style="width: {{ $program->progress }}%"
                                                        aria-valuenow="{{ $program->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteproject{{ $program->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="deleteProjectModalLabel{{ $program->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-danger bg-opacity-10 border-0">
                                                <h5 class="modal-title text-danger"
                                                    id="deleteProjectModalLabel{{ $program->id }}">
                                                    <i class="icofont-ui-delete me-2"></i>Hapus Program Kerja
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="text-center mb-4">
                                                    <div class="warning-icon mb-3">
                                                        <i class="icofont-warning-alt text-danger display-1"></i>
                                                    </div>
                                                    <h4 class="text-danger mb-3">Perhatian!</h4>
                                                    <p class="mb-1">Apakah Anda yakin ingin menghapus program kerja:
                                                    </p>
                                                    <p class="fw-bold fs-5 mb-3">{{ $program->nama }}</p>
                                                    <div class="alert alert-warning">
                                                        <p class="small mb-2">Tindakan ini akan menghapus semua data
                                                            terkait:</p>
                                                        <ul class="text-start small mb-0">
                                                            <li>Dokumen dan berkas program kerja</li>
                                                            <li>Struktur kepanitiaan</li>
                                                            <li>Aktivitas dan tugas</li>
                                                            <li>Rapat dan notulensi</li>
                                                            <li>Anggaran dan evaluasi</li>
                                                        </ul>
                                                    </div>
                                                    <div class="alert alert-danger py-2 mt-3">
                                                        <p class="small fw-bold mb-0">Tindakan ini tidak dapat
                                                            dibatalkan!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0">
                                                <button type="button" class="btn btn-light px-4"
                                                    data-bs-dismiss="modal">
                                                    <i class="icofont-close me-1"></i> Batal
                                                </button>
                                                <form
                                                    action="{{ route('program-kerja.destroy', ['kode_ormawa' => $kode_ormawa, 'id' => $program->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4">
                                                        <i class="icofont-ui-delete me-1"></i> Hapus Program Kerja
                                                    </button>
                                                </form>
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

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title" id="errorModalLabel">Data Belum Lengkap</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Mohon lengkapi data berikut:</p>
              <ul id="errorList"></ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
            </div>
          </div>
        </div>
      </div>

    <!-- Jquery Page JS -->
    <script src="{{ asset('assets/custom/modal/tambah_program_kerja.js') }}"></script>
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check if there are validation errors from Laravel
        @if(session('validation_errors'))
            var validationErrors = @json(session('validation_errors'));
        @endif
    </script>
@endsection
