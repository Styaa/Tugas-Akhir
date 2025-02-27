@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <!-- Body: Body -->
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom">
                        <h3 class="fw-bold mb-0">Calendar</h3>
                        <div class="col-auto d-flex">
                            <button type="button" class="btn btn-dark " data-bs-toggle="modal" data-bs-target="#addevent"><i
                                    class="icofont-plus-circle me-2 fs-6"></i>Add Event</button>
                        </div>
                    </div>
                </div>
            </div> <!-- Row end  -->
            <div class="row clearfix g-3">
                <div class="col-lg-12 col-md-12 ">
                    <!-- card: Calendar -->
                    <div class="card">
                        <div class="card-body" id='my_calendar'></div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var calendarEl = document.getElementById('my_calendar');

                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                    timeZone: 'UTC',
                                    initialView: 'dayGridMonth',
                                    editable: true,
                                    selectable: true,
                                    events: function(fetchInfo, successCallback, failureCallback) {
                                        // Kirim request untuk mengambil data events
                                        fetch("{{ route('events.get') }}?kode_ormawa={{ $kode_ormawa }}")
                                            .then(response => response.json())
                                            .then(data => {
                                                successCallback(data);
                                            })
                                            .catch(error => {
                                                console.error('Error fetching events:', error);
                                                failureCallback(error);
                                            });
                                    },
                                    eventClick: function(info) {
                                        alert('Event: ' + info.event.title);
                                        info.jsEvent.preventDefault();
                                    }
                                });

                                calendar.render();
                            });
                        </script>
                    </div>
                </div>
            </div><!-- Row End -->
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>

    <script src="{{ asset('assets/plugins/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>


@endsection
