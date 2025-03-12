@extends('layouts.app')

@section('js_head')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </link>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.css" crossorigin>
@endsection

@section('content')
    <div class="container">
        <div class="main-container">
            <h3 class="text-center fw-bold">Form Proposal Kegiatan</h3>
            <p class="text-center">Program Kerja: <strong>{{ $programKerja->nama }}</strong> - Periode: {{ $periode }}
            </p>
            <div class="presence" id="editor-presence"></div>
            <div class="editor-container editor-container_document-editor editor-container_include-outline editor-container_include-annotations editor-container_include-pagination"
                id="editor-container">
                <div class="editor-container__menu-bar" id="editor-menu-bar"></div>
                <div class="editor-container__toolbar" id="editor-toolbar"></div>
                <div class="editor-container__editor-wrapper">
                    <div class="editor-container__sidebar">
                        <div id="editor-outline"></div>
                    </div>
                    <div class="editor-container__editor">
                        <div id="editor"></div>
                    </div>
                    <div class="editor-container__sidebar">
                        <div id="editor-annotations"></div>
                    </div>
                </div>
            </div>
            <div class="revision-history" id="editor-revision-history">
                <div class="revision-history__wrapper">
                    <div class="revision-history__editor" id="editor-revision-history-editor"></div>
                    <div class="revision-history__sidebar" id="editor-revision-history-sidebar"></div>
                </div>
            </div>
        </div>
        {{-- <form
            action="{{ route('program-kerja.proposal.generate', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
            method="POST">
            @csrf


            <!-- Latar Belakang -->
            <div class="mt-4">
                <h5 class="fw-bold">Latar Belakang</h5>
                <textarea class="form-control ckeditor" id="latar_belakang" name="latar_belakang" rows="4">
                    {{ old('latar_belakang') }}
                </textarea>
            </div>

            <!-- Sasaran -->
            <div class="mt-4">
                <h5 class="fw-bold">Sasaran</h5>
                <textarea class="form-control" name="sasaran" rows="3" placeholder="Masukkan sasaran kegiatan">{{ old('sasaran') }}</textarea>
            </div>

            <!-- Tujuan -->
            <div class="mt-4">
                <h5 class="fw-bold">Tujuan</h5>
                <div id="tujuan-container">
                    <!-- Tujuan utama -->
                    <div class="mb-3 tujuan-item">
                        <input type="text" class="form-control mb-2 d-inline-block" name="tujuan[]"
                            placeholder="Masukkan tujuan kegiatan tambahan"></input>
                        <button type="button" class="btn btn-danger remove-tujuan">Hapus</button>
                    </div>
                </div>
                <button type="button" id="add-tujuan-proposal" class="btn btn-primary mt-2">Tambah Tujuan</button>
            </div>

            <!-- Bentuk Kegiatan -->
            <div class="mt-4">
                <h5 class="fw-bold">Bentuk Kegiatan</h5>
                <textarea class="form-control" name="bentuk_kegiatan" rows="3" placeholder="Masukkan bentuk kegiatan">{{ old('bentuk_kegiatan') }}</textarea>
            </div>

            <!-- Hari, Tanggal, dan Tempat -->
            <div class="mt-4">
                <h5 class="fw-bold">Hari, Tanggal, dan Tempat</h5>
                <input type="text" class="form-control mb-2" name="hari_tanggal"
                    placeholder="Masukkan hari dan tanggal kegiatan" value="{{ old('hari_tanggal') }}">
                <input type="text" class="form-control" name="tempat" placeholder="Masukkan tempat kegiatan"
                    value="{{ old('tempat') }}">
            </div>

            <!-- Rundown Kegiatan -->
            <div class="mt-4">
                <h5 class="fw-bold">Rundown Kegiatan</h5>
                <div id="rundown-container">
                    @foreach ($hariKegiatan as $index => $tanggal)
                        <div class="mb-3">
                            <h6>Hari {{ $index + 1 }}
                                ({{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }})
                            </h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Kegiatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="rundown-body-{{ $index + 1 }}">
                                    <tr>
                                        <td><input type="text" class="form-control"
                                                name="rundown[{{ $tanggal }}][waktu][]" placeholder="Waktu"></td>
                                        <td><input type="text" class="form-control"
                                                name="rundown[{{ $tanggal }}][kegiatan][]" placeholder="Kegiatan">
                                        </td>
                                        <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary add-rundown"
                                data-hari="{{ $index + 1 }}">Tambah Kegiatan</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Susunan Panitia Pelaksana -->
            <div class="mt-4">
                <h5 class="fw-bold">Susunan Panitia Pelaksana</h5>

                @php
                    $currentDivisi = null;
                @endphp

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Divisi</th>
                            <th>Nama</th>
                            <th>NRP</th>
                            <th>Jabatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggotaProker as $index => $anggotaDivisi)
                            @if ($currentDivisi !== $anggotaDivisi->nama_divisi)
                                @php
                                    $currentDivisi = $anggotaDivisi->nama_divisi;
                                @endphp
                                <!-- Menampilkan header divisi baru -->
                                <tr>
                                    <td colspan="5" class="fw-bold text-center bg-light">{{ $currentDivisi }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $anggotaDivisi->nama_divisi }}
                                    <input type="text" class="form-control"
                                        name="panitia[{{ $anggotaDivisi->nama_user }}][divisi]"
                                        value="{{ $anggotaDivisi->nama_divisi }}" hidden>
                                </td>
                                <td>{{ $anggotaDivisi->nama_user }}
                                    <input type="text" class="form-control"
                                        name="panitia[{{ $anggotaDivisi->nama_user }}][nama]"
                                        value="{{ $anggotaDivisi->nama_user }}" hidden>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                        name="panitia[{{ $anggotaDivisi->nama_user }}][nrp]" placeholder="Masukkan NRP">
                                </td>
                                <td>{{ $anggotaDivisi->nama_jabatan }}
                                    <input type="text" class="form-control"
                                        name="panitia[{{ $anggotaDivisi->nama_user }}][jabatan]"
                                        value="{{ $anggotaDivisi->nama_jabatan }}" hidden>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Indikator Keberhasilan -->
            <div class="mt-4">
                <h5 class="fw-bold">Indikator Keberhasilan</h5>
                <textarea class="form-control" name="indikator_keberhasilan" rows="3"
                    placeholder="Masukkan indikator keberhasilan">{{ old('indikator_keberhasilan') }}</textarea>
            </div>

            <!-- Anggaran Dana -->
            <div class="mt-4">
                <h5 class="fw-bold">Anggaran Dana</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Komponen Biaya</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="anggaran-body">
                        <tr>
                            <td>1</td>
                            <td><input type="text" class="form-control" name="anggaran[komponen][]"
                                    placeholder="Komponen Biaya"></td>
                            <td><input type="number" class="form-control" name="anggaran[jumlah][]"
                                    placeholder="Jumlah">
                            </td>
                            <td><input type="text" class="form-control" name="anggaran[satuan][]"
                                    placeholder="Satuan">
                            </td>
                            <td><input type="number" class="form-control" name="anggaran[harga][]" placeholder="Harga">
                            </td>
                            <td><input type="number" class="form-control" name="anggaran[total][]" placeholder="Total"
                                    readonly></td>
                            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" id="add-anggaran">Tambah Anggaran</button>
            </div>

            <!-- Penutup -->
            <div class="mt-4">
                <h5 class="fw-bold">Penutup</h5>
                <textarea class="form-control" name="penutup" rows="3" placeholder="Masukkan penutup">{{ old('penutup') }}</textarea>
            </div>

            <!-- Lembar Pengesahan -->
            <div class="mt-4">
                <h5 class="fw-bold">Lembar Pengesahan</h5>
                <div id="pengesahan-container">
                    <div class="mb-3 pengesahan-item">
                        <input type="text" class="form-control d-inline-block w-75" name="pengesahan[]"
                            placeholder="Nama Tanda Tangan">
                        <button type="button" class="btn btn-danger remove-pengesahan">Hapus</button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" id="add-pengesahan">Tambah Tanda Tangan</button>
            </div>

            <!-- Tombol Simpan -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Generate Proposal</button>
                <a href="{{ route('program-kerja.index', ['kode_ormawa' => $kode_ormawa]) }}"
                    class="btn btn-dark">Kembali</a>
            </div>
        </form> --}}
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/custom/dokumen/proposal.js') }}"></script>

    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js" crossorigin></script> --}}
    {{-- <script src="{{asset('assets/plugins/ckeditor/ckeditor.js')}}" crossorigin></script> --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/44.2.1/ckeditor5.umd.js" crossorigin></script>
    <script src="{{ asset('js/ckeditorProposal.js') }}"></script>
@endsection
