function removeInput(button) {
    button.parentElement.remove();
};

document.getElementById('add-tujuan').addEventListener('click', function () {
    const tujuanList = document.getElementById('tujuan-program-list');
    const newDiv = document.createElement('div');
    newDiv.className = 'flex items-center mb-2';
    newDiv.innerHTML = `
        <input type="text" class="form-control flex-grow" name="tujuan[]" placeholder="Tujuan Program Kerja">
        <button type="button" class="ml-2 text-red-500" onclick="removeInput(this)"><i class="fas fa-times"></i></button>
    `;
    tujuanList.appendChild(newDiv);
});

document.getElementById('add-manfaat').addEventListener('click', function () {
    const manfaatList = document.getElementById('manfaat-program-list');
    const newDiv = document.createElement('div');
    newDiv.className = 'flex items-center mb-2';
    newDiv.innerHTML = `
        <input type="text" class="form-control flex-grow" name="manfaat[]" placeholder="Manfaat Program Kerja">
        <button type="button" class="ml-2 text-red-500" onclick="removeInput(this)"><i class="fas fa-times"></i></button>
    `;
    manfaatList.appendChild(newDiv);
});

// document.getElementById('e-add-tujuan').addEventListener('click', function () {
//     let id = $(this).data('id');
//     console.log(id);
//     const tujuanList = document.getElementById(`e-tujuan-program-list-${id}`);
//     const newDiv = document.createElement('div');
//     newDiv.className = 'flex items-center mb-2';
//     newDiv.innerHTML = `
//         <input type="text" class="form-control flex-grow" name="tujuan[]" placeholder="Tujuan Program Kerja">
//         <button type="button" class="ml-2 text-red-500" onclick="removeInput(this)"><i class="fas fa-times"></i></button>
//     `;
//     tujuanList.appendChild(newDiv);
// });

// document.getElementById('e-add-manfaat').addEventListener('click', function () {
//     let id = $(this).data('id');
//     const manfaatList = document.getElementById(`e-manfaat-program-list-${id}`);
//     const newDiv = document.createElement('div');
//     newDiv.className = 'flex items-center mb-2';
//     newDiv.innerHTML = `
//         <input type="text" class="form-control flex-grow" name="manfaat[]" placeholder="Manfaat Program Kerja">
//         <button type="button" class="ml-2 text-red-500" onclick="removeInput(this)"><i class="fas fa-times"></i></button>
//     `;
//     manfaatList.appendChild(newDiv);
// });

document.addEventListener('click', function (event) {
    if (event.target.id === 'e-add-tujuan') {
        let id = event.target.dataset.id; // Ambil data ID
        if (!id) {
            console.error('Data ID tidak ditemukan pada elemen #e-add-tujuan');
            return;
        }
        const tujuanList = document.getElementById(`e-tujuan-program-list-${id}`);
        if (!tujuanList) {
            console.error(`Elemen tujuan list dengan ID e-tujuan-program-list-${id} tidak ditemukan.`);
            return;
        }
        const newDiv = document.createElement('div');
        newDiv.className = 'flex items-center mb-2';
        newDiv.innerHTML = `
            <input type="text" class="form-control flex-grow" name="tujuan[]" placeholder="Tujuan Program Kerja">
            <button type="button" class="ml-2 text-red-500" onclick="removeInput(this)"><i class="fas fa-times"></i></button>
        `;
        tujuanList.appendChild(newDiv);
    }

    if (event.target.id === 'e-add-manfaat') {
        let id = event.target.dataset.id; // Ambil data ID
        if (!id) {
            console.error('Data ID tidak ditemukan pada elemen #e-add-manfaat');
            return;
        }
        const manfaatList = document.getElementById(`e-manfaat-program-list-${id}`);
        if (!manfaatList) {
            console.error(`Elemen manfaat list dengan ID e-manfaat-program-list-${id} tidak ditemukan.`);
            return;
        }
        const newDiv = document.createElement('div');
        newDiv.className = 'flex items-center mb-2';
        newDiv.innerHTML = `
            <input type="text" class="form-control flex-grow" name="manfaat[]" placeholder="Manfaat Program Kerja">
            <button type="button" class="ml-2 text-red-500" onclick="removeInput(this)"><i class="fas fa-times"></i></button>
        `;
        manfaatList.appendChild(newDiv);
    }
});


