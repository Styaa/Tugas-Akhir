@extends('layouts.app')

@section('title', __('Dashboard'))

@section('js_head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Candidate Members</h3>
                        {{-- <div class="col-auto d-flex w-sm-100">
                            <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal"
                                data-bs-target="#leaveadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Leave</button>
                        </div> --}}
                    </div>
                </div>
            </div> <!-- Row end  -->
            <div class="row clearfix g-3">
                <div class="col-sm-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Member Id</th>
                                        <th>Member Name</th>
                                        <th>NRP</th>
                                        <th>Email</th>
                                        <th>Divisi Pilihan 1</th>
                                        <th>Divisi Pilihan 2</th>
                                        <th>Jurusan</th>
                                        <th>Id Line</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($candidate as $user)
                                        <tr>
                                            <td>
                                                <a href="" class="fw-bold text-secondary">#{{ $user->id }}</a>
                                            </td>
                                            <td>
                                                <img class="avatar rounded-circle"
                                                    src="{{ url('/') . '/images/xs/avatar1.jpg' }}" alt="">
                                                <span class="fw-bold ms-1">{{ $user->name }}</span>
                                            </td>
                                            <td>
                                                {{ $user->nrp }}
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>{{ $user->registrations[0]->divisi1 ? $user->registrations[0]->divisi1->nama : 'Tidak ada' }}
                                            </td>
                                            <td>{{ $user->registrations[0]->divisi2 ? $user->registrations[0]->divisi2->nama : 'Tidak ada' }}
                                            </td>
                                            <td>
                                                {{ $user->jurusan }}
                                            </td>
                                            <td>
                                                {{ $user->id_line }}
                                            </td>

                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                    <button type="button" class="btn btn-outline-secondary accept-button"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}"
                                                        data-divisi1-id="{{ $user->registrations[0]->divisi1->id }}"
                                                        data-divisi2-id="{{ $user->registrations[0]->divisi2 ? $user->registrations[0]->divisi2->id : '' }}"
                                                        data-divisi1-name="{{ $user->registrations[0]->divisi1->nama }}"
                                                        data-divisi2-name="{{ $user->registrations[0]->divisi2 ? $user->registrations[0]->divisi2->nama : '' }}"><i
                                                            class="icofont-check-circled text-success"></i></button>
                                                    <button type="button" class="btn btn-outline-secondary reject-button"
                                                        data-user-id="{{ $user->id }}" data-bs-toggle="modal"
                                                        data-user-name="{{ $user->name }}"
                                                        data-divisi1="{{ $user->registrations[0]->divisi1->id }}"
                                                        data-divisi2="{{ $user->registrations[0]->divisi2 ? $user->registrations[0]->divisi2->id : '' }}"><i
                                                            class="icofont-close-circled text-danger"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- Row End -->
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/dataTables.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/custom/our-members/candidate-member.js') }}"></script>


    <script>
        var acceptCandidateUrl =
            "{{ route('our-member.candidate-accept', ['kode_ormawa' => $kode_ormawa]) }}?periode=$periode";

        var rejectCandidateUrl =
            "{{ route('our-member.candidate-reject', ['kode_ormawa' => $kode_ormawa]) }}?periode=$periode";
    </script>

@endsection
