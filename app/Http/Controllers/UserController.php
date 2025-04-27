<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class UserController extends Controller
{
    // Method untuk menampilkan halaman manajemen user dengan Inertia.js
    public function index1()
    {
        return Inertia::render('PopulationData'); // 'ManajemenUser' adalah nama komponen Vue.js

    }
    public function index2()
    {
        return Inertia::render('Stunting'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index3()
    {
        return Inertia::render('PanduGenre'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index4()
    {
        return Inertia::render('Baduta'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index5()
    {
        return Inertia::render('Bumil'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index6()
    {
        return Inertia::render('Catin'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index7()
    {
        return Inertia::render('PascaPersalinan'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index8()
    {
        return Inertia::render('KinerjaTPK'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index9()
    {
        return Inertia::render('ManajemenUser'); // 'ManajemenUser' adalah nama komponen Vue.js
    }

    public function index10()
    {
        return Inertia::render('BadutaTPK'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index11()
    {
        return Inertia::render('PopulationDataTPK'); // 'ManajemenUser' adalah nama komponen Vue.js
    }
    public function index12()
    {
        return Inertia::render('StuntingTPK');  // Menampilkan halaman StuntingTPK.vue
    }
    public function index13()
    {
        return Inertia::render('BumilTPK');
    }

    public function index14()
    {
        return Inertia::render('CatinTPK');
    }
    public function index15()
    {
        return Inertia::render('PascaPersalinanTPK');
    }
}
