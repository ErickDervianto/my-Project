<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CampusConnect</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="login-body">
    <div class="login-container">
        <a href="{{ route('landingpage') }}" class="back-button"><i class="fas fa-arrow-left"></i> Kembali</a>
        <div class="login-brand">
            <div class="brand-logo"><i class="fas fa-graduation-cap"></i></div>
            <h2 class="brand-text">CampusConnect</h2>
        </div>
        <div class="login-box">
            <h1 class="login-title">Masuk ke Akun Anda</h1>

            @if ($errors->any())
                <div style="color: red; margin-bottom: 1rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                 <div style="color: green; margin-bottom: 1rem;">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                 <div style="color: red; margin-bottom: 1rem;">{{ session('error') }}</div>
            @endif

            <p style="text-align: center; color: #888; margin-bottom: 1rem;">Khusus Admin / Superadmin</p>
            <form action="{{ route('login.post') }}" method="POST" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input" placeholder="admin@campus.ac.id" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn-login">Masuk</button>
            </form>

            <div style="text-align: center; margin: 20px 0;">
                <p style="color: #999; font-size: 0.9rem;">atau</p>
            </div>
            
            <p style="text-align: center; color: #888; margin-bottom: 1rem;">Khusus Mahasiswa</p>
            <div class="google-login">
                <a href="{{ route('google.redirect') }}" class="btn-google">
                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" class="google-icon">
                    <span>Sign in with Google</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>