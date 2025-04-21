document.addEventListener('DOMContentLoaded', function () {
    // Check if program is completed (read-only mode)
    const isReadOnly = document.querySelector('.alert-info') &&
        document.querySelector('.alert-info').textContent.includes('Program kerja telah selesai');

    if (isReadOnly) {
        setupReadOnlyMode();
    } else {
        setupEditMode();
    }

    // Setup number input restrictions for both modes
    setupNumberInputs();

    // Setup Excel export functionality for both modes
    setupExcelExport();
});

/**
 * Configure read-only mode
 */
function setupReadOnlyMode() {
    // Disable all form inputs
    const formInputs = document.querySelectorAll('input, select, textarea, button[type="submit"], button[type="button"].add-pemasukan, button[type="button"].add-pengeluaran, button[type="button"].remove-row');

    formInputs.forEach(function (input) {
        // Skip the back button and download button
        if (input.classList.contains('btn-dark') || input.id === 'download-excel-btn') return;

        // Disable the input
        input.disabled = true;

        // Add visual indicator for disabled state
        if (input.classList.contains('btn')) {
            input.classList.remove('btn-primary', 'btn-success', 'btn-danger');
            input.classList.add('btn-secondary');
        }
    });

    // Add read-only mode message if not already present
    const form = document.querySelector('form');
    if (form && !document.querySelector('.read-only-banner')) {
        const readOnlyBanner = document.createElement('div');
        readOnlyBanner.className = 'alert alert-info mb-3 read-only-banner';
        readOnlyBanner.innerHTML = '<div class="d-flex align-items-center"><i class="icofont-info-circle fs-4 me-2"></i><div><strong>Mode hanya lihat:</strong> Program kerja telah selesai dan tidak dapat diedit.</div></div>';
        form.prepend(readOnlyBanner);
    }

    // Prevent form submission
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Program kerja telah selesai dan tidak dapat diedit lagi.');
        return false;
    });

    // Initialize calculations for read-only mode
    calculateAllTotals();
}

/**
 * Configure edit mode
 */
function setupEditMode() {
    // Initialize calculations
    calculateAllTotals();

    // Setup event listeners for input changes
    setupEventListeners();

    // Setup add/remove row functionality
    setupRowControls();
}

/**
 * Set up input event listeners for calculating totals
 */
function setupEventListeners() {
    // Add event listeners to all biaya and jumlah inputs
    document.querySelectorAll('.biaya, .jumlah').forEach(input => {
        input.addEventListener('input', function () {
            calculateRowTotal(this);
        });
    });
}

/**
 * Calculate the total for a single row
 */
function calculateRowTotal(inputElement) {
    const row = inputElement.closest('tr');
    const biayaInput = row.querySelector('.biaya');
    const jumlahInput = row.querySelector('.jumlah');
    const totalInput = row.querySelector('.total');

    if (biayaInput && jumlahInput && totalInput) {
        const biaya = Number(biayaInput.value) || 0;
        const jumlah = Number(jumlahInput.value) || 0;
        totalInput.value = biaya * jumlah;

        // Recalculate all totals
        calculateAllTotals();
    }
}

/**
 * Calculate all totals (used in both modes)
 */
