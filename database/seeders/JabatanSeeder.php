<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('jabatans')->insert([
            [
                'nama' => 'Ketua',
                'jobdesc' => 'Memimpin organisasi, merencanakan dan mengkoordinasi semua kegiatan, serta menjadi perwakilan organisasi dalam berbagai forum dan acara.',
            ],
            [
                'nama' => 'Wakil Ketua',
                'jobdesc' => 'Mendampingi Ketua dalam menjalankan tugas, membantu dalam perencanaan kegiatan, dan menggantikan Ketua saat tidak hadir.',
            ],
            [
                'nama' => 'Sekretaris',
                'jobdesc' => 'Mencatat notulen rapat, mengelola dokumen organisasi, dan bertanggung jawab atas komunikasi internal dan eksternal.',
            ],
            [
                'nama' => 'Bendahara',
                'jobdesc' => 'Mengelola anggaran organisasi, mencatat semua transaksi keuangan, dan menyusun laporan keuangan secara berkala.',
            ],
            [
                'nama' => 'Koordinator',
                'jobdesc' => 'Mengatur pelaksanaan kegiatan dan program, serta memastikan semua anggota terlibat dan berkontribusi secara aktif.',
            ],
            [
                'nama' => 'Wakil Koordinator',
                'jobdesc' => 'Mendampingi Koordinator dalam tugasnya, membantu dalam pengorganisasian kegiatan, dan siap menggantikan Koordinator jika diperlukan.',
            ],
            [
                'nama' => 'Anggota',
                'jobdesc' => 'Berpartisipasi aktif dalam kegiatan organisasi, memberikan ide dan masukan, serta mendukung pelaksanaan program yang telah direncanakan.',
            ],
        ]);
    }
}
