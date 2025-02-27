@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold">{{ $rapat->nama }}</h2>
            <p class="text-muted">{{ $rapat->topik }}</p>
        </div>
    </div>

    <!-- Rincian Rapat -->
    <div class="card p-4 shadow-sm mb-4">
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <th scope="row">Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr class="border-top">
                    <th scope="row">Waktu</th>
                    <td>{{ \Carbon\Carbon::parse($rapat->waktu)->format('h:i A') }}</td>
                </tr>
                <tr class="border-top">
                    <th scope="row">Lokasi</th>
                    <td>{{ $rapat->tempat }}</td>
                </tr>
                <tr class="border-top">
                    <th scope="row">Kegiatan</th>
                    <td>{{ $rapat->tipe_penyelenggara }}</td>
                </tr>
                <tr class="border-top">
                    <th scope="row">Status</th>
                    <td>
                        <span class="badge bg-{{ $rapat->status == 'terjadwal' ? 'success' : 'secondary' }}">
                            {{ ucfirst($rapat->status) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Daftar Peserta -->
    <h4 class="fw-bold">Peserta</h4>
    <div class="list-group mt-3">
        @foreach($rapat->peserta as $peserta)
            <div class="list-group-item d-flex align-items-center">
                <img src="{{ asset('storage/profile/'.$peserta->user->foto) }}" class="rounded-circle me-3" width="50" height="50" alt="Foto Peserta">
                <div>
                    <strong>{{ $peserta->user->name }}</strong>
                    <p class="text-muted m-0">{{ $peserta->user->jabatan }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mb-4 mt-4">
        @php
            $izin = $rapat->izin()->where('user_id', auth()->id())->first();
            $daftarIzin = $rapat->izin()->with('user')->get();
        @endphp

        @if(!$izin)
            <p>Bila tidak bisa mengikuti rapat, silahkan izin melalui tombol di bawah.</p>
            <a type="button" class="btn btn-primary w-sm-100" data-bs-toggle="modal"
               data-bs-target="#izinrapat">Saya tidak bisa hadir</a>
        @else
            <p class="fw-bold">Anda sudah mengajukan izin untuk rapat ini.</p>
            <span class="badge bg-warning text-dark">Izin Diajukan - {{ $izin->status }}</span>
            <p class="text-muted mt-2"><strong>Alasan:</strong> {{ $izin->alasan }}</p>
        @endif

        <div class="mt-3">
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#daftarIzinModal">
                Lihat Izin Rapat
            </button>
        </div>
    </div>
</div>

<!-- Jquery Page Js -->
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('js/template.js') }}"></script>
@endsection
