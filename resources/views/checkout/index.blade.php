@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
    <div class="row g-4">
        {{-- Ringkasan keranjang --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">Ringkasan Keranjang</h4>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Ikan</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if(!empty($item['gambar']))
                                                    <img src="{{ asset('storage/' . $item['gambar']) }}"
                                                         alt="{{ $item['nama'] }}"
                                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                                                @endif
                                                <span>{{ $item['nama'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item['qty'] }}
                                        </td>
                                        <td class="text-end">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    <td class="text-end fw-bold">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('keranjang.index') }}" class="btn btn-sm btn-ff-outline">
                            ← Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form data pelanggan --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">Data Pelanggan</h4>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_pelanggan"
                                   class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                   value="{{ old('nama_pelanggan', $user->name ?? '') }}" required>
                            @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="no_hp"
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   value="{{ old('no_hp') }}">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror"
                                      placeholder="Tuliskan alamat lengkap pengiriman...">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                            {{-- Metode Pembayaran --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select">
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                                    Transfer Bank
                                </option>
                                <option value="ewallet" {{ old('metode_pembayaran') == 'ewallet' ? 'selected' : '' }}>
                                    E-Wallet (OVO / DANA / Gopay)
                                </option>
                                <option value="cod" {{ old('metode_pembayaran') == 'cod' ? 'selected' : '' }}>
                                    COD (Bayar di Tempat)
                                </option>
                            </select>
                        </div>

                        {{-- Kurir Pengiriman --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Kurir Pengiriman</label>
                            <select name="kurir" class="form-select">
                                <option value="">-- Pilih Kurir --</option>
                                <option value="jne" {{ old('kurir') == 'jne' ? 'selected' : '' }}>JNE</option>
                                <option value="jnt" {{ old('kurir') == 'jnt' ? 'selected' : '' }}>J&amp;T</option>
                                <option value="sicepat" {{ old('kurir') == 'sicepat' ? 'selected' : '' }}>SiCepat</option>
                                <option value="anteraja" {{ old('kurir') == 'anteraja' ? 'selected' : '' }}>AnterAja</option>
                                <option value="ambil_toko" {{ old('kurir') == 'ambil_toko' ? 'selected' : '' }}>
                                    Ambil di Toko
                                </option>
                            </select>
                        </div>

                        {{-- Tombol submit --}}
                        <button type="submit" class="btn btn-primary w-100">
                            Konfirmasi &amp; Proses Pesanan
                        </button>


                       
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
