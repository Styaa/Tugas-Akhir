@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container py-4">
        <h2 class="fw-bold text-center mb-4">Meetings</h2>

        <!-- Search Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <input type="text" class="form-control form-control-lg w-75" placeholder="Search for a meeting...">
            <a href="{{ route('rapat.create', ['kode_ormawa' => $kode_ormawa]) }}" class="btn btn-primary btn-lg">+ Add Meeting</a>
        </div>

        <!-- Filter Buttons -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button class="btn btn-outline-dark filter-btn active" data-filter="all">Semua Rapat</button>
            <button class="btn btn-outline-secondary filter-btn" data-filter="your_meetings">Rapat Anda</button>
        </div>

        <!-- Meeting List -->
        <div class="row meeting-list-container">
            @include('includes.partials.meeting-list' , ['meetings' => $meetings])
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.filter-btn').on('click', function () {
                let filter = $(this).data('filter');
                let kodeOrmawa = "{{ $kode_ormawa }}"; // Ambil kode ormawa dari URL

                // Ubah tombol aktif
                $('.filter-btn').removeClass('active btn-dark').addClass('btn-outline-secondary');
                $(this).addClass('active btn-dark');

                $.ajax({
                    url: `/${kodeOrmawa}/rapat/all`, // Panggil route dengan kode ormawa
                    type: 'GET',
                    data: { filter: filter }, // Kirim filter ke backend
                    success: function (response) {
                        $('.meeting-list-container').html(response.html); // Perbarui daftar rapat
                    },
                    error: function (xhr) {
                        alert("Terjadi kesalahan dalam memuat data rapat.");
                    }
                });
            });
        });
    </script>
@endsection