document.addEventListener('DOMContentLoaded', function () {
    // let modal = document.getElementById('editproject' +);
    $(document).on('click', '.edit-button', function () {
        let id = $(this).data('id'); // Get the ID from the button
        let kode_ormawa = $(this).data('kode');
        $.ajax({
            url: `/${kode_ormawa}/program-kerja/${id}/edit`, // URL to the Laravel route
            method: 'get',
            success: function (data) {
                // Isi data ke dalam modal
                $(`#e-nama-program-${id}`).val(data.nama);
                $(`#e-deskripsi-program-${id}`).val(data.deskripsi);

                // Tujuan Program Kerja
                $(`#e-tujuan-program-list-${id}`).html('');
                data.tujuan.forEach((tujuan) => {
                    $(`#e-tujuan-program-list-${id}`).append(
                        `<input type="text" class="form-control mb-2" name="tujuan[]" value="${tujuan}">`
                    );
                });

                // Manfaat Program Kerja
                $(`#e-manfaat-program-list-${id}`).html('');
                data.manfaat.forEach((manfaat) => {
                    $(`#e-manfaat-program-list-${id}`).append(
                        `<input type="text" class="form-control mb-2" name="manfaat[]" value="${manfaat}">`
                    );
                });

                // Tipe Program Kerja
                if (data.tipe === 'Internal') {
                    $(`#e-internal-${id}`).prop('checked', true);
                } else if (data.tipe === 'Eksternal') {
                    $(`#e-eksternal-${id}`).prop('checked', true);
                }

                // Anggaran Dana
                $(`input[name="anggaran[]"]`).each(function () {
                    $(this).prop('checked', data.anggaran.includes($(this).val()));
                });

                // Konsep
                if (data.konsep === 'Online') {
                    $(`#e-online-${id}`).prop('checked', true);
                } else if (data.konsep === 'Offline') {
                    $(`#e-offline-${id}`).prop('checked', true);
                }

                // Tempat, Sasaran, dan Indikator
                $(`#e-tempat-${id}`).val(data.tempat);
                $(`#e-sasaran-kegiatan-${id}`).val(data.sasaran);
                $(`#e-indikator-keberhasilan-${id}`).val(data.indikator);

                // Tanggal
                $(`#e-tanggal-mulai-${id}`).val(data.tanggal_mulai.split(' ')[0]); // Ambil bagian tanggal saja
                $(`#e-tanggal-selesai-${id}`).val(data.tanggal_selesai.split(' ')[0]);

                // Divisi
                $(`input[name="divisis[]"]`).each(function () {
                    let value = $(this).val(); // Ambil nilai checkbox
                    // Centang checkbox jika nilai ada di array `data.divisis`
                    $(this).prop('checked', data.divisis.includes(parseInt(value)));
                });

                // Tampilkan modal
                $('#editproject' + id).modal('show');
            },
            error: function (xhr) {
                console.error('Error fetching program data:', xhr);
            }
        });
    });

    const form = document.querySelector('form');

    // Create error modal HTML
    const modalHTML = `
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Data Belum Lengkap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Mohon lengkapi data berikut:</p>
                    <ul id="errorList"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>`;

    // Append modal to document body
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Get error modal element
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

    // Handle form submission
    form.addEventListener('submit', function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Validate form
        const errors = validateForm();

        // If there are errors, show error modal
        if (errors.length > 0) {
            showErrorModal(errors);
        } else {
            // If no errors, submit form
            form.submit();
        }
    });

    // Validate form function
    function validateForm() {
        const errors = [];

        // Check nama program
        const namaProgram = document.getElementById('nama-program').value.trim();
        if (!namaProgram) {
            errors.push('Nama Program Kerja');
        }

        // Check tujuan program (at least one)
        const tujuanInputs = document.querySelectorAll('input[name="tujuan[]"]');
        let hasTujuan = false;
        for (let input of tujuanInputs) {
            if (input.value.trim()) {
                hasTujuan = true;
                break;
            }
        }
        if (!hasTujuan) {
            errors.push('Tujuan Program Kerja');
        }

        // Check deskripsi program
        const deskripsiProgram = document.getElementById('deskripsi-program').value.trim();
        if (!deskripsiProgram) {
            errors.push('Deskripsi Program Kerja');
        }

        // Check manfaat program (at least one)
        const manfaatInputs = document.querySelectorAll('input[name="manfaat[]"]');
        let hasManfaat = false;
        for (let input of manfaatInputs) {
            if (input.value.trim()) {
                hasManfaat = true;
                break;
            }
        }
        if (!hasManfaat) {
            errors.push('Manfaat Program Kerja');
        }

        // Check tipe program
        const tipeProgram = document.querySelector('input[name="tipe"]:checked');
        if (!tipeProgram) {
            errors.push('Tipe Program Kerja');
        }

        // Check anggaran dana
        const anggaranChecked = document.querySelectorAll('input[name="anggaran[]"]:checked');
        if (anggaranChecked.length === 0) {
            errors.push('Anggaran Dana');
        }

        // Check konsep
        const konsep = document.querySelector('input[name="konsep"]:checked');
        if (!konsep) {
            errors.push('Konsep');
        }

        // Check tempat
        const tempat = document.getElementById('tempat').value.trim();
        if (!tempat) {
            errors.push('Tempat');
        }

        // Check sasaran kegiatan
        const sasaranKegiatan = document.getElementById('sasaran-kegiatan').value.trim();
        if (!sasaranKegiatan) {
            errors.push('Sasaran Kegiatan');
        }

        // Check indikator keberhasilan
        const indikatorKeberhasilan = document.getElementById('indikator-keberhasilan').value.trim();
        if (!indikatorKeberhasilan) {
            errors.push('Indikator Keberhasilan');
        }

        // Check tanggal mulai
        const tanggalMulai = document.getElementById('tanggal-mulai').value;
        if (!tanggalMulai) {
            errors.push('Tanggal Mulai');
        }

        // Check tanggal selesai
        const tanggalSelesai = document.getElementById('tanggal-selesai').value;
        if (!tanggalSelesai) {
            errors.push('Tanggal Selesai');
        }

        // Check divisi
        const divisiChecked = document.querySelectorAll('input[name="divisis[]"]:checked');
        if (divisiChecked.length === 0) {
            errors.push('Divisi');
        }

        return errors;
    }

    // Show error modal function
    function showErrorModal(errors) {
        const errorList = document.getElementById('errorList');
        errorList.innerHTML = '';

        // Add each error to the list
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });

        // Show modal
        errorModal.show();
    }
});

// Wait for document to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if there are validation errors from the server
    if (typeof validationErrors !== 'undefined' && validationErrors.length > 0) {
        // Initialize the error modal if it doesn't exist
        if (!document.getElementById('errorModal')) {
            // Create error modal if it doesn't exist yet
            const modalHTML = `
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="errorModalLabel">Data Belum Lengkap</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Mohon lengkapi data berikut:</p>
                            <ul id="errorList"></ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>`;

            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }

        // Set up the Bootstrap modal
        window.errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

        // Display the validation errors in the modal
        const errorList = document.getElementById('errorList');
        errorList.innerHTML = '';

        validationErrors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });

        // Show the modal
        window.errorModal.show();
    }
});
