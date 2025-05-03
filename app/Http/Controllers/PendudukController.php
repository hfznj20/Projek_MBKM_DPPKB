<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduks = Penduduk::all();
        return Inertia::render('Penduduk/Index', [
            'penduduks' => $penduduks,
        ]);
    }

    public function create()
    {
        return Inertia::render('Penduduk/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nik',
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kecamatan' => 'required|in:Ujung,Bacukiki,Bacukiki Barat,Soreang',
            'kelurahan' => 'required',
            'RT' => 'required',
            'RW' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'kategori' => 'required|in:CATIN,BUMIL,BADUTA,Pasca Persalinan,Penduduk',
        ]);

        $penduduk = Penduduk::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'RT' => $request->RT,
            'RW' => $request->RW,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'kategori' => $request->kategori,
        ]);

        return match ($penduduk->kategori) {
            'BADUTA' => Inertia::location(route('baduta.create', ['nik' => $penduduk->nik])),
            'CATIN' => Inertia::location(route('catin.create', ['nik' => $penduduk->nik])),
            'BUMIL' => Inertia::location(route('bumil.create', ['nik' => $penduduk->nik])),
            'Pasca Persalinan' => Inertia::location(route('pasper.create', ['nik' => $penduduk->nik])),
            'Penduduk' => Inertia::location(route('penduduk.index')),
        };
    }

    public function edit($nik)
    {
        $penduduk = Penduduk::findOrFail($nik);
        return Inertia::render('Penduduk/Edit', [
            'penduduk' => $penduduk,
        ]);
    }   


    public function update(Request $request, $nik)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nik',
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kecamatan' => 'required|in:Ujung,Bacukiki,Bacukiki Barat,Soreang',
            'kelurahan' => 'required',
            'RT' => 'required',
            'RW' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'kategori' => 'required|in:CATIN,BUMIL,BADUTA,Pasca Persalinan,Penduduk',
        ]);

        $penduduk = Penduduk::where('nik', $nik)->firstOrFail();
        $penduduk->update($request->all());

        return redirect()->route('penduduk.index')->with('success', 'Data Penduduk berhasil diperbarui');
    }

    public function destroy($nik)
    {
        $penduduk = Penduduk::where('nik', $nik)->firstOrFail();
        $penduduk->delete();

        return redirect()->route('penduduk.index')->with('success', 'Data Penduduk berhasil dihapus');
    }

    public function searchIbu(Request $request, $nik)
    {
        $penduduk = Penduduk::where('nik', $nik)->first();

        if ($penduduk) {
            return response()->json([
                'status' => 'success',
                'nama' => $penduduk->nama,
            ]);
        } else {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Data tidak ditemukan.',
            ]);
        }
    }

    public function cekNIK(Request $request)
{
    $penduduk = Penduduk::where('nik', $request->nik)->first();

    if ($penduduk) {
        return response()->json([
            'status' => 'data ada',
            'nama' => $penduduk->nama
        ]);
    } else {
        return response()->json([
            'status' => 'data tidak ada'
        ]);
    }
}

}
