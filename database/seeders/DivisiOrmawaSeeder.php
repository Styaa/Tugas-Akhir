<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DivisiOrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('divisi_ormawas')->insert([
            [
                'nama' => 'IRD',
                'keterangan' => 'Internal Relation Department',
                'jobdesc' => 'Job Description IRD',
                'ormawas_kode' => 'KSMIF',
            ],
            [
                'nama' => 'PRD',
                'keterangan' => 'Public Relation Department',
                'jobdesc' => 'Job Description PRD',
                'ormawas_kode' => 'KSMIF',
            ],
            [
                'nama' => 'CDD',
                'keterangan' => 'Creative Design Department',
                'jobdesc' => 'Job Description CDD',
                'ormawas_kode' => 'KSMIF',
            ],
        ]);
    }
}
