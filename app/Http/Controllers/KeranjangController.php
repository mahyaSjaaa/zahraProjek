<?php

namespace App\Http\Controllers;

use App\Models\Ikan;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    
   

    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        $cart  = session('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        return view('keranjang.index', compact('cart', 'total'));
    }

    /**
     * Tambah ikan ke keranjang
     */
    public function tambah(Request $request, Ikan $ikan)
    {
        // qty minimal 1
        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        // cek stok
        if ($ikan->stok < $qty) {
            return back()->with('error', 'Stok untuk ' . $ikan->nama . ' tidak mencukupi.');
        }

        // ambil keranjang dari session
        $cart = session('cart', []);

        // kalau sudah ada di keranjang → tambahkan qty
        if (isset($cart[$ikan->id])) {
            $cart[$ikan->id]['qty'] += $qty;
        } else {
            $cart[$ikan->id] = [
                'id'       => $ikan->id,
                'nama'     => $ikan->nama,
                'harga'    => $ikan->harga,
                'qty'      => $qty,
                'gambar'   => $ikan->gambar,
                'subtotal' => 0, // dihitung di bawah
            ];
        }

        // hitung ulang subtotal item
        $cart[$ikan->id]['subtotal'] = $cart[$ikan->id]['harga'] * $cart[$ikan->id]['qty'];

        // hitung total qty untuk badge keranjang
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['qty'];
        }

        // simpan kembali ke session
        session([
            'cart'       => $cart,
            'cart_count' => $cartCount,
        ]);

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Ikan berhasil ditambahkan ke keranjang.');
    }

    /**
     * Ubah jumlah qty di keranjang
     */
    public function update(Request $request, $id)
    {
        $cart = session('cart', []);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Item keranjang tidak ditemukan.');
        }

        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        $cart[$id]['qty']      = $qty;
        $cart[$id]['subtotal'] = $cart[$id]['harga'] * $qty;

        // hitung ulang total qty
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['qty'];
        }

        session([
            'cart'       => $cart,
            'cart_count' => $cartCount,
        ]);

        return back()->with('success', 'Jumlah item berhasil diperbarui.');
    }

    /**
     * Hapus satu item dari keranjang
     */
    public function hapus($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        // hitung ulang total qty
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['qty'];
        }

        session([
            'cart'       => $cart,
            'cart_count' => $cartCount,
        ]);

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    /**
     * Kosongkan seluruh keranjang
     */
    public function kosongkan()
    {
        session()->forget(['cart', 'cart_count']);

        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }


    public function edit($id)
    {
        $cart = session('cart', []);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Item keranjang tidak ditemukan.');
        }

        $item = $cart[$id];

        return view('keranjang.edit', [
            'id'   => $id,
            'item' => $item,
        ]);
    }


}
