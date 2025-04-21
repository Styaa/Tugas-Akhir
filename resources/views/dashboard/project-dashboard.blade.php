@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div id="success-alert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
        <span id="success-message"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <!-- Body: Body -->
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header p-0 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold py-3 mb-0">Program Kerja
                            {{ $strukturOrmawa->divisiOrmawas->ormawa->tipe_ormawa }}
                            {{ $strukturOrmawa->divisiOrmawas->ormawa->nama }}
                            Periode {{ $strukturOrmawa->periodes_periode }}</h3>
                        <div class="d-flex py-2 project-tab flex-wrap w-sm-100">
                            @if (Auth::user()->jabatanOrmawa->nama === 'Ketua')
                                <button type="button" class="btn btn-dark w-sm-100" data-bs-toggle="modal"
                                    data-bs-target="#createproject"><i class="icofont-plus-circle me-2 fs-6"></i>Create
                                    Project</button>
                            @endif
                            <ul class="nav nav-tabs tab-body-header rounded ms-3 prtab-set w-sm-100" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#All-list"
                                        role="tab">All</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Started-list"
                                        role="tab">Started</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Approval-list"
                                        role="tab">Approval</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#Completed-list"
                                        role="tab">Completed</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!-- Row end  -->
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 flex-column">
                    <div class="tab-content mt-4">
                        <div class="tab-pane fade show active" id="All-list">
                            <div class="row g-3 gy-5 py-3 row-deck">
                                @foreach ($programKerjas as $program)
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between mt-5">
                                                    <div class="lesson_name">
                                                        <div class="project-block light-info-bg">
                                                            <i class="icofont-paint"></i>
                                                        </div>
                                                        <a
                                                            href=" {{ route('program-kerja.show', ['id' => $program->id, 'kode_ormawa' => $kode_ormawa]) }}?periode={{ $periode }} "><span
                                                                class="fs-6 project_name fw-bold">{{ $program->nama }}</span></a>
                                                        <h6 class="mb-0 small text-muted fw-bold ">{{ $program->deskripsi }}
                                                        </h6>
                                                    </div>
                                                    <div class="btn-group" role="group"
                                                        aria-label="Basic outlined example">
                                                        <button type="button" class="btn btn-outline-secondary edit-button"
                                                            data-bs-toggle="modal" data-id="{{ $program->id }}"
                                                            data-kode="{{ $kode_ormawa }}"><i
                                                                class="icofont-edit text-success"></i></button>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteproject{{ $program->id }}"><i
                                                                class="icofont-ui-delete text-danger"></i></button>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-list avatar-list-stacked pt-2">
                                                        {{-- @foreach ($program->anggota as $anggota)
                                                            <img class="avatar rounded-circle sm"
                                                                src="{{ url('/') . '/images/xs/' . $anggota->avatar }}"
                                                                alt="">
                                                        @endforeach --}}
                                                        <img class="avatar rounded-circle sm"
                                                            src="{{ url('/') . '/images/xs/' }}" alt="">
                                                        <span class="avatar rounded-circle text-center pointer sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#addUser {{ $program->id }}"><i
                                                                class="icofont-ui-add"></i></span>
                                                    </div>
                                                </div>
                                                <div class="row g-2 pt-4">
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="icofont-paper-clip"></i>
                                                            <span class="ms-2">{{ $program->lampiran_count }}
                                                                Attach</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="icofont-sand-clock"></i>
                                                            <span class="ms-2">{{ $program->tipe }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="icofont-group-students"></i>
                                                            <span class="ms-2">{{ $program->ketua_acara }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="icofont-ui-text-chat"></i>
                                                            <span class="ms-2">{{ $program->komentar_count }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dividers-block"></div>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <h4 class="small fw-bold mb-0">Progress</h4>
                                                    <span class="small light-danger-bg p-1 rounded"><i
                                                            class="icofont-ui-clock"></i> {{ $program->hari_tersisa }}
                                                        Days
                                                        Left</span>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-secondary" role="progressbar"
                                                        style="width: {{ $program->progress }}%"
                                                        aria-valuenow="{{ $program->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="deleteproject{{ $program->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="deleteProjectModalLabel{{ $program->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="deleteProjectModalLabel{{ $program->id }}">Hapus Program
                                                        Kerja</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center mb-4">
                                                        <i class="icofont-ui-delete text-danger display-4 mb-3"></i>
                                                        <h4 class="text-danger">Perhatian!</h4>
                                                        <p class="mb-0">Apakah Anda yakin ingin menghapus program kerja:
                                                        </p>
                                                        <p class="fw-bold">{{ $program->nama }}</p>
                                                        <p class="text-muted">Tindakan ini akan menghapus semua data
                                                            terkait program kerja ini, termasuk:</p>
                                                        <ul class="text-start text-muted">
                                                            <li>Dokumen dan berkas program kerja</li>
                                                            <li>Struktur kepanitiaan</li>
                                                            <li>Aktivitas dan tugas</li>
                                                            <li>Rapat dan notulensi</li>
                                                            <li>Anggaran dan evaluasi</li>
                                                        </ul>
                                                        <p class="text-danger small fw-bold">Tindakan ini tidak dapat
                                                            dibatalkan!</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <form
                                                        action="{{ route('program-kerja.destroy', ['kode_ormawa' => $kode_ormawa, 'id' => $program->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus Program
                                                            Kerja</button>
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
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/custom/modal/tambah_program_kerja.js') }}"></script>
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
@endsection
