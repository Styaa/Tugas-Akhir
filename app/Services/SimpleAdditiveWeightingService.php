<?php

namespace App\Services;

use App\Models\User;
use App\Models\AktivitasDivisiProgramKerja;
use App\Models\ProgramKerja;
use App\Models\Rapat;
use App\Models\RapatPartisipasi;
use App\Models\StrukturProker;
use App\Models\Evaluasi;
use Illuminate\Support\Facades\DB;

class SimpleAdditiveWeightingService
{
    // Bobot kriteria (total harus 1.0)
    protected $bobotKehadiran = 0.20;
    protected $bobotKontribusi = 0.25;
    protected $bobotTanggungJawab = 0.20;
    protected $bobotKualitas = 0.20;
    protected $bobotPenilaianAtasan = 0.15;
    protected $penilaianAtasan;

    public function setPenilaianAtasan($penilaian)
    {
        $this->penilaianAtasan = $penilaian;
    }

    protected function setBobotFromDatabase($proker_id)
    {
        $proker = ProgramKerja::findOrFail($proker_id);

        // Cek apakah bobot sudah diset dan valid
        $totalBobot = ($proker->bobot_kehadiran ?? 0) +
            ($proker->bobot_kontribusi ?? 0) +
            ($proker->bobot_tanggung_jawab ?? 0) +
            ($proker->bobot_kualitas ?? 0) +
            ($proker->bobot_penilaian_atasan ?? 0);

        // Jika bobot valid (total = 1.0 dengan toleransi 0.001), gunakan dari database
        if (abs($totalBobot - 1.0) <= 0.001) {
            $this->bobotKehadiran = $proker->bobot_kehadiran;
            $this->bobotKontribusi = $proker->bobot_kontribusi;
            $this->bobotTanggungJawab = $proker->bobot_tanggung_jawab;
            $this->bobotKualitas = $proker->bobot_kualitas;
            $this->bobotPenilaianAtasan = $proker->bobot_penilaian_atasan;

            return true; // Bobot berhasil diambil dari database
        }

        // Jika bobot tidak valid, gunakan default bobot
        // Opsional: bisa juga throw exception atau return false
        return false; // Menggunakan bobot default
    }

