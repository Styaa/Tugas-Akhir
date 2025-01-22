document.addEventListener('DOMContentLoaded', function () {
    const ketuaDropdown = document.querySelectorAll('.pilih-ketua');

    ketuaDropdown.forEach(item => {
        item.addEventListener('click', function () {
            // Ambil data dari item yang diklik
            const userId = this.dataset.id; // Ambil ID dari dataset item yang baru diklik
            const periode = new URLSearchParams(window.location.search).get('periode'); // Ambil periode dari URL
            const currUrl = window.location.pathname;
            const pathParts = currUrl.split('/');
            const kodeOrmawa = pathParts[1]; // Ambil kode ormawa dari URL
            const prokerId = pathParts[3]; // Ambil ID program kerja dari URL

            // var assignLeaderUrl =
            //     `{{ route('program-kerja.pilih-ketua', ['kode_ormawa' => ${kodeOrmawa}, 'id' => ${prokerId}, 'periode' => ${periode}, 'userId' => ${userId}]) }}?periode=${periode}`;

            const assignLeaderUrl = `/${kodeOrmawa}/program-kerja/${prokerId}/${periode}/${userId}/pilih-ketua`;


            console.log('User ID yang dipilih:', userId);
            console.log(assignLeaderUrl);

            fetch(assignLeaderUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Ketua berhasil dipilih!');
                        location.reload();
                        // Perbarui tampilan UI (opsional, seperti menandai user terpilih)
                        ketuaDropdown.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');
                    } else {
                        alert('Gagal menyimpan ketua: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
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
