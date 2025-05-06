@extends('layouts.app')

@section('title', 'Kelola Anggota Program Kerja')

@section('js_head')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Program Kerja</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard', ['kode_ormawa' => $kode_ormawa]) }}"><i
                                    class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('program-kerja.index', ['kode_ormawa' => $kode_ormawa]) }}">Program Kerja</a>
                        </li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}">{{ $programKerja->nama }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Anggota</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-3 bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Kelola Anggota Program Kerja</h5>
                            <div>
                                <a href="{{ route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                                    class="btn btn-sm btn-secondary">
                                    <i class="icofont-arrow-left me-1"></i>Kembali
                                </a>
                                @if (!$programKerjaSelesai)
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addmember">
                                        <i class="icofont-plus-circle me-1"></i>Tambah Anggota
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Tabs per divisi -->
                        <ul class="nav nav-tabs" id="divisiTab" role="tablist">
                            @foreach ($divisiProker as $index => $divisi)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                        id="divisi-{{ $divisi->id }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#divisi-{{ $divisi->id }}" type="button" role="tab"
                                        aria-controls="divisi-{{ $divisi->id }}"
                                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                        {{ $divisi->nama }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mt-3" id="divisiTabContent">
                            @foreach ($divisiProker as $index => $divisi)
                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                    id="divisi-{{ $divisi->id }}" role="tabpanel"
                                    aria-labelledby="divisi-{{ $divisi->id }}-tab">

                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="20%">Nama</th>
                                                    <th width="15%">NRP</th>
                                                    <th width="20%">Jabatan</th>
                                                    <th width="20%">Status</th>
                                                    <th width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($anggotaByDivisi[$divisi->id]) && count($anggotaByDivisi[$divisi->id]['anggota']) > 0)
                                                    @foreach ($anggotaByDivisi[$divisi->id]['anggota'] as $key => $anggota)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $anggota->name }}</td>
                                                            <td>{{ $anggota->nrp }}</td>
                                                            <td>{{ $anggota->jabatan }}</td>
                                                            <td>
                                                                <span class="badge bg-success">Aktif</span>
                                                            </td>
                                                            <td>
                                                                @if (!$programKerjaSelesai)
                                                                    <button type="button" class="btn btn-sm btn-info"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editMember{{ $anggota->user_id }}">
                                                                        <i class="icofont-edit"></i> Edit
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#deleteMember{{ $anggota->user_id }}">
                                                                        <i class="icofont-trash"></i> Hapus
                                                                    </button>
                                                                @else
                                                                    <span class="text-muted">Tidak tersedia</span>
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        <!-- Modal Edit Anggota -->
                                                        <div class="modal fade" id="editMember{{ $anggota->user_id }}"
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
                                                                        action="{{ route('program-kerja.anggota.update', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id, 'anggotaId' => $anggota->user_id]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="divisi_id"
                                                                            value="{{ $divisi->id }}">
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Nama
                                                                                    Anggota</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $anggota->name }}" disabled>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Jabatan</label>
                                                                                <select class="form-select"
                                                                                    name="jabatan_id">
                                                                                    @foreach ($jabatanList as $jabatan)
                                                                                        <option
                                                                                            value="{{ $jabatan->id }}"
                                                                                            {{ $anggota->jabatan_id == $jabatan->id ? 'selected' : '' }}>
                                                                                            {{ $jabatan->nama }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Divisi</label>
                                                                                <select class="form-select"
                                                                                    name="new_divisi_id">
                                                                                    @foreach ($divisiProker as $divisiOption)
                                                                                        <option
                                                                                            value="{{ $divisiOption->id }}"
                                                                                            {{ $divisi->id == $divisiOption->id ? 'selected' : '' }}>
                                                                                            {{ $divisiOption->nama }}
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

                                                        <!-- Modal Hapus Anggota -->
                                                        <div class="modal fade" id="deleteMember{{ $anggota->user_id }}"
                                                            tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Konfirmasi Hapus Anggota
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Apakah Anda yakin ingin menghapus
                                                                            <strong>{{ $anggota->name }}</strong> dari
                                                                            divisi <strong>{{ $divisi->nama }}</strong>?
                                                                        </p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <form
                                                                            action="{{ route('program-kerja.anggota.destroy', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id, 'anggotaId' => $anggota->user_id]) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <input type="hidden" name="divisi_id"
                                                                                value="{{ $divisi->id }}">
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Hapus</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">Belum ada anggota dalam
                                                            divisi ini</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Anggota -->
    <div class="modal fade" id="addmember" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addmemberLabel">Tambah Anggota Program Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form
                        action="{{ route('program-kerja.pilih-anggota', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id, 'periode' => $periode]) }}"
                        method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="anggota" class="form-label">Pilih Anggota</label>
                            <div class="d-flex align-items-center">
                                <select class="form-select z-10" id="multiple-select-field"
                                    data-placeholder="Choose anything" name="anggotas[]" multiple>
                                    @if (isset($availableUsers) && is_iterable($availableUsers))
                                        @forelse ($availableUsers as $user)
                                            <option value="{{ $user->id ?? '' }}">
                                                {{ $user->name ?? 'Nama tidak tersedia' }} ({{ $user->nrp ?? '' }})
                                            </option>
                                        @empty
                                            <option value="" disabled>Tidak ada anggota tersedia</option>
                                        @endforelse
                                    @else
                                        <option value="" disabled>Data anggota tidak ditemukan</option>
                                    @endif
                                </select>
                            </div>
                            @if (!isset($availableUsers) || !is_iterable($availableUsers))
                                <div class="text-danger mt-2 small">
                                    <i class="icofont-info-circle"></i> Terjadi kesalahan saat memuat data anggota
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="divisi" class="form-label">Pilih Divisi</label>
                            <div class="d-flex align-items-center">
                                <select class="form-select" id="single-select-field1" name="divisi"
                                    data-placeholder="Choose one thing">
                                    <option value="">-- Pilih Divisi --</option>
                                    @if (isset($divisiProker))
                                        @foreach ($divisiProker as $divisi)
                                            <option value="{{ $divisi->id }}">
                                                {{ $divisi->nama }}
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
                                    <option value="">-- Pilih Jabatan --</option>
                                    @if (isset($jabatanList))
                                        @foreach ($jabatanList as $jabatan)
                                            <option value="{{ $jabatan->id }}">
                                                {{ $jabatan->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah Anggota</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
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

            @if(session('validation_errors'))
                var validationErrors = @json(session('validation_errors'));
                displayErrorModal(validationErrors);
            @endif
        });

        $(document).ready(function() {
            // Inisialisasi select2 jika perlu
            if ($.fn.select2) {
                $('select[name="user_id"]').select2({
                    dropdownParent: $('#addMemberModal')
                });
            }
        });
    </script>
@endsection
