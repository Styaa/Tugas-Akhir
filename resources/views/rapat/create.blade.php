@extends('layouts.app')

@section('title', __('Dashboard'))

@section('js_head')
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg rounded-lg p-4">
            <div id="stepWizard">
                <form action="{{ route('rapat.store', ['kode_ormawa' => $kode_ormawa]) }}" id="rapatForm" method="post">
                    @csrf
                    <!-- Progress Bar -->
                    <div class="progress mb-4" style="height: 8px;">
                        <div id="progress-bar" class="progress-bar bg-primary"
                            style="width: 25%; transition: width 0.3s ease-in-out;"></div>
                    </div>

                    <!-- Step 1: Pilih Tipe Rapat -->
                    <div class="step" id="step-1">
                        <h4 class="fw-bold mb-3">Step 1: Choose a meeting type</h4>
                        <p class="text-muted mb-4">Choose the meeting type that best fits your needs.</p>

                        <input type="hidden" id="meetingType" name="meetingType">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card h-100 meeting-type-card" onclick="selectMeetingType('Rapat Ormawa', event)"
                                    role="button">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-users mb-3 fa-2x text-primary"></i>
                                        <h5 class="card-title">Rapat Ormawa</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 meeting-type-card"
                                    onclick="selectMeetingType('Rapat Divisi Ormawa', event)" role="button">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-sitemap mb-3 fa-2x text-primary"></i>
                                        <h5 class="card-title">Rapat Divisi Ormawa</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 meeting-type-card"
                                    onclick="selectMeetingType('Rapat Program Kerja', event)" role="button">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-tasks mb-3 fa-2x text-primary"></i>
                                        <h5 class="card-title">Rapat Program Kerja</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 meeting-type-card"
                                    onclick="selectMeetingType('Rapat Divisi Program Kerja', event)" role="button">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-project-diagram mb-3 fa-2x text-primary"></i>
                                        <h5 class="card-title">Rapat Divisi Program Kerja</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="additional-options" class="mt-4"></div>
                        <div id="step1-error" class="text-danger mt-2 d-none">Please select a meeting type to continue.
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary" onclick="validateAndNextStep()">Continue <i
                                    class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <!-- Step 2: Detail Rapat -->
                    <div class="step d-none" id="step-2">
                        <h4 class="fw-bold">Step 2: Enter Meeting Details</h4>

                        <div class="mb-3">
                            <label class="form-label">Meeting Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="meetingName" name="meetingName"
                                placeholder="Enter meeting name" required>
                            <div class="invalid-feedback">Meeting Name is required.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Topic <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="meetingTopic" name="meetingTopic" placeholder="Enter topic" required></textarea>
                            <div class="invalid-feedback">Topic is required.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="meetingDate" name="meetingDate" required>
                                <div class="invalid-feedback">Date is required.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="meetingTime" name="meetingTime" required>
                                <div class="invalid-feedback">Time is required.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meeting Type <span class="text-danger">*</span></label>
                            <select class="form-control" id="sessionFormat" name="sessionFormat" required>
                                <option value="" selected disabled>Select meeting type</option>
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                            </select>
                            <div class="invalid-feedback">Meeting type is required.</div>
                        </div>

                        <div class="mb-3" id="locationField" style="display: none;">
                            <label class="form-label" id="locationLabel">Location <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="meetingLocation" name="meetingLocation"
                                placeholder="Enter meeting location">
                            <div class="invalid-feedback">Location or link is required.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()"><i
                                    class="fas fa-arrow-left ms-2"></i> Back</button>
                            <button type="button" class="btn btn-primary" onclick="validateAndNextStep()">Continue <i
                                    class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <!-- Step 3: Select Attendees -->
                    <div id="step-3" x-transition class="space-y-6 step d-none">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <i class="fas fa-user-check text-primary fs-4"></i>
                            <h2 class="fs-4 fw-bold text-dark">Select Attendees</h2>
                        </div>

                        <div class="bg-white shadow-sm rounded-lg border border-light">
                            <div class="p-4">
                                <!-- Selection Tools -->
                                <div class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                        <h6 class="fw-semibold text-dark mb-0">Quick Selection Tools</h6>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary mr-4"
                                                id="selectAll">Select
                                                All</button>
                                            <button type="button" class="btn btn-outline-secondary"
                                                id="deselectAll">Deselect All</button>
                                        </div>
                                    </div>

                                    <div class="row g-2 mt-3">
                                        <!-- Filter by Division -->
                                        {{-- <div class="col-md-4">
                                            <select class="form-select form-select-sm" id="filterByDivision">
                                                <option value="">Filter by Division</option>
                                                <option value="select-all-divisions">All Divisions</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}">{{ $division->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filter by Role -->
                                        <div class="col-md-4">
                                            <select class="form-select form-select-sm" id="filterByRole">
                                                <option value="">Filter by Role</option>
                                                <option value="select-all-roles">All Roles</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        <!-- Search Members -->
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-search text-muted"></i>
                                                </span>
                                                <input type="text" class="form-control bg-light border-start-0"
                                                    id="searchMembers" placeholder="Search members...">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Selection Count Badge -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label fw-semibold text-dark mb-0">Select Participants</label>
                                        <span class="badge bg-primary" id="selectedCount">0 selected</span>
                                    </div>
                                </div>

                                <!-- Participant List with Checkboxes -->
                                <div class="border rounded-lg overflow-auto" style="max-height: 300px;"
                                    id="participantContainer">
                                    <!-- Participant list will be grouped by division -->
                                    @php
                                        // Group users by their division
                                        $usersByDivision = [];
                                        foreach ($users as $user) {
                                            $divisionName = $user->division ? $user->division->nama : 'No Division';
                                            if (!isset($usersByDivision[$divisionName])) {
                                                $usersByDivision[$divisionName] = [];
                                            }
                                            $usersByDivision[$divisionName][] = $user;
                                        }
                                    @endphp

                                    @foreach ($usersByDivision as $divisionName => $divisionUsers)
                                        <div class="participant-group">
                                            <div
                                                class="bg-light p-2 border-bottom d-flex justify-content-between align-items-center">
                                                <span class="fw-medium">{{ $divisionName }}</span>
                                                <button type="button" class="btn btn-sm btn-link select-division"
                                                    data-division="{{ $divisionName }}">Select All</button>
                                            </div>

                                            @foreach ($divisionUsers as $user)
                                                <label class="participant-item d-flex align-items-center p-3 border-bottom"
                                                    data-division="{{ $divisionName }}"
                                                    data-division-id="{{ $user->division ? $user->division->id : '' }}"
                                                    data-role="{{ $user->role ? $user->role->nama : 'No Role' }}"
                                                    data-name="{{ strtolower($user->name) }}"
                                                    @if (!empty($user->program_ids)) data-program-ids="{{ json_encode($user->program_ids) }}" @endif
                                                    @if (!empty($user->division_proker_ids)) data-division-proker-ids="{{ json_encode($user->division_proker_ids) }}" @endif>
                                                    <input type="checkbox" name="participants[]"
                                                        value="{{ $user->id }}"
                                                        class="form-check-input participant-checkbox me-3"
                                                        data-division="{{ $divisionName }}"
                                                        data-division-id="{{ $user->division ? $user->division->id : '' }}"
                                                        @if (!empty($user->program_ids)) data-program-ids="{{ json_encode($user->program_ids) }}" @endif
                                                        @if (!empty($user->division_proker_ids)) data-division-proker-ids="{{ json_encode($user->division_proker_ids) }}" @endif>
                                                    <div>
                                                        <span class="d-block text-dark">{{ $user->name }}</span>
                                                        <small
                                                            class="text-muted">{{ $user->role ? $user->role->nama : '' }}</small>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endforeach

                                    <!-- Empty state if no users found -->
                                    <div id="no-results" class="p-4 text-center d-none">
                                        <i class="fas fa-search fa-2x text-muted mb-3"></i>
                                        <p>No members match your search criteria</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mb-4 mx-4">
                                <button type="button" class="btn btn-secondary" onclick="prevStep()">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary" onclick="validateAndNextStep()">
                                    Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Review Meeting Details -->
                    <div id="step-4" x-transition class="space-y-6 step d-none">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <i class="fas fa-clipboard-list text-primary fs-4"></i>
                            <h2 class="fs-6 fw-bold text-dark">Review Meeting Details</h2>
                        </div>

                        <div class="bg-white shadow-sm rounded-lg border border-light fs-6">
                            <div class="p-4">
                                <p class="text-muted">Please review the details before submitting.</p>

                                <div class="bg-light rounded-lg p-3">
                                    <div class="mb-2">
                                        <strong class="text-muted">Meeting Type:</strong>
                                        <span class="text-dark" id="reviewType"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Meeting Name:</strong>
                                        <span class="text-dark" id="reviewName"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Topic:</strong>
                                        <span class="text-dark" id="reviewTopic"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Date:</strong>
                                        <span class="text-dark" id="reviewDate"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Time:</strong>
                                        <span class="text-dark" id="reviewTime"></span>
                                    </div>
                                    <div>
                                        <strong class="text-muted">Location:</strong>
                                        <span class="text-dark" id="reviewLocation"></span>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="px-4 py-3 bg-light border-top justify-content-end gap-2 rounded-bottom d-flex justify-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep()"><i
                                        class="fas fa-arrow-left ms-2"></i> Back</button>
                                <button type="submit" class="btn btn-success">
                                    Confirm Meeting <i class="fas fa-check ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Styling -->
    <style>
        .meeting-type-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .meeting-type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .meeting-type-card.selected {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .progress-bar {
            transition: width 0.3s ease-in-out;
        }
    </style>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Global variables
        let currentStep = 1;
        let selectedType = null;
        let kodeOrmawa = "{{ $kode_ormawa }}";
        let participantsSelected = false;
        let selectedDivisionId = null;
        let selectedProgramId = null;
        let selectedDivisionProkerId = null;

        // Pilih tipe rapat
        function selectMeetingType(type, event) {
            selectedType = type;
            // Reset selection flags when type changes
            participantsSelected = false;
            selectedDivisionId = null;
            selectedProgramId = null;
            selectedDivisionProkerId = null;

            document.getElementById('meetingType').value = type;
            // Remove 'selected' class from all meeting cards
            document.querySelectorAll('.meeting-type-card').forEach(card => card.classList.remove('selected'));

            // Add 'selected' class to clicked card
            event.currentTarget.classList.add('selected');
            document.getElementById('step1-error').classList.add('d-none');

            let additionalOptions = document.getElementById('additional-options');
            additionalOptions.innerHTML = '';

            // Handle different meeting types
            if (type === 'Rapat Divisi Ormawa') {
                // For division meetings, show division selection
                additionalOptions.innerHTML = `
            <div class="card mt-4 p-3">
                <label class="form-label">Select Division <span class="text-danger">*</span></label>
                <select class="form-select" id="multiple-select-field-division" name="divisi_ormawas_id" required>
                    <option value="">Choose a division</option>
                    @foreach ($divisiOrmawas as $divisi)
                        <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select a division</div>
            </div>
        `;

                // Initialize Select2 immediately after creating the element
                setTimeout(function() {
                    $('#multiple-select-field-division').select2({
                        theme: "bootstrap-5",
                        width: '100%',
                        placeholder: "Choose divisions...",
                        closeOnSelect: false,
                        allowClear: true,
                        dropdownParent: $('#additional-options')
                    });

                    // Add event listener to handle automatic participant selection
                    $('#multiple-select-field-division').on('change', function() {
                        // Store the selected division ID for later use in selectParticipantsByDivision
                        selectedDivisionId = $(this).val();
                    });
                }, 100);

            } else if (type === 'Rapat Program Kerja') {
                // For work program meetings, show work program selection
                additionalOptions.innerHTML = `
            <div class="card mt-4 p-3">
                <label class="form-label">Select Work Program <span class="text-danger">*</span></label>
                <select id="programSelect" name="program_kerjas_id" class="form-select" required>
                    <option value="">Choose a work program</option>
                    @foreach ($programKerjas as $proker)
                        <option value="{{ $proker->id }}">{{ $proker->nama }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select a work program</div>
            </div>
        `;

                // Add event listener to handle automatic participant selection
                setTimeout(function() {
                    $('#programSelect').on('change', function() {
                        selectedProgramId = $(this).val();
                    });
                }, 100);

            } else if (type === 'Rapat Divisi Program Kerja') {
                // For work program division meetings, show work program and division selection
                additionalOptions.innerHTML = `
            <div class="card mt-4 p-3">
                <label class="form-label">Select Work Program <span class="text-danger">*</span></label>
                <select id="programSelect" name="program_kerjas_id" class="form-select" onchange="loadDivisions(this.value)" required>
                    <option value="">Choose a work program</option>
                    @foreach ($programKerjas as $proker)
                        <option value="{{ $proker->id }}">{{ $proker->nama }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select a work program</div>
                <div id="divisi-container" class="mt-3"></div>
            </div>
        `;

                // Add event listener for programSelect
                setTimeout(function() {
                    $('#programSelect').on('change', function() {
                        selectedProgramId = $(this).val();
                    });
                }, 100);
            }
        }

        // Handle session format change
        function initSessionFormatListener() {
            const sessionFormat = document.getElementById('sessionFormat');
            const locationField = document.getElementById('locationField');
            const locationLabel = document.getElementById('locationLabel');
            const sessionLocation = document.getElementById('meetingLocation');

            if (sessionFormat) {
                sessionFormat.addEventListener('change', function() {
                    if (this.value === 'offline') {
                        locationLabel.textContent = 'Location *';
                        sessionLocation.placeholder = 'Enter location';
                        locationField.style.display = 'block';
                    } else if (this.value === 'online') {
                        locationLabel.textContent = 'Session Link *';
                        sessionLocation.placeholder = 'Enter session link (Zoom, Google Meet, etc.)';
                        locationField.style.display = 'block';
                    } else {
                        locationField.style.display = 'none';
                    }
                });
            }
        }

        // Memuat divisi dari program kerja menggunakan AJAX
        function loadDivisions(programId) {
            let divisiContainer = document.getElementById('divisi-container');
            divisiContainer.innerHTML = '<div class="text-center text-muted">Loading divisions...</div>';

            if (programId && selectedType === 'Rapat Divisi Program Kerja') {
                $.getJSON(`/get-divisions/${programId}`, function(response) {
                    let divisiOptions = `
                <label class="form-label">Select Division in Work Program <span class="text-danger">*</span></label>
                <select id="multiple-select-field-division-proker" name="divisi_program_kerjas_id" class="form-select" required>
                    <option value="">Choose a division</option>
            `;
                    response.forEach(divisi => {
                        if (divisi.divisi_pelaksana) {
                            divisiOptions +=
                                `<option value="${divisi.id}">${divisi.divisi_pelaksana.nama}</option>`;
                        }
                    });

                    divisiOptions += '</select>';
                    divisiOptions += '<div class="invalid-feedback">Please select a division</div>';
                    divisiContainer.innerHTML = divisiOptions;

                    // Initialize Select2 and add event listener for auto-selection
                    setTimeout(function() {
                        $('#multiple-select-field-division-proker').select2({
                            theme: "bootstrap-5",
                            width: '100%',
                            placeholder: "Choose divisions...",
                            closeOnSelect: false,
                            allowClear: true,
                            dropdownParent: $('#divisi-container')
                        });

                        // Store the selected division ID
                        $('#multiple-select-field-division-proker').on('change', function() {
                            selectedDivisionProkerId = $(this).val();
                        });
                    }, 100);
                }).fail(function(xhr, status, error) {
                    console.error('Error loading divisions:', error);
                    divisiContainer.innerHTML = `
                <div class="alert alert-danger">
                    Failed to load divisions. Please try again.
                </div>
            `;
                });
            }
        }

        // Validasi dan lanjut ke langkah berikutnya
        function validateAndNextStep() {
            if (currentStep === 1) {
                if (!selectedType) {
                    document.getElementById('step1-error').classList.remove('d-none');
                    return;
                }

                // Additional validation for each meeting type
                if (selectedType === 'Rapat Divisi Ormawa' && !document.getElementById('multiple-select-field-division')
                    .value) {
                    alert('Please select a division');
                    return;
                }

                if ((selectedType === 'Rapat Program Kerja' || selectedType === 'Rapat Divisi Program Kerja') &&
                    !document.getElementById('programSelect').value) {
                    alert('Please select a work program');
                    return;
                }

                if (selectedType === 'Rapat Divisi Program Kerja' &&
                    document.getElementById('divisi-container').innerHTML.trim() !== "" &&
                    !document.getElementById('multiple-select-field-division-proker').value) {
                    alert('Please select a division in the work program');
                    return;
                }
            } else if (currentStep === 2) {
                if (!validateStep2()) {
                    return;
                }
            } else if (currentStep === 3) {
                // Auto-select participants based on meeting type before moving to the next step
                if (!participantsSelected) {
                    autoSelectParticipants();
                    participantsSelected = true;
                }

                // Make sure we have at least one participant selected
                const selectedParticipants = document.querySelectorAll('.participant-checkbox:checked');
                if (selectedParticipants.length === 0) {
                    alert('Please select at least one participant for the meeting');
                    return;
                }

                updateReview(); // Update Review Data before moving to Step 4
            }

            nextStep();
        }

        // Validate Step 2 Fields
        function validateStep2() {
            let valid = true;
            const sessionFormat = document.getElementById('sessionFormat');

            // Check if sessionFormat has a value
            if (!sessionFormat.value) {
                sessionFormat.classList.add('is-invalid');
                valid = false;
            } else {
                sessionFormat.classList.remove('is-invalid');
            }

            let fields = ['meetingName', 'meetingTopic', 'meetingDate', 'meetingTime'];

            // Add meetingLocation to required fields if a format is selected
            if (sessionFormat.value) {
                fields.push('meetingLocation');
            }

            fields.forEach(fieldId => {
                let field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    valid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            return valid;
        }

        // Navigasi langkah berikutnya
        function nextStep() {
            // Cek apakah elemen step saat ini ada
            let currentStepElement = document.getElementById(`step-${currentStep}`);
            if (!currentStepElement) {
                console.error(`Step ${currentStep} not found!`);
                return;
            }

            // Sembunyikan step saat ini
            currentStepElement.classList.add('d-none');

            // Naik ke langkah berikutnya
            currentStep++;

            // Cek apakah step berikutnya ada
            let nextStepElement = document.getElementById(`step-${currentStep}`);
            if (!nextStepElement) {
                console.error(`Step ${currentStep} not found!`);
                return;
            }

            // Tampilkan step berikutnya
            nextStepElement.classList.remove('d-none');
            updateProgressBar();

            console.log(`Moved to step ${currentStep}`);
        }

        function prevStep() {
            // Cek apakah elemen step saat ini ada
            let currentStepElement = document.getElementById(`step-${currentStep}`);
            if (!currentStepElement) {
                console.error(`Step ${currentStep} not found!`);
                return;
            }

            // Sembunyikan step saat ini
            currentStepElement.classList.add('d-none');

            // Turun ke langkah sebelumnya
            currentStep--;

            // Cek apakah step sebelumnya ada
            let prevStepElement = document.getElementById(`step-${currentStep}`);
            if (!prevStepElement) {
                console.error(`Step ${currentStep} not found!`);
                return;
            }

            // Tampilkan step sebelumnya
            prevStepElement.classList.remove('d-none');
            updateProgressBar();

            console.log(`Returned to step ${currentStep}`);
        }

        // Function to auto-select participants based on meeting type
        function autoSelectParticipants() {
            console.log("Auto-selecting participants based on meeting type:", selectedType);

            // Deselect all participants first
            document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });

            if (selectedType === 'Rapat Divisi Ormawa' && selectedDivisionId) {
                console.log("Selecting participants from division:", selectedDivisionId);

                // Select all participants from the chosen division
                document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                    const divisionId = checkbox.getAttribute('data-division-id');
                    if (divisionId === selectedDivisionId) {
                        checkbox.checked = true;
                    }
                });

            } else if (selectedType === 'Rapat Program Kerja' && selectedProgramId) {
                console.log("Selecting participants from program:", selectedProgramId);

                // Select all participants from the chosen work program
                document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                    const programIdsStr = checkbox.getAttribute('data-program-ids');
                    if (programIdsStr) {
                        try {
                            const programIds = JSON.parse(programIdsStr);
                            if (programIds.includes(parseInt(selectedProgramId))) {
                                checkbox.checked = true;
                            }
                        } catch (e) {
                            console.error("Error parsing program IDs:", e);
                        }
                    }
                });

            } else if (selectedType === 'Rapat Divisi Program Kerja' && selectedProgramId && selectedDivisionProkerId) {
                console.log("Selecting participants from division:", selectedDivisionProkerId, "in program:",
                    selectedProgramId);

                // Select all participants from the chosen division in the work program
                document.querySelectorAll('.participant-checkbox').forEach(checkbox => {
                    const divisionProkerIdsStr = checkbox.getAttribute('data-division-proker-ids');
                    if (divisionProkerIdsStr) {
                        try {
                            const divisionProkerIds = JSON.parse(divisionProkerIdsStr);
                            if (divisionProkerIds.includes(parseInt(selectedDivisionProkerId))) {
                                checkbox.checked = true;
                            }
                        } catch (e) {
                            console.error("Error parsing division proker IDs:", e);
                        }
                    }
                });
            }

            // Update the selected count display
            updateSelectedCount();
        }

        // Update progress bar based on current step
        function updateProgressBar() {
            let progressBar = document.getElementById('progress-bar');
            if (progressBar) {
                progressBar.style.width = (currentStep * 25) + '%';
            } else {
                console.error("Progress bar element not found!");
            }
        }

        // Update review information for step 4
        function updateReview() {
            document.getElementById('reviewType').innerText = selectedType;
            document.getElementById('reviewName').innerText = document.getElementById('meetingName').value;
            document.getElementById('reviewTopic').innerText = document.getElementById('meetingTopic').value;
            document.getElementById('reviewDate').innerText = document.getElementById('meetingDate').value;
            document.getElementById('reviewTime').innerText = document.getElementById('meetingTime').value;
            document.getElementById('reviewLocation').innerText = document.getElementById('meetingLocation').value;
        }

        // Function to update selected count display
        function updateSelectedCount() {
            const count = document.querySelectorAll('.participant-checkbox:checked').length;
            const selectedCountElement = document.getElementById('selectedCount');
            if (selectedCountElement) {
                selectedCountElement.textContent = `${count} selected`;
            }
        }

        // Initialize participant selection controls
        function initParticipantControls() {
            const participantCheckboxes = document.querySelectorAll('.participant-checkbox');
            const selectAllBtn = document.getElementById('selectAll');
            const deselectAllBtn = document.getElementById('deselectAll');
            const searchMembers = document.getElementById('searchMembers');
            const participantItems = document.querySelectorAll('.participant-item');
            const noResults = document.getElementById('no-results');
            const selectDivisionBtns = document.querySelectorAll('.select-division');

            // Update initial count
            updateSelectedCount();

            // Select/Deselect All buttons
            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function() {
                    participantCheckboxes.forEach(checkbox => {
                        if (!checkbox.closest('.participant-item').classList.contains('d-none')) {
                            checkbox.checked = true;
                        }
                    });
                    updateSelectedCount();
                });
            }

            if (deselectAllBtn) {
                deselectAllBtn.addEventListener('click', function() {
                    participantCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    updateSelectedCount();
                });
            }

            // Search functionality
            if (searchMembers) {
                searchMembers.addEventListener('input', function() {
                    const searchText = this.value.toLowerCase();
                    let hasVisibleItems = false;

                    participantItems.forEach(item => {
                        const name = item.getAttribute('data-name');

                        if (name && name.includes(searchText)) {
                            item.classList.remove('d-none');
                            hasVisibleItems = true;
                        } else {
                            item.classList.add('d-none');
                        }
                    });

                    // Show/hide no results message
                    if (noResults) {
                        if (!hasVisibleItems) {
                            noResults.classList.remove('d-none');
                        } else {
                            noResults.classList.add('d-none');
                        }
                    }

                    // Update division headers visibility
                    updateDivisionHeaders();
                });
            }

            // Select Division buttons
            selectDivisionBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const division = this.getAttribute('data-division');
                    const checkboxes = document.querySelectorAll(
                        `.participant-checkbox[data-division="${division}"]`);

                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

                    checkboxes.forEach(checkbox => {
                        checkbox.checked = !allChecked;
                    });

                    this.textContent = allChecked ? 'Select All' : 'Deselect All';
                    updateSelectedCount();
                });
            });

            // Update count when checkboxes are clicked
            participantCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });
        }

        // Update division headers visibility
        function updateDivisionHeaders() {
            const groups = document.querySelectorAll('.participant-group');

            groups.forEach(group => {
                const header = group.querySelector('.bg-light');
                const items = group.querySelectorAll('.participant-item');

                // Check if any items in this division are visible
                const hasVisibleItems = Array.from(items).some(item => !item.classList.contains('d-none'));

                // Show/hide division header accordingly
                if (header) {
                    if (hasVisibleItems) {
                        header.classList.remove('d-none');
                    } else {
                        header.classList.add('d-none');
                    }
                }
            });
        }

        // Document ready initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date to today
            let dateInput = document.getElementById('meetingDate');
            if (dateInput) {
                dateInput.min = new Date().toISOString().split('T')[0];
            }

            // Initialize session format listener
            initSessionFormatListener();

            // Initialize participant controls
            initParticipantControls();

            // Form submission handler
            $('#rapatForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response.message);
                        window.location.href =
                            `/${kodeOrmawa}/rapat/all`; // Redirect to meeting list
                    },
                    error: function(xhr) {
                        alert("Error: " + (xhr.responseJSON ? xhr.responseJSON.message :
                            "An unknown error occurred"));
                    }
                });
            });
        });
    </script>
@endsection
