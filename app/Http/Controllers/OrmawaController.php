<?php

namespace App\Http\Controllers;

use App\Models\Ormawa;
use Illuminate\Http\Request;

class OrmawaController extends Controller
{
    //
    public function getOrmawa($fakultas)
    {
        $ormawa = Ormawa::where('fakultas', $fakultas)->get();
        return response()->json($ormawa);
    }
}
