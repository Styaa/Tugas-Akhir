<?php

namespace App\Http\Controllers;

use App\Models\DivisiProgramKerja;
use App\Models\ProgramKerja;
use App\Models\RancanganAnggaranBiaya;
use App\Models\RancanganAnggaranDana;
use Illuminate\Http\Request;

class RancanganAnggaranDanaController extends Controller
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
    public function create($kode_ormawa, Request $request)
    {
        //
        $programKerja = ProgramKerja::find($request->prokerId);
        $periode = $programKerja->periode;
        $divisis = DivisiProgramKerja::where('program_kerjas_id', $request->prokerId)->get();

        // Ambil pemasukan dan pengeluaran dari database
        $pemasukans = RancanganAnggaranBiaya::where('program_kerjas_id', $request->prokerId)
            ->where('kategori', 'pemasukan')
            ->get();

        $pengeluarans = RancanganAnggaranBiaya::where('program_kerjas_id', $request->prokerId)
            ->where('kategori', 'pengeluaran')
            ->get();

        // dd($pengeluaran);

        // dd($divisi->first()->divisiPelaksana->nama);
        return view('program-kerja.dokumen.rab.create', compact('programKerja', 'divisis', 'pemasukans', 'pengeluarans', 'periode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($kode_ormawa, Request $request)
    {
        // Simpan pemasukan
        foreach ($request->pemasukan['komponen'] as $index => $komponen) {
            RancanganAnggaranBiaya::create([
                'kategori' => 'pemasukan',
                'komponen_biaya' => $komponen,
                'biaya' => $request->pemasukan['biaya'][$index],
                'jumlah' => $request->pemasukan['jumlah'][$index],
                'satuan' => $request->pemasukan['satuan'][$index],
                'total' => $request->pemasukan['total'][$index],
                'program_kerjas_id' => $request->prokerId,
                'divisi_program_kerjas_id' => null,
            ]);
        }

        // Simpan pengeluaran per divisi
        if ($request->has('pengeluaran')) {
            foreach ($request->pengeluaran as $divisiId => $pengeluaranData) {
                foreach ($pengeluaranData['komponen'] as $index => $komponen) {
                    RancanganAnggaranBiaya::create([
                        'kategori' => 'pengeluaran',
                        'komponen_biaya' => $komponen,
                        'biaya' => $pengeluaranData['biaya'][$index],
                        'jumlah' => $pengeluaranData['jumlah'][$index],
                        'satuan' => $pengeluaranData['satuan'][$index],
                        'total' => $pengeluaranData['total'][$index],
                        'program_kerjas_id' => $request->prokerId,
                        'divisi_program_kerjas_id' => $divisiId,
                    ]);
                }
            }
        }

        return back()->with('success', 'Data berhasil disimpan!');
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
}
