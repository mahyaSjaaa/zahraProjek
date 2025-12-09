<style>
    .ff-navbar {
        background: #068f8f; /* hijau kebiruan khas FourzFish */
        padding: 0.6rem 0;
        border-bottom: 3px solid rgba(255,255,255,0.1);
    }

    .ff-brand {
        font-size: 1.45rem;
        letter-spacing: 0.5px;
    }
    .text-primary-custom {
        color: #e0f7f7 !important;
    }

    .ff-navlinks .nav-link {
        color: #e8f8f8;
        padding: 0.55rem 1rem;
        border-radius: 10px;
        transition: 0.25s;
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .ff-navlinks .nav-link:hover {
        background: rgba(255,255,255,0.12);
        color: white;
    }

    .ff-navlinks .nav-link.active {
        background: rgba(255,255,255,0.25);
        color: #fff;
        font-weight: 700;
        border-bottom: 2px solid #ffffff;
    }

    .cart-badge {
        background: #ef4444;
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 999px;
        margin-left: 4px;
    }

    /* User menu */
    .ff-user-dropdown {
        color: #ffffff;
        font-weight: 500;
    }
    .ff-user-dropdown:hover {
        color: #f9f9f9;
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
        .ff-navbar {
            padding: 0.4rem 0;
        }

        .ff-navlinks .nav-link {
            border-radius: 8px;
            margin-bottom: 4px;
        }
    }
</style>


<nav class="ff-navbar navbar navbar-expand-lg shadow-sm">
    <div class="container">

        {{-- Brand --}}
        <a class="navbar-brand fw-bold ff-brand" href="{{ route('home') }}">
            <span>Fourz</span><span class="text-primary-custom">Fish</span>
        </a>

        {{-- Toggler --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbarMenu">

            {{-- Left --}}
            <ul class="navbar-nav ms-lg-4 gap-lg-2 ff-navlinks">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i> Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('katalog.*') ? 'active' : '' }}"
                       href="{{ route('katalog.index') }}">
                        <i class="bi bi-grid me-1"></i> Katalog Ikan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('keranjang.*') ? 'active' : '' }}"
                       href="{{ route('keranjang.index') }}">
                        <i class="bi bi-cart3 me-1"></i> Keranjang
                        @if(session('cart_count'))
                            <span class="cart-badge">{{ session('cart_count') }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            {{-- Right --}}
            <ul class="navbar-nav ms-auto ff-user-area">

                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light ff-login-btn">
                            Login
                        </a>
                    </li>
                @else

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ff-user-dropdown" href="#" role="button"
                           data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            Hai, {{ explode(' ', Auth::user()->name)[0] }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm ff-user-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person-lines-fill me-2"></i> Profil
                                </a>
                            </li>

                            @if(auth()->user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.ikan.index') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @endguest

            </ul>

        </div>
    </div>
</nav>
