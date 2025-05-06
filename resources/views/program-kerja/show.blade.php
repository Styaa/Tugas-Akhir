@extends('layouts.app')

@section('title', __('Dashboard'))

@section('js_head')
    <link href="{{ asset('assets/filepond/filepond.css') }}" rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Body: Body -->
    @php
        $tanggalSelesaiLewat = $programKerja->tanggal_selesai && now() > $programKerja->tanggal_selesai;
        $isKetuaProker = isset($ketua[0]) && Auth::user()->id == $ketua[0]->id;
        $programKerjaSelesai = $programKerja->konfirmasi_penyelesaian == 'Ya';
    @endphp

    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row clearfix">
                <div class="col-md-12">
                    {{-- Card Info Start --}}
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom">
                            <h3 class="fw-bold mb-0">{{ $programKerja->nama }}</h3>
                            <a href="{{ route('program-kerja.index', ['kode_ormawa' => $kode_ormawa]) }}"
                                class="btn btn-outline-secondary">
                                <i class="icofont-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <p class="text-muted mb-0">{{ $programKerja->deskripsi }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <span class="me-2 fw-bold">Ketua Program Kerja:</span>
                                        <div class="dropdown" disabled>
                                            <a href="#" class="dropdown-toggle text-decoration-none"
                                                id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" ena>
                                                {{ isset($ketua[0]) ? $ketua[0]->name : 'Pilih Ketua Program Kerja' }}
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                @foreach ($anggota as $nama)
                                                    <li
                                                        class="{{ Auth::user()->jabatanOrmawa->nama == 'Anggota' ? 'disabled' : '' }}">
                                                        <a class="dropdown-item pilih-ketua {{ isset($ketua[0]) && $ketua[0]->name === $nama->name ? 'active' : '' }} {{ !$programKerjaSelesai ? '' : 'disabled' }}"
                                                            data-id="{{ $nama->id }}"
                                                            data-name="{{ $nama->name }}">{{ $nama->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <div class="d-flex align-items-center justify-content-md-end">
                                        <span class="me-2 fw-bold">Periode Pelaksanaan:</span>
                                        <span>
                                            {{ $tanggal_mulai }}
                                            @if (@isset($tanggal_selesai))
                                                <span> - {{ $tanggal_selesai }}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Card Info End --}}

                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom">
                            <h5 class="fw-bold mb-0">Status Program Kerja</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                @if ($programKerjaSelesai)
                                    <!-- Program Telah Selesai -->
                                    <div class="alert alert-success mb-0 w-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <i class="icofont-check-circled fs-4 me-2"></i>
                                                <div>
                                                    <strong>Program kerja telah selesai!</strong>
                                                    <p class="mb-0">Program kerja ini telah dikonfirmasi selesai dan siap untuk evaluasi.</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('program-kerja.evaluasi', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                               class="btn btn-primary">
                                                <i class="icofont-chart-bar-graph me-2"></i>Lihat Evaluasi Kinerja
                                            </a>
                                        </div>
                                    </div>
                                @elseif ($tanggalSelesaiLewat && $isKetuaProker)
                                    <!-- Program Belum Selesai dan Tanggal Telah Lewat -->
                                    <div class="alert alert-warning mb-0 w-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="icofont-warning-alt me-2"></i>
                                                <strong>Program kerja telah melewati tanggal selesai.</strong> Silakan
                                                lakukan penilaian anggota secara bertahap.
                                            </div>
                                            @if ($notifikasiTerkirim == 'false')
                                                <button type="button" class="btn btn-info" id="sendNotification"
                                                    data-url="{{ route('program-kerja.kirim-notifikasi', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}">
                                                    <i class="icofont-mail me-2"></i>Kirim Notifikasi Penilaian
                                                </button>
                                            @elseif($allMembersRated == false)
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#penilaianAnggotaModal">
                                                    <i class="icofont-rating me-2"></i>Buka Penilaian Anggota
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#konfirmasiSelesaiModal">
                                                    <i class="icofont-check-circled me-2"></i>Konfirmasi Penyelesaian
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @elseif ($tanggalSelesaiLewat)
                                    <!-- Program Belum Selesai, Tanggal Lewat, Bukan Ketua -->
                                    <div class="alert alert-warning mb-0 w-100">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-warning-alt fs-4 me-2"></i>
                                            <div>
                                                <strong>Program kerja telah melewati tanggal selesai.</strong>
                                                <p class="mb-0">Menunggu konfirmasi penyelesaian dari ketua program kerja.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Program Masih Berjalan -->
                                    <div class="alert alert-info mb-0 w-100">
                                        <div class="d-flex align-items-center">
                                            <i class="icofont-clock-time fs-4 me-2"></i>
                                            <div>
                                                <strong>Program kerja sedang berjalan.</strong>
                                                <p class="mb-0">Program kerja akan berakhir pada tanggal
                                                    {{ $tanggal_selesai ?? 'yang belum ditentukan' }}.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Anggaran Program Kerja --}}
                    @if (Auth::user()->jabatanOrmawa->nama !== 'Anggota' || Auth::user()->jabatanProker->nama !== 'Anggota')
                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom">
                                <h5 class="fw-bold mb-0">Anggaran Program Kerja</h5>
                                <a href="{{ route('program-kerja.rancanganAnggaranDana.create', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="icofont-edit me-1"></i>Edit Anggaran
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row text-center g-3">
                                    <!-- Total Pemasukan -->
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded">
                                            <h6 class="fw-bold text-muted mb-2">Total Pemasukan</h6>
                                            <p class="fs-5 text-success fw-bold mb-0">
                                                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Total Pengeluaran -->
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded">
                                            <h6 class="fw-bold text-muted mb-2">Total Pengeluaran</h6>
                                            <p class="fs-5 text-danger fw-bold mb-0">
                                                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Selisih Anggaran -->
                                    <div class="col-md-4">
                                        <div class="p-3 bg-light rounded">
                                            <h6 class="fw-bold text-muted mb-2">Selisih Anggaran</h6>
                                            <p
                                                class="fs-5 fw-bold mb-0 {{ $selisih >= 0 ? 'text-success' : 'text-danger' }}">
                                                Rp {{ number_format($selisih, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row g-3 mb-4">
                        {{-- Dokumen Program Kerja --}}
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom">
                                    <h5 class="fw-bold mb-0">Dokumen Program Kerja</h5>
                                    @if (!$programKerjaSelesai)
                                        <a href="{{ route('program-kerja.files.upload', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="icofont-upload-alt me-2"></i>Upload File Baru
                                        </a>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="py-3" width="5%">#</th>
                                                    <th class="py-3" width="30%">Nama File</th>
                                                    <th class="py-3" width="12%">Jenis</th>
                                                    <th class="py-3" width="10%">Ukuran</th>
                                                    <th class="py-3" width="15%">Tanggal Upload</th>
                                                    <th class="py-3" width="15%">Diupload Oleh</th>
                                                    <th class="py-3" width="13%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($files ?? [] as $index => $file)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div
                                                                    class="avatar rounded bg-light-info text-info me-3 p-2">
                                                                    <i
                                                                        class="icofont-file-{{ getFileIconClass($file->extension) }} fs-5"></i>
                                                                </div>
                                                                <div class="text-truncate" style="max-width: 250px;"
                                                                    title="{{ $file->original_name }}">
                                                                    {{ $file->original_name }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><span
                                                                class="badge bg-light text-dark">{{ getFileType($file->extension) }}</span>
                                                        </td>
                                                        <td>{{ formatFileSize($file->size) }}</td>
                                                        <td>{{ $file->created_at->format('d M Y, H:i') }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ url('/') . '/images/lg/avatar2.jpg' }}"
                                                                    alt="avatar" class="rounded-circle me-2"
                                                                    style="width: 24px; height: 24px;">
                                                                <span>{{ $file->uploader->name ?? 'Unknown' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('program-kerja.files.download', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id, 'file_id' => $file->id]) }}"
                                                                    class="btn btn-sm btn-outline-secondary"
                                                                    title="Download">
                                                                    <i class="icofont-download"></i>
                                                                </a>
                                                                <a href="{{ route('program-kerja.files.preview', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id, 'file_id' => $file->id]) }}"
                                                                    class="btn btn-sm btn-outline-primary"
                                                                    title="Preview">
                                                                    <i class="icofont-eye-alt"></i>
                                                                </a>
                                                                @if (Auth::user()->jabatanOrmawa->id <= 3 ||
                                                                        Auth::user()->jabatanProker->id <= 3)
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-danger delete-file"
                                                                        data-id="{{ $file->id }}"
                                                                        data-name="{{ $file->original_name }}"
                                                                        title="Hapus">
                                                                        <i class="icofont-trash"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-5">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="icofont-file-document fs-1 text-muted mb-3"></i>
                                                                <p class="mb-3">Belum ada file yang diupload</p>
                                                                @if (!$programKerjaSelesai)
                                                                    <a href="{{ route('program-kerja.files.upload', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                                                        class="btn btn-primary">
                                                                        <i class="icofont-upload-alt me-1"></i>Upload File
                                                                        Sekarang
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if (isset($files) && count($files) > 0 && $files->hasPages())
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $files->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-lg-8 col-md-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom">
                                    <h5 class="fw-bold mb-0">Divisi & Tugas</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-3" id="divisiTabs" role="tablist">
                                        @foreach ($divisi as $index => $item)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                                    id="divisi-{{ $item['id'] }}-tab" data-bs-toggle="tab"
                                                    data-bs-target="#divisi-{{ $item['id'] }}" type="button"
                                                    role="tab" aria-controls="divisi-{{ $item['id'] }}"
                                                    aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                                    {{ $item['divisi_pelaksana']['nama'] }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content" id="divisiTabsContent">
                                        @foreach ($divisi as $index => $item)
                                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                                id="divisi-{{ $item['id'] }}" role="tabpanel"
                                                aria-labelledby="divisi-{{ $item['id'] }}-tab">

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0">Tugas Divisi
                                                        {{ $item['divisi_pelaksana']['nama'] }}</h6>
                                                    <a href="{{ route('program-kerja.divisi.show', ['id' => $item['id'], 'kode_ormawa' => Request::segment(1), 'nama_program_kerja' => $programKerja->nama]) }}"
                                                        class="btn btn-dark btn-sm">Lihat Detail Divisi</a>
                                                </div>

                                                @php
                                                    $activitiesForDivisi = $activities->where(
                                                        'divisi_pelaksana_id',
                                                        $item['id'],
                                                    );
                                                @endphp

                                                @if ($activitiesForDivisi->isEmpty())
                                                    <div class="text-center py-4">
                                                        <i class="icofont-tasks-alt fs-1 text-muted mb-2"></i>
                                                        <p class="mb-0">Belum ada tugas untuk divisi ini</p>
                                                    </div>
                                                @else
                                                    <div class="table-responsive">
                                                        <table class="table table-hover align-middle">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Nama Tugas</th>
                                                                    <th>Person In Charge</th>
                                                                    <th>Tenggat Waktu</th>
                                                                    <th>Prioritas</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($activitiesForDivisi as $activity)
                                                                    <tr>
                                                                        <td>{{ $activity->nama }}</td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <img src="{{ url('/') . '/images/lg/avatar2.jpg' }}"
                                                                                    alt="avatar"
                                                                                    class="rounded-circle me-2"
                                                                                    style="width: 24px; height: 24px;">
                                                                                <span>{{ $activity->personInCharge->name ?? 'Not Assigned' }}</span>
                                                                            </div>
                                                                        </td>
                                                                        <td>{{ $activity->tenggat_waktu }}</td>
                                                                        <td>
                                                                            <span
                                                                                class="badge {{ $activity->prioritas === 'Tinggi'
                                                                                    ? 'bg-danger'
                                                                                    : ($activity->prioritas === 'Sedang'
                                                                                        ? 'bg-warning'
                                                                                        : 'bg-info') }}">
                                                                                {{ $activity->prioritas }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge {{ $activity->status === 'belum_mulai'
                                                                                    ? 'bg-secondary'
                                                                                    : ($activity->status === 'sedang_berjalan'
                                                                                        ? 'bg-primary'
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
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <div class="row g-3">
                                {{-- Anggota Program Kerja --}}
                                <div class="col-12">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom">
                                            <h6 class="mb-0 fw-bold">Anggota Program Kerja</h6>
                                            <div>
                                                @if (Auth::user()->jabatanOrmawa->nama !== 'Anggota' || Auth::user()->jabatanProker->nama !== 'Anggota')
                                                    @if (!$programKerjaSelesai)
                                                        <a href="{{ route('program-kerja.anggota.manage', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id]) }}"
                                                            class="btn btn-info btn-sm me-2">
                                                            <i class="icofont-edit me-1"></i>Kelola Anggota
                                                        </a>
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#addmember">
                                                            <i class="icofont-plus-circle me-1"></i>Tambah
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="flex-grow-1">
                                                <div id="memberList">
                                                    @foreach ($anggotaProker->take(10) as $item)
                                                        <div
                                                            class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                                            <div class="d-flex align-items-center flex-fill">
                                                                <img class="avatar rounded-circle img-thumbnail"
                                                                    src="{{ url('/') . '/images/lg/avatar2.jpg' }}"
                                                                    alt="profile" width="40" height="40">
                                                                <div class="d-flex flex-column ps-3">
                                                                    <h6 class="fw-bold mb-0 small-14">
                                                                        {{ $item->nama_user }}</h6>
                                                                    <span
                                                                        class="text-muted small">{{ $item->nama_jabatan }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="badge bg-light text-dark me-2">
                                                                    {{ $item->nama_divisi }}
                                                                </div>
                                                                @if (Auth::user()->jabatanOrmawa->nama !== 'Anggota' || Auth::user()->jabatanProker->nama !== 'Anggota')
                                                                    @if (!$programKerjaSelesai)
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-secondary ms-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editMember{{ $item->id_user }}">
                                                                            <i class="icofont-edit"></i>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Modal Edit Anggota -->
                                                        <div class="modal fade" id="editMember{{ $item->id_user }}"
                                                            tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Jabatan/Divisi Anggota
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <form
                                                                        action="{{ route('program-kerja.anggota.update', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id, 'anggotaId' => $item->id_user]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Nama
                                                                                    Anggota</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $item->nama_user }}"
                                                                                    disabled>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Jabatan</label>
                                                                                <select class="form-select"
                                                                                    name="jabatan_id">
                                                                                    @foreach ($jabatans as $jabatan)
                                                                                        <option
                                                                                            value="{{ $jabatan->id }}"
                                                                                            {{ $item->id_jabatan == $jabatan->id ? 'selected' : '' }}>
                                                                                            {{ $jabatan->nama }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Divisi</label>
                                                                                <select class="form-select"
                                                                                    name="divisi_id">
                                                                                    @foreach ($divisi as $divisi_item)
                                                                                        <option
                                                                                            value="{{ $divisi_item['divisi_pelaksana']['id'] }}"
                                                                                            {{ $item->divisi_id == $divisi_item['divisi_pelaksana']['id'] ? 'selected' : '' }}>
                                                                                            {{ $divisi_item['divisi_pelaksana']['nama'] }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Batal</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan
                                                                                Perubahan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Kode untuk anggota yang tersembunyi (skip 10) -->
                                                <div id="expandedMembers" style="display: none;">
                                                    @foreach ($anggotaProker->skip(10) as $item)
                                                        <div
                                                            class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                                            <!-- Konten yang sama seperti di atas, termasuk tombol edit dan modal -->
                                                            <div class="d-flex align-items-center flex-fill">
                                                                <img class="avatar rounded-circle img-thumbnail"
                                                                    src="{{ url('/') . '/images/lg/avatar2.jpg' }}"
                                                                    alt="profile" width="40" height="40">
                                                                <div class="d-flex flex-column ps-3">
                                                                    <h6 class="fw-bold mb-0 small-14 text-truncate">
                                                                        {{ $item->nama_user }}</h6>
                                                                    <span
                                                                        class="text-muted small text-truncate">{{ $item->nama_jabatan }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="badge bg-light text-dark me-2">
                                                                    {{ $item->nama_divisi }}
                                                                </div>
                                                                @if (Auth::user()->jabatanOrmawa->nama !== 'Anggota' || Auth::user()->jabatanProker->nama !== 'Anggota')
                                                                    @if (!$programKerjaSelesai)
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-secondary ms-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editMember{{ $item->id_user }}">
                                                                            <i class="icofont-edit"></i>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Modal Edit Anggota -->
                                                        <div class="modal fade" id="editMember{{ $item->id_user }}"
                                                            tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Jabatan/Divisi Anggota
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <form
                                                                        action="{{ route('program-kerja.anggota.update', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id, 'anggotaId' => $item->id_user]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Nama
                                                                                    Anggota</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $item->nama_user }}"
                                                                                    disabled>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Jabatan</label>
                                                                                <select class="form-select"
                                                                                    name="jabatan_id">
                                                                                    @foreach ($jabatans as $jabatan)
                                                                                        <option
                                                                                            value="{{ $jabatan->id }}"
                                                                                            {{ $item->id_jabatan == $jabatan->id ? 'selected' : '' }}>
                                                                                            {{ $jabatan->nama }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Divisi</label>
                                                                                <select class="form-select"
                                                                                    name="divisi_id">
                                                                                    @foreach ($divisi as $divisi_item)
                                                                                        <option
                                                                                            value="{{ $divisi_item['divisi_pelaksana']['id'] }}"
                                                                                            {{ $item->divisi_id == $divisi_item['divisi_pelaksana']['id'] ? 'selected' : '' }}>
                                                                                            {{ $divisi_item['divisi_pelaksana']['nama'] }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Batal</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan
                                                                                Perubahan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if (count($anggotaProker) > 10)
                                                    <button id="showMoreBtn" class="btn btn-outline-secondary w-100 mt-3">
                                                        <i class="icofont-simple-down me-2"></i>Lihat Lebih Banyak
                                                    </button>
                                                    <button id="showLessBtn" class="btn btn-outline-secondary w-100 mt-3"
                                                        style="display: none;">
                                                        <i class="icofont-simple-up me-2"></i>Tampilkan Lebih Sedikit
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Dokumen Wajib Program Kerja --}}
                                @if (Auth::user()->jabatanOrmawa->nama !== 'Anggota' || Auth::user()->jabatanProker->nama !== 'Anggota')
                                    <div class="col-12">
                                        <div class="card mb-4">
                                            <div
                                                class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom">
                                                <h6 class="mb-0 fw-bold">Dokumen Wajib Program Kerja</h6>
                                            </div>
                                            <div class="card-body">
                                                <ul class="nav nav-tabs mb-3" id="documentTabs" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="rab-tab"
                                                            data-bs-toggle="tab" data-bs-target="#rab" type="button"
                                                            role="tab" aria-controls="rab" aria-selected="true">
                                                            RAB
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="proposal-tab" data-bs-toggle="tab"
                                                            data-bs-target="#proposal" type="button" role="tab"
                                                            aria-controls="proposal" aria-selected="false">
                                                            Proposal
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="lpj-tab" data-bs-toggle="tab"
                                                            data-bs-target="#lpj" type="button" role="tab"
                                                            aria-controls="lpj" aria-selected="false">
                                                            LPJ
                                                        </button>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="documentTabsContent">
                                                    <div class="tab-pane fade show active" id="rab" role="tabpanel"
                                                        aria-labelledby="rab-tab">
                                                        <div class="d-flex align-items-center py-2">
                                                            <span
                                                                class="avatar bg-light-info text-info rounded-circle p-2 me-3">
                                                                <i class="icofont-file-text fs-4"></i>
                                                            </span>
                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-bold mb-0">Rancangan Anggaran Biaya</h6>
                                                                <p class="text-muted small mb-0">Dokumen perencanaan
                                                                    keuangan program kerja</p>
                                                            </div>
                                                            <a href="{{ route('program-kerja.rancanganAnggaranDana.create', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id]) }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="icofont-edit me-1"></i>Edit
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="proposal" role="tabpanel"
                                                        aria-labelledby="proposal-tab">
                                                        <div class="d-flex align-items-center py-2">
                                                            <span
                                                                class="avatar bg-light-info text-info rounded-circle p-2 me-3">
                                                                <i class="icofont-file-text fs-4"></i>
                                                            </span>
                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-bold mb-0">Proposal Program Kerja</h6>
                                                                <p class="text-muted small mb-0">Dokumen perencanaan
                                                                    kegiatan program kerja</p>
                                                            </div>
                                                            <a href="{{ route('program-kerja.proposal.progress', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="icofont-edit me-1"></i>Edit
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="lpj" role="tabpanel"
                                                        aria-labelledby="lpj-tab">
                                                        <div class="d-flex align-items-center py-2">
                                                            <span
                                                                class="avatar bg-light-info text-info rounded-circle p-2 me-3">
                                                                <i class="icofont-file-text fs-4"></i>
                                                            </span>
                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-bold mb-0">Laporan Pertanggungjawaban</h6>
                                                                <p class="text-muted small mb-0">Dokumen evaluasi dan
                                                                    laporan kegiatan</p>
                                                            </div>
                                                            <a href="{{ route('program-kerja.lpj.create', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                                                class="btn btn-outline-primary btn-sm">
                                                                <i class="icofont-edit me-1"></i>Edit
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="penilaianAnggotaModal" tabindex="-1"
                    aria-labelledby="penilaianAnggotaModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="penilaianAnggotaModalLabel">Penilaian Anggota Program Kerja
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Silakan nilai kinerja anggota program kerja <strong>{{ $programKerja->nama }}</strong>.
                                </p>
                                <p>Penilaian Anda akan mempengaruhi 15% dari total evaluasi kinerja anggota.</p>

                                <form id="penilaianForm"
                                    action="{{ route('program-kerja.nilai-anggota', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="25%">Nama Anggota</th>
                                                    <th width="20%">Divisi</th>
                                                    <th width="15%">Jabatan</th>
                                                    <th width="20%">Nilai (1-5)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $counter = 1; @endphp
                                                @foreach ($anggotaUntukDinilai as $index => $anggota)
                                                    <tr>
                                                        <td>{{ $counter++ }}</td>
                                                        <td>{{ $anggota->nama_user }}</td>
                                                        <td>{{ $anggota->nama_divisi }}</td>
                                                        <td>{{ $anggota->nama_jabatan }}</td>
                                                        <td>
                                                            <input type="hidden" name="struktur_id[]"
                                                                value="{{ $anggota->id }}">
                                                            <select class="form-select" name="nilai[]" required>
                                                                <option value="" disabled
                                                                    {{ !$anggota->nilai_atasan ? 'selected' : '' }}>Pilih
                                                                    nilai
                                                                </option>
                                                                <option value="1"
                                                                    {{ $anggota->nilai_atasan == 1 ? 'selected' : '' }}>1 -
                                                                    Sangat
                                                                    Kurang</option>
                                                                <option value="2"
                                                                    {{ $anggota->nilai_atasan == 2 ? 'selected' : '' }}>2 -
                                                                    Kurang
                                                                </option>
                                                                <option value="3"
                                                                    {{ $anggota->nilai_atasan == 3 ? 'selected' : '' }}>3 -
                                                                    Cukup
                                                                </option>
                                                                <option value="4"
                                                                    {{ $anggota->nilai_atasan == 4 ? 'selected' : '' }}>4 -
                                                                    Baik
                                                                </option>
                                                                <option value="5"
                                                                    {{ $anggota->nilai_atasan == 5 ? 'selected' : '' }}>5 -
                                                                    Sangat Baik
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="icofont-save me-1"></i>Simpan Penilaian
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addmember" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="addmemberLabel">Tambah Anggota Program Kerja</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form
                                    action="{{ route('program-kerja.pilih-anggota', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id, 'periode' => $periode]) }}"
                                    method="post" id="addMemberForm">
                                    @csrf
                                    {{-- <input type="hidden" name="anggota" value="">
                                    <input type="hidden" name="divisi" value="">
                                    <input type="hidden" name="jabatan" value=""> --}}
                                    <div class="mb-3">
                                        <label for="anggota" class="form-label">Pilih Anggota</label>
                                        <div class="d-flex align-items-center">
                                            <select class="form-select z-10" id="multiple-select-field"
                                                data-placeholder="Choose anything" name="anggotas[]" multiple>
                                                @if (isset($availableAnggota) && is_iterable($availableAnggota))
                                                    @forelse ($availableAnggota as $availableAnggotas)
                                                        <option value="{{ $availableAnggotas->id ?? '' }}">
                                                            {{ $availableAnggotas->name ?? 'Nama tidak tersedia' }}
                                                        </option>
                                                    @empty
                                                        <option value="" disabled>Tidak ada anggota tersedia</option>
                                                    @endforelse
                                                @else
                                                    <option value="" disabled>Data anggota tidak ditemukan</option>
                                                @endif
                                            </select>
                                        </div>
                                        @if (!isset($availableAnggota) || !is_iterable($availableAnggota))
                                            <div class="text-danger mt-2 small">
                                                <i class="icofont-info-circle"></i> Terjadi kesalahan saat memuat data
                                                anggota
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="divisi" class="form-label">Pilih Divisi</label>
                                        <div class="d-flex align-items-center">
                                            <select class="form-select" id="single-select-field1" name="divisi"
                                                data-placeholder="Choose one thing">
                                                @if (@isset($divisi))
                                                    @foreach ($divisi as $item)
                                                        <option value="{{ $item['id'] }}">
                                                            {{-- <a class="dropdown-item pilih-divisi {{ isset($selectedDivisi) && $selectedDivisi->id === $item['id'] ? 'active' : '' }}"
                                                                data-id="{{ $item['id'] }}"
                                                                data-name="{{ $item['divisi_pelaksana']['nama'] }}">{{ $item['divisi_pelaksana']['nama'] }}</a> --}}
                                                            {{ $item['divisi_pelaksana']['nama'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Pilih Jabatan</label>
                                        <div class="d-flex align-items-center">
                                            <select class="form-select" id="single-select-field2" name="jabatan"
                                                data-placeholder="Choose one thing">
                                                @if (@isset($jabatans))
                                                    @foreach ($jabatans as $jabatan)
                                                        <option value="{{ $jabatan->id }}">
                                                            {{-- <a class="dropdown-item pilih-jabatan {{ isset($selectedJabatan) && $selectedJabatan->id === $jabatan->id ? 'active' : '' }}"
                                                                data-id="{{ $jabatan->id }}"
                                                                data-name="{{ $jabatan->nama }}">{{ $jabatan->nama }}</a> --}}
                                                            {{ $jabatan->nama }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Tambah Anggota</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Modal HTML -->
                <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="errorModalLabel">Data Belum Lengkap</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Mohon lengkapi data berikut:</p>
                                <ul id="errorList"></ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
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
    <script src="{{ asset('assets/filepond/filepond.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2
            $('#multiple-select-field').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
                dropdownParent: $("#addmember"),
            });

            $('#single-select-field1').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-200') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                dropdownParent: $("#addmember"),
            });

            $('#single-select-field2').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-200') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                dropdownParent: $("#addmember"),
            });

            // Re-initialize all Bootstrap dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });

            const form = document.getElementById('addMemberForm');
            if (form) {
                // Add submit event listener for client-side validation
                form.addEventListener('submit', function(event) {
                    const errors = validateForm();

                    if (errors.length > 0) {
                        event.preventDefault();
                        displayErrorModal(errors);
                    }
                });
            }

            // Function to validate the form
            function validateForm() {
                const errors = [];

                // Validate anggota selection
                const anggotaSelect = document.getElementById('multiple-select-field');
                if (!anggotaSelect || anggotaSelect.selectedOptions.length === 0) {
                    errors.push('Anggota harus dipilih');
                }

                // Validate divisi selection
                const divisiSelect = document.getElementById('single-select-field1');
                if (!divisiSelect || !divisiSelect.value) {
                    errors.push('Divisi harus dipilih');
                }

                // Validate jabatan selection
                const jabatanSelect = document.getElementById('single-select-field2');
                if (!jabatanSelect || !jabatanSelect.value) {
                    errors.push('Jabatan harus dipilih');
                }

                return errors;
            }

            // Function to display error modal
            function displayErrorModal(errors) {
                const errorList = document.getElementById('errorList');
                if (errorList) {
                    errorList.innerHTML = '';

                    errors.forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorList.appendChild(li);
                    });

                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Setup modal delete file
            const deleteButtons = document.querySelectorAll('.delete-file');
            const deleteFileModal = document.getElementById('deleteFileModal');
            const fileNameToDelete = document.getElementById('file-name-to-delete');
            const deleteFileForm = document.getElementById('delete-file-form');

            if (deleteButtons) {
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const fileId = this.getAttribute('data-id');
                        const fileName = this.getAttribute('data-name');

                        fileNameToDelete.textContent = fileName;
                        deleteFileForm.action =
                            `{{ url('/' . $kode_ormawa . '/program-kerja/' . $programKerja->id . '/files/delete') }}/${fileId}`;

                        const deleteModal = new bootstrap.Modal(deleteFileModal);
                        deleteModal.show();
                    });
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Tombol untuk menampilkan lebih banyak anggota
            const showMoreBtn = document.getElementById('showMoreBtn');
            const showLessBtn = document.getElementById('showLessBtn');
            const expandedMembers = document.getElementById('expandedMembers');

            if (showMoreBtn) {
                showMoreBtn.addEventListener('click', function() {
                    expandedMembers.style.display = 'block';
                    showMoreBtn.style.display = 'none';
                    showLessBtn.style.display = 'block';
                });
            }

            if (showLessBtn) {
                showLessBtn.addEventListener('click', function() {
                    expandedMembers.style.display = 'none';
                    showMoreBtn.style.display = 'block';
                    showLessBtn.style.display = 'none';
                });
            }
        });

        $(document).ready(function() {
            $('#sendNotification').on('click', function() {
                const button = $(this);
                const url = button.data('url');

                button.prop('disabled', true).html(
                    '<i class="spinner-border spinner-border-sm"></i> Mengirim...');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        } else {
                            toastr.error(response.message);
                            button.prop('disabled', false).html(
                                '<i class="icofont-mail me-2"></i>Kirim Notifikasi Penilaian'
                            );
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        toastr.error(response.message ||
                            'Terjadi kesalahan saat mengirim notifikasi');
                        button.prop('disabled', false).html(
                            '<i class="icofont-mail me-2"></i>Kirim Notifikasi Penilaian');
                    }
                });
            });
        });
    </script>



@endsection
