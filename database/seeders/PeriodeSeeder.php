<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('periodes')->insert([
            [
                'periode' => '2021',
                'nama' => '2021-2022',
            ],
            [
                'periode' => '2022',
                'nama' => '2022-2023',
            ],
            [
                'periode' => '2023',
                'nama' => '2023-2023',
            ],
        ]);
    }
}
