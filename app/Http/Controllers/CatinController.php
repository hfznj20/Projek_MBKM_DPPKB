<?php

namespace App\Http\Controllers;

use App\Models\Catin;
use App\Models\Penduduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class CatinController extends Controller
{
    // Menampilkan semua data catin
    public function index()
    {
        $user = auth()->user();

        $query = Catin::orderBy('created_at', 'desc');

        // Jika bukan admin, filter berdasarkan niktpk
        if ($user->name !== 'Admin') {
            $query->where('catin.niktpk', $user->NIK);
        }

        $catins = $query->get();
        
        $catins = Catin::with(['catin1', 'catin2'])->get()->map(function ($catin) {
            $pria = null;
            $wanita = null;
    
            // Deteksi mana pria dan wanita
            if ($catin->catin1 && $catin->catin1->jenis_kelamin === 'Laki-laki') {
                $pria = $catin->catin1;
            } elseif ($catin->catin1 && $catin->catin1->jenis_kelamin === 'Perempuan') {
                $wanita = $catin->catin1;
            }
    
            if ($catin->catin2 && $catin->catin2->jenis_kelamin === 'Laki-laki') {
                $pria = $catin->catin2;
            } elseif ($catin->catin2 && $catin->catin2->jenis_kelamin === 'Perempuan') {
                $wanita = $catin->catin2;
            }
    
            return [
                'id' => $catin->id,
                'nik_catin1' => $wanita?->nik ?? '-',
                'nama_catin1' => $wanita?->nama ?? '-',
                'nik_catin2' => $pria?->nik ?? '-',
                'nama_catin2' => $pria?->nama ?? '-',
                'tanggal_rencana_pernikahan' => $catin->tanggal_pernikahan,
                'niktpk' => $catin->niktpk,
            ];
        });
    
        return Inertia::render('Catin/Index', [
            'catins' => $catins,
        ]);
    }

    // Menampilkan form pendaftaran catin berdasarkan penduduk yang dipilih
    public function create(Request $request)
    {
        $penduduks = Penduduk::all();

        // Ambil data catin berdasarkan NIK (jika ada)
        $catin = null;
        if ($request->nik) {
            $catin = Catin::where('nik_catin1', $request->nik)->orWhere('nik_catin2', $request->nik)->first();
        }

        return Inertia::render('Catin/Create', [
            'penduduks' => $penduduks,
            'penduduk_nik' => $request->nik,
            'catin' => $catin,
        ]);
    }

    // Menyimpan data catin
    public function store(Request $request)
    {
        // Log semua request yang masuk untuk debugging
        Log::info('Menyimpan data catin: ', $request->all());

        // Validasi input
        $request->validate([
            'nik_catin1' => 'required|exists:penduduk,nik',
            'nik_catin2' => 'required|exists:penduduk,nik',
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
        ]);

        // Cek apakah pasangan kedua sudah ada di database
        $pasangan_kedua = Penduduk::where('nik', $request->nik_catin2)->first();

        if (!$pasangan_kedua) {
            // Jika pasangan kedua belum ada, buat pasangan baru
            $pasangan_kedua = Penduduk::create([
                'nik' => $request->nik_catin2,
                'nama' => $request->nama_catin2,
                'tanggal_lahir' => $request->tanggal_lahir_catin2,
                'jenis_kelamin' => $request->jenis_kelamin_catin2,
                'kecamatan' => $request->kecamatan_catin2,
                'kelurahan' => $request->kelurahan_catin2,
                'RT' => $request->RT_catin2,
                'RW' => $request->RW_catin2,
                'alamat' => $request->alamat_catin2,
                'no_hp' => $request->no_hp_catin2,
            ]);
        }

        // Simpan data catin
        Catin::create([
            'nik_catin1' => $request->nik_catin1,
            'nik_catin2' => $request->nik_catin2,
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
            'niktpk' => auth()->user()->NIK,
        ]);

        // Redirect ke halaman daftar penduduk
        return redirect()->route('penduduk.index')->with('success', 'Data Catin berhasil disimpan');
    }

    // Menyimpan data pasangan baru jika belum ada di DB
    public function storePasanganBaru(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nik',
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
            'niktpk' => auth()->user()->NIK,
        ]);

        return Inertia::render('Catin/Create', [
            'successMessage' => 'Pasangan berhasil disimpan'
        ]);
        // return response()->json([
        //     'status' => 'success',
        //     'nik' => $pasangan->nik,
        //     'nama' => $pasangan->nama,
        // ]);
    }
   
   public function show($nik)
   {
       $catin = Catin::with(['catin1', 'catin2'])->where('nik_catin1', $nik)
                     ->orWhere('nik_catin2', $nik)->firstOrFail();

       $catin1 = $catin->catin1;
       $usia1 = Carbon::parse($catin1->tanggal_lahir)->age;
       $catin2 = $catin->catin2;
       $usia2 = Carbon::parse($catin2->tanggal_lahir)->age;

       return Inertia::render('Catin/Show', [
           'catin' => [
               'catin1' => [
                   'nama' => $catin1->nama,
                   'nik' => $catin1->nik,
                   'tempat_lahir' => $catin1->tempat_lahir,
                   'tanggal_lahir' => $catin1->tanggal_lahir,
                   'jenis_kelamin' => $catin1->jenis_kelamin,
                   'alamat' => $catin1->alamat,
                   'no_hp' => $catin1->no_hp,
                   'usia' => $usia1, 
               ],
               'catin2' => [
                   'nama' => $catin2->nama,
                   'nik' => $catin2->nik,
                   'tempat_lahir' => $catin2->tempat_lahir,
                   'tanggal_lahir' => $catin2->tanggal_lahir,
                   'jenis_kelamin' => $catin2->jenis_kelamin,
                   'alamat' => $catin2->alamat,
                   'no_hp' => $catin2->no_hp,
                   'usia' => $usia2, 
               ],

               'tanggal_pernikahan' => $catin->tanggal_pernikahan,
               'tinggi_badan' => $catin->tinggi_badan,
               'berat_badan' => $catin->berat_badan,
               'indeks_massa_tubuh' => $catin->indeks_massa_tubuh,
               'kadar_hemoglobin' => $catin->kadar_hemoglobin,
               'LILA' => $catin->LILA,
               'menggunakan_alat_kontrasepsi' => $catin->menggunakan_alat_kontrasepsi,
               'catin_wanita_meerokok_terpapar' => $catin->catin_wanita_meerokok_terpapar,
               'catin_pria_meerokok_terpapar' => $catin->catin_pria_meerokok_terpapar,
               'sumber_air_minum' => $catin->sumber_air_minum,
               'fasilitas_BAB' => $catin->fasilitas_BAB,
               'longitude' => $catin->longitude,
               'latitude' => $catin->latitude,
               'fasilitas_bantuan_sosial' => $catin->fasilitas_bantuan_sosial,
           ],
       ]);
   }

   public function edit($nik)
{
    $catin = Catin::where('nik_catin1', $nik)
        ->orWhere('nik_catin2', $nik)
        ->firstOrFail();

    return Inertia::render('Catin/Edit', [
        'catin' => [
            'nik_catin1' => $catin->nik_catin1,
            'nik_catin2' => $catin->nik_catin2,
            'tanggal_pernikahan' => $catin->tanggal_pernikahan,
            'latitude' => $catin->latitude,
            'longitude' => $catin->longitude,
            'tinggi_badan' => $catin->tinggi_badan,
            'berat_badan' => $catin->berat_badan,
            'indeks_massa_tubuh' => $catin->indeks_massa_tubuh,
            'kadar_hemoglobin' => $catin->kadar_hemoglobin,
            'LILA' => $catin->LILA,
            'menggunakan_alat_kontrasepsi' => $catin->menggunakan_alat_kontrasepsi,
            'catin_wanita_merokok_terpapar' => $catin->catin_wanita_merokok_terpapar,
            'catin_pria_merokok_terpapar' => $catin->catin_pria_merokok_terpapar,
            'sumber_air_minum' => $catin->sumber_air_minum,
            'fasilitas_BAB' => $catin->fasilitas_BAB,
            'mendapatkan_tablet_tambah_darah' => $catin->mendapatkan_tablet_tambah_darah,
            'meminum_table_tambah_darah' => $catin->meminum_table_tambah_darah,
            'penyuluhan_KIE' => $catin->penyuluhan_KIE,
            'fasilitas_layanan_rujukan' => $catin->fasilitas_layanan_rujukan,
            'fasilitas_bantuan_sosial' => $catin->fasilitas_bantuan_sosial,
        ]
    ]);
}


    public function update(Request $request, $nik)
    {
        $catin = Catin::where('nik_catin1', $nik)
            ->orWhere('nik_catin2', $nik)
            ->firstOrFail();

        $validated = $request->validate([
            'nik_catin1' => 'required|string',
            'nik_catin2' => 'required|string',
            'tanggal_pernikahan' => 'required|date',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'indeks_massa_tubuh' => 'required|numeric',
            'kadar_hemoglobin' => 'required|numeric',
            'LILA' => 'required|numeric',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'catin_wanita_merokok_terpapar' => 'nullable|string',
            'catin_pria_merokok_terpapar' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
        ]);

        $catin->update($validated);

        return redirect()->route('penduduk.index')->with('success', 'Data Catin berhasil diperbarui.');
    }


    public function destroy($nik)
    {
        $catin = Catin::where('nik_catin1', $nik)->firstOrFail();
        $catin->delete();

        return redirect()->route('catin.index')->with('success', 'Data catin berhasil dihapus.');
    }

}