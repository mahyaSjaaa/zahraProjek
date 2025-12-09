<?php

namespace App\Http\Controllers;

use App\Models\Ikan;

class HomeController extends Controller
{
    public function index()
    {
        // hitung dari tabel ikans
        $totalIkan = Ikan::count();
        $totalStok = Ikan::sum('stok');

        return view('home', compact('totalIkan', 'totalStok'));
    }
}
