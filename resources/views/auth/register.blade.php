<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FourzFish</title>
    <style>
        :root {
            --shells: #F0EBD8;
            --sand-castle: #BB7E5D;
            --salt-air: #B3D9E0;
            --aquascape: #0CA4A5;
            --ocean-waves: #0892A5;
            --deep-dive: #06908F;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: radial-gradient(circle at top left, var(--salt-air), var(--aquascape)),
                        linear-gradient(135deg, var(--aquascape), var(--deep-dive));
            background-blend-mode: screen, normal;
        }

        .register-container {
            background: rgba(240, 235, 216, 0.95); /* shells semi transparan */
            border-radius: 24px;
            box-shadow: 0 18px 60px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            max-width: 950px;
            width: 100%;
            display: flex;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .register-left {
            flex: 1.1;
            padding: 55px 40px;
            background: linear-gradient(
                145deg,
                rgba(8, 146, 165, 0.98),
                rgba(6, 144, 143, 0.96)
            );
            color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(179, 217, 224, 0.24);
            filter: blur(2px);
        }

        .bubble.b1 { width: 120px; height: 120px; top: 8%; left: 10%; }
        .bubble.b2 { width: 90px; height: 90px; bottom: 18%; right: -10%; }
        .bubble.b3 { width: 60px; height: 60px; bottom: 5%; left: 30%; }

        .fish-icon {
            font-size: 3.8rem;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .register-left h1 {
            font-size: 2.4rem;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .register-left h1 span {
            color: var(--salt-air);
        }

        .register-left p {
            font-size: 1rem;
            line-height: 1.7;
            opacity: 0.95;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .highlight-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(240, 235, 216, 0.18);
            border: 1px solid rgba(240, 235, 216, 0.5);
            font-size: 0.8rem;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
        }

        .features {
            list-style: none;
            margin-top: 8px;
            position: relative;
            z-index: 1;
        }

        .features li {
            margin-bottom: 10px;
            padding-left: 26px;
            font-size: 0.92rem;
            position: relative;
        }

        .features li::before {
            content: "✓";
            position: absolute;
            left: 0;
            font-weight: 700;
            color: var(--salt-air);
        }

        .register-right {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--shells);
        }

        .register-card {
            width: 100%;
            max-width: 380px;
        }

        .register-card h2 {
            color: #333;
            margin-bottom: 8px;
            font-size: 2rem;
        }

        .register-card > p {
            color: #666;
            margin-bottom: 22px;
            font-size: 0.95rem;
        }

        .error-message {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 11px 13px;
            border: 2px solid #e0e0e0;
            border-radius: 9px;
            font-size: 0.95rem;
            transition: border-color 0.25s, box-shadow 0.25s;
            background-color: var(--white);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--aquascape);
            box-shadow: 0 0 0 3px rgba(12, 164, 165, 0.15);
        }

        .form-group input.error {
            border-color: #e74c3c;
        }

        .error-text {
            color: #e74c3c;
            font-size: 0.8rem;
            margin-top: 4px;
        }

        .btn-register {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--aquascape), var(--deep-dive));
            color: var(--white);
            border: none;
            border-radius: 9px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.18s, box-shadow 0.18s;
            box-shadow: 0 10px 25px rgba(6, 144, 143, 0.35);
        }

        .btn-register:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 12px 30px rgba(6, 144, 143, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
            box-shadow: 0 6px 18px rgba(6, 144, 143, 0.35);
        }

        .login-link {
            text-align: center;
            margin-top: 18px;
            color: #666;
            font-size: 0.9rem;
        }

        .login-link a {
            color: var(--deep-dive);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .small-note {
            font-size: 0.8rem;
            color: #999;
            margin-top: 10px;
            text-align: center;
        }

        @media (max-width: 960px) {
            .register-container {
                flex-direction: column;
            }

            .register-left,
            .register-right {
                padding: 40px 30px;
            }

            .register-left {
                order: -1;
            }
        }

        @media (max-width: 480px) {
            .register-left h1 {
                font-size: 2rem;
            }

            .register-card h2 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-left">
            <div class="bubble b1"></div>
            <div class="bubble b2"></div>
            <div class="bubble b3"></div>

            <span class="highlight-badge">Bergabung dengan komunitas pecinta ikan hias</span>
            <div class="fish-icon">°‧ 𓆝 𓆟 𓆞 ·｡</div>
            <h1>Daftar di <span>FourzFish</span></h1>
            <p>
                Buat akun baru dan mulai jelajahi koleksi ikan hias, perlengkapan
                aquascape, dan berbagai kebutuhan akuarium lainnya.
            </p>

            <ul class="features">
                <li>Katalog ikan hias yang beragam</li>
                <li>Transaksi cepat dan aman</li>
                <li>Riwayat pesanan tersimpan rapi</li>
                <li>Laporan pembelian untuk memantau belanja</li>
            </ul>
        </div>

        <div class="register-right">
            <div class="register-card">
                <h2>Buat Akun Baru</h2>
                <p>Isi data di bawah ini untuk mulai belanja di FourzFish</p>

                @if ($errors->any())
                    <div class="error-message">
                        <strong>Terjadi kesalahan:</strong>
                        <ul style="margin-top: 8px; margin-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="register-form" method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            class="@error('name') error @enderror">
                        @error('name')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="@error('email') error @enderror">
                        @error('email')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            class="@error('password') error @enderror">
                        @error('password')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required>
                    </div>

                    <button type="submit" class="btn-register">
                        Daftar Sekarang
                    </button>
                </form>

                <div class="login-link">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login di sini</a>
                </div>

                <div class="small-note">
                    Dengan mendaftar, kamu menyetujui ketentuan penggunaan FourzFish.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
