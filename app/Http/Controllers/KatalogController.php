<?php

namespace App\Http\Controllers;

use App\Models\Ikan;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    // Halaman katalog
    public function index(Request $request)
    {
        $query = Ikan::query();

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Pencarian nama ikan
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama', 'like', '%' . $q . '%');
        }

        // Ambil ikan + pagination
        $ikans = $query
            ->orderBy('nama')
            ->paginate()
            ->withQueryString();

        // Ambil daftar kategori unik
        $kategoris = Ikan::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('katalog.index', compact('ikans', 'kategoris'));
    }

    public function show(Ikan $ikan)
    {
        return view('katalog.show', compact('ikan'));
    }
   
}
