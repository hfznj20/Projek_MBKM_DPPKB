<?php

namespace App\Http\Controllers;

use App\Models\Datapenduduk;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DatapendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datapenduduks = Datapenduduk::all();
        return Inertia::render('Datapenduduk/Index', [
            'datapenduduks' => $datapenduduks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Datapenduduk/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:datapenduduk,nik',
            'nama_lengkap' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'RT' => 'required|string',
            'RW' => 'required|string',
            'TTL' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'no_telepon' => 'required|string',
            'jalan' => 'required|string',
            'nik_tpk' => 'required|string',
        ]);

        Datapenduduk::create($validated);

        return redirect()->route('datapenduduk.index')->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datapenduduks = Datapenduduk::find($id);
        return Inertia::render('Datapenduduk/Edit', [
            'datapenduduks' => $datapenduduks
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nik)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'RT' => 'required|string',
            'RW' => 'required|string',
            'TTL' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'no_telepon' => 'required|string',
            'jalan' => 'required|string',
            'nik_tpk' => 'required|string',
        ]);

        $datapenduduk = Datapenduduk::where('nik', $nik)->firstOrFail();
        $datapenduduk->update($validated);

        return redirect()->route('datapenduduk.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nik)
    {
        $datapenduduk = Datapenduduk::where('nik', $nik)->firstOrFail();
        $datapenduduk->delete();

        return redirect()->route('datapenduduk.index')->with('success', 'Data berhasil dihapus!');
    }
}
