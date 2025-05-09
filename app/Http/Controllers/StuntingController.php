<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Stunting; // sesuaikan dengan model kamu

class StuntingController extends Controller
{
    public function index()
    {
        $stuntingData = Stunting::all(); // ambil semua data stunting

        return Inertia::render('Stunting/Index', [
            'stuntingData' => $stuntingData,
        ]);
    }
}

