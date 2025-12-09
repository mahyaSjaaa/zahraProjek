<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | FourzFish</title>

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom App CSS --}}
    <style>
        body {
            background: #f0ebd8;
        }

        /* ======================
           NAVBAR BARU
        ====================== */
        .ff-navbar {
            background: #068f8f;
            padding: 0.6rem 0;
            border-bottom: 3px solid rgba(255,255,255,0.1);
        }

        .ff-brand {
            font-size: 1.45rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff !important;
        }
        .ff-brand span.text-primary-custom {
            color: #d9fafa !important;
        }

        .ff-navlinks .nav-link {
            color: #e8f8f8;
            font-weight: 500;
            padding: 0.55rem 1rem;
            border-radius: 10px;
            transition: 0.25s;
            display: flex;
            align-items: center;
        }

        .ff-navlinks .nav-link:hover {
            background: rgba(255,255,255,0.12);
            color: #ffffff;
        }

        .ff-navlinks .nav-link.active {
            background: rgba(255,255,255,0.25);
            border-bottom: 2px solid #ffffff;
            font-weight: 700;
            color: #fff;
        }

        .cart-badge {
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            padding: 1px 6px;
            border-radius: 999px;
            margin-left: 4px;
        }

        /* User dropdown */
        .ff-user-dropdown {
            color: #ffffff !important;
            font-weight: 500;
        }
        .ff-user-dropdown:hover {
            color: #f9f9f9 !important;
        }

        .ff-user-menu {
            border-radius: 12px;
            overflow: hidden;
        }

        .ff-login-btn {
            border-radius: 999px;
            padding: 0.45rem 1rem;
            color: #ffffff;
            border-color: rgba(255,255,255,0.5);
        }
        .ff-login-btn:hover {
            background: #ffffff;
            color: #047777;
        }

        @media (max-width: 991px) {
            .ff-navbar { padding: 0.45rem 0; }
            .ff-navlinks .nav-link {
                margin-bottom: 4px;
            }
        }

    </style>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'FourzFish')</title>

    {{-- Bootstrap 5 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- CSS global FourzFish (kalau ada) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body style="background:#f3f4f6;">

{{-- ====================== NAVBAR ====================== --}}
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#048b8b;">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            FourzFish
        </a>

        {{-- Toggler mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="mainNavbar">
            {{-- LEFT: Link utama --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                {{-- Beranda --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        <span class="me-1">🏠</span> Beranda
                    </a>
                </li>

                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('katalog.*') ? 'active' : '' }}"
                       href="{{ route('katalog.index') }}">
                        <span class="me-1">📚</span> Katalog Ikan
                    </a>
                </li>

                {{-- Keranjang --}}
                <li class="nav-item">
                    @auth
                        <a class="nav-link {{ request()->routeIs('keranjang.*') ? 'active' : '' }}"
                           href="{{ route('keranjang.index') }}">
                            <span class="me-1">🛒</span> Keranjang
                            @if(session('cart_count', 0) > 0)
                                <span class="badge bg-light text-dark ms-1">
                                    {{ session('cart_count') }}
                                </span>
                            @endif
                        </a>
                    @else
                        {{-- Guest: keranjang tidak bisa diakses --}}
                        <span class="nav-link disabled" style="opacity:.6; cursor:not-allowed;">
                            <span class="me-1">🛒</span> Keranjang
                        </span>
                    @endauth
                </li>

            </ul>

            {{-- RIGHT: Auth / User --}}
            <div class="d-flex align-items-center gap-2">
                @guest
                    {{-- Guest: Login & Register --}}
                    <a href="{{ route('login') }}"
                       class="btn btn-light btn-sm rounded-pill px-3">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="btn btn-outline-light btn-sm rounded-pill px-3">
                        Register
                    </a>
                @else
                    {{-- User: dropdown profil + logout --}}
                    <div class="dropdown">
                        <button
                            class="btn btn-outline-light btn-sm rounded-pill d-flex align-items-center gap-2"
                            id="userDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <span class="fw-bold">
                                {{ \Illuminate\Support\Str::limit(Auth::user()->name, 14) }}
                            </span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                            aria-labelledby="userDropdown">

                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    Profil 
                                </a>
                            </li>

                            {{-- Opsional: menu admin kalau role = admin --}}
                            @if(auth()->user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.ikan.index') }}">
                                        Kelola Ikan

                                        </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider"></li>

                            {{-- Logout --}}
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
{{-- ==================== /NAVBAR ==================== --}}

{{-- FLASH MESSAGE (success / error / dsb) --}}
<div class="container mt-3">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif
</div>

{{-- KONTEN UTAMA --}}
<main class="py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

{{-- FOOTER --}}
<footer class="text-center text-muted py-3 mt-4" style="font-size:0.85rem;">
    © {{ date('Y') }} FourzFish
</footer>

{{-- Bootstrap JS (perlu untuk dropdown) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
