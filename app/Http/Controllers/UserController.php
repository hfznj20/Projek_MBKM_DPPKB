<?php

namespace App\Http\Controllers;
use App\Models\Penduduk;
use App\Models\Bumil;
use App\Models\Baduta;
use App\Models\Catin;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
// Method untuk menampilkan halaman manajemen user dengan Inertia.js
    public function indexPenduduk()
    {
        $user = auth()->user();

        $penduduks = $user->name === 'Admin'
            ? Penduduk::orderBy('created_at', 'desc')->get()
            : Penduduk::where('niktpk', $user->NIK)
                ->orderBy('created_at', 'desc')
                ->get();

        return Inertia::render('PopulationData', [
            'penduduks' => $penduduks,
        ]);

    }
    public function indexStunting()
    {
        $stuntingData = collect();

        $baduta = Baduta::with('penduduk')
            ->where('stunting', 'Ya')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nik' => $item->penduduk?->nik ?? '-',
                    'nama' => $item->penduduk?->nama ?? 'Tidak Ditemukan',
                    'kecamatan' => $item->penduduk?->kecamatan ?? 'Tidak Ditemukan',
                    'kelurahan' => $item->penduduk?->kelurahan ?? 'Tidak Ditemukan',
                    'statusStunting' => 'Baduta',
                ];
            });

        $bumil = Bumil::with('penduduk')
            ->where('stunting', 'Ya')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nik' => $item->penduduk?->nik ?? '-',
                    'nama' => $item->penduduk?->nama ?? 'Tidak Ditemukan',
                    'kecamatan' => $item->penduduk?->kecamatan ?? 'Tidak Ditemukan',
                    'kelurahan' => $item->penduduk?->kelurahan ?? 'Tidak Ditemukan',
                    'statusStunting' => 'Bumil',
                ];
            });

        $stuntingData = $baduta->merge($bumil);
        return Inertia::render('Stunting/Index', [
            'stuntingData' => $stuntingData->values()->toArray(),
        ]);   
        

    }
    public function index3()
    {
        return Inertia::render('PanduGenre');
    }
    public function indexBaduta()
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
    
        return Inertia::render('Baduta', [
            'badutas' => $badutas,
        ]);
    }
    public function indexBumil()
    {
        $user = auth()->user();
        $query = DB::table('bumil')
            ->join('penduduk', 'bumil.penduduk_nik', '=', 'penduduk.nik')
            ->select(
                'bumil.id',
                'bumil.stunting',
                'penduduk.nik',
                'penduduk.nama',
                'penduduk.kecamatan',
                'penduduk.kelurahan',
                'bumil.niktpk'
            )
            ->orderBy('bumil.created_at', 'desc');

            if ($user->name !== 'Admin') {
                $query->where('bumil.niktpk', $user->NIK);
            }

            $bumils = $query->get();
    
        return Inertia::render('Bumil', [
            'bumils' => $bumils,
        ]);
    }
    public function indexCatin()
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
            ];
        });
    
        return Inertia::render('Catin', [
            'catins' => $catins,
        ]);
    }
    
    public function indexPascaPersalinan()
    {
        $user = auth()->user();
        $query = DB::table('pasca_persalinan')
            ->join('penduduk', 'pasca_persalinan.penduduk_nik', '=', 'penduduk.nik')
            ->select(
                'pasca_persalinan.id',
                'pasca_persalinan.tanggal_persalinan',
                'penduduk.nik',
                'penduduk.nama',
                'penduduk.kecamatan',
                'penduduk.kelurahan'
            )
            ->orderBy('pasca_persalinan.created_at', 'desc');
            if ($user->name !== 'Admin') {
                $query->where('pasca_persalinan.niktpk', $user->NIK);
            }

            $pasca_persalinan = $query->get();
    
        return Inertia::render('PascaPersalinan', [
            'pasper' => $pasca_persalinan,
        ]);
    }
    public function indexKinerjaTPK()
    {
        return Inertia::render('KinerjaTPK');
    }

  public function indexStuntingTPK()
    {
        $stuntingData = collect();

        $baduta = Baduta::with('penduduk')
            ->where('stunting', 'Ya')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nik' => $item->penduduk?->nik ?? '-',
                    'nama' => $item->penduduk?->nama ?? 'Tidak Ditemukan',
                    'kecamatan' => $item->penduduk?->kecamatan ?? 'Tidak Ditemukan',
                    'kelurahan' => $item->penduduk?->kelurahan ?? 'Tidak Ditemukan',
                    'statusStunting' => 'Baduta',
                ];
            });
            

        $bumil = Bumil::with('penduduk')
            ->where('stunting', 'Ya')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nik' => $item->penduduk?->nik ?? '-',
                    'nama' => $item->penduduk?->nama ?? 'Tidak Ditemukan',
                    'kecamatan' => $item->penduduk?->kecamatan ?? 'Tidak Ditemukan',
                    'kelurahan' => $item->penduduk?->kelurahan ?? 'Tidak Ditemukan',
                    'statusStunting' => 'Bumil',
                ];
            });

        $stuntingData = $baduta->merge($bumil);
        dd($stuntingData);
        return Inertia::render('Stunting/Index', [
            'stuntingData' => $stuntingData->values()->toArray(),
        ]);        
    }

    public function showBaduta($nik)
{
    // Ambil data Baduta berdasarkan ID
    $baduta = Baduta::with('penduduk')
        ->where('nik', $nik)
        ->firstOrFail();

    return Inertia::render('Baduta/Show', [
        'baduta' => $baduta,
        'kunjungan' => $baduta->kunjungan,
    ]);
}

public function showBumil($nik)
{
    // Ambil data Bumil berdasarkan nik dari tabel penduduk
    $bumil = Bumil::with('penduduk')
        ->whereHas('penduduk', function ($query) use ($nik) {
            $query->where('nik', $nik);
        })
        ->firstOrFail();

    return Inertia::render('Bumil/Show', [
        'bumil' => $bumil,
    ]);
}
}
