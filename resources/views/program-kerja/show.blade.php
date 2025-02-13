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

                    <div class="card">
                        <div class="card-body">
                            <h5 class="fw-bold text-center">Anggaran Program Kerja</h5>
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <!-- Total Pemasukan -->
                                <div class="text-center mx-3">
                                    <h6 class="fw-bold text-muted">Total Pemasukan</h6>
                                    <p class="fs-5 text-success fw-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                                </div>

                                <!-- Total Pengeluaran -->
                                <div class="text-center mx-3">
                                    <h6 class="fw-bold text-muted">Total Pengeluaran</h6>
                                    <p class="fs-5 text-danger fw-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                                </div>

                                <!-- Selisih Anggaran -->
                                <div class="text-center mx-3">
                                    <h6 class="fw-bold text-muted">Selisih Anggaran</h6>
                                    <p class="fs-5 fw-bold {{ $selisih >= 0 ? 'text-success' : 'text-danger' }}">
                                        Rp {{ number_format($selisih, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix g-3 mt-4">
                        <div class="col-xl-8 col-lg-12 col-md-12">
                            <div class="row g-3">
                                {{-- Card Divisi Start --}}
                                @foreach ($divisi as $item)
                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                        <div class="card">
                                            <div
                                                class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                                <h6 class="mb-0 fw-bold">{{ $item['divisi_pelaksana']['nama'] }}</h6>
                                                <a href="{{ route('program-kerja.divisi.show', ['id' => $item['id'], 'kode_ormawa' => Request::segment(1), 'nama_program_kerja' => $programKerja->nama]) }}"
                                                    class="btn btn-dark btn-sm">Lihat Detail</a>
                                            </div>
                                            <div class="card-body">
                                                @php
                                                    $activitiesForDivisi = $activities->where(
                                                        'divisi_pelaksana_id',
                                                        $item['id'],
                                                    );
                                                @endphp

                                                @if ($activitiesForDivisi->isEmpty())
                                                    <p class="text-muted">Tidak ada aktivitas</p>
                                                @else
                                                    <!-- Tabel dengan Garis Tipis Antar Kolom -->
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless align-middle">
                                                            <thead class="border-bottom">
                                                                <tr class="text-muted">
                                                                    <th class="border-end">Nama Aktivitas</th>
                                                                    <th class="border-end">Person In Charge</th>
                                                                    <th class="border-end">Tenggat Waktu</th>
                                                                    <th class="border-end">Prioritas</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($activitiesForDivisi as $activity)
                                                                    <tr>
                                                                        <td class="border-end">{{ $activity->nama }}</td>
                                                                        <td class="border-end">
                                                                            {{ $activity->personInCharge->name ?? 'Not Assigned' }}
                                                                        </td>
                                                                        <td class="border-end">
                                                                            {{ $activity->tenggat_waktu }}</td>
                                                                        <td class="border-end">{{ $activity->prioritas }}
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge
                                                                            {{ $activity->status === 'belum_mulai'
                                                                                ? 'bg-warning'
                                                                                : ($activity->status === 'sedang_berjalan'
                                                                                    ? 'bg-info'
                                                                                    : 'bg-success') }}">
                                                                                {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                                                    data-bs-toggle="modal" data-bs-target="#addmember">
                                                    <i class="icofont-plus-circle me-2 fs-6"></i>Tambah Anggota
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Section Dokumen Wajib Program Kerja --}}
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="card">
                                        <div
                                            class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                            <h6 class="mb-0 fw-bold ">Dokumen Wajib Program Kerja</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="flex-grow-1">
                                                <!-- Rancangan Anggaran Biaya -->
                                                <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                                    <div class="d-flex align-items-center flex-fill">
                                                        <span
                                                            class="avatar lg bg-white rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                                                class="icofont-file-text fs-5"></i></span>
                                                        <div class="d-flex flex-column ps-3">
                                                            <a href="{{ route('program-kerja.rancanganAnggaranDana.create', ['kode_ormawa' =>$kode_ormawa, 'prokerId' => $programKerja->id]) }}"
                                                                class="text-decoration-none">
                                                                <h6 class="fw-bold mb-0 small-14">Rancangan Anggaran Biaya
                                                                </h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="time-block text-truncate">
                                                        Update status
                                                    </div>
                                                </div>

                                                <!-- Proposal -->
                                                <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                                    <div class="d-flex align-items-center flex-fill">
                                                        <span
                                                            class="avatar lg bg-white rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                                                class="icofont-file-text fs-5"></i></span>
                                                        <div class="d-flex flex-column ps-3">
                                                            <a href="{{ route('program-kerja.proposal.progress', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                                                class="text-decoration-none">
                                                                <h6 class="fw-bold mb-0 small-14">Proposal</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="time-block text-truncate">
                                                        Update status
                                                    </div>
                                                </div>

                                                <!-- Laporan Pertanggungjawaban -->
                                                <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                                    <div class="d-flex align-items-center flex-fill">
                                                        <span
                                                            class="avatar lg bg-white rounded-circle text-center d-flex align-items-center justify-content-center"><i
                                                                class="icofont-file-text fs-5"></i></span>
                                                        <div class="d-flex flex-column ps-3">
                                                            <a href="{{ route('program-kerja.lpj.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                                                class="text-decoration-none">
                                                                <h6 class="fw-bold mb-0 small-14">Laporan
                                                                    Pertanggungjawaban</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="time-block text-truncate">
                                                        Update status
                                                    </div>
                                                </div>
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

@endsection
