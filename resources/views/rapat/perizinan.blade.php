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
                        <h3 class="fw-bold mb-0">Daftar Izin Rapat</h3>
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
                                        <th>Id Izin</th>
                                        <th>Nama Anggota</th>
                                        <th>Rapat</th>
                                        <th>Kegiatan</th>
                                        <th>Alasan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daftarIzin as $izin)
                                        <tr>
                                            <td>
                                                <a href="" class="fw-bold text-secondary">#{{ $izin->id }}</a>
                                            </td>
                                            <td>
                                                <img class="avatar rounded-circle"
                                                    src="{{ url('/') . '/images/xs/avatar1.jpg' }}" alt="">
                                                <span class="fw-bold ms-1">{{ $izin->user->name }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('rapat.show', ['kode_ormawa' => $kode_ormawa, 'id_rapat' => $izin->rapat->id]) }}"
                                                    class="underline">{{ $izin->rapat->nama }}</a>
                                            </td>
                                            <td>
                                                {{ $izin->rapat->nama_penyelenggara }}
                                            </td>
                                            <td>
                                                {{ Str::limit($izin->alasan, 50) }}
                                                @if (strlen($izin->alasan) > 50)
                                                    <a href="#" data-bs-toggle="tooltip" title="{{ $izin->alasan }}">
                                                        <i class="icofont-info-circle ms-1"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $izin->status == 'disetujui' ? 'bg-success' : ($izin->status == 'ditolak' ? 'bg-danger' : ($izin->status == 'ditolak_hadir' ? 'bg-info' : 'bg-warning text-dark')) }}">
                                                    {{ $izin->status == 'disetujui'
                                                        ? 'Disetujui'
                                                        : ($izin->status == 'ditolak'
                                                            ? 'Ditolak'
                                                            : ($izin->status == 'ditolak_hadir'
                                                                ? 'Ditolak (Hadir)'
                                                                : 'Menunggu')) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                    @if ($izin->status == 'pending')
                                                        <!-- Buttons for pending izin -->
                                                        <button type="button"
                                                            class="btn btn-outline-secondary accept-button"
                                                            data-izin-id="{{ $izin->id }}"
                                                            data-user-name="{{ $izin->user->name }}">
                                                            <i class="icofont-check-circled text-success"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary reject-button"
                                                            data-izin-id="{{ $izin->id }}"
                                                            data-user-name="{{ $izin->user->name }}">
                                                            <i class="icofont-close-circled text-danger"></i>
                                                        </button>
                                                    @elseif($izin->status == 'ditolak')
                                                        <!-- Button for rejected izin - allow marking attendance -->
                                                        <a href="{{ route('rapat.show', ['kode_ormawa' => $kode_ormawa, 'id_rapat' => $izin->rapat->id]) }}"
                                                            class="btn btn-outline-primary btn-sm" title="Tandai Kehadiran">
                                                            <i class="icofont-user-alt-3"></i> Absensi
                                                        </a>
                                                    @elseif($izin->status == 'ditolak_hadir')
                                                        <!-- Info for rejected but attended -->
                                                        <span class="badge bg-info">
                                                            <i class="icofont-check-circled me-1"></i>Hadir
                                                        </span>
                                                    @else
                                                        <!-- No actions for approved izin -->
                                                        <span class="text-muted">-</span>
                                                    @endif
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
