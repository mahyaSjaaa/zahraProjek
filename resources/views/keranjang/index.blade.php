@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Keranjang Belanja</h2>
            <p class="text-muted mb-0">Cek kembali ikan yang akan kamu beli.</p>
        </div>

        @if(!empty($cart))
            <form action="{{ route('keranjang.clear') }}" method="POST"
                  onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    Kosongkan Keranjang
                </button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($cart))
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <p class="mb-3">Keranjang kamu masih kosong.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-ff-primary">
                    Cari Ikan Hias
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Ikan</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center" style="width: 160px;">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Aksi</th>
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
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $item['nama'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('keranjang.update', $item['id']) }}" method="POST" class="d-inline-flex gap-2 justify-content-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="qty" value="{{ $item['qty'] }}"
                                               min="0" class="form-control form-control-sm" style="width: 70px;">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            Update
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('keranjang.hapus', $item['id']) }}" method="POST"
                                          onsubmit="return confirm('Hapus ikan ini dari keranjang?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="text-end fw-bold">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-end">
            <a href="{{ route('checkout.index') }}" class="btn btn-lg btn-ff-primary">
                Checkout
            </a>
        </div>
    @endif
@endsection
