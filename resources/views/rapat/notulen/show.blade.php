@extends('layouts.app')

@section('title', 'Detail Notulen')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Detail Notulen</h3>
                            <div>
                                <a href="{{ route('rapat.notulen.index', ['kode_ormawa' => $ormawaKode]) }}"
                                    class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                @if (Auth::id() == $notulen->users_id)
                                    <a href="{{ route('rapat.notulen.edit', ['kode_ormawa' => $ormawaKode, 'id' => $notulen->id]) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                @endif
                                <button onclick="window.print()" class="btn btn-primary">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <h2 class="text-center font-weight-bold">{{ $notulen->title }}</h2>
                                <span class="badge badge-info">
                                    {{ $notulen->created_at->format('d M Y H:i') }}
                                </span>
                            </div>
                            <hr>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th style="width: 150px">Rapat</th>
                                            <td>: {{ $notulen->rapat ? $notulen->rapat->nama : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Rapat</th>
                                            <td>:
                                                {{ $notulen->rapat ? \Carbon\Carbon::parse($notulen->rapat->tanggal)->format('d M Y') : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Waktu</th>
                                            <td>:
                                                {{ $notulen->rapat ? \Carbon\Carbon::parse($notulen->rapat->waktu)->format('H:i') : '-' }}
                                                WIB</td>
                                        </tr>
                                        <tr>
                                            <th>Tempat</th>
                                            <td>: {{ $notulen->rapat ? $notulen->rapat->tempat : '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th style="width: 150px">Ormawa</th>
                                            <td>: {{ $notulen->ormawa ? $notulen->ormawa->nama : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penyelenggara</th>
                                            <td>:
                                                @if ($notulen->divisi_ormawas_id)
                                                    Divisi Ormawa:
                                                    {{ $notulen->divisiOrmawa ? $notulen->divisiOrmawa->nama : '-' }}
                                                @elseif($notulen->program_kerjas_id)
                                                    Program Kerja:
                                                    {{ $notulen->programKerja ? $notulen->programKerja->nama : '-' }}
                                                @elseif($notulen->divisi_program_kerjas_id)
                                                    Divisi Program Kerja:
                                                    {{ $notulen->divisiProgramKerja && $notulen->divisiProgramKerja->divisiPelaksana ? $notulen->divisiProgramKerja->divisiPelaksana->nama : '-' }}
                                                @else
                                                    Ormawa: {{ $notulen->ormawa ? $notulen->ormawa->nama : '-' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Ditulis Oleh</th>
                                            <td>: {{ $notulen->user ? $notulen->user->name : 'Unknown' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="content-section p-3">
                                <div class="notulen-content">
                                    {!! $notulen->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <span>
                                <i class="fas fa-user"></i> Dibuat oleh:
                                {{ $notulen->user ? $notulen->user->name : 'Unknown' }}
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i> Dibuat pada:
                                {{ $notulen->created_at->format('d M Y H:i') }}
                                @if ($notulen->created_at != $notulen->updated_at)
                                    | <i class="fas fa-edit"></i> Diperbarui pada:
                                    {{ $notulen->updated_at->format('d M Y H:i') }}
                                @endif
                            </span>
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
        @media print {

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
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }

            .notulen-content {
                font-size: 12pt;
            }

            /* Make sure the content is properly shown */
            .content-section {
                page-break-inside: avoid;
            }

            /* Ensure tables don't break across pages */
            table {
                page-break-inside: avoid;
            }

            /* Reset body padding */
            body {
                padding: 0 !important;
                margin: 0 !important;
            }
        }

        .content-section {
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        .notulen-content table {
            width: 100%;
            border-collapse: collapse;
        }

        .notulen-content table td,
        .notulen-content table th {
            padding: 8px;
            border: 1px solid #ddd;
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
    </style>
@endpush
