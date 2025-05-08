<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Baduta;
use App\Models\PanduGenre;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PandugenreController extends Controller
{
    public function index()
    {
        $data = DB::table('pandu_genres')
            ->join('penduduk', 'pandu_genres.nik', '=', 'penduduk.nik')
            ->select(
                'pandu_genres.id',
                'penduduk.nik',
                'penduduk.nama',
                'penduduk.kecamatan',
                'penduduk.kelurahan',
            )
            ->orderBy('pandu_genres.created_at', 'desc')
            ->get();

            return Inertia::render('Pandugenre/Index', [
                'pandugenres' => $data // gunakan nama ini
            ]);
    }

    public function create()
    {
        return Inertia::render('Pandugenre/Create');
    }

    public function checkBaduta($nik)
    {
        // Cari penduduk berdasarkan NIK
        $penduduk = Penduduk::where('nik', $nik)->first();

        // Jika tidak ditemukan
        if (!$penduduk) {
            return response()->json([
                'exists' => false,
                'message' => 'NIK tidak ditemukan dalam data penduduk.'
            ], 404);
        }

        // Jika kategori bukan baduta
        if ($penduduk->kategori !== 'BADUTA') {
            return response()->json([
                'exists' => false,
                'message' => 'Penduduk ditemukan, tetapi bukan kategori baduta.'
            ], 400);
        }

        // Ambil data baduta yang terkait
        $baduta = $penduduk->baduta;

        if (!$baduta) {
            return response()->json([
                'exists' => false,
                'message' => 'Data baduta tidak ditemukan untuk penduduk ini.'
            ], 404);
        }

        return response()->json([
            'exists' => true,
            'message' => 'Data ditemukan.',
            'baduta' => [
                'nik' => $penduduk->nik,
                'stunting' => (bool) $baduta->stunting,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:penduduk,nik',
            'terapi_gizi' => 'nullable|string',
            'terapi_psikososial' => 'nullable|string',
            'kunjungan_rumah' => 'nullable|string',
        ]);

        PanduGenre::create([
            'nik' => $request->nik,
            'terapi_gizi' => $request->terapi_gizi,
            'terapi_psikososial' => $request->terapi_psikososial,
            'kunjungan_rumah' => $request->kunjungan_rumah,
        ]);

        return redirect()->route('pandugenre.index')->with('success', 'Data Pandu Genre berhasil ditambahkan.');
    }

    public function show($nik)
    {
        $pandugenre = PanduGenre::with('penduduk')->where('nik', $nik)->firstOrFail();
        $penduduk = $pandugenre->penduduk;
        // Hitung usia anak dalam tahun dan bulan
        $lahir_anak = Carbon::parse($penduduk->tanggal_lahir);
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

        return Inertia::render('Pandugenre/Show', [
            'pandugenre' => [
                'nama' => $penduduk->nama,
                'nik' => $penduduk->nik,
                'tempat_lahir' => $penduduk->tempat_lahir,
                'tanggal_lahir' => $penduduk->tanggal_lahir,
                'jenis_kelamin' => $penduduk->jenis_kelamin,
                'alamat' => $penduduk->alamat,
                'no_hp' => $penduduk->no_hp,
                'usia' => $usia_anak,

                'terapi_gizi' => $pandugenre->terapi_gizi,
                'terapi_psikososial' => $pandugenre->terapi_psikososial,
                'kunjungan_rumah' => $pandugenre->kunjungan_rumah
            ],
        ]);
    }

    public function destroy($nik)
    {
        DB::table('pandu_genres')->where('nik', $nik)->delete();
    
        return redirect()->route('pandugenre.index')->with('success', 'Data berhasil dihapus.');
    }
    
}
