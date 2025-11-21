<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusConnect - Sistem Rekrutmen Hybrid Kampus</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="brand-badge">
                <span class="brand-icon">🎓</span>
                <span class="brand-name">CampusConnect</span>
            </div>

            <h1 class="hero-title">Sistem Rekrutmen</h1>
            <h2 class="hero-subtitle">Hybrid Kampus</h2>

            <p class="hero-description">
                Platform satu pintu untuk bergabung dengan organisasi kampus dan<br>
                menjadi volunteer event
            </p>

            <div class="hero-buttons">
                <a class="btn-primary-hero" href="{{ route('pendaftaran') }}">Mulai Pendaftaran</a>
                <a class="btn-secondary-hero" href="{{ route('login') }}">Login</a>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="deco deco-1">👁️</div>
        <div class="deco deco-2">🎯</div>
        <div class="deco deco-3">⚙️</div>
    </div>

    <!-- Why Section -->
    <div class="why-section">
        <div class="why-container">
            <h2 class="section-title">Kenapa Memilih CampusConnect?</h2>
            <p class="section-subtitle">
                Sistem terintegrasi yang memudahkan mahasiswa untuk bergabung dengan<br>
                berbagai organisasi dan kegiatan kampus!
            </p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon orange">
                        <svg width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                        </svg>
                    </div>
                    <h3>Organisasi Kampus</h3>
                    <p>Bergabung dengan Senat, BEM, dan Himpunan Mahasiswa melalui proses seleksi yang terstruktur</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon orange">
                        <svg width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                    </div>
                    <h3>Volunteer Event</h3>
                    <p>Daftar sebagai volunteer untuk berbagai event kampus seperti seminar, PPKM, publikasi, dan lomba</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon orange">
                        <svg width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                    </div>
                    <h3>Sertifikat Digital</h3>
                    <p>Dapatkan bukti anggota digital dan sertifikat dengan QR code untuk verifikasi autentik</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <h3 class="stat-number">50+</h3>
                <p class="stat-label">Organisasi Aktif</p>
            </div>
            <div class="stat-item">
                <h3 class="stat-number">1000+</h3>
                <p class="stat-label">Mahasiswa Terdaftar</p>
            </div>
            <div class="stat-item">
                <h3 class="stat-number">200+</h3>
                <p class="stat-label">Event Berlangsung</p>
            </div>
            <div class="stat-item">
                <h3 class="stat-number">5000+</h3>
                <p class="stat-label">Sertifikat Diterbitkan</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <p>© 2024 CampusConnect - Sistem Rekrutmen Hybrid Kampus</p>
            <p class="footer-subtitle">Memudahkan mahasiswa dengan integrasi organisasi dan volunteer</p>
        </div>
    </div>
</body>
</html>
