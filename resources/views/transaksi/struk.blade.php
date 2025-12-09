@extends('layouts.app')

@section('title', 'Struk ' . $transaksi->kode)

@push('styles')
<style>
    .receipt-wrapper {
        max-width: 700px;
        margin: 0 auto;
    }

    .receipt-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        padding: 24px 28px;
    }

    .receipt-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px dashed #e5e7eb;
        padding-bottom: 16px;
        margin-bottom: 16px;
    }

    .brand-title {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 4px;
        color: var(--ff-primary-dark);
    }

    .brand-subtitle {
        font-size: 0.9rem;
        color: #6b7280;
    }

    .receipt-badge {
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        background: rgba(12, 164, 165, 0.08);
        color: var(--ff-primary-dark);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        display: inline-block;
        margin-bottom: 4px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 24px;
        font-size: 0.9rem;
        margin-bottom: 16px;
    }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9ca3af;
        margin-bottom: 2px;
        font-weight: 600;
    }

    .info-value {
        color: #111827;
        font-weight: 500;
    }

    .receipt-table th,
    .receipt-table td {
        font-size: 0.9rem;
        padding: 6px 4px;
    }

    .receipt-table thead th {
        border-top: none;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6b7280;
    }

    .receipt-table tfoot td {
        border-top: 1px solid #e5e7eb;
        font-weight: 600;
    }

    .receipt-footer {
        border-top: 2px dashed #e5e7eb;
        margin-top: 16px;
        padding-top: 12px;
        font-size: 0.8rem;
        color: #6b7280;
        text-align: center;
    }

    .print-actions {
        margin-bottom: 16px;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    @media print {
        nav.navbar, footer.ff-footer, .print-actions {
            display: none !important;
        }
        body {
            background: #ffffff !important;
        }
        .receipt-wrapper {
            margin-top: 0;
        }
    }
</style>
@endpush

@section('content')
@php
    // Mapping label metode pembayaran
    $mapPembayaran = [
        'transfer' => 'Transfer Bank',
        'ewallet'  => 'E-Wallet',
        'cod'      => 'COD (Bayar di Tempat)',
    ];
    $labelPembayaran = $mapPembayaran[$transaksi->metode_pembayaran] ?? ucfirst($transaksi->metode_pembayaran);

    // Mapping label kurir
    $mapKurir = [
        'jne'        => 'JNE',
        'jnt'        => 'J&T',
        'sicepat'    => 'SiCepat',
        'anteraja'   => 'AnterAja',
        'ambil_toko' => 'Ambil di Toko',
    ];
    $labelKurir = $mapKurir[$transaksi->kurir] ?? ucfirst(str_replace('_', ' ', $transaksi->kurir));
@endphp

<div class="receipt-wrapper mb-4">
    <div class="print-actions">
        <a href="{{ route('transaksi.struk_pdf', $transaksi) }}" class="btn btn-sm btn-ff-outline">
            Download PDF
        </a>
        <button onclick="window.print()" class="btn btn-sm btn-ff-primary">
            Cetak Struk
        </button>
    </div>

    <div class="receipt-card">
        {{-- Header --}}
        <div class="receipt-header">
            <div>
                <div class="brand-title">FourzFish</div>
                <div class="brand-subtitle">Toko Ikan Hias Online</div>
                <div style="font-size: 0.8rem; color:#9ca3af; margin-top:4px;">
                    WA: 081327209963 · Instagram: @fourzfish
                </div>
            </div>
            <div class="text-end">
                <div class="receipt-badge">Struk Transaksi</div>
                <div style="font-size: 0.85rem; color:#6b7280;">
                    Kode: <strong>{{ $transaksi->kode }}</strong><br>
                    Tanggal: {{ $transaksi->created_at->format('d M Y H:i') }}
                </div>
            </div>
        </div>

        {{-- Info pelanggan & transaksi --}}
        <div class="info-grid">
            <div>
                <div class="info-label">Pelanggan</div>
                <div class="info-value">{{ $transaksi->nama_pelanggan }}</div>
            </div>
            <div>
                <div class="info-label">No. HP</div>
                <div class="info-value">
                    {{ $transaksi->no_hp ?: '-' }}
                </div>
            </div>
            <div>
                <div class="info-label">Alamat</div>
                <div class="info-value">
                    {{ $transaksi->alamat ?: '-' }}
                </div>
            </div>
            <div>
                <div class="info-label">Metode Pembayaran</div>
                <div class="info-value">
                    {{ $labelPembayaran }}
                </div>
            </div>
            <div>
                <div class="info-label">Kurir Pengiriman</div>
                <div class="info-value">
                    {{ $labelKurir }}
                </div>
            </div>
        </div>

        {{-- Tabel item --}}
        <div class="table-responsive">
            <table class="table receipt-table mb-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ikan</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_ikan }}</td>
                            <td class="text-end">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                {{ $item->qty }}
                            </td>
                            <td class="text-end">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end">Total</td>
                        <td class="text-end">
                            Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Footer kecil --}}
        <div class="receipt-footer">
            Terima kasih telah berbelanja di FourzFish 🐠<br>
            Ikan sehat, aquascape makin hidup!
        </div>
    </div>
</div>
@endsection
