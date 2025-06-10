@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card border-0 mb-4 no-bg">
                        <div class="card-header py-3 px-0 d-flex align-items-center  justify-content-between border-bottom">
                            <h3 class=" fw-bold flex-fill mb-0">Member Profile</h3>
                        </div>
                    </div>
                </div>
            </div><!-- Row End -->
            <div class="row g-3">
                <div class="col-xl-8 col-lg-12 col-md-12">
                    <div class="card teacher-card  mb-3">
                        <div class="card-body  d-flex teacher-fulldeatil">
                            <div class="profile-teacher pe-xl-4 pe-md-2 pe-sm-4 pe-0 text-center w220 mx-sm-0 mx-auto">
                                <a href="#">
                                    <img src="{{ url('/') . '/images/lg/avatar3.jpg' }}" alt=""
                                        class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                </a>
                                <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                                    <h6 class="mb-0 fw-bold d-block fs-6">{{ $divisiUser->divisiOrmawas->nama }}</h6>
                                    <span class="text-muted small">Member Id : {{ $anggotaOrmawa->id }}</span>
                                </div>
                            </div>
                            <div class="teacher-info border-start ps-xl-4 ps-md-3 ps-sm-4 ps-4 w-100">
                                <h6 class="mb-0 mt-2  fw-bold d-block fs-6">{{ $anggotaOrmawa->name }}</h6>
                                <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted">{{ $divisiUser->jabatan->nama }}
                                    {{ $divisiUser->divisiOrmawas->nama }}</span>
                                <p class="mt-2 small">The purpose of lorem ipsum is to create a natural looking block of
                                    text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice
                                    not without controversy</p>
                                <div class="row g-2 pt-2">
                                    <div class="col-xl-5">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-ui-touch-phone"></i>
                                            <span class="ms-2 small">{{ $anggotaOrmawa->nrp }} </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-email"></i>
                                            <span class="ms-2 small">{{ $anggotaOrmawa->email }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="icofont-birthday-cake"></i>
                                        <span class="ms-2 small">19/03/1980</span>
                                    </div>
                                    {{-- <div class="col-xl-5">
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-address-book"></i>
                                            <span class="ms-2 small">2734 West Fork Street,EASTON 02334.</span>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($evaluasiUsers && $evaluasiUsers->count() > 0)
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold py-3 mb-3">Evaluation Results</h6>
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Performance Evaluations</h6>
                                        <span class="badge bg-primary">{{ $evaluasiUsers->count() }} Evaluations</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Program Kerja</th>
                                                        <th>Score & Kategori</th>
                                                        <th>Periode</th>
                                                        <th>Tahun</th>
                                                        <th>Tanggal</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($evaluasiUsers as $evaluasi)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex flex-column">
                                                                    <span
                                                                        class="fw-bold small">{{ $evaluasi['program_kerja'] }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $score = $evaluasi['score'];
                                                                    $badgeClass = 'bg-secondary';
                                                                    $kategori = 'Belum Dinilai';

                                                                    if ($score >= 0.8) {
                                                                        $badgeClass = 'bg-success';
                                                                        $kategori = 'Sangat Baik';
                                                                    } elseif ($score >= 0.6) {
                                                                        $badgeClass = 'bg-primary';
                                                                        $kategori = 'Baik';
                                                                    } elseif ($score >= 0.4) {
                                                                        $badgeClass = 'bg-warning';
                                                                        $kategori = 'Cukup';
                                                                    } elseif ($score >= 0.2) {
                                                                        $badgeClass = 'bg-danger';
                                                                        $kategori = 'Kurang';
                                                                    } elseif ($score > 0) {
                                                                        $badgeClass = 'bg-dark';
                                                                        $kategori = 'Sangat Kurang';
                                                                    }
                                                                @endphp
                                                                <span class="badge {{ $badgeClass }}">
                                                                    {{ $score > 0 ? number_format($score * 100, 1) . '%' : 'N/A' }}
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">{{ $kategori }}</small>
                                                                <br>
                                                                <small
                                                                    class="text-muted">({{ number_format($score, 3) }})</small>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-light text-dark">{{ $evaluasi['periode'] }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="small">{{ $evaluasi['tahun'] }}</span>
                                                            </td>
                                                            <td>
                                                                <small
                                                                    class="text-muted">{{ $evaluasi['tanggal_evaluasi'] }}</small>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-success">{{ $evaluasi['status'] }}</span>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#evaluationDetail{{ $evaluasi['id'] }}">
                                                                    <i class="icofont-eye"></i> Detail
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal untuk Detail Evaluasi -->
                        @foreach ($evaluasiUsers as $evaluasi)
                            <div class="modal fade" id="evaluationDetail{{ $evaluasi['id'] }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Evaluasi - {{ $evaluasi['program_kerja'] }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <!-- Informasi Umum -->
                                                <div class="col-12">
                                                    <h6 class="fw-bold border-bottom pb-2">Informasi Umum</h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Program Kerja:</label>
                                                    <p class="mb-2">{{ $evaluasi['program_kerja'] }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Periode:</label>
                                                    <p class="mb-2">{{ $evaluasi['periode'] }}</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Tahun:</label>
                                                    <p class="mb-2">{{ $evaluasi['tahun'] }}</p>
                                                </div>

                                                <!-- Score Total -->
                                                <div class="col-12 mt-4">
                                                    <h6 class="fw-bold border-bottom pb-2">Score Total</h6>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    @php
                                                        $score = $evaluasi['score'];
                                                        $badgeClass = 'bg-secondary';
                                                        $textClass = 'text-muted';
                                                        $kategori = 'Belum Dinilai';
                                                        $rentang = '-';

                                                        if ($score >= 0.8) {
                                                            $badgeClass = 'bg-success';
                                                            $textClass = 'text-success';
                                                            $kategori = 'Sangat Baik';
                                                            $rentang = '0.8 - 1.0';
                                                        } elseif ($score >= 0.6) {
                                                            $badgeClass = 'bg-primary';
                                                            $textClass = 'text-primary';
                                                            $kategori = 'Baik';
                                                            $rentang = '0.6 - 0.79';
                                                        } elseif ($score >= 0.4) {
                                                            $badgeClass = 'bg-warning';
                                                            $textClass = 'text-warning';
                                                            $kategori = 'Cukup';
                                                            $rentang = '0.4 - 0.59';
                                                        } elseif ($score >= 0.2) {
                                                            $badgeClass = 'bg-danger';
                                                            $textClass = 'text-danger';
                                                            $kategori = 'Kurang';
                                                            $rentang = '0.2 - 0.39';
                                                        } elseif ($score > 0) {
                                                            $badgeClass = 'bg-dark';
                                                            $textClass = 'text-dark';
                                                            $kategori = 'Sangat Kurang';
                                                            $rentang = '0.0 - 0.19';
                                                        }
                                                    @endphp
                                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                                        <div class="text-center">
                                                            <div style="font-size: 3rem; font-weight: bold;"
                                                                class="{{ $textClass }}">
                                                                {{ $score > 0 ? number_format($score * 100, 1) . '%' : 'N/A' }}
                                                            </div>
                                                            <div class="text-muted mb-2">
                                                                Raw Score: {{ number_format($score, 4) }}
                                                            </div>
                                                            <span class="badge {{ $badgeClass }} fs-6">
                                                                {{ $kategori }}
                                                            </span>
                                                            <div class="mt-2">
                                                                <small class="text-muted">
                                                                    Rentang: {{ $rentang }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Detail Penilaian -->
                                                <div class="col-12 mt-4">
                                                    <h6 class="fw-bold border-bottom pb-2">Detail Penilaian</h6>
                                                </div>

                                                <!-- Raw Scores -->
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold mb-3">Nilai Asli</h6>
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Kehadiran:</span>
                                                                <span
                                                                    class="badge bg-primary">{{ $evaluasi['kehadiran'] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Kontribusi:</span>
                                                                <span
                                                                    class="badge bg-primary">{{ $evaluasi['kontribusi'] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Tanggung Jawab:</span>
                                                                <span
                                                                    class="badge bg-primary">{{ $evaluasi['tanggung_jawab'] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Kualitas:</span>
                                                                <span
                                                                    class="badge bg-primary">{{ $evaluasi['kualitas'] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Penilaian Atasan:</span>
                                                                <span
                                                                    class="badge bg-primary">{{ $evaluasi['penilaian_atasan'] }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Normalized Scores -->
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold mb-3">Nilai Normalized</h6>
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Kehadiran:</span>
                                                                <div class="text-end">
                                                                    <span
                                                                        class="badge bg-success">{{ number_format($evaluasi['kehadiran_normalized'] * 100, 1) }}%</span>
                                                                    <br><small
                                                                        class="text-muted">({{ number_format($evaluasi['kehadiran_normalized'], 4) }})</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Kontribusi:</span>
                                                                <div class="text-end">
                                                                    <span
                                                                        class="badge bg-success">{{ number_format($evaluasi['kontribusi_normalized'] * 100, 1) }}%</span>
                                                                    <br><small
                                                                        class="text-muted">({{ number_format($evaluasi['kontribusi_normalized'], 4) }})</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Tanggung Jawab:</span>
                                                                <div class="text-end">
                                                                    <span
                                                                        class="badge bg-success">{{ number_format($evaluasi['tanggung_jawab_normalized'] * 100, 1) }}%</span>
                                                                    <br><small
                                                                        class="text-muted">({{ number_format($evaluasi['tanggung_jawab_normalized'], 4) }})</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Kualitas:</span>
                                                                <div class="text-end">
                                                                    <span
                                                                        class="badge bg-success">{{ number_format($evaluasi['kualitas_normalized'] * 100, 1) }}%</span>
                                                                    <br><small
                                                                        class="text-muted">({{ number_format($evaluasi['kualitas_normalized'], 4) }})</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                                <span class="fw-bold">Penilaian Atasan:</span>
                                                                <div class="text-end">
                                                                    <span
                                                                        class="badge bg-success">{{ number_format($evaluasi['penilaian_atasan_normalized'] * 100, 1) }}%</span>
                                                                    <br><small
                                                                        class="text-muted">({{ number_format($evaluasi['penilaian_atasan_normalized'], 4) }})</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Progress Bars untuk Visual -->
                                                <div class="col-12 mt-4">
                                                    <h6 class="fw-bold border-bottom pb-2">Progress Visual</h6>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Kehadiran</label>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar bg-primary" role="progressbar"
                                                                    style="width: {{ $evaluasi['kehadiran_normalized'] * 100 }}%">
                                                                    {{ number_format($evaluasi['kehadiran_normalized'] * 100, 1) }}%
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">Raw:
                                                                {{ number_format($evaluasi['kehadiran_normalized'], 4) }}</small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Kontribusi</label>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar bg-success" role="progressbar"
                                                                    style="width: {{ $evaluasi['kontribusi_normalized'] * 100 }}%">
                                                                    {{ number_format($evaluasi['kontribusi_normalized'] * 100, 1) }}%
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">Raw:
                                                                {{ number_format($evaluasi['kontribusi_normalized'], 4) }}</small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Tanggung Jawab</label>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: {{ $evaluasi['tanggung_jawab_normalized'] * 100 }}%">
                                                                    {{ number_format($evaluasi['tanggung_jawab_normalized'] * 100, 1) }}%
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">Raw:
                                                                {{ number_format($evaluasi['tanggung_jawab_normalized'], 4) }}</small>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label small fw-bold">Kualitas</label>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                    style="width: {{ $evaluasi['kualitas_normalized'] * 100 }}%">
                                                                    {{ number_format($evaluasi['kualitas_normalized'] * 100, 1) }}%
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">Raw:
                                                                {{ number_format($evaluasi['kualitas_normalized'], 4) }}</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <label class="form-label small fw-bold">Penilaian Atasan</label>
                                                    <div class="progress" style="height: 25px;">
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                            style="width: {{ $evaluasi['penilaian_atasan_normalized'] * 100 }}%">
                                                            {{ number_format($evaluasi['penilaian_atasan_normalized'] * 100, 1) }}%
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">Raw:
                                                        {{ number_format($evaluasi['penilaian_atasan_normalized'], 4) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <h6 class="fw-bold  py-3 mb-3">Current Work Project</h6>
                    <div class="teachercourse-list">
                        <div class="row g-3 gy-5 py-3 row-deck">
                            @foreach ($programKerjaUsers as $programKerjaUser)
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between mt-5">
                                                <div class="lesson_name">
                                                    <div class="project-block light-info-bg">
                                                        <i class="icofont-paint"></i>
                                                    </div>
                                                    <a
                                                        href=" {{ route('program-kerja.show', ['id' => $programKerjaUser['id_program_kerja'], 'kode_ormawa' => $kode_ormawa]) }}?periode={{ $periode }} "><span
                                                            class="fs-6 project_name fw-bold">{{ $programKerjaUser['nama_program_kerja'] }}</span></a>
                                                    <h6 class="mb-0 small text-muted fw-bold ">
                                                        {{ $programKerjaUser['deskripsi_program_kerja'] }}
                                                    </h6>
                                                </div>
                                                <div class="btn-group" role="group"
                                                    aria-label="Basic outlined example">
                                                    <button type="button" class="btn btn-outline-secondary edit-button"
                                                        data-bs-toggle="modal"
                                                        data-id="{{ $programKerjaUser['id_program_kerja'] }}"
                                                        data-kode="{{ $kode_ormawa }}"><i
                                                            class="icofont-edit text-success"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteproject{{ $programKerjaUser['id_program_kerja'] }}"><i
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
                                                        data-bs-target="#addUser {{ $programKerjaUser['id_program_kerja'] }}"><i
                                                            class="icofont-ui-add"></i></span>
                                                </div>
                                            </div>
                                            <div class="row g-2 pt-4">
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-paper-clip"></i>
                                                        <span class="ms-2">0
                                                            Attach</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-sand-clock"></i>
                                                        <span
                                                            class="ms-2">{{ $programKerjaUser['tipe_program_kerja'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-group-students"></i>
                                                        <span class="ms-2">{{ $programKerjaUser['ketua_acara'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="icofont-ui-text-chat"></i>
                                                        <span class="ms-2">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dividers-block"></div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <h4 class="small fw-bold mb-0">Progress</h4>
                                                <span class="small light-danger-bg p-1 rounded"><i
                                                        class="icofont-ui-clock"></i>
                                                    Days
                                                    Left</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-secondary" role="progressbar"
                                                    style="width: 25%" aria-valuenow="15" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                                <div class="progress-bar bg-secondary ms-1" role="progressbar"
                                                    style="width: 25%" aria-valuenow="30" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                                <div class="progress-bar bg-secondary ms-1" role="progressbar"
                                                    style="width: 10%" aria-valuenow="10" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header py-3 d-flex justify-content-between">
                                    <h6 class="mb-0 fw-bold ">Personal Informations</h6>
                                    <button type="button" class="btn p-0" data-bs-toggle="modal"
                                        data-bs-target="#edit1"><i class="icofont-edit text-primary fs-6"></i></button>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Tanggal Lahir</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">---</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">ID Line</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $anggotaOrmawa->id_line }}</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">Instagram</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">---</span>
                                            </div>
                                        </li>
                                        <li class="row flex-wrap mb-3">
                                            <div class="col-6">
                                                <span class="fw-bold">WhatsApp</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted">{{ $anggotaOrmawa->no_hp }}</span>
                                            </div>
                                        </li>
                                        @if (Auth::user()->jabatanOrmawa->id !== 13)
                                            <li class="row flex-wrap">
                                                <div class="col-6">
                                                    <span class="fw-bold">Jabatan</span>
                                                </div>
                                                <div class="col-6">
                                                    <span class="text-muted">{{ $divisiUser->jabatan->nama }}</span>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12 col-md-12">
                    <div class="card mb-3">
                        <div class="card-header py-3">
                            <h6 class="mb-0 fw-bold ">Current Task</h6>
                        </div>
                        <div class="card-body">
                            <div class="flex-grow-1">
                                @foreach ($aktivitasUsers as $aktivitasUser)
                                    <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                        <div class="d-flex align-items-center flex-fill">
                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                src="{{ url('/') . '/images/lg/avatar2.jpg' }}" alt="profile">
                                            <div class="d-flex flex-column ps-3">
                                                <h6 class="fw-bold mb-0 small-14 w-4">{{ $aktivitasUser->nama }}</h6>
                                                <span class="text-muted">{{ $aktivitasUser->programKerja->nama }}</span>
                                            </div>
                                        </div>
                                        <div class="time-block text-truncate">
                                            <i class="icofont-clock-time"></i>
                                            {{ $aktivitasUser->tenggat_waktu ? \Carbon\Carbon::parse($aktivitasUser->tenggat_waktu)->locale('id')->translatedFormat('l, d F Y') : 'Deadline belum diatur' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Row End -->
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>

    <script src="{{ asset('js/template.js') }}"></script>
@endsection
