@extends('layouts.app')

@section('title', 'Daftar Notulen')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="fas fa-file-alt mr-1"></i> Daftar Notulen Rapat
                            </h3>
                            <a href="{{ route('rapat.tulis_notulensi', ['kode_ormawa' => $kode_ormawa]) }}"
                                class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Buat Notulen Baru
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('rapat.notulen.index', ['kode_ormawa' => $kode_ormawa]) }}"
                                    method="GET">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control"
                                                    placeholder="Cari judul notulen..." value="{{ request('search') }}">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="filter" class="form-control">
                                                <option value="">-- Semua Penyelenggara --</option>
                                                <option value="ormawa"
                                                    {{ request('filter') == 'ormawa' ? 'selected' : '' }}>
                                                    Ormawa
                                                </option>
                                                <option value="divisi_ormawa"
                                                    {{ request('filter') == 'divisi_ormawa' ? 'selected' : '' }}>
                                                    Divisi Ormawa
                                                </option>
                                                <option value="program_kerja"
                                                    {{ request('filter') == 'program_kerja' ? 'selected' : '' }}>
                                                    Program Kerja
                                                </option>
                                                <option value="divisi_program_kerja"
                                                    {{ request('filter') == 'divisi_program_kerja' ? 'selected' : '' }}>
                                                    Divisi Program Kerja
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-info">
                                                    <i class="fas fa-filter mr-1"></i> Filter
                                                </button>
                                                @if (request('search') || request('filter'))
                                                    <a href="{{ route('rapat.notulen.index', ['kode_ormawa' => $kode_ormawa]) }}"
                                                        class="btn btn-default">
                                                        <i class="fas fa-undo mr-1"></i> Reset
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover datatable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" style="width: 50px">No</th>
                                        <th>Judul</th>
                                        <th>Rapat</th>
                                        <th>Penyelenggara</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Tanggal</th>
                                        <th class="text-center" style="width: 180px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($notulens as $index => $notulen)
                                        <tr>
                                            <td class="text-center">{{ $index + $notulens->firstItem() }}</td>
                                            <td>
                                                <strong>{{ $notulen->title }}</strong>
                                            </td>
                                            <td>
                                                @if ($notulen->rapat)
                                                    <span class="d-block">{{ $notulen->rapat->nama }}</span>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($notulen->rapat->tanggal)->format('d/m/Y') }}
                                                        •
                                                        {{ \Carbon\Carbon::parse($notulen->rapat->waktu)->format('H:i') }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($notulen->divisi_ormawas_id)
                                                    <span class="badge badge-info">Divisi Ormawa</span>
                                                    <span
                                                        class="d-block mt-1">{{ $notulen->divisiOrmawa ? $notulen->divisiOrmawa->nama : '-' }}</span>
                                                @elseif($notulen->program_kerjas_id)
                                                    <span class="badge badge-success">Program Kerja</span>
                                                    <span
                                                        class="d-block mt-1">{{ $notulen->programKerja ? $notulen->programKerja->nama : '-' }}</span>
                                                @elseif($notulen->divisi_program_kerjas_id)
                                                    <span class="badge badge-warning">Divisi Program Kerja</span>
                                                    <span
                                                        class="d-block mt-1">{{ $notulen->divisiProgramKerja && $notulen->divisiProgramKerja->divisiPelaksana ? $notulen->divisiProgramKerja->divisiPelaksana->nama : '-' }}</span>
                                                @else
                                                    <span class="badge badge-primary">Ormawa</span>
                                                    <span
                                                        class="d-block mt-1">{{ $notulen->ormawa ? $notulen->ormawa->nama : '-' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    {{-- <div class="user-avatar mr-2">
                                                        <img src="{{ asset('assets/dist/img/user-placeholder.jpg') }}"
                                                            alt="User" class="img-circle" width="30" height="30">
                                                    </div> --}}
                                                    <div>
                                                        {{ $notulen->user ? $notulen->user->name : 'Unknown' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    {{ $notulen->created_at->format('d M Y') }}
                                                    <br>
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ $notulen->created_at->format('H:i') }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('rapat.notulen.show', ['kode_ormawa' => $kode_ormawa, 'id' => $notulen->id]) }}"
                                                        class="btn btn-sm btn-info" data-toggle="tooltip" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if (Auth::id() == $notulen->user_id)
                                                        <a href="{{ route('rapat.notulen.edit', ['kode_ormawa' => $kode_ormawa, 'id' => $notulen->id]) }}"
                                                            class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $notulen->id }}"
                                                            data-toggle="tooltip" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>

                                                <!-- Modal Konfirmasi Hapus -->
                                                <div class="modal fade" id="deleteModal{{ $notulen->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="deleteModalLabel{{ $notulen->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $notulen->id }}">
                                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                    Konfirmasi Hapus
                                                                </h5>
                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin menghapus notulen:</p>
                                                                <div class="alert alert-warning">
                                                                    <strong>{{ $notulen->title }}</strong>
                                                                </div>
                                                                <p class="mb-0 text-danger">
                                                                    <i class="fas fa-info-circle mr-1"></i>
                                                                    Tindakan ini tidak dapat dibatalkan!
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">
                                                                    <i class="fas fa-times mr-1"></i> Batal
                                                                </button>
                                                                <form
                                                                    action="{{ route('rapat.notulen.destroy', ['kode_ormawa' => $kode_ormawa, 'id' => $notulen->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="empty-state">
                                                    <img src="{{ asset('assets/dist/img/document-empty.svg') }}"
                                                        alt="Empty" style="width: 100px; height: auto; opacity: 0.5">
                                                    <p class="mt-3 mb-0 text-muted">Tidak ada data notulen</p>
                                                    <a href="{{ route('rapat.tulis_notulensi', ['kode_ormawa' => $kode_ormawa]) }}"
                                                        class="btn btn-primary btn-sm mt-3">
                                                        <i class="fas fa-plus mr-1"></i> Buat Notulen Baru
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <small class="text-muted">
                                    Menampilkan {{ $notulens->firstItem() ?? 0 }} sampai {{ $notulens->lastItem() ?? 0 }}
                                    dari {{ $notulens->total() ?? 0 }} entri
                                </small>
                            </div>
                            <div>
                                {{ $notulens->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('dashboard', ['kode_ormawa' => $kode_ormawa]) }}"
                                    class="btn btn-default btn-sm">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('rapat.index', ['kode_ormawa' => $kode_ormawa]) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-calendar-alt mr-1"></i> Daftar Rapat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
@endsection

@push('styles')
    <style>
        .datatable th {
            vertical-align: middle;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .user-avatar img {
            object-fit: cover;
        }

        .badge {
            padding: 5px 8px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Datatables configuration if needed
            // $('.datatable').DataTable({ ... });

            // Success and error notifications
            @if (session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if (session('error'))
                toastr.error('{{ session('error') }}');
            @endif
        });
    </script>
@endpush
