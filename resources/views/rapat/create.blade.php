@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-lg p-4">
        <div id="stepWizard">
            <form action="{{ route('rapat.store', ['kode_ormawa' => $kode_ormawa]) }}" id="rapatForm" method="post">
                @csrf
                <!-- Progress Bar -->
                <div class="progress mb-4" style="height: 8px;">
                    <div id="progress-bar" class="progress-bar bg-primary" style="width: 25%; transition: width 0.3s ease-in-out;"></div>
                </div>

                <!-- Step 1: Pilih Tipe Rapat -->
                <div class="step" id="step-1">
                    <h4 class="fw-bold mb-3">Step 1: Choose a meeting type</h4>
                    <p class="text-muted mb-4">Choose the meeting type that best fits your needs.</p>

                    <input type="hidden" id="meetingType" name="meetingType">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card h-100 meeting-type-card" onclick="selectMeetingType('Rapat Ormawa', event)" role="button">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-users mb-3 fa-2x text-primary"></i>
                                    <h5 class="card-title">Rapat Ormawa</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 meeting-type-card" onclick="selectMeetingType('Rapat Divisi Ormawa', event)" role="button">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-sitemap mb-3 fa-2x text-primary"></i>
                                    <h5 class="card-title">Rapat Divisi Ormawa</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 meeting-type-card" onclick="selectMeetingType('Rapat Program Kerja', event)" role="button">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-tasks mb-3 fa-2x text-primary"></i>
                                    <h5 class="card-title">Rapat Program Kerja</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 meeting-type-card" onclick="selectMeetingType('Rapat Divisi Program Kerja', event)" role="button">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-project-diagram mb-3 fa-2x text-primary"></i>
                                    <h5 class="card-title">Rapat Divisi Program Kerja</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="additional-options" class="mt-4"></div>
                    <div id="step1-error" class="text-danger mt-2 d-none">Please select a meeting type to continue.</div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-primary" onclick="validateAndNextStep()">Continue <i class="fas fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- Step 2: Detail Rapat -->
                <div class="step d-none" id="step-2">
                    <h4 class="fw-bold">Step 2: Enter Meeting Details</h4>

                    <div class="mb-3">
                        <label class="form-label">Meeting Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="meetingName" name="meetingName" placeholder="Enter meeting name" required>
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
                        <label class="form-label">Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="meetingLocation" name="meetingLocation" placeholder="Enter meeting location" required>
                        <div class="invalid-feedback">Location is required.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" onclick="prevStep()"><i class="fas fa-arrow-left ms-2"></i> Back</button>
                        <button type="button" class="btn btn-primary" onclick="validateAndNextStep()">Continue <i class="fas fa-arrow-right ms-2"></i></button>
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
                            <label class="form-label fw-semibold text-dark">Select Participants</label>
                            <div class="border rounded-lg overflow-auto" style="max-height: 200px;">
                                {{-- <select id="participants" name="participants[]" class="form-select" multiple required>
                                    @foreach($users as $user)
                                        <option type="checkbox" value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select> --}}
                                @foreach($users as $user)
                                    <label class="d-flex align-items-center p-3 border-bottom">
                                        <input type="checkbox" name="participants[]" value="{{ $user->id }}" class="form-check-input me-3">
                                        <span class="text-dark">{{ $user->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mb-4 mx-4">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()"><i class="fas fa-arrow-left ms-2"></i> Back</button>
                            <button type="button" class="btn btn-primary" onclick="validateAndNextStep()">Continue <i class="fas fa-arrow-right ms-2"></i></button>
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

                        <div class="px-4 py-3 bg-light border-top justify-content-end gap-2 rounded-bottom d-flex justify-between">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()"><i class="fas fa-arrow-left ms-2"></i> Back</button>
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
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .meeting-type-card.selected {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }

    .progress-bar {
        transition: width 0.3s ease-in-out;
    }
    </style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let currentStep = 1;
let selectedType = null;
let kodeOrmawa = "{{ $kode_ormawa }}";

// Pilih tipe rapat
function selectMeetingType(type, event) {
    selectedType = type;

    document.getElementById('meetingType').value = type;
    // Hapus semua class 'selected' pada card meeting
    document.querySelectorAll('.meeting-type-card').forEach(card => card.classList.remove('selected'));

    // Tambahkan class 'selected' pada card yang diklik
    event.currentTarget.classList.add('selected');
    document.getElementById('step1-error').classList.add('d-none');

    let additionalOptions = document.getElementById('additional-options');
    additionalOptions.innerHTML = '';

    if (type === 'Rapat Divisi Ormawa') {
        additionalOptions.innerHTML = `
            <div class="card mt-4 p-3">
                <label class="form-label">Select Division <span class="text-danger">*</span></label>
                <select class="form-select" id="divisiSelect" name="divisi_ormawas_id" required>
                    <option value="">Choose a division</option>
                    @foreach($divisiOrmawas as $divisi)
                        <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select a division</div>
            </div>
        `;
    } else if (type === 'Rapat Program Kerja') {
        additionalOptions.innerHTML = `
            <div class="card mt-4 p-3">
                <label class="form-label">Select Work Program <span class="text-danger">*</span></label>
                <select id="programSelect" name="program_kerjas_id" class="form-select" required>
                    <option value="">Choose a work program</option>
                    @foreach($programKerjas as $proker)
                        <option value="{{ $proker->id }}">{{ $proker->nama }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select a work program</div>
                <div id="divisi-container" class="mt-3"></div>
            </div>
        `;
    } else if (type === 'Rapat Divisi Program Kerja') {
        additionalOptions.innerHTML = `
            <div class="card mt-4 p-3">
                <label class="form-label">Select Work Program <span class="text-danger">*</span></label>
                <select id="programSelect" name="program_kerjas_id" class="form-select" onchange="loadDivisions(this.value)" required>
                    <option value="">Choose a work program</option>
                    @foreach($programKerjas as $proker)
                        <option value="{{ $proker->id }}">{{ $proker->nama }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Please select a work program</div>
                <div id="divisi-container" class="mt-3"></div>
            </div>
        `;
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
                <select id="divisiSelect" name="divisi_program_kerjas_id" class="form-select" required>
                    <option value="">Choose a division</option>
            `;

            response.forEach(divisi => {
                if (divisi.divisi_pelaksana) {
                    divisiOptions += `<option value="${divisi.id}">${divisi.divisi_pelaksana.nama}</option>`;
                }
            });

            divisiOptions += '</select>';
            divisiOptions += '<div class="invalid-feedback">Please select a division</div>';
            divisiContainer.innerHTML = divisiOptions;
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

        if (selectedType === 'divisi_ormawa' && !document.getElementById('divisiSelect').value) {
            alert('Please select a division');
            return;
        }

        if ((selectedType === 'program_kerja' || selectedType === 'divisi_program_kerja') &&
            !document.getElementById('programSelect').value) {
            alert('Please select a work program');
            return;
        }

        if (selectedType === 'divisi_program_kerja' &&
            document.getElementById('divisi-container').innerHTML.trim() !== "" &&
            !document.getElementById('divisiSelect').value) {
            alert('Please select a division in the work program');
            return;
        }
    } else if (currentStep === 2) {
        if (!validateStep2()) {
            return;
        }
    } else if (currentStep === 3) {
        updateReview(); // Update Review Data before moving to Step 4
    }

    nextStep();
}

// Validate Step 2 Fields
function validateStep2() {
    let valid = true;
    let fields = ['meetingName', 'meetingTopic', 'meetingDate', 'meetingTime', 'meetingLocation'];

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

// Update progress bar berdasarkan langkah saat ini
function updateProgressBar() {
    let progressBar = document.getElementById('progress-bar');
    if (progressBar) {
        progressBar.style.width = (currentStep * 25) + '%';
    } else {
        console.error("Progress bar element not found!");
    }
}

function updateReview() {
    console.log(selectedType);
    document.getElementById('reviewType').innerText = selectedType;
    document.getElementById('reviewName').innerText = document.getElementById('meetingName').value;
    document.getElementById('reviewTopic').innerText = document.getElementById('meetingTopic').value;
    document.getElementById('reviewDate').innerText = document.getElementById('meetingDate').value;
    document.getElementById('reviewTime').innerText = document.getElementById('meetingTime').value;
    document.getElementById('reviewLocation').innerText = document.getElementById('meetingLocation').value;
}

// Set minimal tanggal hari ini pada input date
window.addEventListener('load', function() {
    let dateInput = document.getElementById('meetingDate');
    if (dateInput) {
        dateInput.min = new Date().toISOString().split('T')[0];
    } else {
        console.error("Date input element not found!");
    }
});


$('#rapatForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            alert(response.message);
            window.location.href = `/${kodeOrmawa}/rapat`; // Redirect ke halaman daftar rapat
        },
        error: function(xhr) {
            alert("Error: " + xhr.responseJSON.message);
        }
    });
});

</script>
@endsection