    /**
     * Menghitung evaluasi untuk semua panitia dalam program kerja
     */
    public function hitungEvaluasiProker($proker_id)
    {
        $bobotFromDb = $this->setBobotFromDatabase($proker_id);

        // Dapatkan program kerja
        $proker = ProgramKerja::findOrFail($proker_id);

        // Dapatkan semua panitia dalam proker ini melalui struktur proker
        $panitia = StrukturProker::whereIn('divisi_program_kerjas_id', function ($query) use ($proker_id) {
            $query->select('id')
                ->from('divisi_program_kerjas')
                ->where('program_kerjas_id', $proker_id);
        })->with('user')->get()->pluck('user');

        // Inisialisasi array untuk menyimpan nilai setiap kriteria
        $nilaiKehadiran = [];
        $nilaiKontribusi = [];
        $nilaiTanggungJawab = [];
        $nilaiKualitas = [];
        $nilaiPenilaianAtasan = [];

        // Hitung nilai untuk setiap panitia
        foreach ($panitia as $user) {
            $nilaiKehadiran[$user->id] = $this->hitungNilaiKehadiran($user->id, $proker_id);
            $nilaiKontribusi[$user->id] = $this->hitungNilaiKontribusi($user->id, $proker_id);
            $nilaiTanggungJawab[$user->id] = $this->hitungNilaiTanggungJawab($user->id, $proker_id);
            $nilaiKualitas[$user->id] = $this->hitungNilaiKualitas($user->id, $proker_id);
            $nilaiPenilaianAtasan[$user->id] = $this->hitungNilaiPenilaianAtasan($user->id, $proker_id);
        }

        // Lakukan normalisasi
        $normalisasiKehadiran = $this->normalisasi($nilaiKehadiran, 'benefit');
        $normalisasiKontribusi = $this->normalisasi($nilaiKontribusi, 'benefit');
        $normalisasiTanggungJawab = $this->normalisasi($nilaiTanggungJawab, 'benefit');
        $normalisasiKualitas = $this->normalisasi($nilaiKualitas, 'benefit');
        $normalisasiPenilaianAtasan = $this->normalisasi($nilaiPenilaianAtasan, 'benefit');

        // Hitung skor akhir dan simpan ke database
        foreach ($panitia as $user) {
            $skorAkhir =
                ($normalisasiKehadiran[$user->id] * $this->bobotKehadiran) +
                ($normalisasiKontribusi[$user->id] * $this->bobotKontribusi) +
                ($normalisasiTanggungJawab[$user->id] * $this->bobotTanggungJawab) +
                ($normalisasiKualitas[$user->id] * $this->bobotKualitas) +
                ($normalisasiPenilaianAtasan[$user->id] * $this->bobotPenilaianAtasan);

            // Only use unique identifiers for matching
            Evaluasi::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'program_kerjas_id' => $proker_id,
                    'periode' => date('F'),
                    'tahun' => date('Y')
                ],
                [
                    'kehadiran' => $nilaiKehadiran[$user->id],
                    'kontribusi' => $nilaiKontribusi[$user->id],
                    'tanggung_jawab' => $nilaiTanggungJawab[$user->id],
                    'kualitas' => $nilaiKualitas[$user->id],
                    'penilaian_atasan' => $nilaiPenilaianAtasan[$user->id],
                    'kehadiran_normalized' => $normalisasiKehadiran[$user->id],
                    'kontribusi_normalized' => $normalisasiKontribusi[$user->id],
                    'tanggung_jawab_normalized' => $normalisasiTanggungJawab[$user->id],
                    'kualitas_normalized' => $normalisasiKualitas[$user->id],
                    'penilaian_atasan_normalized' => $normalisasiPenilaianAtasan[$user->id],
                    'score' => $skorAkhir
                ]
            );
        }
        // exit();
        return true;
    }

    /**
     * Menghitung nilai kehadiran berdasarkan kehadiran rapat
     */
    protected function hitungNilaiKehadiran($user_id, $proker_id)
    {
        // Get all meetings related to this project
        $rapat = Rapat::where('program_kerjas_id', $proker_id)->get();

        if ($rapat->isEmpty()) {
            return 0;
        }

        $total_rapat = $rapat->count();
        $hadir = RapatPartisipasi::whereIn('rapat_id', $rapat->pluck('id'))
            ->where('user_id', $user_id)
            ->where('status_kehadiran', 'hadir')
            ->count();

        $izin = RapatPartisipasi::whereIn('rapat_id', $rapat->pluck('id'))
            ->where('user_id', $user_id)
            ->where('status_kehadiran', 'izin')
            ->count();

        // Calculate attendance value with formula: ((jumlah hadir / jumlah rapat partisipan) + ((jumlah izin / jumlah rapat partisipan) ** 0.5)) * 100
        $nilai_kehadiran = (($hadir / $total_rapat) + (($izin / $total_rapat) * 0.5)) * 100;

        return $nilai_kehadiran;
    }

    /**
     * Menghitung nilai kontribusi berdasarkan tugas yang dikerjakan
     */
    protected function hitungNilaiKontribusi($user_id, $proker_id)
    {
        // Get all tasks assigned to this user
        $aktivitas = AktivitasDivisiProgramKerja::where('person_in_charge', $user_id)
            ->where('program_kerjas_id', $proker_id)
            ->get();

        if ($aktivitas->isEmpty()) {
            return 0;
        }

        // First count all tasks for reference
        $total_tugas = count($aktivitas);

        // Now filter for only completed tasks
        $aktivitas_selesai = $aktivitas->filter(function ($aktiviti) {
            return $aktiviti->status == 'selesai';
        });

        // If no completed tasks, return 0
        if ($aktivitas_selesai->isEmpty()) {
            return 0;
        }

        $total_tugas_selesai = count($aktivitas_selesai);
        $total_nilai_prioritas = 0;
        $nilai_prioritas_maksimal = 0;

        foreach ($aktivitas_selesai as $aktiviti) {
            // Assign value based on priority
            $nilai_prioritas = 0;
            switch ($aktiviti->prioritas) {
                case 'rendah':
                    $nilai_prioritas = 1;
                    break;
                case 'sedang':
                    $nilai_prioritas = 2;
                    break;
                case 'tinggi':
                    $nilai_prioritas = 3;
                    break;
                case 'kritikal':
                    $nilai_prioritas = 4;
                    break;
            }

            $total_nilai_prioritas += $nilai_prioritas;
            $nilai_prioritas_maksimal = max($nilai_prioritas_maksimal, $nilai_prioritas);
        }

        // Avoid division by zero
        if ($nilai_prioritas_maksimal == 0 || $total_tugas_selesai == 0) {
            return 0;
        }

        // Calculate contribution value with formula: [Σ(Jumlah tugas selesai × Nilai prioritas) / (Nilai prioritas maksimal tugas × Total tugas selesai)] × 100
        $nilai_kontribusi = ($total_nilai_prioritas / ($nilai_prioritas_maksimal * $total_tugas_selesai)) * 100;

        return $nilai_kontribusi;
    }

    /**
     * Menghitung nilai tanggung jawab berdasarkan deadline
     */
    protected function hitungNilaiTanggungJawab($user_id, $proker_id)
    {
        // Get all tasks assigned to this user with deadlines
        $aktivitas = AktivitasDivisiProgramKerja::where('person_in_charge', $user_id)
            ->where('program_kerjas_id', $proker_id)
            ->whereNotNull('tenggat_waktu')
            ->get();

        if ($aktivitas->isEmpty()) {
            return 0;
        }

        $total_tugas = count($aktivitas);
        $selesai_tepat_waktu = 0;

        foreach ($aktivitas as $aktiviti) {
            if (
                $aktiviti->status == 'selesai' && $aktiviti->tanggal_selesai &&
                strtotime($aktiviti->tanggal_selesai) <= strtotime($aktiviti->tenggat_waktu)
            ) {
                $selesai_tepat_waktu++;
            }
        }

        // Calculate responsibility value with formula: (Total tugas selesai sebelum deadline / total tugas) * 100
        $nilai_tanggung_jawab = ($selesai_tepat_waktu / $total_tugas) * 100;

        return $nilai_tanggung_jawab;
    }

    /**
     * Menghitung nilai kualitas berdasarkan penilaian kualitas tugas
     */
    protected function hitungNilaiKualitas($user_id, $proker_id)
    {
        // Dapatkan semua aktivitas yang ditugaskan pada user dan sudah memiliki nilai
        $aktivitas = AktivitasDivisiProgramKerja::where('person_in_charge', $user_id)
            ->where('program_kerjas_id', $proker_id)
            ->whereNotNull('nilai')
            ->get();

        if ($aktivitas->isEmpty()) {
            return 0;
        }

        // Hitung rata-rata nilai
        $total_nilai = 0;
        foreach ($aktivitas as $aktiviti) {
            // Konversi nilai enum ('1', '2', '3', '4', '5') ke float
            $total_nilai += (float) $aktiviti->nilai;
        }

        // Nilai rata-rata (dalam skala 1-5) dikalikan 20 untuk menjadi skala 0-100
        $nilai_kualitas = ($total_nilai / count($aktivitas)) * 20;

        return $nilai_kualitas;
    }

    /**
     * Menghitung nilai dari atasan
     */
    protected function hitungNilaiPenilaianAtasan($user_id, $proker_id)
    {
        // Get supervisor rating from struktur_prokers
        $penilaian = StrukturProker::whereIn('divisi_program_kerjas_id', function ($query) use ($proker_id) {
            $query->select('id')
                ->from('divisi_program_kerjas')
                ->where('program_kerjas_id', $proker_id);
        })
            ->where('users_id', $user_id)
            ->first();

        // Calculate supervisor rating with formula: (Nilai atasan / maksimal nilai atasan) * 100
        if ($penilaian && $penilaian->nilai_atasan !== null) {
            $nilai_maksimal_atasan = 5;
            return ($penilaian->nilai_atasan / $nilai_maksimal_atasan) * 100;
        }

        return 60; // Default value (scale 0-100)
    }

    /**
     * Melakukan normalisasi nilai
     *
     * @param array $nilai Array nilai untuk semua user [user_id => nilai]
     * @param string $tipe 'benefit' (makin besar makin baik) atau 'cost' (makin kecil makin baik)
     * @return array Array nilai yang sudah dinormalisasi
     */
    protected function normalisasi($nilai, $tipe)
    {
        // If array is empty, return empty array
        if (empty($nilai)) {
            return [];
        }

        // Find max value
        $max = max($nilai);

        // Avoid division by zero
        if ($max == 0) {
            $hasil = [];
            foreach ($nilai as $userId => $value) {
                $hasil[$userId] = 1;
            }
            return $hasil;
        }

        // Normalize: value / maximum value for benefit criteria
        $hasil = [];
        foreach ($nilai as $userId => $value) {
            if ($tipe == 'benefit') {
                $hasil[$userId] = $value / $max;
            } else {
                // For cost criteria (not used in this case but kept for completeness)
                $min = min($nilai);
                $hasil[$userId] = $min / $value;
            }
        }

        return $hasil;
    }
}
