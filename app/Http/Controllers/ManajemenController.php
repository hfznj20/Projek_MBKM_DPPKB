<?php

namespace App\Http\Controllers;

use App\Models\Manajemen;
use App\Models\User;

use App\Models\Penduduk;
use App\Models\Baduta;
use App\Models\Catin;
use App\Models\Pasper;
use App\Models\Bumil;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ManajemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manajemens = Manajemen::get();
        return Inertia::render('Manajemen/Index', [
            'manajemens' => $manajemens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Manajemen/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "NIK" => "required|string|size:16|unique:manajemens,NIK",
            "nama" => "required|string|max:100",
            "kecamatan" => "required|string",
            "kelurahan" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:6|confirmed",
        ]);

        $manajemen = Manajemen::create([
            "NIK" => $request->NIK,
            "nama" => $request->nama,
            "kecamatan" => $request->kecamatan,
            "kelurahan" => $request->kelurahan,
        ]);

        $user = User::create([
            'name' => $manajemen->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'NIK' => $manajemen->NIK,
        ]);

        $user->assignRole('TPK');

        return redirect()->route('manajemen.index')
            ->with('success', 'Data manajemen dan akun TPK berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $NIK)
    {
        $manajemen = Manajemen::where('NIK', $NIK)->firstOrFail();
        return Inertia::render("Manajemen/Edit", [
            "manajemen" => $manajemen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $NIK)
    {
        $request->validate([
            "nama" => "required|string|max:100",
            "kecamatan" => "required|string",
            "kelurahan" => "required|string",
        ]);

        $manajemen = Manajemen::where('NIK', $NIK)->firstOrFail();
        $manajemen->nama = $request->nama;
        $manajemen->kecamatan = $request->kecamatan;
        $manajemen->kelurahan = $request->kelurahan;
        $manajemen->save();

        return redirect()->route('manajemen.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $NIK)
    {
        $manajemen = Manajemen::where('NIK', $NIK)->firstOrFail();
        $manajemen->delete();

        return redirect()->route('manajemen.index')->with('success', 'Data berhasil dihapus!');
    }

    public function show($nik)
    {
        $manajemen = Manajemen::where('NIK', $nik)->firstOrFail();

        $data = [
            'penduduk' => Penduduk::where('niktpk', $nik)->count(),
            // 'penduduk' => Penduduk::where('jenis_kelamin', $nik)->count(),
            'baduta' => Baduta::where('niktpk', $nik)->count(),
            'catin' => Catin::where('niktpk', $nik)->count(),
            'bumil' => Bumil::where('niktpk', $nik)->count(),
            'pasper' => Pasper::where('niktpk', $nik)->count(),
        ];
        $genderCount = [
            'Laki' => Penduduk::where('niktpk', $nik)->where('jenis_kelamin', 'Laki-laki')->count(),
            'Perempuan' => Penduduk::where('niktpk', $nik)->where('jenis_kelamin', 'Perempuan')->count(),
        ];

        return Inertia::render('Manajemen/Show', [
            'tpk' => $manajemen,
            'dataInput' => $data,
            'genderCount' => $genderCount,
        ]);
    }

}