@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container py-4">
        <h2 class="fw-bold text-center mb-4">Meetings</h2>

        <!-- Search Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <input type="text" class="form-control form-control-lg w-75" placeholder="Search for a meeting...">
            <a href="{{ route('rapat.create', ['kode_ormawa' => $kode_ormawa]) }}" class="btn btn-primary btn-lg">+ Add
                Meeting</a>
        </div>

        <!-- Filter Buttons -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button class="btn btn-outline-dark filter-btn active" data-filter="all">Semua Rapat</button>
            <button class="btn btn-outline-secondary filter-btn" data-filter="your_meetings">Rapat Anda</button>
        </div>

        <!-- Meeting List -->
        <div class="row meeting-list-container">
            @include('includes.partials.meeting-list', ['meetings' => $meetings])
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Filter button handling
            $('.filter-btn').on('click', function() {
                let filter = $(this).data('filter');
                let kodeOrmawa = "{{ $kode_ormawa }}";

                // Update active button
                $('.filter-btn').removeClass('active btn-dark').addClass('btn-outline-secondary');
                $(this).addClass('active btn-dark');

                $.ajax({
                    url: `/${kodeOrmawa}/rapat/all`,
                    type: 'GET',
                    data: {
                        filter: filter
                    },
                    success: function(response) {
                        $('.meeting-list-container').html(response.html);
                    },
                    error: function(xhr) {
                        alert("Terjadi kesalahan dalam memuat data rapat.");
                    }
                });
            });

            // Search functionality
            $('input[placeholder="Search for a meeting..."]').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();

                // Get current active filter
                const currentFilter = $('.filter-btn.active').data('filter');

                if (searchText.length > 0) {
                    // Client-side filtering for immediate response
                    $('.meeting-card').each(function() {
                        const meetingTitle = $(this).find('.meeting-title').text().toLowerCase();
                        const meetingDate = $(this).find('.meeting-date').text().toLowerCase();
                        const meetingLocation = $(this).find('.meeting-location').text()
                            .toLowerCase();

                        if (meetingTitle.includes(searchText) ||
                            meetingDate.includes(searchText) ||
                            meetingLocation.includes(searchText)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });

                    // Show "no results" message if all cards are hidden
                    if ($('.meeting-card:visible').length === 0) {
                        if ($('.no-results-message').length === 0) {
                            $('.meeting-list-container').append(
                                '<div class="col-12 text-center py-5 no-results-message">' +
                                '<i class="fas fa-search fa-3x text-muted mb-3"></i>' +
                                '<h4 class="text-muted">No meetings found matching "' + searchText +
                                '"</h4>' +
                                '</div>'
                            );
                        }
                    } else {
                        $('.no-results-message').remove();
                    }
                } else {
                    // If search field is emptied, reset to current filter view
                    $('.meeting-card').show();
                    $('.no-results-message').remove();

                    // Optional: refresh from server for complete reset
                    if (currentFilter) {
                        let kodeOrmawa = "{{ $kode_ormawa }}";
                        $.ajax({
                            url: `/${kodeOrmawa}/rapat/all`,
                            type: 'GET',
                            data: {
                                filter: currentFilter
                            },
                            success: function(response) {
                                $('.meeting-list-container').html(response.html);
                            }
                        });
                    }
                }
            });

            // Server-side search with 500ms debounce for performance
            let searchTimer;
            $('input[placeholder="Search for a meeting..."]').on('keyup', function() {
                const searchText = $(this).val();
                const currentFilter = $('.filter-btn.active').data('filter');
                const kodeOrmawa = "{{ $kode_ormawa }}";

                clearTimeout(searchTimer);

                // Only make the server request if at least 2 characters are entered
                if (searchText.length >= 2) {
                    searchTimer = setTimeout(function() {
                        $.ajax({
                            url: `/${kodeOrmawa}/rapat/all`,
                            type: 'GET',
                            data: {
                                filter: currentFilter,
                                search: searchText
                            },
                            success: function(response) {
                                $('.meeting-list-container').html(response.html);
                            }
                        });
                    }, 500); // Wait 500ms after typing stops
                }
            });
        });
    </script>
@endsection
