document.addEventListener('DOMContentLoaded', function () {

    function initializeCalculations() {
        // Hitung total pemasukan
        updateTotalPemasukan();

        // Hitung total pengeluaran untuk setiap divisi
        document.querySelectorAll('[id^="pengeluaran-body-"]').forEach(tbody => {
            updateTotalPengeluaranPerDivisi(tbody.id);
        });

        // Hitung total pengeluaran keseluruhan dan selisih
        updateTotalPengeluaran();
    }

    // Fungsi untuk menghitung total pengeluaran keseluruhan
    function updateTotalPengeluaran() {
        let totalPengeluaran = 0;

        document.querySelectorAll('[id^="total-pengeluaran-divisi-"]').forEach(span => {
            // Hapus format ribuan dan konversi ke angka
            const value = span.textContent.replace(/\./g, '').replace(/,/g, '.');
            totalPengeluaran += parseFloat(value) || 0;
        });

        document.getElementById('total-pengeluaran').textContent = `Rp ${totalPengeluaran.toLocaleString('id-ID')}`;

        // Hitung selisih
        const totalPemasukan = parseFloat(document.getElementById('total-pemasukan').textContent.replace(/[^\d,-]/g, '').replace(/\./g, '').replace(/,/g, '.')) || 0;
        const selisih = totalPemasukan - totalPengeluaran;
        document.getElementById('selisih').textContent = `Rp ${selisih.toLocaleString('id-ID')}`;
    }

    // Fungsi untuk menghitung total pemasukan
    function updateTotalPemasukan() {
        let totalPemasukan = 0;

        document.querySelectorAll('#pemasukan-body .total').forEach(input => {
            totalPemasukan += parseFloat(input.value) || 0;
        });

        document.getElementById('total-pemasukan').textContent = `Rp ${totalPemasukan.toLocaleString('id-ID')}`;

        // Update selisih setiap kali total pemasukan berubah
        updateTotalPengeluaran();
    }

    // Fungsi untuk memperbarui total pengeluaran per divisi
    function updateTotalPengeluaranPerDivisi(tbodyId) {
        const tbody = document.getElementById(tbodyId);
        const divisiId = tbodyId.split('-')[2]; // Extract divisi ID
        let totalPengeluaran = 0;

        tbody.querySelectorAll('.total').forEach(input => {
            totalPengeluaran += parseFloat(input.value) || 0;
        });

        document.getElementById(`total-pengeluaran-divisi-${divisiId}`).textContent = totalPengeluaran.toLocaleString('id-ID');

        // Update total pengeluaran keseluruhan
        updateTotalPengeluaran();
    }

    // Inisialisasi perhitungan saat halaman dimuat
    initializeCalculations();

    // Fungsi untuk menambahkan baris baru ke tabel pemasukan
    document.getElementById('add-pemasukan').addEventListener('click', function () {
        const tbody = document.getElementById('pemasukan-body');
        const rowCount = tbody.rows.length + 1;

        const row = `<tr>
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="pemasukan[komponen][]" placeholder="Komponen Biaya"></td>
            <td><input type="number" class="form-control biaya" name="pemasukan[biaya][]" placeholder="Biaya"></td>
            <td><input type="number" class="form-control jumlah" name="pemasukan[jumlah][]" placeholder="Jumlah"></td>
            <td><input type="text" class="form-control satuan" name="pemasukan[satuan][]" placeholder="Satuan"></td>
            <td><input type="number" class="form-control total" name="pemasukan[total][]" placeholder="Total" readonly></td>
            <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
        </tr>`;
        tbody.insertAdjacentHTML('beforeend', row);
    });

    // Fungsi untuk menambahkan baris baru ke tabel pengeluaran per divisi
    document.querySelectorAll('.add-pengeluaran').forEach(button => {
        button.addEventListener('click', function () {
            const divisiId = this.getAttribute('data-divisi-id');
            const tbody = document.getElementById(`pengeluaran-body-${divisiId}`);
            const rowCount = tbody.rows.length + 1;

            const row = `<tr>
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="pengeluaran[${divisiId}][komponen][]" placeholder="Komponen Biaya"></td>
                <td><input type="number" class="form-control biaya" name="pengeluaran[${divisiId}][biaya][]" placeholder="Biaya"></td>
                <td><input type="number" class="form-control jumlah" name="pengeluaran[${divisiId}][jumlah][]" placeholder="Jumlah"></td>
                <td><input type="text" class="form-control satuan" name="pengeluaran[${divisiId}][satuan][]" placeholder="Satuan"></td>
                <td><input type="number" class="form-control total" name="pengeluaran[${divisiId}][total][]" placeholder="Total" readonly></td>
                <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
        });
    });

    // Fungsi untuk menghitung total pemasukan secara otomatis
    document.addEventListener('input', function (e) {
        if (e.target.closest('#pemasukan-body')) {
            console.log(document.querySelectorAll('#pemasukan-body .total').value);
            updateTotalPemasukan();
        }
    });

    // Fungsi untuk menghitung total pengeluaran per divisi
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('biaya') || e.target.classList.contains('jumlah')) {
            const row = e.target.closest('tr');
            const biaya = row.querySelector('.biaya').value || 0;
            const jumlah = row.querySelector('.jumlah').value || 0;
            const total = row.querySelector('.total');
            total.value = biaya * jumlah;

            if (e.target.closest('[id^="pengeluaran-body-"]')) {
                const tbodyId = e.target.closest('tbody').id;
                updateTotalPengeluaranPerDivisi(tbodyId);
            }
        }
    });

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('biaya') || e.target.classList.contains('jumlah')) {
            const row = e.target.closest('tr');
            const biaya = row.querySelector('.biaya').value || 0;
            const jumlah = row.querySelector('.jumlah').value || 0;
            const total = row.querySelector('.total');
            total.value = biaya * jumlah;

            if (e.target.closest('#pemasukan-body')) {
                updateTotalPemasukan();
            } else if (e.target.closest('[id^="pengeluaran-body-"]')) {
                const tbodyId = e.target.closest('tbody').id;
                updateTotalPengeluaranPerDivisi(tbodyId);
            }
        }
    });

    // Fungsi untuk menghapus baris
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            const tbody = e.target.closest('tbody');
            e.target.closest('tr').remove();

            // Update total untuk tabel yang sesuai
            if (tbody.id === 'pemasukan-body') {
                updateTotalPemasukan();
            } else if (tbody.id.startsWith('pengeluaran-body-')) {
                updateTotalPengeluaranPerDivisi(tbody.id);
            }

            // Perbarui nomor urut
            updateRowNumbers(tbody);
        }
    });

    // Fungsi untuk memperbarui total pemasukan
    function updateTotalPemasukan() {
        let totalPemasukan = 0;

        document.querySelectorAll('#pemasukan-body .total').forEach(input => {
            totalPemasukan += parseFloat(input.value) || 0;
        });

        document.getElementById('total-pemasukan').textContent = totalPemasukan.toLocaleString('id-ID');
    }

    // Fungsi untuk memperbarui total pengeluaran per divisi
    function updateTotalPengeluaranPerDivisi(tbodyId) {
        const tbody = document.getElementById(tbodyId);
        const divisiId = tbodyId.split('-')[2]; // Extract divisi ID
        let totalPengeluaran = 0;

        tbody.querySelectorAll('.total').forEach(input => {
            totalPengeluaran += parseFloat(input.value) || 0;
        });

        document.getElementById(`total-pengeluaran-divisi-${divisiId}`).textContent = totalPengeluaran.toLocaleString('id-ID');
    }

    // Fungsi untuk memperbarui nomor urut pada tabel
    function updateRowNumbers(tbody) {
        Array.from(tbody.rows).forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }
});

document.querySelectorAll('input[type="number"]').forEach(function (input) {
    input.addEventListener('keydown', function (e) {
        // Cegah karakter 'e' atau 'E'
        if (e.key === 'e' || e.key === 'E') {
            e.preventDefault();
        }
    });
});

document.getElementById('rab-download-form').addEventListener('submit', function (e) {
    const pemasukanData = [];
    document.querySelectorAll('#pemasukan-body tr').forEach((row, index) => {
        const cells = row.querySelectorAll('input');
        pemasukanData.push({
            komponen: cells[0].value,
            biaya: cells[1].value,
            jumlah: cells[2].value,
            satuan: cells[3].value,
            total: cells[4].value,
        });
    });

    const pengeluaranData = [];
    document.querySelectorAll('[id^="pengeluaran-body-"]').forEach((tbody) => {
        tbody.querySelectorAll('tr').forEach((row) => {
            const cells = row.querySelectorAll('input');
            pengeluaranData.push({
                komponen: cells[0].value,
                biaya: cells[1].value,
                jumlah: cells[2].value,
                satuan: cells[3].value,
                total: cells[4].value,
                divisi: tbody.id.split('-')[2], // Ambil ID divisi dari ID tbody
            });
        });
    });

    const rabData = {
        pemasukan: pemasukanData,
        pengeluaran: pengeluaranData
    };

    console.log(rabData);
    document.getElementById('rab-data').value = JSON.stringify(rabData);
});
