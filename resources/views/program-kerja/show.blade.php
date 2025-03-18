@extends('layouts.app')

@section('title', __('Dashboard'))

@section('js_head')
    <link href="{{ asset('assets/filepond/filepond.css') }}" rel="stylesheet" />
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle text-decoration-none"
                                                id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ isset($ketua[0]) ? $ketua[0]->name : 'Pilih Ketua Program Kerja' }}
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                @foreach ($anggota as $nama)
                                                    <li
                                                        class="{{ Auth::user()->jabatanOrmawa->id == 13 ? 'disabled' : '' }}">
                                                        <a class="dropdown-item pilih-ketua {{ isset($ketua[0]) && $ketua[0]->name === $nama->name ? 'active' : '' }}"
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

                    @php
                        $tanggalSelesaiLewat = $programKerja->tanggal_selesai && now() > $programKerja->tanggal_selesai;
                        $isKetuaProker = isset($ketua[0]) && Auth::user()->id == $ketua[0]->id;
                        $programKerjaBelumSelesai = $programKerja->disetujui != 'Ya';
                    @endphp

                    @if ($tanggalSelesaiLewat && $isKetuaProker && $programKerjaBelumSelesai)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="icofont-check-circled me-2"></i>
                                    <strong>Program kerja telah melewati tanggal selesai.</strong> Silakan konfirmasi
                                    penyelesaian program kerja untuk melakukan evaluasi kinerja panitia.
                                </div>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#konfirmasiSelesaiModal">
                                    <i class="icofont-check-circled me-2"></i>Konfirmasi Penyelesaian
                                </button>
                            </div>
                        </div>
                    @endif

                    {{-- Anggaran Program Kerja --}}
                    @if (Auth::user()->jabatanOrmawa->id !== 13 || Auth::user()->jabatanProker->id !== 13)
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
                                    <a href="{{ route('program-kerja.files.upload', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="icofont-upload-alt me-2"></i>Upload File Baru
                                    </a>
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
                                                                @if (Auth::user()->id == $file->uploaded_by ||
                                                                        Auth::user()->jabatanOrmawa->id <= 3 ||
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
                                                                <a href="{{ route('program-kerja.files.upload', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                                                    class="btn btn-primary">
                                                                    <i class="icofont-upload-alt me-1"></i>Upload File
                                                                    Sekarang
                                                                </a>
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
                                    <h5 class="fw-bold mb-0">Divisi & Aktivitas</h5>
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
                                                    <h6 class="mb-0">Aktivitas Divisi
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
                                                        <p class="mb-0">Belum ada aktivitas untuk divisi ini</p>
                                                    </div>
                                                @else
                                                    <div class="table-responsive">
                                                        <table class="table table-hover align-middle">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Nama Aktivitas</th>
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
                                            @if (Auth::user()->jabatanOrmawa->id !== 13 || Auth::user()->jabatanProker->id !== 13)
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#addmember">
                                                    <i class="icofont-plus-circle me-1"></i>Tambah
                                                </button>
                                            @endif
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
                                                            <div class="badge bg-light text-dark ms-2">
                                                                {{ $item->nama_divisi }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div id="expandedMembers" style="display: none;">
                                                    @foreach ($anggotaProker->skip(10) as $item)
                                                        <div
                                                            class="py-2 d-flex align-items-center border-bottom flex-wrap">
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
                                                            <div class="badge bg-light text-dark ms-2">
                                                                {{ $item->nama_divisi }}
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
                                @if (Auth::user()->jabatanOrmawa->id !== 13 || Auth::user()->jabatanProker->id !== 13)
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
            </div><!-- Row End -->
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/custom/program-kerja/detail-program-kerja.js') }}"></script>
    <script src="{{ asset('assets/filepond/filepond.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
    </script>



@endsection
