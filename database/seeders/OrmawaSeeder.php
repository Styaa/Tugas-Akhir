<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class OrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('ormawas')->insert([
            [
                'kode' => 'KSMIF',
                'naungan' => 'Teknik Informatika',
                'visi' => 'Visi KSM IF',
                'misi' => 'Misi KSM IF',
                'tipe_ormawa' => 'KSM',
            ],
            [
                'kode' => 'KSMTK',
                'naungan' => 'Teknik Kimia',
                'visi' => 'Visi KSM TK',
                'misi' => 'Visi KSM TK',
                'tipe_ormawa' => 'KSM',
            ],
            [
                'kode' => 'KMMSPORT',
                'naungan' => 'Fakultas Teknik',
                'visi' => 'Visi KMM Sport',
                'misi' => 'Misi KMM Sport',
                'tipe_ormawa' => 'KMM',
            ],
        ]);
    }
}
