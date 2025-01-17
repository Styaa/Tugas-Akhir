<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            // Default nilai kode ormawa
            $kode_ormawa = 'default_kode';

            // Jika user terautentikasi, ambil kode ormawa dari relasi
            if (Auth::check()) {
                $user = Auth::user();
                $kode_ormawa = $user->strukturOrmawas()
                    ->with('divisiOrmawas.ormawa')
                    ->get()
                    ->pluck('divisiOrmawas.ormawa.kode')
                    ->first() ?? $kode_ormawa; // Fallback ke default jika tidak ditemukan
            }

            // Ambil periode dengan prioritas session, query string, atau tahun saat ini
            $periode = session('periode')
                ?? request()->query('periode')
                ?? now()->year; // Fallback ke tahun sekarang

            // Share variabel ke semua view
            $view->with(compact('kode_ormawa', 'periode'));
        });
    }
}