function calculateAllTotals() {
    // Calculate totals for each division
    const divisiElements = document.querySelectorAll('[id^="total-pengeluaran-divisi-"]');
    divisiElements.forEach(divisiElement => {
        const divisiId = divisiElement.id.replace('total-pengeluaran-divisi-', '');
        let totalDivisi = 0;

        // Check if we're in read-only mode
        if (document.querySelector('.alert-info') && document.querySelector('.alert-info').textContent.includes('Program kerja telah selesai')) {
            // Read from hidden inputs in read-only mode
            document.querySelectorAll(`#pengeluaran-body-${divisiId} input[name^="pengeluaran[${divisiId}][total]"]`).forEach(input => {
                totalDivisi += Number(input.value) || 0;
            });
        } else {
            // Read from regular inputs in edit mode
            document.querySelectorAll(`#pengeluaran-body-${divisiId} .total`).forEach(input => {
                totalDivisi += Number(input.value) || 0;
            });
        }

        divisiElement.textContent = totalDivisi.toLocaleString('id-ID');
    });

    // Calculate total income
    let totalPemasukan = 0;
    if (document.querySelector('.alert-info') && document.querySelector('.alert-info').textContent.includes('Program kerja telah selesai')) {
        // Read from hidden inputs in read-only mode
        document.querySelectorAll('input[name^="pemasukan[total]"]').forEach(input => {
            totalPemasukan += Number(input.value) || 0;
        });
    } else {
        // Read from regular inputs in edit mode
        document.querySelectorAll('#pemasukan-body .total').forEach(input => {
            totalPemasukan += Number(input.value) || 0;
        });
    }

    const totalPemasukanElement = document.getElementById('total-pemasukan');
    if (totalPemasukanElement) {
        totalPemasukanElement.textContent = totalPemasukan.toLocaleString('id-ID');
    }

    // Calculate total expense
    let totalPengeluaran = 0;
    divisiElements.forEach(divisiElement => {
        totalPengeluaran += Number(divisiElement.textContent.replace(/\./g, '').replace(/,/g, '.')) || 0;
    });

    const totalPengeluaranElement = document.getElementById('total-pengeluaran');
    if (totalPengeluaranElement) {
        totalPengeluaranElement.textContent = totalPengeluaran.toLocaleString('id-ID');
    }

    // Calculate difference
    let selisih = totalPemasukan - totalPengeluaran;
    const selisihElement = document.getElementById('selisih');
    if (selisihElement) {
        selisihElement.textContent = selisih.toLocaleString('id-ID');

        // Set color based on value
        const selisihParent = selisihElement.parentElement;
        if (selisihParent) {
            selisihParent.classList.remove('text-success', 'text-danger');
            selisihParent.classList.add(selisih >= 0 ? 'text-success' : 'text-danger');
        }
    }
}

/**
 * Set up row controls (add/remove) functionality
 */
function setupRowControls() {
    // Add pemasukan row
    const addPemasukanBtn = document.getElementById('add-pemasukan');
    if (addPemasukanBtn) {
        addPemasukanBtn.addEventListener('click', function () {
            const tbody = document.getElementById('pemasukan-body');
            const rowCount = tbody.getElementsByTagName('tr').length;
            const newRow = `
                <tr>
                    <td>${rowCount + 1}</td>
                    <td>
                        <input type="text" class="form-control" name="pemasukan[komponen][]" placeholder="Komponen Biaya">
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control biaya" name="pemasukan[biaya][]" placeholder="Biaya">
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control jumlah" name="pemasukan[jumlah][]" placeholder="Jumlah">
                    </td>
                    <td>
                        <input type="text" class="form-control satuan" name="pemasukan[satuan][]" placeholder="Satuan">
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control total" name="pemasukan[total][]" placeholder="Total" readonly>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                            <i class="icofont-trash me-1"></i>Hapus
                        </button>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', newRow);
            setupEventListeners();
            setupNumberInputs(); // Setup restrictions for new inputs
        });
    }

    // Add pengeluaran row
    document.querySelectorAll('.add-pengeluaran').forEach(button => {
        button.addEventListener('click', function () {
            const divisiId = this.getAttribute('data-divisi-id');
            const tbody = document.getElementById(`pengeluaran-body-${divisiId}`);
            const rowCount = tbody.getElementsByTagName('tr').length;
            const newRow = `
                <tr>
                    <td>${rowCount + 1}</td>
                    <td>
                        <input type="text" class="form-control" name="pengeluaran[${divisiId}][komponen][]"
                            placeholder="Komponen Biaya">
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control biaya" name="pengeluaran[${divisiId}][biaya][]"
                                placeholder="Biaya">
                        </div>
                    </td>
                    <td>
                        <input type="number" class="form-control jumlah" name="pengeluaran[${divisiId}][jumlah][]"
                            placeholder="Jumlah">
                    </td>
                    <td>
                        <input type="text" class="form-control satuan" name="pengeluaran[${divisiId}][satuan][]"
                            placeholder="Satuan">
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control total" name="pengeluaran[${divisiId}][total][]"
                                placeholder="Total" readonly>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                            <i class="icofont-trash me-1"></i>Hapus
                        </button>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', newRow);
            setupEventListeners();
            setupNumberInputs(); // Setup restrictions for new inputs
        });
    });

    // Remove row
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
            const button = e.target.classList.contains('remove-row') ? e.target : e.target.closest('.remove-row');
            const row = button.closest('tr');
            const tbody = row.closest('tbody');

            // Don't remove if it's the last row
            if (tbody.rows.length > 1) {
                row.remove();

                // Update row numbers
                Array.from(tbody.rows).forEach((row, index) => {
                    row.cells[0].textContent = index + 1;
                });

                // Recalculate totals
                calculateAllTotals();
            } else {
                // Clear values instead of removing the last row
                row.querySelectorAll('input:not([readonly])').forEach(input => {
                    input.value = '';
                });
                row.querySelector('.total').value = '';
                calculateAllTotals();
            }
        }
    });
}

