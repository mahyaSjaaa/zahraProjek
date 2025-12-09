@extends('layouts.app')
@section('title', 'Checkout Berhasil')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h3 class="fw-bold mb-3">Terima kasih! 🎉</h3>
            <p class="mb-1">
                Pesanan kamu telah berhasil dibuat.
            </p>
            <p class="mb-3">
                <strong>Kode Transaksi:</strong> {{ $transaksi->kode }}<br>
                <strong>Total:</strong> Rp {{ number_format($transaksi->total, 0, ',', '.') }}
            </p>

            <a href="{{ route('home') }}" class="btn btn-ff-primary me-2">
                Kembali ke Beranda
            </a>
            <a href="{{ route('katalog.index') }}" class="btn btn-ff-outline">
                Lanjut Belanja
            </a>
            <a href="{{ route('transaksi.struk', $transaksi) }}" class="btn btn-ff-primary me-2">
                Cetak Struk
            </a>
            <a href="{{ route('katalog.index') }}" class="btn btn-ff-outline">
                Lanjut Belanja
            </a>

        </div>
    </div>
@endsection
