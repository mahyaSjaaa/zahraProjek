@extends('layouts.app')
@section('title', 'Beranda')

@push('styles')
<style>
    /* ===== HERO WRAPPER ===== */
    .hero-section {
        background: linear-gradient(
            135deg,
            rgba(var(--ff-primary-rgb, 59, 130, 246), 0.04) 0%,
            rgba(var(--ff-primary-rgb, 59, 130, 246), 0.09) 100%
        );
        border-radius: 24px;
        padding: 3.5rem 2.5rem;
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -45%;
        right: -10%;
        width: 520px;
        height: 520px;
        background: radial-gradient(
            circle,
            rgba(var(--ff-primary-rgb, 59, 130, 246), 0.12) 0%,
            transparent 70%
        );
        border-radius: 50%;
        opacity: 0.9;
        animation: hero-float 6s ease-in-out infinite;
    }

    @keyframes hero-float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50%      { transform: translateY(-16px) rotate(3deg); }
    }

    .hero-title {
        font-size: clamp(2.4rem, 5vw, 3.6rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.75rem;
        color: #111827;
    }

    .hero-subtitle {
        color: #4b5563;
        font-size: 1.15rem;
    }

    .hero-highlight {
        color: #111827;
        position: relative;
        display: inline-block;
    }

    .hero-highlight::after {
        content: '';
        position: absolute;
        bottom: 6px;
        left: 0;
        width: 100%;
        height: 14px;
        background: rgba(147, 197, 253, 0.8); /* biru lembut di bawah teks */
        z-index: -1;
        border-radius: 6px;
    }

    .badge-new {
        display: inline-block;
        background: #10b981;
        color: white;
        padding: 0.25rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-left: 0.5rem;
    }

    /* ===== LIST CHECK ===== */
    .check-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .check-list li {
        padding: 0.75rem 0;
        padding-left: 2.4rem;
        position: relative;
        font-size: 1.02rem;
        color: #4b5563;
    }

    .check-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        top: 0.7rem;
        width: 26px;
        height: 26px;
        background: #e5f3ff;
        color: #2563eb;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* ===== CTA BUTTON ===== */
    .cta-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1.05rem 3rem;
        font-size: 1.05rem;
        font-weight: 700;
        border-radius: 999px;
        border: none;
        background: #12a0a0;
        color: #ffffff;
        text-decoration: none;
        box-shadow:
            0 14px 30px rgba(0,0,0,0.18),
            0 0 0 1px rgba(255,255,255,0.4);
        transition: all 0.25s ease;
    }

    .cta-button:hover {
        transform: translateY(-3px);
        box-shadow:
            0 18px 40px rgba(0,0,0,0.22),
            0 0 0 1px rgba(255,255,255,0.6);
        color: #ffffff;
    }

    /* ===== INFO CARD KANAN ===== */
    .info-card {
        border: none;
        border-radius: 28px;
        background: #ffffff;
        box-shadow: 0 18px 45px rgba(0,0,0,0.12);
        overflow: hidden;
        padding: 2.2rem 2rem 2rem;
        min-height: 100%;
    }

    .info-pin-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 1.6rem;
    }

    .info-pin {
        width: 46px;
        height: 46px;
        border-radius: 999px;
        background: #fee2e2;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .info-list {
        border-top: 1px solid #f3f4f6;
        margin-top: 0.5rem;
        padding-top: 0.5rem;
    }

    .info-item {
        padding: 1.1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0.4rem;
    }

    .info-label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: #9ca3af;
        margin-bottom: 0.2rem;
    }

    .info-value {
        font-weight: 700;
        color: #111827;
        font-size: 1rem;
    }

    .info-alert {
        background: #ecfdf5;
        border-radius: 16px;
        border-left: 4px solid #10b981;
        padding: 0.9rem 1rem;
        color: #065f46;
        line-height: 1.6;
        font-size: 0.9rem;
        margin-top: 1.2rem;
    }

    /* ===== FEATURE CARDS ===== */
    .feature-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: #ffffff;
        height: 100%;
        overflow: hidden;
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.12);
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(
            135deg,
            var(--ff-primary) 0%,
            rgba(var(--ff-primary-rgb, 59, 130, 246), 0.7) 100%
        );
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.4rem;
        font-size: 1.7rem;
        color: #ffffff;
        transition: transform 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.05) rotate(4deg);
    }

    .feature-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #111827;
    }

    .feature-text {
        line-height: 1.7;
        color: #6b7280;
        font-size: 0.95rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
    }

    .section-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 2.4rem 1.4rem;
        }
    }
