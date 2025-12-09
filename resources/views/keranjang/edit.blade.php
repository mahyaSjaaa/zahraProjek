@extends('layouts.app')

@section('title', 'Edit Keranjang')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2 class="mb-3">Ubah Jumlah Ikan di Keranjang</h2>

            {{-- Alert flash message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-bold mb-1">Terjadi kesalahan:</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- Form update qty --}}
                    {{-- Pastikan route-nya: Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update'); --}}
                    <form action="{{ route('keranjang.update', $id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Jika ada gambar --}}
                        @if (!empty($item['gambar']))
                            <div class="mb-3 text-center">
                                <img src="{{ $item['gambar'] }}"
                                     alt="{{ $item['nama'] }}"
                                     class="img-fluid"
                                     style="max-height: 180px; object-fit: cover;">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Nama Ikan</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $item['nama'] ?? '-' }}"
                                   disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Satuan</label>
                            <input type="text"
                                   class="form-control"
                                   value="Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}"
                                   disabled>
                        </div>

                        <div class="mb-3">
                            <label for="qty" class="form-label">Jumlah</label>
                            <input
                                type="number"
                                name="qty"
                                id="qty"
                                class="form-control @error('qty') is-invalid @enderror"
                                value="{{ old('qty', $item['qty'] ?? 1) }}"
                                min="1"
                                step="1"
                                required
                            >
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subtotal Sekarang</label>
                            <input type="text"
                                   class="form-control"
                                   value="Rp {{ number_format($item['subtotal'] ?? (($item['harga'] ?? 0) * ($item['qty'] ?? 1)), 0, ',', '.') }}"
                                   disabled>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('keranjang.index') }}" class="btn btn-outline-secondary">
                                &laquo; Kembali ke Keranjang
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
