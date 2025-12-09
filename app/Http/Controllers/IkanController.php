<?php

namespace App\Http\Controllers;

use App\Models\Ikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IkanController extends Controller
{
    public function index(Request $request)
    {
        // ambil kata kunci pencarian (optional)
        $q = $request->input('q');

        $ikans = Ikan::query()
            ->when($q, function ($query, $q) {
                $query->where('nama', 'like', '%' . $q . '%')
                      ->orWhere('kategori', 'like', '%' . $q . '%');
            })
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString(); // supaya parameter ?q= tetap ada di pagination

        return view('admin.ikan.index', compact('ikans'));
    }

    public function create()
    {
        return view('admin.ikan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:100',
            'harga'     => 'required|integer|min:0',
            'stok'      => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'kategori', 'harga', 'stok', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            // disimpan di storage/app/public/ikan
            $path = $request->file('gambar')->store('ikan', 'public');
            $data['gambar'] = $path;
        }

        Ikan::create($data);

        return redirect()->route('admin.ikan.index')
            ->with('success', 'Data ikan berhasil ditambahkan.');
    }

    public function edit(Ikan $ikan)
    {
        return view('admin.ikan.edit', compact('ikan'));
    }

    public function update(Request $request, Ikan $ikan)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:100',
            'harga'     => 'required|integer|min:0',
            'stok'      => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'kategori', 'harga', 'stok', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            // hapus gambar lama jika ada
            if ($ikan->gambar && Storage::disk('public')->exists($ikan->gambar)) {
                Storage::disk('public')->delete($ikan->gambar);
            }

            $path = $request->file('gambar')->store('ikan', 'public');
            $data['gambar'] = $path;
        }

        $ikan->update($data);

        return redirect()->route('admin.ikan.index')
            ->with('success', 'Data ikan berhasil diperbarui.');
    }

    public function destroy(Ikan $ikan)
    {
        if ($ikan->gambar && Storage::disk('public')->exists($ikan->gambar)) {
            Storage::disk('public')->delete($ikan->gambar);
        }

        $ikan->delete();

        return redirect()->route('admin.ikan.index')
            ->with('success', 'Data ikan berhasil dihapus.');
    }
}
