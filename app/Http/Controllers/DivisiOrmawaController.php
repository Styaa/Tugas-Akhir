<?php

namespace App\Http\Controllers;

use App\Models\DivisiOrmawa;
use Illuminate\Http\Request;
use Pest\Mutate\Mutators\Arithmetic\DivisionToMultiplication;

class DivisiOrmawaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getDivisi($ormawa)
    {
        // Ambil data divisi berdasarkan ormawa dari database
        $divisi = DivisiOrmawa::where('ormawas_kode', $ormawa)
            ->where('nama', '!=', 'Badan Pengurus Harian')->get();

        // dd($divisi);

        return response()->json($divisi);
    }
}
