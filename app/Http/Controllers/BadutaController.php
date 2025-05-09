<?php

namespace App\Http\Controllers;

use App\Models\Baduta;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\TPK;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BadutaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = DB::table('baduta')
            ->join('penduduk as anak', 'baduta.penduduk_nik', '=', 'anak.nik')
            ->join('penduduk as ibu', 'baduta.penduduk_ibu_nik', '=', 'ibu.nik')
            ->select(
                'baduta.id',
                'baduta.stunting',
                'anak.nik',
                'anak.nama',
                'anak.kecamatan',
                'anak.kelurahan',
                'ibu.nama as nama_ibu',
                'baduta.niktpk'
            )
            ->orderBy('baduta.created_at', 'desc');

            if ($user->name !== 'Admin') {
                $query->where('baduta.niktpk', $user->NIK);
            }
    
            $badutas = $query->get();
    
        return Inertia::render('Baduta/Index', [
            'badutas' => $badutas,
        ]);
    }
    

    
    public function create(Request $request)
    {
        $penduduks = Penduduk::all(); // ambil semua penduduk
        return Inertia::render('Baduta/Create', [
            'penduduks' => $penduduks,
            'penduduk_nik' => $request->nik, // <-- ubah dari $request->penduduk_nik
        ]);
    }


    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'penduduk_nik' => 'required|exists:penduduk,nik', // nik bayi
            'penduduk_ibu_nik' => 'required|exists:penduduk,nik', // nik ibu
            'jumlah_anak_kandung' => 'required|integer',
            'tanggal_lahir_anak_terakhir' => 'required|date',
            'berat_badan' => 'required|integer',
            'tinggi_badan' => 'required|integer',
            'urutan_anak' => 'required|integer',
            'umur_kehamilan_saat_lahir' => 'required|integer',
            'menggunakan_alat_kontrasepsi' => 'nullable|string',
            'sumber_air_minum' => 'nullable|string',
            'fasilitas_BAB' => 'nullable|string',
            'asi_eksklusif' => 'nullable|string',
            'imunisasi_hepatitis_B' => 'nullable|string',
            'meerokok_terpapar' => 'nullable|string',
            'mengisi_KKA' => 'nullable|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'kehadiran_posyandu' => 'nullable|string',
            'penyuluhan_KIE' => 'nullable|string',
            'fasilitas_bantuan_sosial' => 'nullable|string',
            'stunting' => 'required|string',
        ]);

        // Simpan data ke dalam tabel baduta
        Baduta::create([
            'penduduk_nik' => $request->penduduk_nik,
            'penduduk_ibu_nik' => $request->penduduk_ibu_nik,
            'jumlah_anak_kandung' => $request->jumlah_anak_kandung,
            'tanggal_lahir_anak_terakhir' => $request->tanggal_lahir_anak_terakhir,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'urutan_anak' => $request->urutan_anak,
            'umur_kehamilan_saat_lahir' => $request->umur_kehamilan_saat_lahir,
            'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
            'sumber_air_minum' => $request->sumber_air_minum,
            'fasilitas_BAB' => $request->fasilitas_BAB,
            'asi_eksklusif' => $request->asi_eksklusif,
            'imunisasi_hepatitis_B' => $request->imunisasi_hepatitis_B,
            'meerokok_terpapar' => $request->meerokok_terpapar,
            'mengisi_KKA' => $request->mengisi_KKA,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'kehadiran_posyandu' => $request->kehadiran_posyandu,
            'penyuluhan_KIE' => $request->penyuluhan_KIE,
            'fasilitas_bantuan_sosial' => $request->fasilitas_bantuan_sosial,
            'stunting' => $request->stunting,
            'niktpk' => auth()->user()->NIK,
        ]);

        return redirect()->route('penduduk.index')->with('success', 'Data Baduta berhasil disimpan');
    }
    
    public function show($nik)
    {
        $baduta = Baduta::with(['anak', 'ibu'])->where('penduduk_nik', $nik)->firstOrFail();

        // Hitung usia anak dalam tahun dan bulan
        $lahir_anak = Carbon::parse($baduta->anak->tanggal_lahir);
        $now = Carbon::now();
        $diff = $lahir_anak->diff($now);

        $tahun = $diff->y;
        $bulan = $diff->m;
        $hari = $diff->d;

        $usia_anak = '';
        if ($tahun > 0) {
            $usia_anak .= "{$tahun} tahun ";
        }
        if ($bulan > 0) {
            $usia_anak .= "{$bulan} bulan ";
        }
        if ($tahun === 0 && $bulan === 0) {
            // Jika belum genap 1 bulan
            $usia_anak .= "{$hari} hari";
        } elseif ($hari > 0) {
            $usia_anak .= "{$hari} hari";
        }

        // Hitung usia ibu dalam tahun
        $usia_ibu = Carbon::parse($baduta->ibu->tanggal_lahir)->age;

        return Inertia::render('Baduta/Show', [
            'baduta' => [
                'nama' => $baduta->anak->nama,
                'nik' => $baduta->anak->nik,
                'tanggal_lahir' => $baduta->anak->tanggal_lahir,
                'usia' => $usia_anak,
                'jenis_kelamin' => $baduta->anak->jenis_kelamin,
                'alamat' => $baduta->anak->alamat,
                'no_hp' => $baduta->anak->no_hp,

                'berat_badan' => $baduta->berat_badan,
                'tinggi_badan' => $baduta->tinggi_badan,
                'asi_eksklusif' => $baduta->asi_eksklusif,
                'imunisasi_hepatitis_B' => $baduta->imunisasi_hepatitis_B,
                'mengisi_KKA' => $baduta->mengisi_KKA,
                'meerokok_terpapar' => $baduta->meerokok_terpapar,

                'nama_ibu' => $baduta->ibu->nama,
                'nik_ibu' => $baduta->ibu->nik,
                'tanggal_lahir_ibu' => $baduta->ibu->tanggal_lahir,
                'usia_ibu' => $usia_ibu,
                'no_hp' => $baduta->ibu->no_hp,
                'alamat' => $baduta->ibu->alamat,

                'jumlah_anak_kandung' => $baduta->jumlah_anak_kandung,
                'tanggal_lahir_anak_terakhir' => $baduta->tanggal_lahir_anak_terakhir,
                'menggunakan_alat_kontrasepsi' => $baduta->menggunakan_alat_kontrasepsi,
                'sumber_air_minum' => $baduta->sumber_air_minum,
                'fasilitas_BAB' => $baduta->fasilitas_BAB,
            ]
        ]);
    }

    public function edit($penduduk_nik)
    {
        $baduta = Baduta::findOrFail($penduduk_nik);
        return view('baduta.edit', compact('baduta'));
    }

    public function update(Request $request, $penduduk_nik)
    {
        $request->validate([
                'penduduk_nik' => 'required|exists:penduduk,nik', // nik bayi
                'penduduk_ibu_nik' => 'required|exists:penduduk,nik', // nik ibu
                'jumlah_anak_kandung' => 'required|integer',
                'tanggal_lahir_anak_terakhir' => 'required|date',
                'berat_badan' => 'required|integer',
                'tinggi_badan' => 'required|integer',
                'urutan_anak' => 'required|integer',
                'umur_kehamilan_saat_lahir' => 'required|integer',
                'menggunakan_alat_kontrasepsi' => 'nullable|string',
                'sumber_air_minum' => 'nullable|string',
                'fasilitas_BAB' => 'nullable|string',
                'asi_eksklusif' => 'nullable|string',
                'imunisasi_hepatitis_B' => 'nullable|string',
                'meerokok_terpapar' => 'nullable|string',
                'mengisi_KKA' => 'nullable|string',
                'longitude' => 'required|numeric',
                'latitude' => 'required|numeric',
                'kehadiran_posyandu' => 'nullable|string',
                'penyuluhan_KIE' => 'nullable|string',
                'fasilitas_bantuan_sosial' => 'nullable|string',
                'stunting' => 'required|string',
        ]);

        // Cari data Baduta yang akan diperbarui
        $baduta = Baduta::findOrFail($id);
        $baduta->update([
            'penduduk_nik' => $request->penduduk_nik,
            'penduduk_ibu_nik' => $request->penduduk_ibu_nik,
            'jumlah_anak_kandung' => $request->jumlah_anak_kandung,
            'tanggal_lahir_anak_terakhir' => $request->tanggal_lahir_anak_terakhir,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'urutan_anak' => $request->urutan_anak,
            'umur_kehamilan_saat_lahir' => $request->umur_kehamilan_saat_lahir,
            'menggunakan_alat_kontrasepsi' => $request->menggunakan_alat_kontrasepsi,
            'sumber_air_minum' => $request->sumber_air_minum,
            'fasilitas_BAB' => $request->fasilitas_BAB,
            'asi_eksklusif' => $request->asi_eksklusif,
            'imunisasi_hepatitis_B' => $request->imunisasi_hepatitis_B,
            'meerokok_terpapar' => $request->meerokok_terpapar,
            'mengisi_KKA' => $request->mengisi_KKA,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'kehadiran_posyandu' => $request->kehadiran_posyandu,
            'penyuluhan_KIE' => $request->penyuluhan_KIE,
            'fasilitas_bantuan_sosial' => $request->fasilitas_bantuan_sosial,
            'stunting' => $request->stunting,
        ]);

        return redirect()->route('baduta.index')->with('success', 'Data Baduta berhasil diperbarui');
    }

    public function destroy($nik)
    {
        $baduta = Baduta::where('penduduk_nik', $nik)->firstOrFail();
        $baduta->delete();

        return redirect()->route('baduta.index')->with('success', 'Data Baduta berhasil dihapus.');
    }

    public function locations()
    {
        $baduta = Baduta::with('anak:nik,nama')
            ->select('penduduk_nik', 'latitude', 'longitude')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->anak->nama ?? 'Tidak diketahui',
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'penduduk_nik' => $item->penduduk_nik,
                ];
            });

        return response()->json($baduta);
    }
}
