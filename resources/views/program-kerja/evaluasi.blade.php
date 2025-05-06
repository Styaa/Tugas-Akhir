@extends('layouts.app')

@section('title', __('Evaluasi Kinerja - ' . $programKerja->nama))

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom">
                        <h3 class="fw-bold mb-0">Evaluasi Kinerja - {{ $programKerja->nama }}</h3>
                        <a href="{{ route('program-kerja.show', ['kode_ormawa' => $kode_ormawa, 'id' => $programKerja->id]) }}"
                           class="btn btn-outline-secondary">
                            <i class="icofont-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <p class="text-muted">Evaluasi kinerja anggota program kerja yang telah selesai.</p>
                            <div class="d-flex align-items-center">
                                <span class="me-2 fw-bold">Ketua Program Kerja:</span>
                                <span>{{ isset($ketua) ? $ketua->name : 'Tidak Diketahui' }}</span>
                            </div>
                        </div>

                        <!-- Chart summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header py-3 bg-transparent">
                                        <h5 class="fw-bold mb-0">Performa Anggota Teratas</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="evaluationChart" height="280"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header py-3 bg-transparent">
                                        <h5 class="fw-bold mb-0">Distribusi Nilai</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Rentang Nilai</th>
                                                        <th>Jumlah Anggota</th>
                                                        <th>Persentase</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $categories = [
                                                            'Sangat Baik (0.8-1.0)' => 0,
                                                            'Baik (0.6-0.79)' => 0,
                                                            'Cukup (0.4-0.59)' => 0,
                                                            'Kurang (0.2-0.39)' => 0,
                                                            'Sangat Kurang (0-0.19)' => 0
                                                        ];

                                                        foreach ($anggotaEvaluasi as $anggota) {
                                                            $nilai = $anggota->nilai_akhir ?? 0;
                                                            if ($nilai >= 0.8) $categories['Sangat Baik (0.8-1.0)']++;
                                                            elseif ($nilai >= 0.6) $categories['Baik (0.6-0.79)']++;
                                                            elseif ($nilai >= 0.4) $categories['Cukup (0.4-0.59)']++;
                                                            elseif ($nilai >= 0.2) $categories['Kurang (0.2-0.39)']++;
                                                            else $categories['Sangat Kurang (0-0.19)']++;
                                                        }

                                                        $total = count($anggotaEvaluasi);
                                                    @endphp

                                                    @foreach ($categories as $category => $count)
                                                        <tr>
                                                            <td>{{ $category }}</td>
                                                            <td>{{ $count }}</td>
                                                            <td>{{ $total > 0 ? number_format(($count / $total) * 100, 1) : 0 }}%</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Criteria weights info -->
                        <div class="alert alert-info mb-4">
                            <h6 class="fw-bold mb-2">Bobot Kriteria Penilaian:</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Kehadiran:</strong> 20%
                                </div>
                                <div class="col-md-3">
                                    <strong>Kontribusi:</strong> 25%
                                </div>
                                <div class="col-md-3">
                                    <strong>Tanggung Jawab:</strong> 20%
                                </div>
                                <div class="col-md-3">
                                    <strong>Kualitas:</strong> 20%
                                </div>
                                <div class="col-md-3">
                                    <strong>Penilaian Atasan:</strong> 15%
                                </div>
                            </div>
                        </div>

                        <!-- Anggota evaluations table -->
                        <div class="card">
                            <div class="card-header py-3 bg-transparent">
                                <h5 class="fw-bold mb-0">Detail Evaluasi Anggota</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="py-3" width="5%">No</th>
                                                <th class="py-3" width="15%">Nama Anggota</th>
                                                <th class="py-3" width="10%">Divisi</th>
                                                <th class="py-3" width="10%">Jabatan</th>
                                                <th class="py-3" width="10%" class="text-center">Kehadiran (20%)</th>
                                                <th class="py-3" width="10%" class="text-center">Kontribusi (25%)</th>
                                                <th class="py-3" width="10%" class="text-center">Tanggung Jawab (20%)</th>
                                                <th class="py-3" width="10%" class="text-center">Kualitas (20%)</th>
                                                <th class="py-3" width="10%" class="text-center">Penilaian Atasan (15%)</th>
                                                <th class="py-3" width="10%" class="text-center">Nilai Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($anggotaEvaluasi as $index => $anggota)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img class="avatar rounded-circle img-thumbnail"
                                                                 src="{{ url('/') . '/images/lg/avatar2.jpg' }}"
                                                                 alt="profile" width="40" height="40">
                                                            <div class="d-flex flex-column ps-3">
                                                                <h6 class="fw-bold mb-0 small-14">{{ $anggota->nama_anggota }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $anggota->nama_divisi }}</td>
                                                    <td>{{ $anggota->jabatan }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            <span>{{ $anggota->kehadiran }}</span>
                                                            <span class="badge {{ getNormalizedBadgeClass($anggota->kehadiran_normalized) }}">
                                                                {{ number_format($anggota->kehadiran_normalized, 2) }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            <span>{{ $anggota->kontribusi }}</span>
                                                            <span class="badge {{ getNormalizedBadgeClass($anggota->kontribusi_normalized) }}">
                                                                {{ number_format($anggota->kontribusi_normalized, 2) }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            <span>{{ $anggota->tanggung_jawab }}</span>
                                                            <span class="badge {{ getNormalizedBadgeClass($anggota->tanggung_jawab_normalized) }}">
                                                                {{ number_format($anggota->tanggung_jawab_normalized, 2) }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-column">
                                                            <span>{{ $anggota->kualitas }}</span>
                                                            <span class="badge {{ getNormalizedBadgeClass($anggota->kualitas_normalized) }}">
                                                                {{ number_format($anggota->kualitas_normalized, 2) }}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ getAtasanBadgeClass($anggota->penilaian_atasan) }} p-2">
                                                            {{ number_format($anggota->penilaian_atasan, 2) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge {{ getNormalizedBadgeClass($anggota->nilai_akhir) }} p-2 fs-6">
                                                            {{ number_format($anggota->nilai_akhir, 2) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @if (!empty($anggota->keterangan_nilai))
                                                <tr class="bg-light">
                                                    <td colspan="10" class="small">
                                                        <strong>Keterangan:</strong> {{ $anggota->keterangan_nilai }}
                                                    </td>
                                                </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center py-5">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <i class="icofont-user-alt-7 fs-1 text-muted mb-3"></i>
                                                            <p class="mb-0">Belum ada data evaluasi anggota</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare chart data (only show top 5 performers)
    const ctx = document.getElementById('evaluationChart').getContext('2d');

    const anggotaData = @json($anggotaEvaluasi->take(5));
    const anggotaNames = anggotaData.map(a => a.nama_anggota);
    const nilaiAkhir = anggotaData.map(a => a.nilai_akhir);

    // Create horizontal bar chart for better visualization
    const evaluationChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: anggotaNames,
            datasets: [{
                label: 'Nilai Akhir',
                data: nilaiAkhir,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',  // Horizontal bar chart
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Top 5 Performa Anggota'
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 1,
                    title: {
                        display: true,
                        text: 'Nilai'
                    }
                }
            }
        }
    });
});
</script>

@endsection

@php
// Helper function for normalized badge colors (0-1 scale)
function getNormalizedBadgeClass($nilai) {
    if ($nilai >= 0.8) return 'bg-success';
    if ($nilai >= 0.6) return 'bg-primary';
    if ($nilai >= 0.4) return 'bg-info';
    if ($nilai >= 0.2) return 'bg-warning';
    return 'bg-danger';
}

// Helper function for atasan badge colors (typically 0-100 scale)
function getAtasanBadgeClass($nilai) {
    if ($nilai >= 80) return 'bg-success';
    if ($nilai >= 60) return 'bg-primary';
    if ($nilai >= 40) return 'bg-info';
    if ($nilai >= 20) return 'bg-warning';
    return 'bg-danger';
}
@endphp
