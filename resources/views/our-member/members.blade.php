@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card border-0 mb-4 no-bg">
                        <div
                            class="card-header py-3 px-0 d-sm-flex align-items-center  justify-content-between border-bottom">
                            <h3 class=" fw-bold flex-fill mb-0 mt-sm-0">Anggota </h3>
                            {{-- <button type="button" class="btn btn-dark me-1 mt-1 w-sm-100" data-bs-toggle="modal" data-bs-target="#createemp"><i class="icofont-plus-circle me-2 fs-6"></i>Add Employee</button> --}}
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mt-1  w-sm-100" type="button"
                                    id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    Status
                                </button>
                                <ul class="dropdown-menu  dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="#">All</a></li>
                                    <li><a class="dropdown-item" href="#">Task Assign Members</a></li>
                                    <li><a class="dropdown-item" href="#">Not Assign Members</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Row End -->
            <div
                class="row g-3 row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-2 row-deck py-1 pb-4">
                @foreach ($anggotas as $anggota)
                    <div class="col">
                        <div class="card teacher-card">
                            <div class="card-body d-flex">
                                <div class="profile-av pe-xl-4 pe-md-2 pe-sm-4 pe-4 text-center w220">
                                    <img src="{{ url('/') . '/images/lg/avatar3.jpg' }}" alt=""
                                        class="avatar xl rounded-circle img-thumbnail shadow-sm">
                                    {{-- <div class="about-info d-flex align-items-center mt-3 justify-content-center">
                                            <div class="followers me-2">
                                                <i class="icofont-tasks color-careys-pink fs-4"></i>
                                                <span class="">04</span>
                                            </div>
                                            <div class="star me-2">
                                                <i class="icofont-star text-warning fs-4"></i>
                                                <span class="">4.5</span>
                                            </div>
                                            <div class="own-video">
                                                <i class="icofont-data color-light-orange fs-4"></i>
                                                <span class="">04</span>
                                            </div>
                                        </div> --}}
                                </div>
                                <div class="teacher-info border-start ps-xl-4 ps-md-3 ps-sm-4 ps-4 w-100">
                                    <h6 class="mb-0 mt-2  fw-bold d-block fs-6">{{ $anggota->name }}</h6>
                                    <span
                                        class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-11 mb-0 mt-1">{{ $anggota->strukturOrmawas[0]->divisiOrmawas->nama }}
                                        ({{ $anggota->strukturOrmawas[0]->jabatan->nama }})
                                    </span>
                                    <div class="video-setting-icon mt-3 pt-3 border-top">
                                        {{-- <p>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices.Vestibulum ante ipsum primis in faucibus orci luctus et ultrices</p> --}}
                                    </div>
                                    {{-- <a href="" class="btn btn-dark btn-sm mt-1"><i class="icofont-plus-circle me-2 fs-6"></i>Add Task</a> --}}
                                    <a href="{{ route('our-member.member-profile', ['kode_ormawa' => $kode_ormawa, 'id_member' => $anggota->id, 'periode' => $periode]) }}"
                                        class="btn btn-dark btn-sm mt-1"><i
                                            class="icofont-invisible me-2 fs-6"></i>Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>

    <script src="{{ asset('js/template.js') }}"></script>
@endsection
