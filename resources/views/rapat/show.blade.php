@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">{{ $rapat->nama }}</h2>
                <p class="text-muted">{{ $rapat->topik }}</p>
            </div>
            <div class="d-flex gap-2">
                @if ($canMarkAttendance)
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#absensiRapatModal">
                        <i class="fas fa-user-check me-2"></i>Absensi Peserta
                    </button>
                @endif
                <a href="{{ route('rapat.tulis_notulensi', ['id_rapat' => $rapat->id, 'kode_ormawa' => $kode_ormawa]) }}"
                    class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Tulis Notulen
                </a>
            </div>
        </div>

        <!-- Rincian Rapat -->
        <div class="card p-4 shadow-sm mb-4">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row" width="40%">Tanggal</th>
                                <td>{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr class="border-top">
                                <th scope="row">Waktu</th>
                                <td>{{ \Carbon\Carbon::parse($rapat->waktu)->format('H:i') }} WIB</td>
                            </tr>
                            <tr class="border-top">
                                <th scope="row">Lokasi</th>
                                <td>{{ $rapat->tempat }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row" width="40%">Tipe</th>
                                <td><span class="badge bg-info">{{ ucfirst($rapat->tipe) }}</span></td>
                            </tr>
                            <tr class="border-top">
                                <th scope="row">Status</th>
                                <td>
                                    <span
                                        class="badge bg-{{ $rapat->status == 'terjadwal' ? 'primary' : ($rapat->status == 'selesai' ? 'success' : 'secondary') }}">
                                        {{ ucfirst($rapat->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="border-top">
                                <th scope="row">Dibuat oleh</th>
                                <td>{{ $rapat->creator->name ?? 'Unknown' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ringkasan Kehadiran -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Ringkasan Kehadiran</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $stats['persenHadir'] }}%;" aria-valuenow="{{ $stats['persenHadir'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $stats['persenHadir'] }}% Hadir
                            </div>
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $stats['persenIzin'] }}%;" aria-valuenow="{{ $stats['persenIzin'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $stats['persenIzin'] }}% Izin
                            </div>
                            <div class="progress-bar bg-danger" role="progressbar"
                                style="width: {{ $stats['persenAbsen'] }}%;" aria-valuenow="{{ $stats['persenAbsen'] }}"
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $stats['persenAbsen'] }}% Tidak Hadir
                            </div>
                        </div>

                        @if ($rapat->catatan_absensi)
                            <div class="mt-3 p-3 bg-light rounded">
                                <h6 class="fw-bold">Catatan Absensi:</h6>
                                <p class="mb-0">{{ $rapat->catatan_absensi }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-5">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">Statistik Kehadiran</h6>
                                <ul class="list-group list-group-flush">
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                        <span>Total Peserta</span>
                                        <span class="badge bg-primary rounded-pill">{{ $stats['total'] }}</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                        <span>Hadir</span>
                                        <span class="badge bg-success rounded-pill">{{ $stats['hadir'] }}</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                        <span>Izin</span>
                                        <span class="badge bg-warning text-dark rounded-pill">{{ $stats['izin'] }}</span>
                                    </li>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                        <span>Tidak Hadir</span>
                                        <span class="badge bg-danger rounded-pill">{{ $stats['absen'] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Peserta -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Peserta</h5>
                @if (Auth::user()->jabatanOrmawa->id <= 3 ||
                        (isset(Auth::user()->jabatanProker) && Auth::user()->jabatanProker->id <= 3))
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#daftarIzinModal">
                        <i class="fas fa-clipboard-list me-1"></i>Lihat Daftar Izin
                    </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Waktu Hadir</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rapat_partisipasi as $partisipan)
                                @php
                                    $izin = $daftarIzin->where('user_id', $partisipan->user_id)->first();
                                    $kehadiran = $partisipan->status_kehadiran ?? 'absen';

                                    $statusClass = 'text-danger';
                                    $statusLabel = 'Tidak Hadir';

                                    if ($kehadiran === 'hadir') {
                                        $statusClass = 'text-success';
                                        $statusLabel = 'Hadir';
                                    } elseif ($kehadiran === 'izin' || $izin) {
                                        $statusClass = 'text-warning';
                                        $statusLabel = 'Izin';
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/profile/' . $partisipan->user->foto ?? 'default.jpg') }}"
                                                class="rounded-circle me-3" width="40" height="40"
                                                alt="Foto Peserta">
                                            <div>
                                                <strong>{{ $partisipan->user->name }}</strong>
                                                <p class="text-muted m-0 small">{{ $partisipan->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $kehadiran === 'hadir' ? 'bg-success' : ($kehadiran === 'izin' || $izin ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($kehadiran === 'hadir')
                                            {{ $partisipan->waktu_check_in ? \Carbon\Carbon::parse($partisipan->waktu_check_in)->format('H:i') : '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($izin)
                                            <span class="small">{{ Str::limit($izin->alasan, 50) }}</span>
                                            @if (strlen($izin->alasan) > 50)
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $izin->alasan }}">
                                                    <i class="fas fa-info-circle ms-1"></i>
                                                </a>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">
                                        <i class="fas fa-users-slash fs-4 text-muted mb-2"></i>
                                        <p class="mb-0">Belum ada peserta yang terdaftar dalam rapat ini</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            @php
                $izin = $daftarIzin->where('user_id', Auth::id())->first();
            @endphp

            @if (!$izin)
                <p>Bila tidak bisa mengikuti rapat, silahkan izin melalui tombol di bawah.</p>
                <a type="button" class="btn btn-primary w-sm-100" data-bs-toggle="modal"
                    data-bs-target="#izinrapat">Saya
                    tidak bisa hadir</a>
            @else
                <p class="fw-bold">Anda sudah mengajukan izin untuk rapat ini.</p>
                <span class="badge bg-warning text-dark">Izin Diajukan - {{ $izin->status }}</span>
                <p class="text-muted mt-2"><strong>Alasan:</strong> {{ $izin->alasan }}</p>
            @endif
        </div>
    </div>

    <div class="modal fade" id="absensiRapatModal" tabindex="-1" aria-labelledby="absensiRapatModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="absensiRapatModalLabel">
                        <i class="fas fa-user-check me-2"></i>Absensi Peserta Rapat
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="absensiForm"
                        action="{{ route('rapat.absensi', ['id_rapat' => $rapat->id, 'kode_ormawa' => $kode_ormawa]) }}"
                        method="POST">
                        @csrf

                        <div class="alert alert-info mb-4">
                            <div class="d-flex">
                                <i class="fas fa-info-circle fs-5 me-2 mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Informasi Rapat</h6>
                                    <p class="mb-0">{{ $rapat->nama }} -
                                        {{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('d F Y') }}</p>
                                    <p class="mb-0 small">Centang peserta yang hadir pada rapat ini</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Daftar Peserta</h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="btnPilihSemua">
                                        <i class="fas fa-check-double me-1"></i>Pilih Semua
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnBatalPilih">
                                        <i class="fas fa-times me-1"></i>Batal Pilih
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%">Hadir</th>
                                            <th width="40%">Nama</th>
                                            <th width="25%">Status</th>
                                            <th width="20%">Waktu Hadir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rapat_partisipasi as $index => $partisipan)
                                            @php
                                                // Get izin info if exists
                                                $izin = $daftarIzin->where('user_id', $partisipan->user_id)->first();

                                                // Current status
                                                $currentStatus = $partisipan->status_kehadiran ?? 'absen';
                                                $isHadir = $currentStatus === 'hadir';

                                                // Only disable if izin is approved
                                                $isApprovedIzin = $izin && $izin->status === 'disetujui';

                                                // Show special label for rejected izin
                                                $isRejectedIzin = $izin && $izin->status === 'ditolak';

                                                // Get waktu check in
                                                $waktuHadir = $partisipan->waktu_check_in
                                                    ? \Carbon\Carbon::parse($partisipan->waktu_check_in)->format('H:i')
                                                    : now()->format('H:i');
                                            @endphp
                                            <tr
                                                class="{{ $isApprovedIzin ? 'table-warning' : ($isHadir ? 'table-success' : ($isRejectedIzin ? 'table-danger' : '')) }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkbox-hadir" type="checkbox"
                                                            name="kehadiran[{{ $partisipan->user_id }}][hadir]"
                                                            id="hadir_{{ $partisipan->user_id }}" value="1"
                                                            {{ $isHadir ? 'checked' : '' }}
                                                            {{ $isApprovedIzin ? 'disabled' : '' }}>
                                                        <input type="hidden"
                                                            name="kehadiran[{{ $partisipan->user_id }}][user_id]"
                                                            value="{{ $partisipan->user_id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/profile/' . $partisipan->user->foto ?? 'default.jpg') }}"
                                                            class="rounded-circle me-2" width="40" height="40"
                                                            alt="Foto Peserta">
                                                        <div>
                                                            <strong>{{ $partisipan->user->name }}</strong>
                                                            @if ($isApprovedIzin)
                                                                <span class="badge bg-warning text-dark ms-2">Izin
                                                                    Disetujui</span>
                                                            @elseif ($isRejectedIzin)
                                                                <span class="badge bg-danger ms-2">Izin Ditolak</span>
                                                                @if ($isHadir)
                                                                    <span class="badge bg-success ms-1">Hadir</span>
                                                                @endif
                                                            @elseif ($isHadir)
                                                                <span class="badge bg-success ms-2">Hadir</span>
                                                            @else
                                                                <span class="badge bg-secondary ms-2">Belum Hadir</span>
                                                            @endif
                                                            <div class="text-muted small">
                                                                {{ $partisipan->user->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($isApprovedIzin && $izin)
                                                        <span
                                                            class="small text-muted">{{ Str::limit($izin->alasan, 50) }}</span>
                                                    @elseif ($isRejectedIzin && $izin)
                                                        <div>
                                                            <span class="small text-danger">Izin ditolak</span>
                                                            <p class="small text-muted mb-0">
                                                                {{ Str::limit($izin->alasan, 30) }}</p>
                                                            <select class="form-select form-select-sm mt-1"
                                                                name="kehadiran[{{ $partisipan->user_id }}][status]">
                                                                <option value="hadir" {{ $isHadir ? 'selected' : '' }}>
                                                                    Hadir</option>
                                                                <option value="absen" {{ !$isHadir ? 'selected' : '' }}>
                                                                    Tidak
                                                                    Hadir</option>
                                                            </select>
                                                        </div>
                                                    @else
                                                        <select class="form-select form-select-sm"
                                                            name="kehadiran[{{ $partisipan->user_id }}][status]"
                                                            {{ $isApprovedIzin ? 'disabled' : '' }}>
                                                            <option value="hadir" {{ $isHadir ? 'selected' : '' }}>
                                                                Hadir</option>
                                                            <option value="absen"
                                                                {{ !$isHadir && !$isApprovedIzin ? 'selected' : '' }}>Tidak
                                                                Hadir</option>
                                                        </select>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="time" class="form-control form-control-sm waktu-hadir"
                                                        name="kehadiran[{{ $partisipan->user_id }}][waktu]"
                                                        id="waktu_{{ $partisipan->user_id }}"
                                                        value="{{ $waktuHadir }}"
                                                        {{ !$isHadir && !$isRejectedIzin ? 'disabled' : '' }}
                                                        {{ $isApprovedIzin ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="catatan_absensi" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="catatan_absensi" name="catatan_absensi" rows="3"
                                placeholder="Tambahkan catatan tentang kehadiran rapat (opsional)">{{ $rapat->catatan_absensi ?? '' }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanAbsensi">
                        <i class="fas fa-save me-1"></i>Simpan Absensi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get buttons and checkboxes
            const btnPilihSemua = document.getElementById('btnPilihSemua');
            const btnBatalPilih = document.getElementById('btnBatalPilih');
            const btnSimpanAbsensi = document.getElementById('btnSimpanAbsensi');
            const checkboxesHadir = document.querySelectorAll('.checkbox-hadir:not([disabled])');
            const waktuHadirInputs = document.querySelectorAll('.waktu-hadir');

            // Toggle attendance time field based on checkbox
            checkboxesHadir.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const userId = this.id.replace('hadir_', '');
                    const waktuInput = document.getElementById('waktu_' + userId);
                    const statusSelect = this.closest('tr').querySelector(
                        'select[name^="kehadiran"][name$="[status]"]');

                    if (waktuInput) {
                        if (this.checked) {
                            waktuInput.disabled = false;
                            if (statusSelect) statusSelect.value = 'hadir';

                            // If time is empty, set current time
                            if (!waktuInput.value || waktuInput.value === '') {
                                const now = new Date();
                                const hours = String(now.getHours()).padStart(2, '0');
                                const minutes = String(now.getMinutes()).padStart(2, '0');
                                waktuInput.value = `${hours}:${minutes}`;
                            }
                        } else {
                            waktuInput.disabled = true;
                            if (statusSelect) statusSelect.value = 'absen';
                        }
                    }
                });
            });

            // Status select change should update checkbox
            document.querySelectorAll('select[name$="[status]"]').forEach(select => {
                select.addEventListener('change', function() {
                    const userId = this.name.match(/kehadiran\[(\d+)\]/)[1];
                    const checkbox = document.getElementById('hadir_' + userId);
                    const waktuInput = document.getElementById('waktu_' + userId);

                    if (checkbox && waktuInput) {
                        if (this.value === 'hadir') {
                            checkbox.checked = true;
                            waktuInput.disabled = false;

                            // Set current time if empty
                            if (!waktuInput.value || waktuInput.value === '') {
                                const now = new Date();
                                const hours = String(now.getHours()).padStart(2, '0');
                                const minutes = String(now.getMinutes()).padStart(2, '0');
                                waktuInput.value = `${hours}:${minutes}`;
                            }
                        } else {
                            checkbox.checked = false;
                            waktuInput.disabled = true;
                        }
                    }
                });
            });

            // Select all attendees (except those with approved excuses)
            btnPilihSemua.addEventListener('click', function() {
                checkboxesHadir.forEach(checkbox => {
                    // Skip checkboxes that are disabled (approved excuses)
                    if (!checkbox.disabled) {
                        checkbox.checked = true;
                        // Trigger change event
                        const event = new Event('change');
                        checkbox.dispatchEvent(event);
                    }
                });
            });

            // Unselect all attendees
            btnBatalPilih.addEventListener('click', function() {
                checkboxesHadir.forEach(checkbox => {
                    // Skip checkboxes that are disabled (approved excuses)
                    if (!checkbox.disabled) {
                        checkbox.checked = false;
                        // Trigger change event
                        const event = new Event('change');
                        checkbox.dispatchEvent(event);
                    }
                });
            });

            // Save attendance
            btnSimpanAbsensi.addEventListener('click', function() {
                document.getElementById('absensiForm').submit();
            });

            document.querySelectorAll('.accept-button, .reject-button').forEach(button => {
                button.addEventListener('click', function() {
                    const izinId = this.getAttribute('data-izin-id');
                    const userName = this.getAttribute('data-user-name');
                    const isAccept = this.classList.contains('accept-button');

                    // Get the current URL parts
                    const url = new URL(window.location.href);
                    const kodeOrmawa = url.pathname.split('/')[
                        1]; // Gets "KSMIF" from "/KSMIF/rapat/show"
                    const idRapat = url.searchParams.get(
                        'id_rapat'); // Gets the id_rapat from query string

                    // Confirmation dialog with appropriate message
                    const message = isAccept ?
                        `Apakah Anda yakin ingin menyetujui izin dari ${userName}?` :
                        `Apakah Anda yakin ingin menolak izin dari ${userName}?`;

                    if (confirm(message)) {
                        // Create and submit the form
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action =
                            `/${kodeOrmawa}/rapat/izin/${izinId}/update?id_rapat=${idRapat}`;

                        // Add CSRF token
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content');
                        form.appendChild(csrfToken);

                        // Add method override
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'PATCH';
                        form.appendChild(methodField);

                        // Add status
                        const statusField = document.createElement('input');
                        statusField.type = 'hidden';
                        statusField.name = 'status';
                        statusField.value = isAccept ? 'disetujui' : 'ditolak';
                        form.appendChild(statusField);

                        // Submit the form
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
