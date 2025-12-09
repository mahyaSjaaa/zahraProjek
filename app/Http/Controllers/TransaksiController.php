<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;  // alias PDF

class TransaksiController extends Controller
{
    /**
     * Detail transaksi (misalnya untuk halaman riwayat / admin).
     */
    public function show(Transaksi $transaksi)
    {
        // pastikan relasi "items" ada di model Transaksi
        $transaksi->load('items');

        return view('transaksi.show', [
            'transaksi' => $transaksi,
            'items'     => $transaksi->items,
        ]);
    }

    /**
     * Struk tampilan HTML (bisa langsung di-print dari browser).
     * Ini yang dipakai oleh route('transaksi.cetak').
     */
    public function cetak(Transaksi $transaksi)
    {
        $transaksi->load('items');

        // view ini bisa berisi script window.print()
        return view('transaksi.struk', [
            'transaksi' => $transaksi,
            'items'     => $transaksi->items,
        ]);
    }

    /**
     * Struk PDF pakai dompdf (sesuai modul 14).
     */
    public function strukPdf(Transaksi $transaksi)
    {
        $transaksi->load('items');

        $pdf = PDF::loadView('transaksi.struk_pdf', [
                'transaksi' => $transaksi,
            ])
            ->setPaper('A5', 'portrait'); // ukuran lebih mirip struk

        $filename = 'Struk-' . ($transaksi->kode ?? $transaksi->id) . '.pdf';

        return $pdf->download($filename);
    }
}
