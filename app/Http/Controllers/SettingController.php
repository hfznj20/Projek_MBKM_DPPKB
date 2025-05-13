<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function store(Request $request)
    {
        // Validasi file logo yang diunggah
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // Tentukan nama file yang diinginkan
        $filename = 'dppkb-logo.png';

        // Simpan file dengan nama yang ditentukan
        $path = $request->file('logo')->storeAs('public/logos', $filename);

        // Menyimpan data ke model Setting
        Setting::create([
            'logo' => 'logos/' . $filename,
        ]);

        return back()->with('success', 'Logo berhasil disimpan!');
    }
}
