<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use App\Models\Bumil;
use App\Models\Baduta;
use App\Models\Catin;
use App\Models\Pasper;
use Illuminate\Support\Facades\DB;

class PendudukController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $penduduks = $user->name === 'Admin'
            ? Penduduk::orderBy('created_at', 'desc')->get()
            : Penduduk::where('niktpk', $user->NIK)
                ->orderBy('created_at', 'desc')
                ->get();

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
            'kategori' => 'required|in:CATIN,BUMIL,BADUTA,Pasca Persalinan,Penduduk,penduduk, catin',
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
            'niktpk' => auth()->user()->NIK,
        ]);

        // Redirect berdasarkan kategori
        return match ($penduduk->kategori) {
            'BADUTA' => Inertia::location(route('baduta.create', ['nik' => $penduduk->nik])),
            'CATIN' => Inertia::location(route('catin.create', ['nik' => $penduduk->nik])),
            'BUMIL' => Inertia::location(route('bumil.create', ['nik' => $penduduk->nik])),
            'Pasca Persalinan' => Inertia::location(route('pasper.create', ['nik' => $penduduk->nik])),
            'penduduk' => redirect()->route('baduta.create', ['penduduk_nik' => $penduduk->nik]),
            'catin' => redirect()->route('catin.create', ['penduduk_nik' => $penduduk->nik]),
            'Penduduk' => Inertia::location(route('penduduk.index')),
            default => redirect()->route('penduduk.index')->with('success', 'Data Penduduk berhasil disimpan'),
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
            'nik' => 'required|digits:16|unique:penduduk,nik,' . $nik . ',nik',
            'nama' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kecamatan' => 'required|in:Ujung,Bacukiki,Bacukiki Barat,Soreang',
            'kelurahan' => 'required',
            'RT' => 'required',
            'RW' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'kategori' => 'required|in:CATIN,BUMIL,BADUTA,Pasca Persalinan,Penduduk,penduduk',
        ]);

        $penduduk = Penduduk::where('nik', $nik)->firstOrFail();
        $kategoriLama = $penduduk->kategori;
        $kategoriBaru = $request->kategori;
    
        // Jika kategori berubah, hapus data lama di tabel kategori sebelumnya
        if ($kategoriLama !== $kategoriBaru) {
            match ($kategoriLama) {
                'BUMIL' => \App\Models\Bumil::where('penduduk_nik', $nik)->delete(),
                'BADUTA' => \App\Models\Baduta::where('penduduk_nik', $nik)->delete(),
                'CATIN' => \App\Models\Catin::where('penduduk_nik', $nik)->delete(),
                'Pasca Persalinan' => \App\Models\Pasper::where('penduduk_nik', $nik)->delete(),
                default => null,
            };
        }

        $penduduk->update($request->all());

        return match ($penduduk->kategori) {
            'CATIN' => Inertia::location(route('catin.create', ['nik' => $penduduk->nik])),
            'BUMIL' => Inertia::location(route('bumil.create', ['nik' => $penduduk->nik])),
            'BADUTA' => Inertia::location(route('baduta.create', ['nik' => $penduduk->nik])),
            'Pasca Persalinan' => Inertia::location(route('pasper.create', ['nik' => $penduduk->nik])),
            'Penduduk' => Inertia::location(route('penduduk.index')),
            default => redirect()->route('penduduk.index')->with('success', 'Data Penduduk berhasil disimpan'),
        };
    }


    public function destroy($nik)
    {
        $penduduk = Penduduk::where('nik', $nik)->firstOrFail();

        if (!$penduduk) {
            return back()->withErrors(['error' => 'Data penduduk tidak ditemukan.']);
        }

        $kategori = $penduduk->kategori;

        // Hapus dari tabel kategori jika ada
        match ($kategori) {
            'BUMIL' => Bumil::where('penduduk_nik', $nik)->delete(),
            'BADUTA' => Baduta::where('penduduk_nik', $nik)->delete(),
            'CATIN' => Catin::where('penduduk_nik', $nik)->delete(),
            'Pasca Persalinan' => Pasper::where('penduduk_nik', $nik)->delete(),
            default => null,
        };

        // Hapus dari tabel penduduk
        $penduduk->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
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

    public function kategoriPerKecamatan()
    {

        $data = DB::table('penduduk')
            ->select('kecamatan', 'kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kecamatan', 'kategori')
            ->get();

        $result = [];
        $categories = ['BADUTA', 'BUMIL', 'CATIN', 'Pasca Persalinan', 'Penduduk'];

        foreach ($data as $item) {

            if (!isset($result[$item->kecamatan])) {
                $result[$item->kecamatan] = [
                    'kecamatan' => $item->kecamatan,
                    'BADUTA' => 0,
                    'BUMIL' => 0,
                    'CATIN' => 0,
                    'Pasca Persalinan' => 0,
                    'Penduduk' => 0,
                ];
            }


            $result[$item->kecamatan][$item->kategori] = $item->total;
        }
        $formattedData = array_values($result);
        return response()->json($formattedData);
    }
}