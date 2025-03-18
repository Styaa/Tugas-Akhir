<?php

namespace App\Http\Controllers;

use App\Models\DivisiProgramKerja;
use App\Models\ProgramKerja;
use App\Models\RancanganAnggaranBiaya;
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
        // $divisis = DivisiProgramKerja::where('program_kerjas_id', $request->prokerId)->get();
        $divisis = DivisiProgramKerja::with('divisiPelaksana')
            ->where('program_kerjas_id', $request->prokerId)
            ->get();

        // Ambil pemasukan dan pengeluaran dari database
        $pemasukans = RancanganAnggaranBiaya::where('program_kerjas_id', $request->prokerId)
            ->where('kategori', 'pemasukan')
            ->get();

        $pengeluarans = RancanganAnggaranBiaya::where('program_kerjas_id', $request->prokerId)
            ->where('kategori', 'pengeluaran')
            ->get();

        // dd($divisis);

        // dd($pengeluaran);

        // dd($divisi->first()->divisiPelaksana->nama);
        return view('program-kerja.dokumen.rab.create', compact('programKerja', 'divisis', 'pemasukans', 'pengeluarans', 'periode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($kode_ormawa, Request $request)
    {
        $prokerId = $request->prokerId;

        // Ambil data lama dari database
        $existingData = RancanganAnggaranBiaya::where('program_kerjas_id', $prokerId)->get();

        // Simpan pemasukan
        $newPemasukanIds = [];
        foreach ($request->pemasukan['komponen'] as $index => $komponen) {
            // Cek jika komponen kosong, lewati
            if (empty($komponen) || empty($request->pemasukan['biaya'][$index]) || empty($request->pemasukan['jumlah'][$index])) {
                continue;
            }

            $pemasukan = RancanganAnggaranBiaya::updateOrCreate(
                [
                    'program_kerjas_id' => $prokerId,
                    'komponen_biaya' => $komponen,
                    'kategori' => 'pemasukan'
                ],
                [
                    'biaya' => $request->pemasukan['biaya'][$index],
                    'jumlah' => $request->pemasukan['jumlah'][$index],
                    'satuan' => $request->pemasukan['satuan'][$index] ?? '-',
                    'total' => $request->pemasukan['total'][$index],
                    'divisi_program_kerjas_id' => null,
                ]
            );
            $newPemasukanIds[] = $pemasukan->id;
        }

        // Simpan pengeluaran per divisi
        $newPengeluaranIds = [];
        if ($request->has('pengeluaran')) {
            foreach ($request->pengeluaran as $divisiId => $pengeluaranData) {
                foreach ($pengeluaranData['komponen'] as $index => $komponen) {
                    // Cek jika komponen kosong, lewati
                    if (empty($komponen) || empty($pengeluaranData['biaya'][$index]) || empty($pengeluaranData['jumlah'][$index])) {
                        continue;
                    }

                    $pengeluaran = RancanganAnggaranBiaya::updateOrCreate(
                        [
                            'program_kerjas_id' => $prokerId,
                            'komponen_biaya' => $komponen,
                            'kategori' => 'pengeluaran',
                            'divisi_program_kerjas_id' => $divisiId,
                        ],
                        [
                            'biaya' => $pengeluaranData['biaya'][$index],
                            'jumlah' => $pengeluaranData['jumlah'][$index],
                            'satuan' => $pengeluaranData['satuan'][$index] ?? '-',
                            'total' => $pengeluaranData['total'][$index],
                        ]
                    );
                    $newPengeluaranIds[] = $pengeluaran->id;
                }
            }
        }

        // Hapus data yang sudah tidak ada di form
        $existingData->each(function ($item) use ($newPemasukanIds, $newPengeluaranIds) {
            if (!in_array($item->id, array_merge($newPemasukanIds, $newPengeluaranIds))) {
                $item->delete();
            }
        });

        return back()->with('success', 'Data berhasil diperbarui!');
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
