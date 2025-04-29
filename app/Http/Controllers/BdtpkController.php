<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Bdtpk; // <-- Tambahkan ini!
class BdtpkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bdtpks = Bdtpk::get(); // <-- Ini pakai huruf besar Bdtpk
        return Inertia::render('Bdtpk/Index', [
            "bdtpks" => $bdtpks
        ]);

        

    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Bdtpk/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request ->validate([
            'nik'=>'required',
            'nama'=>'required'
        ]);

        Bdtpk::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
        ]);
        return redirect()->route('bdtpk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bdtpk = bdtpk::find($id);
        return Inertia::render('Bdtpk/Edit',[
            'bdtpk'=>$bdtpk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request ->validate([
            'nik'=>'required',
            'nama'=>'required'
        ]);

        $bdtpk = Bdtpk::find($id);
        $bdtpk ->nik=$request->nik;
        $bdtpk ->nama=$request->nama;
        $bdtpk->save();

        return redirect()->route('bdtpk.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bdtpk=bdtpk::find($id);
        $bdtpk->delete();

        return redirect()->route('bdtpk.index');

    }
}
