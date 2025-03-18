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

    /**
     * Menghitung evaluasi untuk semua panitia dalam program kerja
     */
    public function hitungEvaluasiProker($proker_id)
    {
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

            // Simpan ke database
            Evaluasi::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'program_kerjas_id' => $proker_id,
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
                    'score' => $skorAkhir,
                    'periode' => date('F'), // Bulan saat ini
                    'tahun' => date('Y')   // Tahun saat ini
                ]
            );
        }

        return true;
    }

    /**
     * Menghitung nilai kehadiran berdasarkan kehadiran rapat
     */
    protected function hitungNilaiKehadiran($user_id, $proker_id)
    {
        // Dapatkan semua rapat terkait proker ini
        $rapat = Rapat::where('program_kerjas_id', $proker_id)
            ->where('status', 'selesai')
            ->get();

        if ($rapat->isEmpty()) {
            return 0;
        }

        // Hitung jumlah kehadiran
        $total_rapat = $rapat->count();
        $hadir = RapatPartisipasi::whereIn('rapat_id', $rapat->pluck('id'))
            ->where('user_id', $user_id)
            ->where('status_kehadiran', 'hadir')
            ->count();

        // Izin dihitung sebagai 0.5 dari hadir
        $izin = RapatPartisipasi::whereIn('rapat_id', $rapat->pluck('id'))
            ->where('user_id', $user_id)
            ->where('status_kehadiran', 'izin')
            ->count() * 0.5;

        // Hitung persentase kehadiran
        $nilai_kehadiran = ($hadir + $izin) / $total_rapat * 100;

        return $nilai_kehadiran;
    }

    /**
     * Menghitung nilai kontribusi berdasarkan tugas yang dikerjakan
     */
    protected function hitungNilaiKontribusi($user_id, $proker_id)
    {
        // Dapatkan semua aktivitas yang ditugaskan pada user
        $aktivitas = AktivitasDivisiProgramKerja::where('person_in_charge', $user_id)
            ->where('program_kerjas_id', $proker_id)
            ->get();

        if ($aktivitas->isEmpty()) {
            return 0;
        }

        // Hitung kontribusi berdasarkan jumlah dan prioritas tugas
        $total_kontribusi = 0;
        $jumlah_aktivitas = count($aktivitas);

        foreach ($aktivitas as $aktiviti) {
            // Berikan nilai berdasarkan prioritas
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

            // Berikan nilai berdasarkan status
            $nilai_status = 0;
            switch ($aktiviti->status) {
                case 'belum_mulai':
                    $nilai_status = 0;
                    break;
                case 'sedang_berjalan':
                    $nilai_status = 0.5;
                    break;
                case 'selesai':
                    $nilai_status = 1;
                    break;
                case 'ditunda':
                    $nilai_status = 0.2;
                    break;
            }

            $total_kontribusi += $nilai_prioritas * $nilai_status;
        }

        // Normalisasi ke skala 0-100
        $nilai_maksimal = 4 * $jumlah_aktivitas; // Nilai maksimal jika semua tugas kritikal dan selesai
        $nilai_kontribusi = ($total_kontribusi / $nilai_maksimal) * 100;

        return $nilai_kontribusi;
    }

    /**
     * Menghitung nilai tanggung jawab berdasarkan deadline
     */
    protected function hitungNilaiTanggungJawab($user_id, $proker_id)
    {
        // Dapatkan semua aktivitas yang ditugaskan pada user dan sudah selesai
        $aktivitas = AktivitasDivisiProgramKerja::where('person_in_charge', $user_id)
            ->where('program_kerjas_id', $proker_id)
            ->where('status', 'selesai')
            ->whereNotNull('tenggat_waktu')
            ->get();

        if ($aktivitas->isEmpty()) {
            return 0;
        }

        // Hitung berapa banyak tugas yang selesai sebelum deadline
        $selesai_tepat_waktu = 0;
        foreach ($aktivitas as $aktiviti) {
            if ($aktiviti->tanggal_selesai && strtotime($aktiviti->tanggal_selesai) <= strtotime($aktiviti->tenggat_waktu)) {
                $selesai_tepat_waktu++;
            }
        }

        // Hitung persentase ketepatan waktu
        $nilai_tanggung_jawab = ($selesai_tepat_waktu / count($aktivitas)) * 100;

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
        // Untuk sementara, gunakan nilai default
        // Nantinya bisa ditambahkan tabel baru untuk penilaian dari atasan
        // atau bisa diambil dari nilai yang diberikan oleh ketua proker

        // Dapatkan atasan (ketua proker)
        $ketua = StrukturProker::whereIn('divisi_program_kerjas_id', function ($query) use ($proker_id) {
            $query->select('id')
                ->from('divisi_program_kerjas')
                ->where('program_kerjas_id', $proker_id);
        })->where('jabatans_id', 2) // ID untuk ketua
            ->first();

        // Jika tidak ada ketua, gunakan nilai default
        if (!$ketua) {
            return 60; // Nilai default 60 dari 100
        }

        // Di sini bisa ditambahkan logika untuk mengambil penilaian dari ketua
        // Untuk sementara bisa menggunakan nilai random antara 60-100
        $nilai_atasan = rand(60, 100);

        return $nilai_atasan;
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
        // Jika array kosong, kembalikan array kosong
        if (empty($nilai)) {
            return [];
        }

        // Cari nilai min dan max
        $min = min($nilai);
        $max = max($nilai);

        // Hindari division by zero
        if ($min == $max) {
            // Jika semua nilai sama, normalisasi jadi 1
            $hasil = [];
            foreach ($nilai as $userId => $value) {
                $hasil[$userId] = 1;
            }
            return $hasil;
        }

        // Lakukan normalisasi sesuai tipe
        $hasil = [];
        foreach ($nilai as $userId => $value) {
            if ($tipe == 'benefit') {
                // Untuk kriteria benefit: nilai / nilai maksimum
                $hasil[$userId] = $value / $max;
            } else {
                // Untuk kriteria cost: nilai minimum / nilai
                $hasil[$userId] = $min / $value;
            }
        }

        return $hasil;
    }
}
