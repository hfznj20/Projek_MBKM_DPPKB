<?php

namespace App\Http\Controllers;

use App\Models\Catin;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class CatinController extends Controller
{
    public function __construct()
    {
        // Menambahkan middleware jika diperlukan
        // $this->middleware('auth');
    }

    // Menampilkan semua data catin
    public function index()
    {
        $catins = Catin::all(); // Ambil semua data catin
        return Inertia::render('Catin/Index', [
            'catins' => $catins,
        ]);
    }

    // Menampilkan form pendaftaran catin berdasarkan penduduk yang dipilih
    public function create(Request $request)
    {
        $penduduks = Penduduk::all(); // Ambil semua penduduk untuk pilihan
        return Inertia::render('Catin/Create', [
            'penduduks' => $penduduks, // Kirimkan data penduduk ke Vue component
            'penduduk_nik' => $request->nik, // Kirimkan NIK jika ada
        ]);

        $catin = Penduduk::where('nik', $request->nik)->first();
        return Inertia::render('Catin/Create', [
            'catin' => $catin,  // Mengirimkan data nama catin ke Vue
        ]);
    }

    // Menyimpan data catin
    public function store(Request $request)
    {
        Log::info($request->all());

        // Validasi data yang dikirim dari form
        $request->validate([
            'nik_catin1' => 'required|exists:penduduk,nik', // NIK pasangan pertama
            'nik_catin2' => 'required|exists:penduduk,nik', // NIK pasangan kedua
            'tanggal_pernikahan' => 'required|date',
            'tinggi_badan' => 'required|integer',
            'berat_badan' => 'required|integer',
            'indeks_massa_tubuh' => 'required|integer',
            'kadar_hemoglobin' => 'required|integer',
            'LILA' => 'required|integer',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'fasilitas_bantuan_sosial' => 'nullable|string',
            'stunting' => 'required|string',  // Validasi untuk kolom stunting
        ]);

        // Cek apakah pasangan kedua ada di database
        $pasangan_kedua = Penduduk::where('nik', $request->nik_catin2)->first();

        if (!$pasangan_kedua) {
            // Jika pasangan kedua tidak ditemukan, maka minta untuk menambahkannya
            $pasangan_kedua = Penduduk::create([
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
            ]);
        }

        // Simpan data catin ke database
        Catin::create([
            'nik_catin1' => $request->nik_catin1, // NIK pasangan pertama
            'nik_catin2' => $request->nik_catin2, // NIK pasangan kedua yang valid
            'tanggal_pernikahan' => $request->tanggal_pernikahan,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'indeks_massa_tubuh' => $request->indeks_massa_tubuh,
            'kadar_hemoglobin' => $request->kadar_hemoglobin,
            'LILA' => $request->LILA,
            'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
            'sumber_air_minum' => $request->sumber_air_minum,
            'fasilitas_BAB' => $request->fasilitas_BAB,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'fasilitas_bantuan_sosial' => $request->fasilitas_bantuan_sosial,
            'stunting' => $request->stunting,  // Menyimpan data stunting
        ]);

        return redirect()->route('penduduk.index')->with('success', 'Data Catin berhasil disimpan');
    }

    // Fungsi untuk menyimpan pasangan kedua yang baru
    public function storePasanganBaru(Request $request)
    {
        // Validasi untuk pasangan kedua yang baru
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nik,' ,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|in:Ujung,Bacukiki,Bacukiki Barat,Soreang',
            'RT' => 'required|string|max:3',
            'RW' => 'required|string|max:3',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:16',
        ]);

        // Simpan pasangan kedua ke database
        $pasangan = Penduduk::create([
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
        ]);

        return response()->json([
            'status' => 'success',
            'nik' => $pasangan->nik,
            'nama' => $pasangan->nama,
        ]);
    }
}
