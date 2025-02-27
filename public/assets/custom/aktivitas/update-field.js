document.addEventListener('DOMContentLoaded', function () {
    const currentUrl = window.location.pathname;
    const pathParts = currentUrl.split('/');

    const kodeOrmawa = pathParts[1];
    const prokerNama = decodeURIComponent(pathParts[3]);
    const namaDivisi = pathParts[5];

    // Fungsi untuk update field
    function updateFieldData(field) {
        const parentRow = field.closest('tr') || field.closest('.child').closest('tr');
        const activityId = parentRow.getAttribute('data-id');
        const fieldName = field.getAttribute('name');
        const fieldValue = field.value;

        const updateField = `/${encodeURIComponent(kodeOrmawa)}/program-kerja/${encodeURIComponent(prokerNama)}/divisi/${encodeURIComponent(namaDivisi)}/aktivitas/${encodeURIComponent(activityId)}/update`;

        const payload = {};
        payload[fieldName] = fieldValue;

        // Cek status yang dipilih untuk tanggal mulai dan selesai
        const currentDate = new Date().toISOString().split('T')[0];
        if (fieldName === 'status') {
            if (fieldValue === 'sedang_berjalan') {
                payload['tanggal_mulai'] = currentDate;
            } else if (fieldValue === 'selesai') {
                payload['tanggal_selesai'] = currentDate;
            }
        }

        console.log('Payload:', payload);

        // Kirim permintaan AJAX ke server
        fetch(updateField, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(payload),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Update berhasil:', data.message);

                    // Tampilkan notifikasi sukses
                    const alertElement = document.getElementById('success-alert');
                    const alertMessage = document.getElementById('success-message');
                    alertMessage.textContent = data.message;
                    alertElement.hidden = false;
                    setTimeout(() => {
                        alertElement.hidden = true;
                    }, 3000);
                } else {
                    console.error('Gagal mengupdate data.');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Fungsi untuk menambah event listener pada elemen update-field
    function addUpdateFieldListeners() {
        const updateFields = document.querySelectorAll('.update-field');
        updateFields.forEach(field => {
            field.removeEventListener('change', handleChange); // Hapus listener sebelumnya
            field.addEventListener('change', handleChange); // Tambahkan listener baru
        });
    }

    // Event handler untuk change event
    function handleChange(event) {
        updateFieldData(event.target);
    }

    // Pasang event listener pertama kali
    addUpdateFieldListeners();

    // Observer untuk memantau perubahan pada tabel
    const tableContainer = document.querySelector('#myProjectTable tbody');
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            mutation.addedNodes.forEach(node => {
                if (node.nodeType === 1 && node.classList.contains('child')) {
                    // Dapatkan <tr> parent yang tepat
                    const parentRow = $(node).prev('tr.parent');
                    const parentDataId = parentRow.attr('data-id');

                    if (parentDataId) {
                        // Tambahkan data-id dari parent ke <tr class="child">
                        node.setAttribute('data-id', parentDataId);
                        console.log(`data-id ${parentDataId} ditambahkan ke .child`);
                    }
                    addUpdateFieldListeners(); // Tambahkan listener pada elemen baru
                }
            });
        });
    });

    // Pantau perubahan pada tabel
    observer.observe(tableContainer, {
        childList: true,
        subtree: true
    });

    // Media Query Listener untuk tampilan responsif
    const mediaQuery = window.matchMedia('(max-width: 768px)');

    function handleMediaQueryChange(event) {
        if (event.matches) {
            console.log('Tampilan Mobile');
        } else {
            console.log('Tampilan Desktop');
        }
        addUpdateFieldListeners();
    }
    mediaQuery.addEventListener('change', handleMediaQueryChange);
});


document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua elemen select dengan class 'update-field'
    document.querySelectorAll('.update-field').forEach(function (select) {
        // Dapatkan status saat ini dari data-status
        const currentStatus = select.getAttribute('data-status');

        // Disable option sesuai dengan status saat ini
        select.querySelectorAll('option').forEach(function (option) {
            if (currentStatus === 'belum_mulai' && option.value === 'belum_mulai') {
                option.disabled = false;
            } else if (currentStatus === 'sedang_berjalan') {
                if (option.value === 'belum_mulai') {
                    option.disabled = true;
                }
            } else if (currentStatus === 'selesai') {
                if (option.value === 'belum_mulai' || option.value === 'sedang_berjalan') {
                    option.disabled = true;
                }
            }
        });

        // Disable Completed jika belum In Progress
        if (currentStatus === 'belum_mulai') {
            select.querySelector('option[value="selesai"]').disabled = true;
        }
    });
});
