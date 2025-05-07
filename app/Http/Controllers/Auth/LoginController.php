<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        // Validasi kredensial
        $credentials = $request->only('NIK', 'password');

        // Cek apakah kredensial cocok
        if (Auth::attempt($credentials)) {
            // Regenerasi session setelah login berhasil
            $request->session()->regenerate();

            // Redirect berdasarkan role user
            if (Auth::user()->hasRole('admin')) {  // Pastikan 'hasRole' digunakan
                return redirect()->route('manajemen.index'); // Halaman admin
            } else {
                return redirect()->route('dashboard'); // Halaman untuk TPK
            }
        }

        // Jika login gagal
        throw ValidationException::withMessages([
            'NIK' => 'NIK atau password salah.',
        ]);
    }
}