</style>
@endpush

@section('content')
    {{-- HERO --}}
    <div class="hero-section">
        <div class="row g-4 align-items-center">
            {{-- Kiri: teks --}}
            <div class="col-lg-7 position-relative" style="z-index: 1;">
                <h1 class="hero-title">
                    Selamat datang di
                    <span class="hero-highlight">FourzFish</span>
                    <span class="badge-new">New</span>
                </h1>

                <p class="hero-subtitle lead mb-4">
                    Toko ikan hias online terpercaya untuk kamu pecinta aquascape dan ikan hias.
                    Pengalaman belanja yang mudah, aman, dan menyenangkan!
                </p>

                <ul class="check-list mb-4">
                    <li>Katalog ikan hias lengkap dengan foto berkualitas tinggi</li>
                    <li>Keranjang belanja dan checkout yang cepat &amp; mudah</li>
                    <li>Cetak struk transaksi otomatis untuk setiap pembelian</li>
                </ul>

                <a href="{{ route('katalog.index') }}" class="cta-button">
                    <span>Mulai Belanja Ikan</span>
                    <svg width="20" height="20" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            {{-- Kanan: kartu info --}}
            <div class="col-lg-5 position-relative" style="z-index: 1;">
                <div class="info-card">
                    <div class="info-pin-wrapper">
                        <div class="info-pin">
                            📍
                        </div>
                    </div>

                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-label">Nama Toko</div>
                            <div class="info-value">FourzFish</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Jenis Usaha</div>
                            <div class="info-value">Toko Ikan Hias Online</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Spesialisasi</div>
                            <div class="info-value">Aquascape &amp; Ikan Hias Rumahan</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Jam Operasional</div>
                            <div class="info-value">Setiap Hari (Online 24/7)</div>
                        </div>
                    </div>

                    <div class="info-alert d-flex align-items-start gap-2">
                        <span style="font-size: 1.2rem;">✨</span>
                        <span>
                            <strong>Garansi Ikan Sehat!</strong><br>
                            Kami kirim ikan sehat langsung ke akuarium kamu dengan pengemasan aman.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3 fitur utama --}}
    <div class="mb-4 text-center">
        <h2 class="section-title mb-2">Kenapa Belanja di FourzFish?</h2>
        <p class="section-subtitle mb-5">
            Tiga keunggulan utama yang membuat belanja ikan hias jadi lebih mudah
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card card shadow-sm">
                <div class="card-body p-4">
                    <div class="feature-icon">🐠</div>
                    <h5 class="feature-title fw-bold mb-3">Katalog Lengkap</h5>
                    <p class="feature-text mb-3">
                        Temukan ikan favoritmu dari berbagai jenis: community fish, predator,
                        hingga ikan aquascape dengan foto detail.
                    </p>
                    <a href="{{ route('katalog.index') }}"
                       class="text-decoration-none fw-semibold"
                       style="color: var(--ff-primary);">
                        Lihat Katalog →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card card shadow-sm">
                <div class="card-body p-4">
                    <div class="feature-icon">🛒</div>
                    <h5 class="feature-title fw-bold mb-3">Transaksi Mudah</h5>
                    <p class="feature-text mb-3">
                        Tambahkan ke keranjang, checkout, dan cetak struk transaksi hanya
                        dalam beberapa klik. Cepat dan praktis!
                    </p>
                    <a href="{{ route('keranjang.index') }}"
                       class="text-decoration-none fw-semibold"
                       style="color: var(--ff-primary);">
                        Cek Keranjang →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card card shadow-sm">
                <div class="card-body p-4">
                    <div class="feature-icon">⚙️</div>
                    <h5 class="feature-title fw-bold mb-3">Panel Admin</h5>
                    <p class="feature-text mb-3">
                        Admin bisa mengelola data ikan, update stok, dan atur harga
                        langsung dari dashboard yang user-friendly.
                    </p>
                    <span class="text-muted">Khusus Admin</span>
                </div>
            </div>
        </div>
    </div>
@endsection
