<?php

namespace App\Http\Controllers;

use App\Models\DivisiPelaksana;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        //

        // dd($programKerjas);
        return view('dashboard.dashboard');
    }
}
