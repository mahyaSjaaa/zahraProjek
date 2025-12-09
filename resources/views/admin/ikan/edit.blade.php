@extends('layouts.app')

@section('title', 'Edit Ikan')

@section('content')
<h2 class="mb-3">Edit Data Ikan</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.ikan.update', $ikan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Ikan</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ old('nama', $ikan->nama) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control"
                       value="{{ old('kategori', $ikan->kategori) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" class="form-control"
                       value="{{ old('harga', $ikan->harga) }}" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control"
                       value="{{ old('stok', $ikan->stok) }}" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="form-control">
                    {{ old('deskripsi', $ikan->deskripsi) }}
                </textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Ikan</label><br>
                @if ($ikan->gambar)
                    <img src="{{ asset('storage/' . $ikan->gambar) }}"
                        alt="{{ $ikan->nama }}" width="80" class="mb-2 rounded"><br>
                @endif
                <input type="file" name="gambar" class="form-control">
                <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar.</div>
            </div>

            <button class="btn btn-ff-primary" type="submit">Update</button>
            <a href="{{ route('admin.ikan.index') }}" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection
