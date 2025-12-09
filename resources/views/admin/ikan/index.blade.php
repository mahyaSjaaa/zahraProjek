@extends('layouts.app')
@section('title', 'Kelola Ikan')

@push('styles')
<style>
    /* Header halaman */
    .admin-page-title {
        font-weight: 800;
        font-size: 1.5rem;
        color: #111827;
    }

    .admin-page-subtitle {
        font-size: 0.95rem;
        color: #6b7280;
    }

    /* Card pencarian */
    .search-admin-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        background: #ffffff;
    }

    .search-admin-label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.35rem;
        color: #4b5563;
    }

    .search-admin-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: center;
    }

    .search-admin-input {
        min-width: 260px;
        max-width: 360px;
        border-radius: 999px;
        padding: 0.55rem 1rem;
        border: 1.5px solid #e5e7eb;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .search-admin-input:focus {
        border-color: var(--ff-primary);
        box-shadow: 0 0 0 3px rgba(var(--ff-primary-rgb, 59,130,246), 0.15);
        outline: none;
    }

    .search-admin-total {
        font-size: 0.9rem;
        color: #6b7280;
        white-space: nowrap;
    }

    .search-admin-total strong {
        color: #111827;
    }

    /* Tabel ikan */
    .table-ikan-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 4px 18px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table thead th {
        border-bottom-width: 1px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #6b7280;
        background: #f9fafb;
    }

    .table tbody td {
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .thumb-ikan {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    }

    .badge-kategori {
        font-size: 0.75rem;
        padding: 0.18rem 0.55rem;
        border-radius: 999px;
        background: #ecfeff;
        color: #0f766e;
        border: 1px solid #ccfbf1;
    }

    .badge-stok-habis {
        background: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    /* Tombol aksi */
    .btn-aksi {
        font-size: 0.8rem;
        padding: 0.25rem 0.55rem;
        border-radius: 999px;
    }

    .btn-aksi i {
        margin-right: 2px;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 1.25rem;
        gap: 0.2rem;
    }

    .page-item .page-link {
        border-radius: 999px !important;
        padding: 0.3rem 0.75rem;
        font-size: 0.85rem;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .page-item .page-link:hover {
        background-color: rgba(var(--ff-primary-rgb, 59,130,246), 0.08);
        border-color: rgba(var(--ff-primary-rgb, 59,130,246), 0.6);
        color: var(--ff-primary);
    }

    .page-item.active .page-link {
        background-color: var(--ff-primary);
        border-color: var(--ff-primary);
        color: #fff;
    }

    .page-item.disabled .page-link {
        color: #9ca3af;
        background-color: #f9fafb;
    }

    @media (max-width: 768px) {
        .search-admin-card {
            padding: 0.75rem 1rem;
        }

        .search-admin-group {
            width: 100%;
        }

        .search-admin-input {
            flex: 1 1 auto;
            min-width: 0;
        }

        .search-admin-total {
            width: 100%;
            text-align: right;
        }
    }
</style>
@endpush

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="admin-page-title">Kelola Ikan</h2>
        <p class="admin-page-subtitle mb-0">
            Tambah, ubah, dan kelola data ikan yang tampil di katalog FourzFish
        </p>
    </div>
    <div>
        <a href="{{ route('admin.ikan.create') }}" class="btn btn-ff-primary">
            + Tambah Ikan
        </a>
    </div>
</div>

{{-- Pencarian --}}
<div class="card search-admin-card mb-4">
    <div class="card-body py-3 px-4">
        <div class="d-flex flex-wrap justify-content-between gap-3">
            {{-- Kiri: form pencarian --}}
            <div class="flex-grow-1">
                <div class="search-admin-label">Pencarian</div>
                <form action="{{ route('admin.ikan.index') }}" method="GET" class="search-admin-group">
                    <input
                        type="text"
                        name="q"
                        class="form-control search-admin-input"
                        placeholder="Cari nama / kategori ikan..."
                        value="{{ request('q') }}"
                    />

                    <button type="submit" class="btn btn-ff-primary px-4">
                        Cari
                    </button>

                    @if(request('q'))
                        <a href="{{ route('admin.ikan.index') }}" class="btn btn-outline-secondary btn-sm">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Kanan: total data --}}
            <div class="search-admin-total align-self-center ms-auto">
                Total data: <strong>{{ $ikans->total() }}</strong>
            </div>
        </div>
    </div>
</div>

{{-- Tabel data ikan --}}
<div class="card table-ikan-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">Gambar</th>
                    <th>Nama Ikan</th>
                    <th style="width: 140px;">Kategori</th>
                    <th style="width: 120px;" class="text-end">Harga</th>
                    <th style="width: 90px;" class="text-center">Stok</th>
                    <th style="width: 130px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ikans as $ikan)
                    <tr>
                        <td>
                            @if ($ikan->gambar)
                                <img src="{{ asset('storage/' . $ikan->gambar) }}" class="thumb-ikan" alt="{{ $ikan->nama }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center thumb-ikan">
                                    <span class="text-muted">🐟</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $ikan->nama }}</div>
                        </td>
                        <td>
                            @if($ikan->kategori)
                                <span class="badge-kategori">{{ $ikan->kategori }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            Rp {{ number_format($ikan->harga, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if($ikan->stok > 0)
                                <span class="badge-kategori">{{ $ikan->stok }}</span>
                            @else
                                <span class="badge-kategori badge-stok-habis">Habis</span>
                            @endif
                        </td>
                     
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.ikan.edit', $ikan) }}" class="btn btn-outline-primary btn-aksi">
                                    <i class="bi bi-pencil"></i>Edit
                                </a>

                                <form action="{{ route('admin.ikan.destroy', $ikan) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus ikan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-aksi">
                                        <i class="bi bi-trash"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            Belum ada data ikan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($ikans->hasPages())
        <div class="card-body">
            {{ $ikans->onEachSide(1)->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
