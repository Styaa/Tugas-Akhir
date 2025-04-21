@extends('layouts.app')

@section('content')
    <div class="container mb-4">
        <!-- Program Status Alert -->
        @php
            $programKerjaSelesai = $programKerja->konfirmasi_penyelesaian == 'Ya';
        @endphp

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="text-center fw-bold mb-0">Rancangan Anggaran Biaya</h3>
            </div>
            <div class="card-body">
                <p class="text-center mb-0">{{ $programKerja->nama }} - Periode: {{ $periode }}</p>
            </div>
        </div>

        @if ($programKerjaSelesai)
            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="icofont-info-circle fs-4 me-2"></i>
                    <div>
                        <strong>Program kerja telah selesai!</strong>
                        <p class="mb-0">Anggaran program kerja ini hanya dapat dilihat karena program kerja telah
                            dikonfirmasi selesai.</p>
                    </div>
                </div>
            </div>
        @endif

        <form
            action="{{ route('program-kerja.rancanganAnggaranDana.store', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id]) }}"
            method="post">
            @csrf

            <!-- Summary Card -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Ringkasan Anggaran</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center g-3">
                        <!-- Total Pemasukan -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h6 class="fw-bold text-muted mb-2">Total Pemasukan</h6>
                                <p class="fs-5 text-success fw-bold mb-0" id="total-pemasukan-display">
                                    Rp <span id="total-pemasukan">0</span>
                                </p>
                            </div>
                        </div>

                        <!-- Total Pengeluaran -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h6 class="fw-bold text-muted mb-2">Total Pengeluaran</h6>
                                <p class="fs-5 text-danger fw-bold mb-0" id="total-pengeluaran-display">
                                    Rp <span id="total-pengeluaran">0</span>
                                </p>
                            </div>
                        </div>

                        <!-- Selisih Anggaran -->
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <h6 class="fw-bold text-muted mb-2">Selisih Anggaran</h6>
                                <p class="fs-5 fw-bold mb-0" id="selisih-display">
                                    Rp <span id="selisih">0</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemasukan Section -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">PEMASUKAN</h5>
                    @if (!$programKerjaSelesai)
                        <button type="button" class="btn btn-light btn-sm" id="add-pemasukan">
                            <i class="icofont-plus-circle me-1"></i>Tambah Pemasukan
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Komponen Biaya</th>
                                    <th width="15%">Biaya</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Satuan</th>
                                    <th width="15%">Total</th>
                                    @if (!$programKerjaSelesai)
                                        <th width="10%">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="pemasukan-body">
                                @forelse ($pemasukans as $index => $pemasukan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($programKerjaSelesai)
                                                <span>{{ $pemasukan->komponen_biaya }}</span>
                                                <input type="hidden" name="pemasukan[komponen][]"
                                                    value="{{ $pemasukan->komponen_biaya }}">
                                            @else
                                                <input type="text" class="form-control" name="pemasukan[komponen][]"
                                                    value="{{ $pemasukan->komponen_biaya }}" placeholder="Komponen Biaya">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($programKerjaSelesai)
                                                <span>Rp {{ number_format($pemasukan->biaya, 0, ',', '.') }}</span>
                                                <input type="hidden" name="pemasukan[biaya][]"
                                                    value="{{ $pemasukan->biaya }}">
                                            @else
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control biaya"
                                                        name="pemasukan[biaya][]" value="{{ $pemasukan->biaya }}"
                                                        placeholder="Biaya">
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($programKerjaSelesai)
                                                <span>{{ $pemasukan->jumlah }}</span>
                                                <input type="hidden" name="pemasukan[jumlah][]"
                                                    value="{{ $pemasukan->jumlah }}">
                                            @else
                                                <input type="number" class="form-control jumlah" name="pemasukan[jumlah][]"
                                                    value="{{ $pemasukan->jumlah }}" placeholder="Jumlah">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($programKerjaSelesai)
                                                <span>{{ $pemasukan->satuan }}</span>
                                                <input type="hidden" name="pemasukan[satuan][]"
                                                    value="{{ $pemasukan->satuan }}">
                                            @else
                                                <input type="text" class="form-control satuan" name="pemasukan[satuan][]"
                                                    value="{{ $pemasukan->satuan }}" placeholder="Satuan">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($programKerjaSelesai)
                                                <span class="fw-bold">Rp
                                                    {{ number_format($pemasukan->total, 0, ',', '.') }}</span>
                                                <input type="hidden" name="pemasukan[total][]"
                                                    value="{{ $pemasukan->total }}">
                                            @else
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control total"
                                                        name="pemasukan[total][]" value="{{ $pemasukan->total }}"
                                                        placeholder="Total" readonly>
                                                </div>
                                            @endif
                                        </td>
                                        @if (!$programKerjaSelesai)
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                                                    <i class="icofont-trash me-1"></i>Hapus
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    @if (!$programKerjaSelesai)
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input type="text" class="form-control" name="pemasukan[komponen][]"
                                                    placeholder="Komponen Biaya">
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control biaya"
                                                        name="pemasukan[biaya][]" placeholder="Biaya">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control jumlah"
                                                    name="pemasukan[jumlah][]" placeholder="Jumlah">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control satuan"
                                                    name="pemasukan[satuan][]" placeholder="Satuan">
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control total"
                                                        name="pemasukan[total][]" placeholder="Total" readonly>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                                                    <i class="icofont-trash me-1"></i>Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="{{ $programKerjaSelesai ? '6' : '7' }}"
                                                class="text-center py-3">
                                                <i class="icofont-warning-alt fs-4 text-warning"></i>
                                                <p class="mb-0">Belum ada data pemasukan</p>
                                            </td>
                                        </tr>
                                    @endif
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran Section -->
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="fw-bold mb-0">PENGELUARAN BERDASARKAN DIVISI</h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionPengeluaran">
                        @foreach ($divisis as $index => $item)
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="heading{{ $item->id }}">
                                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}"
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                        aria-controls="collapse{{ $item->id }}">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span><i class="icofont-users-alt-3 me-2"></i>Divisi:
                                                {{ $item->divisiPelaksana->nama }}</span>
                                            <span class="badge bg-dark ms-2">Total: Rp <span
                                                    id="total-pengeluaran-divisi-{{ $item->id }}">0</span></span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $item->id }}"
                                    class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                    aria-labelledby="heading{{ $item->id }}" data-bs-parent="#accordionPengeluaran">
                                    <div class="accordion-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="30%">Komponen Biaya</th>
                                                        <th width="15%">Biaya</th>
                                                        <th width="10%">Jumlah</th>
                                                        <th width="15%">Satuan</th>
                                                        <th width="15%">Total</th>
                                                        @if (!$programKerjaSelesai)
                                                            <th width="10%">Aksi</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody id="pengeluaran-body-{{ $item->id }}">
                                                    @php
                                                        $divisiHasPengeluaran = false;
                                                        foreach ($pengeluarans as $pengeluaran) {
                                                            if ($pengeluaran->divisi_program_kerjas_id == $item->id) {
                                                                $divisiHasPengeluaran = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp

                                                    @if ($divisiHasPengeluaran)
                                                        @php $counter = 1; @endphp
                                                        @foreach ($pengeluarans as $pengeluaran)
                                                            @if ($pengeluaran->divisi_program_kerjas_id == $item->id)
                                                                <tr>
                                                                    <td>{{ $counter++ }}</td>
                                                                    <td>
                                                                        @if ($programKerjaSelesai)
                                                                            <span>{{ $pengeluaran->komponen_biaya }}</span>
                                                                            <input type="hidden"
                                                                                name="pengeluaran[{{ $item->id }}][komponen][]"
                                                                                value="{{ $pengeluaran->komponen_biaya }}">
                                                                        @else
                                                                            <input type="text" class="form-control"
                                                                                name="pengeluaran[{{ $item->id }}][komponen][]"
                                                                                value="{{ $pengeluaran->komponen_biaya }}"
                                                                                placeholder="Komponen Biaya">
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($programKerjaSelesai)
                                                                            <span>Rp
                                                                                {{ number_format($pengeluaran->biaya, 0, ',', '.') }}</span>
                                                                            <input type="hidden"
                                                                                name="pengeluaran[{{ $item->id }}][biaya][]"
                                                                                value="{{ $pengeluaran->biaya }}">
                                                                        @else
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">Rp</span>
                                                                                <input type="number"
                                                                                    class="form-control biaya"
                                                                                    name="pengeluaran[{{ $item->id }}][biaya][]"
                                                                                    value="{{ $pengeluaran->biaya }}"
                                                                                    placeholder="Biaya">
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($programKerjaSelesai)
                                                                            <span>{{ $pengeluaran->jumlah }}</span>
                                                                            <input type="hidden"
                                                                                name="pengeluaran[{{ $item->id }}][jumlah][]"
                                                                                value="{{ $pengeluaran->jumlah }}">
                                                                        @else
                                                                            <input type="number"
                                                                                class="form-control jumlah"
                                                                                name="pengeluaran[{{ $item->id }}][jumlah][]"
                                                                                value="{{ $pengeluaran->jumlah }}"
                                                                                placeholder="Jumlah">
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($programKerjaSelesai)
                                                                            <span>{{ $pengeluaran->satuan }}</span>
                                                                            <input type="hidden"
                                                                                name="pengeluaran[{{ $item->id }}][satuan][]"
                                                                                value="{{ $pengeluaran->satuan }}">
                                                                        @else
                                                                            <input type="text"
                                                                                class="form-control satuan"
                                                                                name="pengeluaran[{{ $item->id }}][satuan][]"
                                                                                value="{{ $pengeluaran->satuan }}"
                                                                                placeholder="Satuan">
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($programKerjaSelesai)
                                                                            <span class="fw-bold">Rp
                                                                                {{ number_format($pengeluaran->total, 0, ',', '.') }}</span>
                                                                            <input type="hidden"
                                                                                name="pengeluaran[{{ $item->id }}][total][]"
                                                                                value="{{ $pengeluaran->total }}">
                                                                        @else
                                                                            <div class="input-group">
                                                                                <span class="input-group-text">Rp</span>
                                                                                <input type="number"
                                                                                    class="form-control total"
                                                                                    name="pengeluaran[{{ $item->id }}][total][]"
                                                                                    value="{{ $pengeluaran->total }}"
                                                                                    placeholder="Total" readonly>
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    @if (!$programKerjaSelesai)
                                                                        <td>
                                                                            <button type="button"
                                                                                class="btn btn-outline-danger btn-sm remove-row">
                                                                                <i class="icofont-trash me-1"></i>Hapus
                                                                            </button>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @elseif (!$programKerjaSelesai)
                                                        <tr>
                                                            <td>1</td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="pengeluaran[{{ $item->id }}][komponen][]"
                                                                    placeholder="Komponen Biaya">
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Rp</span>
                                                                    <input type="number" class="form-control biaya"
                                                                        name="pengeluaran[{{ $item->id }}][biaya][]"
                                                                        placeholder="Biaya">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control jumlah"
                                                                    name="pengeluaran[{{ $item->id }}][jumlah][]"
                                                                    placeholder="Jumlah">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control satuan"
                                                                    name="pengeluaran[{{ $item->id }}][satuan][]"
                                                                    placeholder="Satuan">
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Rp</span>
                                                                    <input type="number" class="form-control total"
                                                                        name="pengeluaran[{{ $item->id }}][total][]"
                                                                        placeholder="Total" readonly>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm remove-row">
                                                                    <i class="icofont-trash me-1"></i>Hapus
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="{{ $programKerjaSelesai ? '6' : '7' }}"
                                                                class="text-center py-3">
                                                                <i class="icofont-warning-alt fs-4 text-warning"></i>
                                                                <p class="mb-0">Belum ada data pengeluaran untuk divisi
                                                                    ini</p>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        @if (!$programKerjaSelesai)
                                            <button type="button" class="btn btn-primary add-pengeluaran mt-2"
                                                data-divisi-id="{{ $item->id }}">
                                                <i class="icofont-plus-circle me-1"></i>Tambah Pengeluaran
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('program-kerja.show', ['kode_ormawa' => Request::segment(1), 'id' => $programKerja->id]) }}"
                            class="btn btn-outline-secondary">
                            <i class="icofont-arrow-left me-1"></i>Kembali
                        </a>

                        <div>
                            @if (!$programKerjaSelesai)
                                <button type="submit" class="btn btn-success">
                                    <i class="icofont-save me-1"></i>Simpan
                                </button>
                            @endif

                            <button type="button" class="btn btn-info" id="download-excel-btn">
                                <i class="icofont-download me-1"></i>Unduh Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/custom/dokumen/rab.js') }}"></script>
@endsection
