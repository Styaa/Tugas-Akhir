<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DivisiPelaksanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('divisi_pelaksanas')->insert([
            [
                'nama' => 'Acara',
                'keterangan' => 'Keterangan Divisi Acara',
                'jobdesc' => 'Job Description Divisi Acara',
            ],
            [
                'nama' => 'Perlengkapan',
                'keterangan' => 'Keterangan Divisi Perlengkapan',
                'jobdesc' => 'Job Description Perlengkapan',
            ],
            [
                'nama' => 'Desain',
                'keterangan' => 'Keterangan Divisi Desain',
                'jobdesc' => 'Job Description Desain',
            ],
        ]);
    }
}
