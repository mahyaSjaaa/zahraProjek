<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk {{ $transaksi->kode }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
        }
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }
        .brand {
            font-size: 16px;
            font-weight: 700;
        }
        .subtitle {
            font-size: 10px;
            color: #6b7280;
        }
        .info-table {
            width: 100%;
            margin-bottom: 8px;
        }
        .info-table td {
            vertical-align: top;
            font-size: 10px;
            padding: 2px 0;
        }
        .label {
            color: #6b7280;
            width: 110px;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        table.items th,
        table.items td {
            border: 1px solid #e5e7eb;
            padding: 4px;
            font-size: 10px;
        }
        table.items th {
            background: #f3f4f6;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 10px;
            border-top: 1px dashed #e5e7eb;
            padding-top: 6px;
            font-size: 9px;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>
<body>
@php
    $mapPembayaran = [
        'transfer' => 'Transfer Bank',
        'ewallet'  => 'E-Wallet',
        'cod'      => 'COD (Bayar di Tempat)',
    ];
    $labelPembayaran = $mapPembayaran[$transaksi->metode_pembayaran] ?? ucfirst($transaksi->metode_pembayaran);

    $mapKurir = [
        'jne'        => 'JNE',
        'jnt'        => 'J&T',
        'sicepat'    => 'SiCepat',
        'anteraja'   => 'AnterAja',
        'ambil_toko' => 'Ambil di Toko',
    ];
    $labelKurir = $mapKurir[$transaksi->kurir] ?? ucfirst(str_replace('_', ' ', $transaksi->kurir));
@endphp

<div class="wrapper">
    <div class="header">
        <div class="brand">FourzFish</div>
        <div class="subtitle">
            Toko Ikan Hias Online<br>
            Struk Transaksi · {{ $transaksi->kode }} · {{ $transaksi->created_at->format('d M Y H:i') }}
        </div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Pelanggan</td>
            <td>: {{ $transaksi->nama_pelanggan }}</td>
        </tr>
        <tr>
            <td class="label">No. HP</td>
            <td>: {{ $transaksi->no_hp ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td>: {{ $transaksi->alamat ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Metode Pembayaran</td>
            <td>: {{ $labelPembayaran }}</td>
        </tr>
        <tr>
            <td class="label">Kurir Pengiriman</td>
            <td>: {{ $labelKurir }}</td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th>Ikan</th>
                <th style="width: 20%;" class="text-right">Harga</th>
                <th style="width: 10%;" class="text-center">Qty</th>
                <th style="width: 20%;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transaksi->items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_ikan }}</td>
                <td class="text-right">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="text-center">{{ $item->qty }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-right"><strong>Total</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
        </tr>
        </tbody>
    </table>

    <div class="footer">
        Terima kasih telah berbelanja di FourzFish. 🐠<br>
        Simpan struk ini sebagai bukti transaksi yang sah.
    </div>
</div>
</body>
</html>
