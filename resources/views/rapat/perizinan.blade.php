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
                                        <th>Meeting</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="" class="fw-bold text-secondary">#001</a>
                                        </td>
                                        <td>
                                            <img class="avatar rounded-circle"
                                                src="{{ url('/') . '/images/xs/avatar1.jpg' }}" alt="">
                                            <span class="fw-bold ms-1">Satya</span>
                                        </td>
                                        <td>
                                            Rapat Koordinator Informatics Gathering
                                        </td>
                                        <td>
                                            19-03-2003
                                        </td>
                                        <td>
                                            Acara keluarga
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                {{-- <button type="button" class="btn btn-outline-secondary accept-button"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->name }}"><i
                                                        class="icofont-check-circled text-success"></i></button>
                                                <button type="button" class="btn btn-outline-secondary reject-button"
                                                    data-user-id="{{ $user->id }}" data-bs-toggle="modal"
                                                    data-user-name="{{ $user->name }}"><i
                                                        class="icofont-close-circled text-danger"></i></button> --}}
                                                <button type="button" class="btn btn-outline-secondary accept-button"
                                                    data-user-id="1"
                                                    data-user-name="Satya"><i
                                                        class="icofont-check-circled text-success"></i></button>
                                                <button type="button" class="btn btn-outline-secondary reject-button"
                                                    data-user-id="1" data-bs-toggle="modal"
                                                    data-user-name="Satya"><i
                                                        class="icofont-close-circled text-danger"></i></button>
                                            </div>
                                        </td>
                                    </tr>
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
    {{-- <script src="{{ asset('assets/custom/our-members/candidate-member.js') }}"></script> --}}


    <script>
        var acceptCandidateUrl =
            "{{ route('our-member.candidate-accept', ['kode_ormawa' => $kode_ormawa]) }}?periode=$periode";
        // project data table
        $(document).ready(function() {
            $('#myProjectTable')
                .addClass('nowrap')
                .dataTable({
                    responsive: true,
                    columnDefs: [{
                        targets: [-1, -3],
                        className: 'dt-body-right'
                    }]
                });
        });
    </script>

@endsection
