@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container-xxl py-4">
        <!-- Summary Card -->
        <div class="row g-3 mb-4 row-deck">
            <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar lg  rounded-1 no-thumbnail bg-lightyellow color-defult"><i
                                    class="bi bi-journal-check fs-4"></i></div>
                            <div class="flex-fill ms-4">
                                <div class="">Lihat Alur Pengurusan Dana Jurusan</div>
                            </div>
                            <a href="" title="view-members" class="btn btn-link text-decoration-none  rounded-1"><i
                                    class="icofont-hand-drawn-right fs-2 "></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar lg  rounded-1 no-thumbnail bg-lightblue color-defult"><i
                                    class="bi bi-list-check fs-4"></i></div>
                            <div class="flex-fill ms-4">
                                <div class="">Lihat Alur Pengurusan Dana Kemahasiwaan</div>
                            </div>
                            <a href="" title="space-used" class="btn btn-link text-decoration-none  rounded-1"><i
                                    class="icofont-hand-drawn-right fs-2 "></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                <div class="card ">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar lg  rounded-1 no-thumbnail bg-lightgreen color-defult"><i
                                    class="bi bi-clipboard-data fs-4"></i></div>
                            <div class="flex-fill ms-4">
                                <div class="">Proposal/LPJ Telat</div>
                                <h5 class="mb-0 ">74</h5>
                            </div>
                            <a href="" title="renewal-date" class="btn btn-link text-decoration-none  rounded-1"><i
                                    class="icofont-hand-drawn-right fs-2 "></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-xl-8 col-lg-12 col-md-12 flex-column">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                <h6 class="mb-0 fw-bold ">Kegiatan Mendatang</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama Kegiatan</th>
                                            <th>Tanggal</th>
                                            <th>Lokasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Studi Ekskursi</td>
                                            <td>16-20 Desember 2024</td>
                                            <td>Bali</td>
                                        </tr>
                                        <tr>
                                            <td>Informatics Gathering</td>
                                            <td>10 Februari 2025</td>
                                            <td>Kampus UBAYA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                <h6 class="mb-0 fw-bold ">Program Kerja Anda</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2 row-deck">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="card">
                                            <div class="card-body ">
                                                <i class="icofont-checked fs-3"></i>
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Informatics Gathering</h6>
                                                <span class="text-muted">12 Maret 2023 - 13 Maret 2023</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="card">
                                            <div class="card-body ">
                                                <i class="icofont-stopwatch fs-3"></i>
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Studi Ekskursi</h6>
                                                <span class="text-muted">12 Maret 2023 - 13 Maret 2023</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                <h6 class="mb-0 fw-bold ">Status Program Kerja</h6>
                                <h4 class="mb-0 fw-bold ">4</h4>
                            </div>
                            <div class="card-body">
                                <div class="mt-3" id="apex-StatisticProker"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-12">
                <div class="row g-3 row-deck">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                <h6 class="mb-0 fw-bold ">Aktivitas Anda</h6>
                            </div>
                            <div class="card-body">
                                <div class="flex-grow-1">
                                    <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                        <div class="d-flex align-items-center flex-fill">
                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                src="{{ url('/') . '/images/lg/avatar2.jpg' }}" alt="profile">
                                            <div class="d-flex flex-column ps-3">
                                                <h6 class="fw-bold mb-0 small-14">Beli galon</h6>
                                                <span class="text-muted">Informatics Gathering</span>
                                            </div>
                                        </div>
                                        <div class="time-block text-truncate">
                                            <i class="icofont-clock-time"></i> Rabu, 19 Maret 2023
                                        </div>
                                    </div>
                                    <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                        <div class="d-flex align-items-center flex-fill">
                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                src="{{ url('/') . '/images/lg/avatar9.jpg' }}" alt="profile">
                                            <div class="d-flex flex-column ps-3">
                                                <h6 class="fw-bold mb-0 small-14">Peter Piperg</h6>
                                                <span class="text-muted">Web Design</span>
                                            </div>
                                        </div>
                                        <div class="time-block text-truncate">
                                            <i class="icofont-clock-time"></i> 9.00 - 1:30
                                        </div>
                                    </div>
                                    <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                        <div class="d-flex align-items-center flex-fill">
                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                src="{{ url('/') . '/images/lg/avatar12.jpg' }}" alt="profile">
                                            <div class="d-flex flex-column ps-3">
                                                <h6 class="fw-bold mb-0 small-14">Robert Young</h6>
                                                <span class="text-muted">PHP Developer</span>
                                            </div>
                                        </div>
                                        <div class="time-block text-truncate">
                                            <i class="icofont-clock-time"></i> 1.30 - 2:30
                                        </div>
                                    </div>
                                    <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                        <div class="d-flex align-items-center flex-fill">
                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                src="{{ url('/') . '/images/lg/avatar8.jpg' }}" alt="profile">
                                            <div class="d-flex flex-column ps-3">
                                                <h6 class="fw-bold mb-0 small-14">Victoria Vbell</h6>
                                                <span class="text-muted">IOS Developer</span>
                                            </div>
                                        </div>
                                        <div class="time-block text-truncate">
                                            <i class="icofont-clock-time"></i> 2.00 - 3:30
                                        </div>
                                    </div>
                                    <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                        <div class="d-flex align-items-center flex-fill">
                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                src="{{ url('/') . '/images/lg/avatar7.jpg' }}" alt="profile">
                                            <div class="d-flex flex-column ps-3">
                                                <h6 class="fw-bold mb-0 small-14">Mary Butler</h6>
                                                <span class="text-muted">Writer</span>
                                            </div>
                                        </div>
                                        <div class="time-block text-truncate">
                                            <i class="icofont-clock-time"></i> 4.00 - 4:30
                                        </div>
                                    </div>
                                    <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                        <div class="d-flex align-items-center flex-fill">
                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                src="{{ url('/') . '/images/lg/avatar3.jpg' }}" alt="profile">
                                            <div class="d-flex flex-column ps-3">
                                                <h6 class="fw-bold mb-0 small-14">Youn Bel</h6>
                                                <span class="text-muted">Unity 3d</span>
                                            </div>
                                        </div>
                                        <div class="time-block text-truncate">
                                            <i class="icofont-clock-time"></i> 7.00 - 8.00
                                        </div>
                                    </div>
                                    <div class="py-2 d-flex align-items-center  flex-wrap">
                                        <div class="d-flex align-items-center flex-fill">
                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                src="{{ url('/') . '/images/lg/avatar2.jpg' }}" alt="profile">
                                            <div class="d-flex flex-column ps-3">
                                                <h6 class="fw-bold mb-0 small-14">Gibson Butler</h6>
                                                <span class="text-muted">Networking</span>
                                            </div>
                                        </div>
                                        <div class="time-block text-truncate">
                                            <i class="icofont-clock-time"></i> 8.00 - 9.00
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-12  flex-column">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-fill">
                                    <span
                                        class="avatar lg light-success-bg rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                            class="icofont-users-alt-2 fs-5"></i></span>
                                    <div class="d-flex flex-column ps-3  flex-fill">
                                        <h6 class="fw-bold mb-0 fs-4">BPH</h6>
                                        <span class="text-muted">badan Pengurus Harian</span>
                                    </div>
                                    <span class="fs-3 text-muted">4</span>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-fill">
                                    <span
                                        class="avatar lg light-success-bg rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                            class="icofont-users-alt-2 fs-5"></i></span>
                                    <div class="d-flex flex-column ps-3  flex-fill">
                                        <h6 class="fw-bold mb-0 fs-4">IRD</h6>
                                        <span class="text-muted">Internal Relation Department</span>
                                    </div>
                                    <span class="fs-3 text-muted">6</span>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-fill">
                                    <span
                                        class="avatar lg light-success-bg rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                            class="icofont-users-alt-2 fs-5"></i></span>
                                    <div class="d-flex flex-column ps-3  flex-fill">
                                        <h6 class="fw-bold mb-0 fs-4">PRD</h6>
                                        <span class="text-muted">Public Relation Department</span>
                                    </div>
                                    <span class="fs-3 text-muted">5</span>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-fill">
                                    <span
                                        class="avatar lg light-success-bg rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                            class="icofont-users-alt-2 fs-5"></i></span>
                                    <div class="d-flex flex-column ps-3  flex-fill">
                                        <h6 class="fw-bold mb-0 fs-4">CDD</h6>
                                        <span class="text-muted">Creative Design Department</span>
                                    </div>
                                    <span class="fs-3 text-muted">4</span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-fill">
                                    <span
                                        class="avatar lg light-success-bg rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                            class="icofont-holding-hands fs-5"></i></span>
                                    <div class="d-flex flex-column ps-3 flex-fill">
                                        <h6 class="fw-bold mb-0 fs-4">HRDD</h6>
                                        <span class="text-muted">Human Resource Development Department</span>
                                    </div>
                                    <span class="fs-3 text-muted">4</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Visualizations -->
        <div class="row mt-4 g-4">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">Aktivitas Divisi</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tugas Divisi Kritikal
                                <span class="badge bg-danger rounded-pill">5</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tugas Selesai
                                <span class="badge bg-success rounded-pill">12</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tugas Overdue
                                <span class="badge bg-warning rounded-pill">3</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/page/hr.js') }}"></script>
@endsection
