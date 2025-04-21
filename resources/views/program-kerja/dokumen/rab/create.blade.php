@extends('layouts.app')

@section('content')
    @php
        $programKerjaSelesai = $programKerja->konfirmasi_penyelesaian == 'Ya';
    @endphp
    <div class="container mb-4">
        <h3 class="text-center fw-bold">Rancangan Anggaran Biaya</h3>
        <p class="text-center">{{ $programKerja->nama }} - Periode: {{ $periode }}</p>

        <form
            action="{{ route('program-kerja.rancanganAnggaranDana.store', ['kode_ormawa' => $kode_ormawa, 'prokerId' => $programKerja->id]) }}"
            method="post">
            @csrf
            <div class="mt-4">
                <h5 class="text-center fw-bold text-uppercase">Pemasukan</h5>
                <table class="table table-bordered">
                    <thead class="">
                        <tr>
                            <th>No</th>
                            <th>Komponen Biaya</th>
                            <th>Biaya</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pemasukan-body">
                        @forelse ($pemasukans as $index => $pemasukan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><input type="text" class="form-control" name="pemasukan[komponen][]"
                                        value="{{ $pemasukan->komponen_biaya }}" placeholder="Komponen Biaya"></td>
                                <td><input type="number" class="form-control biaya" name="pemasukan[biaya][]"
                                        value="{{ $pemasukan->biaya }}" placeholder="Biaya"></td>
                                <td><input type="number" class="form-control jumlah" name="pemasukan[jumlah][]"
                                        value="{{ $pemasukan->jumlah }}" placeholder="Jumlah"></td>
                                <td><input type="text" class="form-control satuan" name="pemasukan[satuan][]"
                                        value="{{ $pemasukan->satuan }}" placeholder="Satuan"></td>
                                <td><input type="number" class="form-control total" name="pemasukan[total][]"
                                        value="{{ $pemasukan->total }}" placeholder="Total" readonly></td>
                                <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                            </tr>
                        @empty
                            <tr>
                                <td>1</td>
                                <td><input type="text" class="form-control" name="pemasukan[komponen][]"
                                        placeholder="Komponen Biaya"></td>
                                <td><input type="number" class="form-control biaya" name="pemasukan[biaya][]"
                                        placeholder="Biaya"></td>
                                <td><input type="number" class="form-control jumlah" name="pemasukan[jumlah][]"
                                        placeholder="Jumlah"></td>
                                <td><input type="text" class="form-control satuan" name="pemasukan[satuan][]"
                                        placeholder="Satuan"></td>
                                <td><input type="number" class="form-control total" name="pemasukan[total][]"
                                        placeholder="Total" readonly></td>
                                <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary add-pemasukan" id="add-pemasukan">Tambah Pemasukan</button>
            </div>


            <div class="mt-4">
                <h5 class="text-center fw-bold text-uppercase">Pengeluaran Berdasarkan Divisi</h5>
                @foreach ($divisis as $item)
                    <div class="mt-4">
                        <h6 class="text-center fw-bold py-2">Divisi: {{ $item->divisiPelaksana->nama }}</h6>
                        <table class="table table-bordered">
                            <thead class="">
                                <tr>
                                    <th>No</th>
                                    <th>Komponen Biaya</th>
                                    <th>Biaya</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pengeluaran-body-{{ $item->id }}">
                                @forelse ($pengeluarans as $index => $pengeluaran)
                                    @if ($pengeluaran->divisi_program_kerjas_id == $item->id)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><input type="text" class="form-control"
                                                    name="pengeluaran[{{ $item->id }}][komponen][]"
                                                    value="{{ $pengeluaran->komponen_biaya }}"
                                                    placeholder="Komponen Biaya">
                                            </td>
                                            <td><input type="number" class="form-control biaya"
                                                    name="pengeluaran[{{ $item->id }}][biaya][]"
                                                    value="{{ $pengeluaran->biaya }}" placeholder="Biaya"></td>
                                            <td><input type="number" class="form-control jumlah"
                                                    name="pengeluaran[{{ $item->id }}][jumlah][]"
                                                    value="{{ $pengeluaran->jumlah }}" placeholder="Jumlah"></td>
                                            <td><input type="text" class="form-control satuan"
                                                    name="pengeluaran[{{ $item->id }}][satuan][]"
                                                    value="{{ $pengeluaran->satuan }}" placeholder="Satuan"></td>
                                            <td><input type="number" class="form-control total"
                                                    name="pengeluaran[{{ $item->id }}][total][]"
                                                    value="{{ $pengeluaran->total }}" placeholder="Total" readonly></td>
                                            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td>1</td>
                                        <td><input type="text" class="form-control"
                                                name="pengeluaran[{{ $item->id }}][komponen][]"
                                                placeholder="Komponen Biaya"></td>
                                        <td><input type="number" class="form-control biaya"
                                                name="pengeluaran[{{ $item->id }}][biaya][]" placeholder="Biaya">
                                        </td>
                                        <td><input type="number" class="form-control jumlah"
                                                name="pengeluaran[{{ $item->id }}][jumlah][]" placeholder="Jumlah">
                                        </td>
                                        <td><input type="text" class="form-control satuan"
                                                name="pengeluaran[{{ $item->id }}][satuan][]" placeholder="Satuan">
                                        </td>
                                        <td><input type="number" class="form-control total"
                                                name="pengeluaran[{{ $item->id }}][total][]" placeholder="Total"
                                                readonly></td>
                                        <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Total Pengeluaran Per Divisi -->
                        <div class="text-end fw-bold mt-2">
                            Total Pengeluaran Divisi: Rp <span id="total-pengeluaran-divisi-{{ $item->id }}">0</span>
                        </div>
                        <button type="button" class="btn btn-primary add-pengeluaran"
                            data-divisi-id="{{ $item->id }}">Tambah Pengeluaran</button>
                    </div>
                @endforeach
            </div>


            <!-- Total Anggaran -->
            <div class="mt-4">
                <h5>Total Anggaran</h5>
                <p>Total Pemasukan: <span id="total-pemasukan">Rp 0</span></p>
                <p>Total Pengeluaran: <span id="total-pengeluaran">Rp 0</span></p>
                <p>Selisih: <span id="selisih">Rp 0</span></p>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Simpan</button>
                {{-- <form
                    action="{{ route('program-kerja.rab.export', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                    method="POST" id="rab-download-form">
                    @csrf
                    <input type="hidden" id="rab-data" name="rab_data">

                    <!-- Tombol Download -->
                    <button type="submit" class="btn btn-info">Download Excel</button>
                </form> --}}

                {{-- <button type="button" class="btn btn-secondary">Download</button> --}}
                <a href="{{ route('program-kerja.show', ['kode_ormawa' => Request::segment(1), 'id' => $programKerja->id]) }}"
                    class="btn btn-dark">Kembali</a>
            </div>
        </form>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/custom/dokumen/rab.js') }}"></script>
@endsection
