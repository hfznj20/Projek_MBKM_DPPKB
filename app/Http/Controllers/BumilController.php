<?php

namespace App\Http\Controllers;

use App\Models\Bumil;
use App\Models\Penduduk;
use App\Models\KunjunganBumil; // Tambahkan import model KunjunganBumil
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BumilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Bumil::with('penduduk')
            ->orderBy('created_at', 'desc');

        if ($user->name !== 'Admin') {
            $query->where('niktpk', $user->NIK);
        }

        $bumils = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'stunting' => $item->stunting,
                'niktpk' => $item->niktpk,
                'nik' => $item->penduduk->nik,
                'nama' => $item->penduduk->nama,
                'kecamatan' => $item->penduduk->kecamatan,
                'kelurahan' => $item->penduduk->kelurahan,
            ];
        });

        return Inertia::render('Bumil/Index', [
            'bumils' => $bumils,
        ]);
    }

    public function create(Request $request)
    {
        $penduduks = Penduduk::all();
        return Inertia::render('Bumil/Create', [
            'penduduks' => $penduduks,
            'penduduk_nik' => $request->nik,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penduduk_nik' => 'required|exists:penduduk,nik',
            'usia_kehamilan' => 'required|integer',
            'TUF' => 'required|integer',
            'jumlah_anak_kandung' => 'required|integer',
            'tgl_lahir_ank_terakhir' => 'required|date',
            'tinggi_badan' => 'required|integer',
            'berat_badan_sebelum_hamil' => 'required|integer',
            'berat_badan_saat_ini' => 'required|integer',
            'indeks_massa_tubuh' => 'required|numeric',
            'kadar_hemoglobin' => 'required|numeric',
            'LILA' => 'required|numeric',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'meerokok_terpapar' => 'nullable|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
            'stunting' => 'required|string',
        ]);

        $bumil = Bumil::create(array_merge(
            $request->all(),
            ['niktpk' => auth()->user()->NIK]
        ));

        // Menambahkan data kunjungan terkait Bumil setelah data Bumil disimpan
        // KunjunganBumil::create([
        //     'penduduk_nik' => $bumil->penduduk_nik,
        //     'usia_kehamilan' => $bumil->usia_kehamilan,
        //     'tanggal_kunjungan' => Carbon::now(), // Menggunakan waktu saat ini sebagai tanggal kunjungan
        //     'berat_badan' => $bumil->berat_badan_saat_ini,
        //     'tinggi_badan' => $bumil->tinggi_badan,
        //     'menggunakan_alat_kontrasepsi' => $bumil->menggunakan_alat_kontrasepsi,
        //     'sumber_air_minum' => $bumil->sumber_air_minum,
        //     'fasilitas_BAB' => $bumil->fasilitas_BAB,
        //     'merokok_terpapar' => $bumil->meerokok_terpapar,
        //     'longitude' => $bumil->longitude,
        //     'latitude' => $bumil->latitude,
        //     'mendapatkan_tablet_tambah_darah' => $bumil->mendapatkan_tablet_tambah_darah,
        //     'meminum_table_tambah_darah' => $bumil->meminum_table_tambah_darah,
        //     'penyuluhan_KIE' => $bumil->penyuluhan_KIE,
        //     'fasilitas_layanan_rujukan' => $bumil->fasilitas_layanan_rujukan,
        //     'fasilitas_bantuan_sosial' => $bumil->fasilitas_bantuan_sosial,
        // ]);

        return redirect()->route('penduduk.index')->with('success', 'Data Bumil berhasil disimpan');
    }

    public function show($nik)
    {
        $bumil = Bumil::with('penduduk')->where('penduduk_nik', $nik)->firstOrFail();
        $penduduk = $bumil->penduduk;
        $usia = Carbon::parse($penduduk->tanggal_lahir)->age;

        return Inertia::render('Bumil/Show', [
            'bumil' => [
                'nama' => $penduduk->nama,
                'nik' => $penduduk->nik,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir,
                'jenis_kelamin' => $penduduk->jenis_kelamin,
                'alamat' => $penduduk->alamat,
                'no_hp' => $penduduk->no_hp,
                'usia' => $usia,

                'usia_kehamilan' => $bumil->usia_kehamilan,
                'jumlah_anak_kandung' => $bumil->jumlah_anak_kandung,
                'tgl_lahir_ank_terakhir' => $bumil->tgl_lahir_ank_terakhir,
                'berat_badan_saat_ini' => $bumil->berat_badan_saat_ini,
                'tinggi_badan' => $bumil->tinggi_badan,
                'indeks_massa_tubuh' => $bumil->indeks_massa_tubuh,
                'LILA' => $bumil->LILA,
                'kadar_hemoglobin' => $bumil->kadar_hemoglobin,
                'menggunakan_alat_kontrasepsi' => $bumil->menggunakan_alat_kontrasepsi,
                'sumber_air_minum' => $bumil->sumber_air_minum,
                'fasilitas_BAB' => $bumil->fasilitas_BAB,
                'meerokok_terpapar' => $bumil->meerokok_terpapar,
                'niktpk' => $bumil->niktpk,
                'stunting' => $bumil->stunting, // ⬅️ INI WAJIB ADA
                'kunjungan' => $bumil->kunjungan ?? [],
            ],
        ]);
    }

    public function edit($id)
    {
        $bumil = Bumil::with('penduduk')->findOrFail($id);
        $penduduks = Penduduk::all();

        return Inertia::render('Bumil/Edit', [
            'bumil' => $bumil,
            'penduduks' => $penduduks,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penduduk_nik' => 'required|exists:penduduk,nik',
            'usia_kehamilan' => 'required|integer',
            'TUF' => 'required|integer',
            'jumlah_anak_kandung' => 'required|integer',
            'tgl_lahir_ank_terakhir' => 'required|date',
            'tinggi_badan' => 'required|integer',
            'berat_badan_sebelum_hamil' => 'required|integer',
            'berat_badan_saat_ini' => 'required|integer',
            'indeks_massa_tubuh' => 'required|numeric',
            'kadar_hemoglobin' => 'required|numeric',
            'LILA' => 'required|numeric',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'meerokok_terpapar' => 'nullable|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'mendapatkan_tablet_tambah_darah' => 'nullable|string',
            'meminum_table_tambah_darah' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_layanan_rujukan' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
            'stunting' => 'required|string',
        ]);

        $bumil = Bumil::findOrFail($id);
        $bumil->update(array_merge(
            $request->all(),
            ['niktpk' => auth()->user()->NIK]
        ));

        // Update kunjungan Bumil jika diperlukan
        $kunjungan = KunjunganBumil::where('penduduk_nik', $bumil->penduduk_nik)->first();
        if ($kunjungan) {
            $kunjungan->update([
                'berat_badan' => $bumil->berat_badan_saat_ini,
                'tinggi_badan' => $bumil->tinggi_badan,
                'menggunakan_alat_kontrasepsi' => $bumil->menggunakan_alat_kontrasepsi,
                'sumber_air_minum' => $bumil->sumber_air_minum,
                'fasilitas_BAB' => $bumil->fasilitas_BAB,
                'merokok_terpapar' => $bumil->meerokok_terpapar,
                'longitude' => $bumil->longitude,
                'latitude' => $bumil->latitude,
            ]);
        }

        return redirect()->route('penduduk.index')->with('success', 'Data Bumil berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bumil = Bumil::findOrFail($id);
        $bumil->delete();

        return redirect()->route('bumil.index')->with('success', 'Data bumil berhasil dihapus.');
    }
}
