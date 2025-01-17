@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Body: Body -->
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row clearfix">
                <div class="col-md-12">
                    {{-- Card Info Start --}}
                    <div class="card mb-4">
                        <div
                            class="card-header py-3 px-0 d-flex flex-column align-items-center text-center justify-content-between">
                            <h3 class=" fw-bold flex-fill mb-2">{{ $programKerja->nama }}</h3>
                            <h6 class="mb-0 small text-muted fw-bold ">{{ $programKerja->deskripsi }}
                            </h6>
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span class="me-2">Nama Ketua Program Kerja:</span>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle text-decoration-none" id="dropdownMenuLink"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ isset($ketua[0]) ? $ketua[0]->name : 'Pilih Ketua Program Kerja' }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        @foreach ($anggota as $nama)
                                            <li><a class="dropdown-item pilih-ketua {{ isset($ketua[0]) && $ketua[0]->name === $nama->name ? 'active' : '' }}"
                                                    data-id="{{ $nama->id }}"
                                                    data-name="{{ $nama->name }}">{{ $nama->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-2">Hari Pelaksana Program Kerja: {{ $tanggal_mulai }}
                                    @if (@isset($tanggal_selesai))
                                        <span> - {{ $tanggal_selesai }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- Card Info End --}}

                    <div class="row clearfix g-3">
                        <div class="col-xl-8 col-lg-12 col-md-12 flex-column">
                            <div class="row g-3">
                                {{-- Card Divisi Start --}}
                                <div class="d-flex flex-row flex-wrap justify-content-start">
                                    @foreach ($divisi as $item)
                                        <div class="card mb-4 w-30 me-4"> <!-- Mengatur lebar kartu -->
                                            <div
                                                class="card-header py-3 px-0 d-flex flex-column align-items-center text-center justify-content-between">
                                                <h3 class="fw-bold flex-fill mb-2">
                                                    {{ $item['divisi_pelaksana']['nama'] }}
                                                </h3>
                                            </div>
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div class="planned_task client_task">
                                                    <div class="dd" data-plugin="nestable">
                                                        <ol class="dd-list">
                                                            @foreach ($activities as $activity)
                                                                @if ($activity->divisi_pelaksana_id === $item['id'])
                                                                    <li class="dd-item mb-3">
                                                                        <div class="dd-handle">
                                                                            <div
                                                                                class="task-info d-flex align-items-center justify-content-between">
                                                                                <h6
                                                                                    class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">
                                                                                    {{ $activity->nama }}</h6>
                                                                                <div
                                                                                    class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                                                    <div
                                                                                        class="avatar-list avatar-list-stacked m-0">
                                                                                        <img class="avatar rounded-circle small-avt sm"
                                                                                            src="{{ url('/') . '/images/xs/avatar2.jpg' }}"
                                                                                            alt="">
                                                                                        <img class="avatar rounded-circle small-avt sm"
                                                                                            src="{{ url('/') . '/images/xs/avatar1.jpg' }}"
                                                                                            alt="">
                                                                                    </div>
                                                                                    @if ($activity->status === 'belum_mulai')
                                                                                        <span
                                                                                            class="badge bg-warning text-end mt-1">
                                                                                            Not Started
                                                                                        </span>
                                                                                    @elseif($activity->status === 'sedang_berjalan')
                                                                                        <span
                                                                                            class="badge bg-warning text-end mt-1">
                                                                                            In Progress
                                                                                        </span>
                                                                                    @else
                                                                                        <span
                                                                                            class="badge bg-warning text-end mt-1">
                                                                                            Completed
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            {{-- <p class="py-2 mb-0">Lorem ipsum dolor sit amet,
                                                                                consectetur
                                                                                adipiscing
                                                                                elit. In id
                                                                                nec scelerisque massa.</p> --}}
                                                                            {{-- <div
                                                                                class="tikit-info row g-3 align-items-center">
                                                                                <div class="col-sm">
                                                                                </div>
                                                                                <div class="col-sm text-end">
                                                                                    <div
                                                                                        class="small text-truncate light-danger-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                                                        Social Geek Made </div>
                                                                                </div>
                                                                            </div> --}}
                                                                        </div>
                                                                    </li>
                                                                @else
                                                                    <p>Belum ada aktivitas</p>
                                                                @endif
                                                            @endforeach
                                                        </ol>
                                                        <a href="{{ route('program-kerja.divisi.show', ['id' => $item['id'], 'kode_ormawa' => $kode_ormawa, 'nama_program_kerja' => $programKerja->nama]) }}"
                                                            class="btn btn-dark btn-sm mt-1"><i
                                                                class="icofont-plus-circle me-2 fs-6"></i>Lihat Detail</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- Card Divisi End --}}
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12 col-md-12">
                            <div class="row g-3 row-deck">
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="card">
                                        <div
                                            class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                            <h6 class="mb-0 fw-bold ">Anggota Program Kerja</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="flex-grow-1">
                                                @foreach ($anggotaProker as $item)
                                                    <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                                        <div class="d-flex align-items-center flex-fill">
                                                            <img class="avatar lg rounded-circle img-thumbnail"
                                                                src="{{ url('/') . '/images/lg/avatar2.jpg' }}"
                                                                alt="profile">
                                                            <div class="d-flex flex-column ps-3">
                                                                <h6 class="fw-bold mb-0 small-14">{{ $item->nama_user }}
                                                                </h6>
                                                                <span class="text-muted">{{ $item->nama_jabatan }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="time-block text-truncate">
                                                            {{ $item->nama_divisi }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <button type="button" class="btn btn-dark w-sm-100 mt-3"
                                                    data-bs-toggle="modal" data-bs-target="#addmember"><i
                                                        class="icofont-plus-circle me-2 fs-6"></i>Tambah Anggota</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{ asset('assets/custom/program-kerja/detail-program-kerja.js') }}"></script>

    <script>
        var assignLeaderUrl =
            "{{ route('program-kerja.pilih-ketua', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id, 'periode' => $periode, 'userId' => $nama->id]) }}?periode=$periode";
    </script>
@endsection
