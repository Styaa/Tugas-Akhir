<?php

use App\Models\User;
use Illuminate\Support\Facades\Schedule;
use App\Notifications\DeadlineReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $aktivitas = DB::table('aktivitas_divisi_program_kerjas')
        ->select('*', DB::raw('DATEDIFF(DATE(tenggat_waktu), CURDATE()) AS sisa_hari'))
        ->whereRaw("DATE(tenggat_waktu) IN (
            CURDATE() + INTERVAL 1 DAY,
            CURDATE() + INTERVAL 2 DAY,
            CURDATE() + INTERVAL 3 DAY,
            CURDATE() + INTERVAL 4 DAY,
            CURDATE() + INTERVAL 5 DAY
        )")
        ->get();

    foreach ($aktivitas as $item) {
        // Kirim log sebagai debug
        Log::info("Peringatan: Aktivitas '{$item->nama}' memiliki tenggat waktu dalam 5 hari!");

        // Kirim notifikasi ke person in charge jika ada
        $user = User::find($item->person_in_charge);
        Notification::send($user, new DeadlineReminder($item));
    }
})->everyFiveSeconds();

