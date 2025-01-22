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

            if (Auth::check()) {
                // Jika user terautentikasi, ambil kode ormawa dari relasi
                if (Auth::check()) {
                    $user = Auth::user();
                    $kode_ormawa = $user->strukturOrmawas()
                        ->with('divisiOrmawas.ormawa')
                        ->get()
                        ->pluck('divisiOrmawas.ormawa.kode')
                        ->first() ?? $kode_ormawa; // Fallback ke default jika tidak ditemukan
                }

                $periode = $user->strukturOrmawas()
                    ->orderBy('periodes_periode', 'desc') // Ambil periode terbaru
                    ->pluck('periodes_periode') // Ambil kolom periode
                    ->first(); // Ambil nilai pertama (jika ada)

                // Share variabel ke semua view
                $view->with(compact('kode_ormawa', 'periode'));
            } else {
                return route('login');
            }
        });
    }
}
