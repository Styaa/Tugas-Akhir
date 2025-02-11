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
                            <a href="{{ route('alur-dana.jurusan') }}" title="Lihat alur dana jurusan"
                                class="btn btn-link text-decoration-none  rounded-1"><i
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
                            <a href="{{ route('alur-dana.kemahasiswaan') }}" title="Lihat alur dana kemahasiswaan"
                                class="btn btn-link text-decoration-none  rounded-1"><i
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

        <div class="col-md-6 col-lg-6 col-xl-12">
            <div class="card bg-primary">
                <div class="card-body row ">
                    <div class="col text-white">
                        <h1 class="mt-3 mb-0 fw-bold ">{{ $ormawas[0]['nama'] }}</h1>
                        <span class="">{{ $ormawas[0]['kode'] }}</span>
                    </div>
                    {{-- <div class="col">
                        <img class="img-fluid" src="{{ url('/') . '/images/interview.svg' }}" alt="interview">
                    </div> --}}
                    <div class="row mt-4">
                        <div class="col-12 col-md-7 col-lg-6 order-md-1 px-4 text-white">
                            <h3 class="fw-bold ">Visi</h3>
                            <p class="line-height-custom fs-6">{{ $ormawas[0]['visi'] }}</p>
                            <a class="btn bg-secondary text-light btn-lg lift" href="http://pixelwibes.com/" target="_blank">Free Inquire</a>
                        </div>
                        <div class="col-12 col-md-5 col-lg-6 order-md-2 ">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="mb-0 fw-bold ">Divisi Ormawa</h6>
                                </div>
                                <div class="card-body mem-list">
                                    @foreach ($divisiOrmawas as $divisi)
                                        <div class="timeline-item ti-danger border-bottom ms-2">
                                            <div class="d-flex">
                                                <div class="flex-fill ms-3">
                                                    <div class="mb-1"><strong><a href="#">{{ $divisi->keterangan }}</a></strong></div>
                                                    <span class="d-flex text-muted">{{ $divisi->nama }}</span>
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

        <div class="row clearfix g-3 mt-4">
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
                                        @foreach ($programKerjaTerdekats as $programKerjaTerdekat)
                                            <tr>
                                                <td>{{ $programKerjaTerdekat['nama'] }}</td>
                                                <td>{{ $programKerjaTerdekat['tanggal_mulai'] }} -
                                                    {{ $programKerjaTerdekat['tanggal_selesai'] }}</td>
                                                <td>{{ $programKerjaTerdekat['tempat'] }}</td>
                                            </tr>
                                        @endforeach
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
                                    @foreach ($programKerjaUsers as $programKerjaUser)
                                        <div class="col-md-6 col-sm-6">
                                            <div class="card">
                                                <div class="card-body ">
                                                    <i class="icofont-checked fs-3"></i>
                                                    <h6 class="mt-3 mb-0 fw-bold small-14">
                                                        {{ $programKerjaUser['nama_program_kerja'] }}</h6>
                                                    <span
                                                        class="text-muted">{{ $programKerjaUser['tanggal_mulai_program_kerja'] }}
                                                        -
                                                        {{ $programKerjaUser['tanggal_selesai_program_kerja'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- <div class="col-md-6 col-sm-6">
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
                                    </div> --}}
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
                                    @foreach ($aktivitasUsers as $aktivitasUser)
                                        <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                            <div class="d-flex align-items-center flex-fill">
                                                <img class="avatar lg rounded-circle img-thumbnail"
                                                    src="{{ url('/') . '/images/lg/avatar2.jpg' }}" alt="profile">
                                                <div class="d-flex flex-column ps-3">
                                                    <h6 class="fw-bold mb-0 small-14">{{ $aktivitasUser->nama }}</h6>
                                                    <span
                                                        class="text-muted">{{ $aktivitasUser->programKerja->nama }}</span>
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
