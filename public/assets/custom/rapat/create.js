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
        setTimeout(function () {
            $('#multiple-select-field-division').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: "Choose divisions...",
                closeOnSelect: false,
                allowClear: true,
                dropdownParent: $('#additional-options')
            });

            // Add event listener to handle automatic participant selection
            $('#multiple-select-field-division').on('change', function () {
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
        setTimeout(function () {
            $('#programSelect').on('change', function () {
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
        setTimeout(function () {
            $('#programSelect').on('change', function () {
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
        sessionFormat.addEventListener('change', function () {
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
        $.getJSON(`/get-divisions/${programId}`, function (response) {
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
            setTimeout(function () {
                $('#multiple-select-field-division-proker').select2({
                    theme: "bootstrap-5",
                    width: '100%',
                    placeholder: "Choose divisions...",
                    closeOnSelect: false,
                    allowClear: true,
                    dropdownParent: $('#divisi-container')
                });

                // Store the selected division ID
                $('#multiple-select-field-division-proker').on('change', function () {
                    selectedDivisionProkerId = $(this).val();
                });
            }, 100);
        }).fail(function (xhr, status, error) {
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
        if (selectedType === 'Rapat Divisi Ormawa' && !document.getElementById('multiple-select-field-division').value) {
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
        console.log("Selecting participants from division:", selectedDivisionProkerId, "in program:", selectedProgramId);

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
        selectAllBtn.addEventListener('click', function () {
            participantCheckboxes.forEach(checkbox => {
                if (!checkbox.closest('.participant-item').classList.contains('d-none')) {
                    checkbox.checked = true;
                }
            });
            updateSelectedCount();
        });
    }

    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', function () {
            participantCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectedCount();
        });
    }

    // Search functionality
    if (searchMembers) {
        searchMembers.addEventListener('input', function () {
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
        btn.addEventListener('click', function () {
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
document.addEventListener('DOMContentLoaded', function () {
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
    $('#rapatForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert(response.message);
                window.location.href = `/${kodeOrmawa}/rapat/all`; // Redirect to meeting list
            },
            error: function (xhr) {
                alert("Error: " + (xhr.responseJSON ? xhr.responseJSON.message : "An unknown error occurred"));
            }
        });
    });
});
