var selectedUserId = 0;
$(document).on('click', '.accept-button', function () {
    selectedUserId = this.getAttribute('data-user-id');
    const userName = this.getAttribute('data-user-name');

    let divisi1_id = this.getAttribute("data-divisi1-id");
    let divisi2_id = this.getAttribute("data-divisi2-id");

    let divisi1_name = this.getAttribute("data-divisi1-name");
    let divisi2_name = this.getAttribute("data-divisi2-name");

    let divisiSelect = document.getElementById("approveUserDivisi");
    let divisiSelectionContainer = document.getElementById("divisiSelection");
    let singleDivisiConfirmation = document.getElementById("singleDivisiConfirmation");

    divisiSelect.innerHTML = ""; // Bersihkan dropdown sebelumnya
    divisiSelectionContainer.classList.add("d-none");
    singleDivisiConfirmation.classList.add("d-none");

    if (divisi1_id && divisi2_id) {
        // Jika ada 2 divisi, tampilkan dropdown
        divisiSelectionContainer.classList.remove("d-none");
        divisiSelect.innerHTML += `<option value="${divisi1_id}">${divisi1_name}</option>`;
        divisiSelect.innerHTML += `<option value="${divisi2_id}">${divisi2_name}</option>`;
    } else if (divisi1_id) {
        // Jika hanya ada 1 divisi, tampilkan konfirmasi langsung
        singleDivisiConfirmation.classList.remove("d-none");
        singleDivisiConfirmation.textContent = `User will be assigned to: ${divisi1_id}`;
    }

    // Update modal content
    document.getElementById('approveUserName').textContent = userName;

    // Show modal
    $('#candidateapprove').modal('show');
});

$(document).on('click', '.reject-button', function () {
    selectedUserId = this.getAttribute('data-user-id');
    const userName = this.getAttribute('data-user-name');
    let divisi1 = this.getAttribute("data-divisi1"); // Divisi pertama
    let divisi2 = this.getAttribute("data-divisi2");

    // Update modal content
    document.getElementById('rejectUserName').textContent = userName;

    // Show modal
    $('#candidatereject').modal('show');
});

// Confirm Accept User
document.querySelector('.confirm-accept').addEventListener('click', function () {
    let selectedDivisi = document.getElementById("approveUserDivisi").value || document.getElementById("singleDivisiConfirmation").textContent.split(": ")[1];

    if (!selectedDivisi) {
        alert("Please select a division!");
        return;
    }

    if (selectedUserId) {
        // Lakukan AJAX request
        $.ajax({
            url: acceptCandidateUrl, // Route ke controller
            type: "POST",
            data: {
                "user_id": selectedUserId, // Sertakan CSRF token untuk keamanan
                "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'divisi_selected': selectedDivisi
            },
            success: function (response) {
                console.log(response);
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Reload halaman setelah sukses
                } else {
                    alert('Failed to accept user.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                console.error('Error:', error);
                alert('An error occurred while processing the request.');
            }
        });
    }
});

// Confirm Reject User
document.querySelector('.confirm-reject').addEventListener('click', function () {
    if (selectedUserId) {
        fetch("{{ route('candidates.reject ') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    user_id: selectedUserId
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Failed to reject user.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing the request.');
            });
    }
});

// document.querySelectorAll('.accept-button').forEach(button => {
//     button.addEventListener('click', function () {
//         const userId = this.getAttribute('data-user-id');

//         if (confirm('Are you sure you want to accept this user?')) {
//             fetch("{{ route('candidates.accept ') }}", {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/json',
//                         'X-CSRF-TOKEN': '{{ csrf_token() }}',
//                     },
//                     body: JSON.stringify({
//                         user_id: userId
//                     }),
//                 })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         alert(data.message);
//                         location.reload(); // Reload halaman setelah berhasil
//                     } else {
//                         alert('Failed to accept user.');
//                     }
//                 })
//                 .catch(error => {
//                     console.error('Error:', error);
//                     alert('An error occurred while processing the request.');
//                 });
//         }
//     });
// });
