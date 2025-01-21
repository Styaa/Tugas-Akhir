document.addEventListener('DOMContentLoaded', function () {
    const updateFields = document.querySelectorAll('.update-field');

    const currentUrl = window.location.pathname;
    const pathParts = currentUrl.split('/');

    const kodeOrmawa = pathParts[1];
    const prokerNama = decodeURIComponent(pathParts[3]);
    const namaDivisi = pathParts[5];

    updateFields.forEach(field => {
        field.addEventListener('change', function () {
            const row = field.closest('tr');
            const activityId = row.getAttribute('data-id');
            const fieldName = field.getAttribute('name');
            const fieldValue = field.value;

            const updateField = `/${encodeURIComponent(kodeOrmawa)}/program-kerja/${encodeURIComponent(prokerNama)}/divisi/${encodeURIComponent(namaDivisi)}/aktivitas/${encodeURIComponent(activityId)}/update`;

            const payload = {};
            payload[fieldName.split('_')[0]] = fieldValue;

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
                        console.log(data.message);
                        // Ambil elemen alert
                        const alertElement = document.getElementById('success-alert');
                        const alertMessage = document.getElementById('success-message');

                        // Set pesan dan tampilkan alert
                        alertMessage.textContent = data.message;
                        alertElement.hidden = false;

                        // Auto-hide setelah beberapa detik (opsional)
                        setTimeout(() => {
                            alertElement.hidden = true;
                        }, 5000);
                    } else {
                        console.error('Error updating activity.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
