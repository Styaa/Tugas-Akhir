document.addEventListener('DOMContentLoaded', function () {
    const ketuaDropdown = document.querySelectorAll('.pilih-ketua');

    ketuaDropdown.forEach(item => {
        item.addEventListener('click', function () {
            const url = new URL(assignLeaderUrl);
            const userId = url.searchParams.get('userId'); // Ambil parameter userId
            const prokerId = url.searchParams.get('id');
            const kode_ormawa = url.searchParams.get('kode_ormawa'); // Ambil parameter kode_ormawa
            const periode = url.searchParams.get('periode'); // Ambil parameter periode
            // let userId = this.dataset.id;
            console.log(url);
            fetch(assignLeaderUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        userId: userId,
                        kode_ormawa: kode_ormawa,
                        prokerId: prokerId,
                        periode: periode, // Masukkan parameter lainnya jika perlu
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Ketua berhasil dipilih!');
                    } else {
                        alert('Gagal menyimpan ketua: ' + data.message);
                    }
                });
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Handle user selection
    document.querySelectorAll('.pilih-anggota').forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            // Set selected text
            const userButton = document.getElementById('dropdownUserButton');
            userButton.textContent = this.dataset.name;

            // Update hidden input
            document.querySelector('input[name="anggota"]').value = this.dataset.id;

            // Mark active
            document.querySelectorAll('.pilih-anggota').forEach(function (el) {
                el.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Handle division selection
    document.querySelectorAll('.pilih-divisi').forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            // Set selected text
            const divisiButton = document.getElementById('dropdownDivisiButton');
            divisiButton.textContent = this.dataset.name;

            // Update hidden input
            document.querySelector('input[name="divisi"]').value = this.dataset.id;

            // Mark active
            document.querySelectorAll('.pilih-divisi').forEach(function (el) {
                el.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Handle job position selection
    document.querySelectorAll('.pilih-jabatan').forEach(function (item) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            // Set selected text
            const jabatanButton = document.getElementById('dropdownJabatanButton');
            jabatanButton.textContent = this.dataset.name;

            // Update hidden input
            document.querySelector('input[name="jabatan"]').value = this.dataset.id;

            // Mark active
            document.querySelectorAll('.pilih-jabatan').forEach(function (el) {
                el.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
});
