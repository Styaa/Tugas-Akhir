<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TipeOrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tipe_ormawas')->insert([
            [
                'tipe_ormawa' => 'KSM',
                'nama' => 'Kelompok Studi Mahasiswa',
            ],
            [
                'tipe_ormawa' => 'UKM',
                'nama' => 'Unit Kegiatan Mahasiswa',
            ],
            [
                'tipe_ormawa' => 'KMM',
                'nama' => 'Kelompok Minat Mahasiswa',
            ],
            [
                'tipe_ormawa' => 'BEM',
                'nama' => 'Badan Eksekutif Mahasiswa',
            ],
            [
                'tipe_ormawa' => 'DPM',
                'nama' => 'Dewan Perwakilan Mahasiswa',
            ],
        ]);
    }
}
