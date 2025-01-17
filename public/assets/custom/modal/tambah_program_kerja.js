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

document.getElementById('e-add-tujuan').addEventListener('click', function () {
    const tujuanList = document.getElementById('e-tujuan-program-list');
    const newDiv = document.createElement('div');
    newDiv.className = 'flex items-center mb-2';
    newDiv.innerHTML = `
        <input type="text" class="form-control flex-grow" name="tujuan[]" placeholder="Tujuan Program Kerja">
        <button type="button" class="ml-2 text-red-500" onclick="removeInput(this)"><i class="fas fa-times"></i></button>
    `;
    tujuanList.appendChild(newDiv);
});

document.getElementById('e-add-manfaat').addEventListener('click', function () {
    const manfaatList = document.getElementById('e-manfaat-program-list');
    const newDiv = document.createElement('div');
    newDiv.className = 'flex items-center mb-2';
    newDiv.innerHTML = `
        <input type="text" class="form-control flex-grow" name="manfaat[]" placeholder="Manfaat Program Kerja">
        <button type="button" class="ml-2 text-red-500" onclick="removeInput(this)"><i class="fas fa-times"></i></button>
    `;
    manfaatList.appendChild(newDiv);
});

document.addEventListener('DOMContentLoaded', function () {
    // let modal = document.getElementById('editproject' +);
    $(document).on('click', '.edit-button', function () {
        let id = $(this).data('id'); // Get the ID from the button
        let kode_ormawa = $(this).data('kode');
        console.log(id);
        $.ajax({
            url: `/${kode_ormawa}/program-kerja/${id}/edit`, // URL to the Laravel route
            method: 'get',
            success: function (data) {
                // Isi data ke dalam modal
                $('#e-nama-program').val(data.nama);
                $('#e-deskripsi-program').val(data.deskripsi);

                // Tujuan Program Kerja
                $('#e-tujuan-program-list').html('');
                data.tujuan.forEach((tujuan) => {
                    $('#e-tujuan-program-list').append(
                        `<input type="text" class="form-control mb-2" name="tujuan[]" value="${tujuan}">`
                    );
                });

                // Manfaat Program Kerja
                $('#e-manfaat-program-list').html('');
                data.manfaat.forEach((manfaat) => {
                    $('#e-manfaat-program-list').append(
                        `<input type="text" class="form-control mb-2" name="manfaat[]" value="${manfaat}">`
                    );
                });

                // Tipe Program Kerja
                if (data.tipe === 'Internal') {
                    $('#e-internal').prop('checked', true);
                } else if (data.tipe === 'Eksternal') {
                    $('#e-eksternal').prop('checked', true);
                }

                // Anggaran Dana
                $('input[name="anggaran[]"]').each(function () {
                    $(this).prop('checked', data.anggaran.includes($(this).val()));
                });

                // Konsep
                if (data.konsep === 'Online') {
                    $('#e-online').prop('checked', true);
                } else if (data.konsep === 'Offline') {
                    $('#e-offline').prop('checked', true);
                }

                // Tempat, Sasaran, dan Indikator
                $('#e-tempat').val(data.tempat);
                $('#e-sasaran-kegiatan').val(data.sasaran);
                $('#e-indikator-keberhasilan').val(data.indikator);

                // Tanggal
                $('#e-tanggal-mulai').val(data.tanggal_mulai.split(' ')[0]); // Ambil bagian tanggal saja
                $('#e-tanggal-selesai').val(data.tanggal_selesai.split(' ')[0]);

                // Divisi
                $('input[name="divisis[]"]').each(function () {
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
});
