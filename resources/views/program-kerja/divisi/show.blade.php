@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="row g-3">
        {{-- Card Aktivitas --}}
        <div class="col-xl-9 col-lg-8 col-md-8">
            <div class="card mb-4">
                <div class="card-header py-3 px-0 d-flex flex-column align-items-center text-center justify-content-between">
                    <h3 class="fw-bold flex-fill mb-2">{{ $namaDivisi->nama_divisi }}</h3>
                </div>
                <div class="card-body d-flex flex-column">
                    @if ($activities->isEmpty())
                        <p class="text-center">No activities yet. Start by adding a new activity below.</p>
                    @endif
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Assignee</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Dependency</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control fs-10" value="{{ $activity->nama }}"
                                            name="activity_name_{{ $activity->id }}" />
                                    </td>
                                    <td>
                                        <select class="form-select fs-11" name="person_in_charge_{{ $activity->id }}">
                                            <option value="">Assign User</option>
                                            @foreach ($anggotaProker as $user)
                                                <option value="{{ $user->user_id }}"
                                                    {{ $activity->person_in_charge == $user->user_id ? 'selected' : '' }}>
                                                    {{ $user->nama_user }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control"
                                            value="{{ $activity->tenggat_waktu ? $activity->tenggat_waktu->format('Y-m-d') : '' }}"
                                            name="tenggat_waktu_{{ $activity->id }}" />
                                    </td>
                                    <td>
                                        <select class="form-select" name="prioritas_{{ $activity->id }}">
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
                                        <select class="form-select" name="status_{{ $activity->id }}">
                                            <option value="belum_mulai"
                                                {{ $activity->status == 'belum_mulai' ? 'selected' : '' }}>Not
                                                Started</option>
                                            <option value="sedang_berjalan"
                                                {{ $activity->status == 'sedang_berjalan' ? 'selected' : '' }}>In
                                                Progress</option>
                                            <option value="selesai" {{ $activity->status == 'selesai' ? 'selected' : '' }}>
                                                Completed
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" name="dependency_{{ $activity->id }}">
                                            <option value="">No Dependency</option>
                                            @foreach ($activities as $activity)
                                                <option value="{{ $activity->id }}"
                                                    {{ $activity->id == $activity->dependency_id ? 'selected' : '' }}>
                                                    {{ $activity->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
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
        <div class="col-xl-3 col-lg-12 col-md-12 ms-auto">
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
    <script src="{{ asset('js/template.js') }}"></script>
@endsection
