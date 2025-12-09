<?php

namespace App\Http\Controllers;

use App\Models\Ikan;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout:
     * - Ringkasan keranjang
     * - Form data pelanggan
     */
    public function index()
    {
        // Ambil keranjang dari session
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Keranjang masih kosong, silakan pilih ikan terlebih dahulu.');
        }

        // Hitung total dari keranjang
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        // Kalau user sudah login, bisa auto-isi nama
        $user = Auth::user();

        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    /**
     * Proses checkout:
     * - Validasi input
     * - Simpan data ke tabel transaksis & transaksi_items
     * - Kurangi stok ikan
     * - Kosongkan keranjang
     */
    public function process(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        // Validasi form checkout (sudah ada metode pembayaran & kurir)
        $validated = $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'no_hp'             => 'nullable|string|max:50',
            'alamat'            => 'nullable|string',
            'metode_pembayaran' => 'required|in:transfer,ewallet,cod',
            'kurir'             => 'required|in:jne,jnt,sicepat,anteraja,ambil_toko',
        ]);

        // Hitung total dari session (supaya tidak bisa dimanipulasi dari sisi client)
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }

        try {
            DB::beginTransaction();

            // Generate kode transaksi unik
            $kode = 'TRX-' . now()->format('Ymd-His') . '-' . Str::upper(Str::random(5));

            // Simpan ke tabel transaksis
            $transaksi = Transaksi::create([
                'user_id'           => Auth::id(), // boleh null kalau guest
                'kode'              => $kode,
                'nama_pelanggan'    => $validated['nama_pelanggan'],
                'no_hp'             => $validated['no_hp'] ?? null,
                'alamat'            => $validated['alamat'] ?? null,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'kurir'             => $validated['kurir'],
                'total'             => $total,
            ]);

            // Simpan detail item + kurangi stok
            foreach ($cart as $cartItem) {
                // Lock row ikan supaya stok aman saat banyak transaksi
                $ikan = Ikan::lockForUpdate()->findOrFail($cartItem['id']);

                // Cek stok cukup
                if ($ikan->stok < $cartItem['qty']) {
                    DB::rollBack();

                    return redirect()
                        ->route('keranjang.index')
                        ->with('error', 'Stok untuk ' . $ikan->nama . ' tidak mencukupi.');
                }

                // Simpan ke transaksi_items
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'ikan_id'      => $ikan->id,
                    'nama_ikan'    => $ikan->nama,
                    'harga'        => $ikan->harga,
                    'qty'          => $cartItem['qty'],
                    'subtotal'     => $cartItem['subtotal'],
                ]);

                // Kurangi stok di tabel ikan
                $ikan->decrement('stok', $cartItem['qty']);
            }

            DB::commit();

            // Bersihkan keranjang di session
            session()->forget('cart');
            session()->forget('cart_count');

            // Langsung arahkan ke halaman cetak struk (auto print)
            return redirect()
                ->route('transaksi.cetak', $transaksi)
                ->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // logger()->error($e->getMessage());

            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Terjadi kesalahan saat memproses checkout.');
        }
    }

    /**
     * (Opsional) Halaman sukses jika masih ingin dipakai terpisah
     * Sekarang boleh dipanggil dari tempat lain:
     *  return redirect()->route('checkout.success', $transaksi);
     */
    public function success(Transaksi $transaksi)
    {
        return view('checkout.success', compact('transaksi'));
    }
}
