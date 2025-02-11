@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container py-4">
        <h2 class="fw-bold text-center mb-4">Meetings</h2>

        <!-- Search Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <input type="text" class="form-control form-control-lg w-75" placeholder="Search for a meeting...">
            <a href="{{ route('rapat.create', ['kode_ormawa' => Request::segment(1)]) }}" class="btn btn-primary btn-lg">+ Add Meeting</a>
        </div>

        <!-- Filter Buttons -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button class="btn btn-outline-dark">All Meetings</button>
            <button class="btn btn-outline-secondary">Your Meetings</button>
            <button class="btn btn-outline-secondary">Completed</button>
        </div>

        <!-- Meeting List -->
        <div class="row">
            @foreach ($meetings as $meeting)
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm p-3 d-flex flex-row align-items-center">
                        <div class="me-3">
                            <img src="{{ $meeting['image'] }}" class="rounded" width="150" height="100" alt="Meeting Image">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-1">{{ $meeting['title'] }}</h5>
                            <p class="text-muted small mb-1">
                                <strong>{{ $meeting['day'] }}, {{ $meeting['time'] }}</strong>
                            </p>
                            <p class="text-muted small mb-2">Hosted by: <strong>{{ $meeting['host'] }}</strong></p>
                            <a href="#" class="btn btn-primary btn-sm">Join</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>

    <script src="{{ asset('js/template.js') }}"></script>
@endsection
