@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" hidden role="alert">
        <span id="success-message"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="row g-3">
        {{-- Card Aktivitas --}}
        <div class="col-xl-9 col-lg-8 col-md-12 mb-4">
            <div class="card mb-4">
                <div
                    class="card-header py-3 px-0 d-flex flex-column align-items-center text-center justify-content-between">
                    <h3 class="fw-bold flex-fill mb-2">{{ $namaDivisi->nama_divisi }}</h3>
                </div>
                <div class="card-body d-flex flex-column">
                    @if ($activities->isEmpty())
                        <p class="text-center">No activities yet. Start by adding a new activity below.</p>
                    @endif
                    <table id="myProjectTable" class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Assignee</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Dependency</th>
                                @if (Auth::user()->jabatanOrmawa->id !== 13 || Auth::user()->jabatanProker->id !== 13)
                                    <th>Nilai</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <form
                                    action="{{ route('program-kerja.divisi.aktivitas.update', ['kode_ormawa' => $kode_ormawa, 'id' => $prokerId, 'aktivitas_id' => $activity->id, 'nama_program_kerja' => $prokerNama]) }}"
                                    method="PATCH">
                                    @csrf
                                    @method('PATCH')
                                    <tr data-id="{{ $activity->id }}">
                                        @php
                                            $activityId = $activity->id;
                                        @endphp
                                        <td>
                                            <input type="text"
                                                class="form-control bg-transparent border-0 fs-10 update-field"
                                                value="{{ $activity->nama }}" name="nama" />
                                        </td>
                                        <td>
                                            <select class="form-select bg-transparent border-0 fs-11 update-field"
                                                name="person_in_charge">
                                                <option value="">Assign User</option>
                                                @foreach ($anggotaProker as $user)
                                                    <option value="{{ $user->user_id }}"
                                                        {{ $activity->person_in_charge == $user->user_id ? 'selected' : '' }}>
                                                        {{ $user->nama_user }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control bg-transparent border-0 update-field"
                                                value="{{ $activity->tenggat_waktu ? $activity->tenggat_waktu : '' }}"
                                                name="tenggat_waktu" />
                                        </td>
                                        <td>
                                            <select class="form-select bg-transparent border-0 update-field"
                                                name="prioritas">
                                                <option value="rendah"
                                                    {{ $activity->prioritas == 'rendah' ? 'selected' : '' }}>Low
                                                </option>
                                                <option value="sedang"
                                                    {{ $activity->prioritas == 'sedang' ? 'selected' : '' }}>Normal
                                                </option>
                                                <option value="tinggi"
                                                    {{ $activity->prioritas == 'tinggi' ? 'selected' : '' }}>High
                                                </option>
                                                <option value="kritikal"
                                                    {{ $activity->prioritas == 'kritikal' ? 'selected' : '' }}>Urgent
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select bg-transparent border-0 update-field" name="status"
                                                data-status="{{ $activity->status }}">
                                                <option value="belum_mulai"
                                                    {{ $activity->status == 'belum_mulai' ? 'selected' : '' }}>Not Started
                                                </option>
                                                <option value="sedang_berjalan"
                                                    {{ $activity->status == 'sedang_berjalan' ? 'selected' : '' }}>In
                                                    Progress</option>
                                                <option value="selesai"
                                                    {{ $activity->status == 'selesai' ? 'selected' : '' }}>Completed
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select bg-transparent border-0 update-field"
                                                name="dependency_id">
                                                <option value="">No Dependency</option>
                                                @foreach ($activities as $depActivity)
                                                    <option value="{{ $depActivity->id }}"
                                                        {{ $depActivity->id == $activity->dependency_id ? 'selected' : '' }}>
                                                        {{ $depActivity->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        @if (Auth::user()->jabatanOrmawa->id !== 13 || Auth::user()->jabatanProker->id !== 13)
                                            <td>
                                                <select class="form-select update-field" name="nilai" id="nilai">
                                                    <option value="">Pilih Nilai</option>
                                                    <option value="1" {{ $activity->nilai == '1' ? 'selected' : '' }}>
                                                        1
                                                    </option>
                                                    <option value="2" {{ $activity->nilai == '2' ? 'selected' : '' }}>
                                                        2
                                                    </option>
                                                    <option value="3" {{ $activity->nilai == '3' ? 'selected' : '' }}>
                                                        3
                                                    </option>
                                                    <option value="4" {{ $activity->nilai == '4' ? 'selected' : '' }}>
                                                        4
                                                    </option>
                                                    <option value="5" {{ $activity->nilai == '5' ? 'selected' : '' }}>
                                                        5
                                                    </option>
                                                </select>
                                            </td>
                                        @endif
                                    </tr>
                                </form>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-dark w-100 mt-3" data-bs-toggle="modal"
                        data-bs-target="#addActivity">
                        <i class="icofont-plus-circle me-2 fs-6"></i>Tambah Aktivitas
                    </button>
                </div>
            </div>
        </div>

        {{-- Card Anggota Divisi --}}
        <div class="col-xl-3 col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                    <h6 class="mb-0 fw-bold ">Anggota Divisi</h6>
                </div>
                <div class="card-body">
                    <div class="flex-grow-1">
                        @forelse ($anggotaProker as $item)
                            <div class="py-2 d-flex align-items-center border-bottom flex-wrap">
                                <div class="d-flex align-items-center flex-fill">
                                    <img class="avatar lg rounded-circle img-thumbnail"
                                        src="{{ url('/') . '/images/lg/avatar2.jpg' }}" alt="profile">
                                    <div class="d-flex flex-column ps-3">
                                        <h6 class="fw-bold mb-0 small-14">{{ $item->nama_user }}</h6>
                                        <span class="text-muted">{{ $item->nama_jabatan }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <h6 class="fw-bold mb-0 small-14">Divisi ini belum memiliki anggota.</h6>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Jquery Page Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/dataTables.bundle.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('assets/custom/aktivitas/update-field.js') }}"></script>

    <script>
        // project data table
        $(document).ready(function() {
            // Inisialisasi DataTables dengan Responsive
            var table = $('#myProjectTable')
                .addClass('nowrap')
                .DataTable({
                    responsive: true,
                    columnDefs: [{
                        targets: [-1, -3],
                        className: 'dt-body-right'
                    }]
                });

            // Observer untuk memantau perubahan pada tabel
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    // Cek apakah ada elemen child yang ditambahkan
                    if (mutation.addedNodes.length > 0) {
                        mutation.addedNodes.forEach(node => {
                            if (node.nodeType === 1 && node.classList.contains('child')) {
                                // Dapatkan <tr> parent yang tepat
                                const parentRow = $(node).prev('tr.parent');
                                const parentDataId = parentRow.attr('data-id');

                                if (parentDataId) {
                                    // Tambahkan data-id dari parent ke <tr class="child">
                                    $(node).attr('data-id', parentDataId);
                                    console.log(
                                        `data-id ${parentDataId} ditambahkan ke .child`);
                                }
                            }
                        });
                    }
                });
            });

            // Pantau perubahan pada tabel
            observer.observe(document.querySelector('#myProjectTable tbody'), {
                childList: true,
                subtree: true
            });
        });
    </script>

    {{-- <script>
        // const activityId = row.getAttribute('data-id');

        var updateField =
            `{{ route('program-kerja.divisi.aktivitas.update', ['kode_ormawa' => $kode_ormawa, 'nama_program_kerja' => $prokerNama, 'id' => $namaDivisi->id_divisi, 'aktivitas_id' => $activityId]) }}?periode=$periode`;
    </script> --}}
@endsection