/**
 * Set up number input restrictions
 */
function setupNumberInputs() {
    document.querySelectorAll('input[type="number"]').forEach(function (input) {
        input.addEventListener('keydown', function (e) {
            // Prevent 'e' or 'E' characters
            if (e.key === 'e' || e.key === 'E') {
                e.preventDefault();
            }
        });
    });
}

/**
 * Set up Excel export functionality
 */
function setupExcelExport() {
    const downloadExcelBtn = document.getElementById('download-excel-btn');
    if (downloadExcelBtn) {
        downloadExcelBtn.addEventListener('click', function () {
            // Collect form data
            const formData = new FormData(document.querySelector('form'));

            // Create form for Excel download
            const downloadForm = document.createElement('form');
            downloadForm.method = 'POST';
            downloadForm.action = window.location.href.replace(/\/create|\/edit/, '/export');

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('input[name="_token"]').value;
            downloadForm.appendChild(csrfToken);

            // Add form data as JSON
            const rabData = document.createElement('input');
            rabData.type = 'hidden';
            rabData.name = 'rab_data';

            // Prepare the data object
            const data = {
                pemasukan: [],
                pengeluaran: {}
            };

            // Get pemasukan data
            const pemasukanRows = document.querySelectorAll('#pemasukan-body tr');
            pemasukanRows.forEach(row => {
                const komponenInput = row.querySelector('input[name="pemasukan[komponen][]"]');
                if (komponenInput) {
                    const biayaInput = row.querySelector('input[name="pemasukan[biaya][]"]');
                    const jumlahInput = row.querySelector('input[name="pemasukan[jumlah][]"]');
                    const satuanInput = row.querySelector('input[name="pemasukan[satuan][]"]');
                    const totalInput = row.querySelector('input[name="pemasukan[total][]"]');

                    const item = {
                        komponen: komponenInput.value,
                        biaya: biayaInput ? biayaInput.value : 0,
                        jumlah: jumlahInput ? jumlahInput.value : 0,
                        satuan: satuanInput ? satuanInput.value : '',
                        total: totalInput ? totalInput.value : 0
                    };
                    data.pemasukan.push(item);
                }
            });

            // Get pengeluaran data for each division
            const divisiContainers = document.querySelectorAll('[id^="pengeluaran-body-"]');
            divisiContainers.forEach(container => {
                const divisiId = container.id.replace('pengeluaran-body-', '');
                data.pengeluaran[divisiId] = [];

                const pengeluaranRows = container.querySelectorAll('tr');
                pengeluaranRows.forEach(row => {
                    const komponenInput = row.querySelector(`input[name^="pengeluaran[${divisiId}][komponen]"]`);
                    if (komponenInput) {
                        const biayaInput = row.querySelector(`input[name^="pengeluaran[${divisiId}][biaya]"]`);
                        const jumlahInput = row.querySelector(`input[name^="pengeluaran[${divisiId}][jumlah]"]`);
                        const satuanInput = row.querySelector(`input[name^="pengeluaran[${divisiId}][satuan]"]`);
                        const totalInput = row.querySelector(`input[name^="pengeluaran[${divisiId}][total]"]`);

                        const item = {
                            komponen: komponenInput.value,
                            biaya: biayaInput ? biayaInput.value : 0,
                            jumlah: jumlahInput ? jumlahInput.value : 0,
                            satuan: satuanInput ? satuanInput.value : '',
                            total: totalInput ? totalInput.value : 0
                        };
                        data.pengeluaran[divisiId].push(item);
                    }
                });
            });

            rabData.value = JSON.stringify(data);
            downloadForm.appendChild(rabData);

            // Submit the form
            document.body.appendChild(downloadForm);
            downloadForm.submit();
            document.body.removeChild(downloadForm);
        });
    }
}
