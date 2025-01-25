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

        <div class="col-xl-8 col-lg-12 col-md-12 flex-column">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Employees Availability</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2 row-deck">
                                <div class="col-md-6 col-sm-6">
                                    <div class="card">
                                        <div class="card-body ">
                                            <i class="icofont-checked fs-3"></i>
                                            <h6 class="mt-3 mb-0 fw-bold small-14">Attendance</h6>
                                            <span class="text-muted">400</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="card">
                                        <div class="card-body ">
                                            <i class="icofont-stopwatch fs-3"></i>
                                            <h6 class="mt-3 mb-0 fw-bold small-14">Late Coming</h6>
                                            <span class="text-muted">17</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="card">
                                        <div class="card-body ">
                                            <i class="icofont-ban fs-3"></i>
                                            <h6 class="mt-3 mb-0 fw-bold small-14">Absent</h6>
                                            <span class="text-muted">06</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="card">
                                        <div class="card-body ">
                                            <i class="icofont-beach-bed fs-3"></i>
                                            <h6 class="mt-3 mb-0 fw-bold small-14">Leave Apply</h6>
                                            <span class="text-muted">14</span>
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

        <!-- Notifications -->
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">Notifikasi Penting</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">Proposal <strong>Studi Ekskursi</strong> mendekati tenggat waktu!
                            </li>
                            <li class="list-group-item">Rapat koordinasi divisi desain dijadwalkan pada <strong>30 Januari
                                    2025</strong>.</li>
                            <li class="list-group-item">LPJ untuk <strong>Informatics Gathering</strong> belum diajukan.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">Kegiatan Mendatang</h6>
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
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/page/hr.js') }}"></script>
@endsection
