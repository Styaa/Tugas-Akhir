@extends('layouts.app')

@section('title', 'Detail Notulen')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="fas fa-file-alt mr-1"></i> Detail Notulen Rapat
                            </h3>
                            <div class="btn-group">
                                <a href="{{ route('rapat.notulen.index', ['kode_ormawa' => $kode_ormawa]) }}"
                                    class="btn btn-default btn-sm">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                                @if (Auth::id() == $notulen->user_id)
                                    <a href="{{ route('rapat.notulen.edit', ['kode_ormawa' => $kode_ormawa, 'id' => $notulen->id]) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                @endif
                                <button onclick="window.print()" class="btn btn-info btn-sm">
                                    <i class="fas fa-print mr-1"></i> Cetak
                                </button>
                                <a href="#" class="btn btn-primary btn-sm" onclick="generatePDF()">
                                    <i class="fas fa-download mr-1"></i> Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="notulen-container">
                            <!-- Header Notulen -->
                            <div class="notulen-header mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h1 class="notulen-title">{{ $notulen->title }}</h1>
                                    <div class="notulen-date">
                                        <span class="badge badge-info">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            {{ $notulen->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <!-- Informasi Notulen -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-info-circle mr-1"></i> Informasi Rapat
                                            </h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-striped mb-0">
                                                <tr>
                                                    <th style="width: 150px">Rapat</th>
                                                    <td>{{ $notulen->rapat ? $notulen->rapat->nama : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <td>{{ $notulen->rapat ? \Carbon\Carbon::parse($notulen->rapat->tanggal)->format('d M Y') : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Waktu</th>
                                                    <td>{{ $notulen->rapat ? \Carbon\Carbon::parse($notulen->rapat->waktu)->format('H:i') : '-' }}
                                                        WIB</td>
                                                </tr>
                                                <tr>
                                                    <th>Tempat</th>
                                                    <td>{{ $notulen->rapat ? $notulen->rapat->tempat : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tipe</th>
                                                    <td>
                                                        @if ($notulen->rapat)
                                                            <span
                                                                class="badge badge-{{ $notulen->rapat->tipe == 'online' ? 'success' : 'primary' }}">
                                                                {{ $notulen->rapat->tipe }}
                                                            </span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-users mr-1"></i> Informasi Penyelenggara
                                            </h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <table class="table table-striped mb-0">
                                                <tr>
                                                    <th style="width: 150px">Ormawa</th>
                                                    <td>{{ $notulen->ormawa ? $notulen->ormawa->nama : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Penyelenggara</th>
                                                    <td>
                                                        @if ($notulen->divisi_ormawas_id)
                                                            <span class="badge badge-info">Divisi Ormawa</span>
                                                            {{ $notulen->divisiOrmawa ? $notulen->divisiOrmawa->nama : '-' }}
                                                        @elseif($notulen->program_kerjas_id)
                                                            <span class="badge badge-success">Program Kerja</span>
                                                            {{ $notulen->programKerja ? $notulen->programKerja->nama : '-' }}
                                                        @elseif($notulen->divisi_program_kerjas_id)
                                                            <span class="badge badge-warning">Divisi Program Kerja</span>
                                                            {{ $notulen->divisiProgramKerja && $notulen->divisiProgramKerja->divisiPelaksana ? $notulen->divisiProgramKerja->divisiPelaksana->nama : '-' }}
                                                        @else
                                                            <span class="badge badge-primary">Ormawa</span>
                                                            {{ $notulen->ormawa ? $notulen->ormawa->nama : '-' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Ditulis Oleh</th>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('assets/dist/img/user-placeholder.jpg') }}"
                                                                alt="User" class="img-circle mr-2" width="25"
                                                                height="25">
                                                            {{ $notulen->user ? $notulen->user->name : 'Unknown' }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Dibuat Pada</th>
                                                    <td>{{ $notulen->created_at->format('d M Y H:i') }}</td>
                                                </tr>
                                                @if ($notulen->created_at != $notulen->updated_at)
                                                    <tr>
                                                        <th>Diperbarui Pada</th>
                                                        <td>{{ $notulen->updated_at->format('d M Y H:i') }}</td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Konten Notulen -->
                            <div class="notulen-content rounded p-4 border">
                                {!! $notulen->content !!}
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="notulen-meta">
                                <small class="text-muted">
                                    <i class="fas fa-history mr-1"></i>
                                    Terakhir diedit: {{ $notulen->updated_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="notulen-actions">
                                <div class="btn-group">
                                    @if (Auth::id() == $notulen->user_id)
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal">
                                            <i class="fas fa-trash mr-1"></i> Hapus Notulen
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        @if (Auth::id() == $notulen->user_id)
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title" id="deleteModalLabel">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Konfirmasi Hapus
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus notulen ini?</p>
                            <div class="alert alert-warning">
                                <strong>{{ $notulen->title }}</strong>
                            </div>
                            <p class="mb-0 text-danger">
                                <i class="fas fa-info-circle mr-1"></i>
                                Tindakan ini tidak dapat dibatalkan!
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
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
        @endif
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
@endsection

@push('styles')
    <style>
        /* Styling untuk halaman notulen */
        .notulen-title {
            font-size: 1.75rem;
            margin-bottom: 0;
        }

        .notulen-content {
            background-color: #fff;
            min-height: 300px;
        }

        .notulen-content table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        .notulen-content table td,
        .notulen-content table th {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }

        .notulen-content h1,
        .notulen-content h2,
        .notulen-content h3 {
            margin-top: 1em;
            margin-bottom: 0.5em;
        }

        .notulen-content ol,
        .notulen-content ul {
            padding-left: 20px;
        }

        @media print {
            body {
                background-color: #fff !important;
            }

            .card-header,
            .card-footer,
            .sidebar,
            .navbar,
            .main-header,
            .main-footer {
                display: none !important;
            }

            .content-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
                background-color: #fff !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
            }

            .card-body {
                padding: 0 !important;
            }

            /* Reset notulen container padding */
            .notulen-container {
                padding: 0 !important;
            }

            /* Make the content fill the page better */
            .notulen-content {
                border: none !important;
                padding: 0 !important;
            }

            /* Ensure tables don't break across pages */
            table {
                page-break-inside: avoid;
            }

            /* Remove background color from badges */
            .badge {
                border: 1px solid #000;
                background-color: transparent !important;
                color: #000 !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.
