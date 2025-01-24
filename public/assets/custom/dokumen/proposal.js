// Event listener utama untuk menangani berbagai klik pada elemen
document.addEventListener('click', function (e) {
    // Menghapus baris pada tabel
    if (e.target.classList.contains('remove-row')) {
        e.target.closest('tr').remove();
    }

    // Menambahkan hari baru pada rundown
    if (e.target.id === 'add-hari') {
        addHari();
    }

    // Menambahkan baris baru pada rundown untuk hari tertentu
    if (e.target.classList.contains('add-rundown')) {
        const hari = e.target.dataset.hari;
        addRundownRow(hari, e.target);
    }

    // Menambahkan tanda tangan baru
    if (e.target.id === 'add-pengesahan') {
        addPengesahan();
    }

    // Menghapus tanda tangan
    if (e.target.classList.contains('remove-pengesahan')) {
        e.target.closest('.pengesahan-item').remove();
    }

    // Menghapus tujuan
    if (e.target.classList.contains('remove-tujuan')) {
        e.target.closest('.tujuan-item').remove();
    }
});

// Event listener untuk menambahkan baris pada tabel anggaran
const addAnggaranButton = document.getElementById('add-anggaran');
if (addAnggaranButton) {
    addAnggaranButton.addEventListener('click', function () {
        addAnggaranRow();
    });
}

// Event listener untuk menambahkan tujuan baru
const addTujuanButton = document.getElementById('add-tujuan-proposal');
if (addTujuanButton) {
    addTujuanButton.addEventListener('click', function () {
        addTujuan();
    });
}

// Fungsi untuk menambahkan hari baru pada rundown
function addHari() {
    const container = document.getElementById('rundown-container');
    const hariCount = container.children.length + 1;

    container.insertAdjacentHTML('beforeend', `
        <div class="mb-3">
            <h6>Hari ${hariCount}</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Kegiatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="rundown[${hariCount}][waktu][]" placeholder="Waktu"></td>
                        <td><input type="text" class="form-control" name="rundown[${hariCount}][kegiatan][]" placeholder="Kegiatan"></td>
                        <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    `);
}

// Fungsi untuk menambahkan baris baru pada rundown untuk hari tertentu
function addRundownRow(hari, targetElement) {
    const tbody = targetElement.closest('.mb-3').querySelector('tbody');
    const rowCount = tbody.rows.length + 1;

    tbody.insertAdjacentHTML('beforeend', `
        <tr>
            <td><input type="text" class="form-control" name="rundown[${hari}][waktu][]" placeholder="Waktu"></td>
            <td><input type="text" class="form-control" name="rundown[${hari}][kegiatan][]" placeholder="Kegiatan"></td>
            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
        </tr>
    `);
}

// Fungsi untuk menambahkan tanda tangan baru
function addPengesahan() {
    const container = document.getElementById('pengesahan-container');
    const newField = `
        <div class="mb-3 pengesahan-item">
            <input type="text" class="form-control d-inline-block w-75" name="pengesahan[]" placeholder="Nama Tanda Tangan">
            <button type="button" class="btn btn-danger remove-pengesahan">Hapus</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newField);
}

// Fungsi untuk menambahkan baris baru pada tabel anggaran
function addAnggaranRow() {
    const tbody = document.getElementById('anggaran-body');
    const rowCount = tbody.rows.length + 1;

    tbody.insertAdjacentHTML('beforeend', `
        <tr>
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="anggaran[komponen][]" placeholder="Komponen Biaya"></td>
            <td><input type="number" class="form-control" name="anggaran[jumlah][]" placeholder="Jumlah"></td>
            <td><input type="text" class="form-control" name="anggaran[satuan][]" placeholder="Satuan"></td>
            <td><input type="number" class="form-control" name="anggaran[harga][]" placeholder="Harga"></td>
            <td><input type="number" class="form-control" name="anggaran[total][]" placeholder="Total" readonly></td>
            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
        </tr>
    `);
}

// Fungsi untuk menambahkan textarea baru pada tujuan
function addTujuan() {
    const container = document.getElementById('tujuan-container');
    const newField = `
        <div class="mb-3 tujuan-item">
            <input type="text" class="form-control mb-2 d-inline-block"  name="tujuan[]" placeholder="Masukkan tujuan kegiatan tambahan"></input>
            <button type="button" class="btn btn-danger remove-tujuan">Hapus</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newField);
}

document.addEventListener('input', function (e) {
    if (e.target.closest('#anggaran-body')) {
        const row = e.target.closest('tr');
        const jumlah = parseFloat(row.querySelector('[name="anggaran[jumlah][]"]').value) || 0;
        const harga = parseFloat(row.querySelector('[name="anggaran[harga][]"]').value) || 0;
        const total = jumlah * harga;

        row.querySelector('[name="anggaran[total][]"]').value = total || 0;

        // Hitung total keseluruhan
        // let grandTotal = 0;
        // document.querySelectorAll('[name="anggaran[total][]"]').forEach(input => {
        //     grandTotal += parseFloat(input.value) || 0;
        // });

        // document.getElementById('total-anggaran').textContent = `Rp ${grandTotal.toLocaleString()}`;
    }
});
