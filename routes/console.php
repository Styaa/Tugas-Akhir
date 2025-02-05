<?php

use App\Models\User;
use Illuminate\Support\Facades\Schedule;
use App\Notifications\DeadlineReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $aktivitas = DB::table('aktivitas_divisi_program_kerjas')
        ->whereRaw("DATE(tenggat_waktu) = DATE(NOW() + INTERVAL 5 DAY)")
        ->get();

    foreach ($aktivitas as $item) {
        // Kirim log sebagai debug
        Log::info("Peringatan: Aktivitas '{$item->nama}' memiliki tenggat waktu dalam 5 hari!");

        // Kirim notifikasi ke person in charge jika ada
        $user = User::find($item->person_in_charge);
        dd($user);
        if ($user) {
            $user->notify(new DeadlineReminder($item));
        }
    }
})->everyFiveSeconds();

