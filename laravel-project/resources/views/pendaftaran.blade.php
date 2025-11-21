@php
    use App\Models\Organization;
    use App\Models\Event;
    
    // PERBAIKAN 1: Mengubah ->get() menjadi ->paginate(3) untuk membatasi 3 item per halaman
    $organizations = Organization::where('is_open', true)->latest()->paginate(3, ['*'], 'orgPage');
    $events = Event::where('is_open', true)->latest()->paginate(3, ['*'], 'eventPage');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pendaftaran Mahasiswa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <a href="/" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </header>

    <section class="hero-section-portal">
        <div class="hero-content-portal">
            <h1 class="hero-title-portal">Portal Pendaftaran Mahasiswa</h1>
            <p class="hero-subtitle-portal">Bergabunglah dengan organisasi kampus atau menjadi volunteer event</p>
        </div>
    </section>

    <section class="main-content">
        <div class="content-container">
            <div class="content-column">
                <div class="column-header">
                    <i class="fas fa-users"></i>
                    <h2>Pendaftaran Anggota Organisasi</h2>
                </div>
                <p class="column-description">Daftar untuk menjadi anggota organisasi kampus resmi</p>

                <div class="card-list">
                    @forelse($organizations as $org)
                    <div class="registration-card">
                        <div class="card-content">
                            <h3 class="card-title">{{ $org->name }}</h3>
                            <p class="card-description">{{ Str::limit($org->description, 100) }}</p>
                            <div class="card-meta">
                                <span class="meta-item">
                                    <i class="far fa-calendar"></i> Deadline: {{ $org->deadline->format('d F Y') }}
                                </span>
                            </div>
                        </div>
                        <span class="card-status status-open">Dibuka</span>
                    </div>
                    @empty
                        <p style="padding: 0 30px;">Tidak ada pendaftaran organisasi yang dibuka saat ini.</p>
                    @endforelse
                </div>

                {{-- PERBAIKAN 2: Menambahkan link navigasi halaman untuk organisasi --}}
                <div class="pagination-container" style="padding: 0 30px;">
                    {{ $organizations->links() }}
                </div>
                
                <a class="btn-view-all" href="{{ route('mahasiswa.org.step1') }}">
                    <i class="fas fa-list"></i> Daftar Anggota Organisasi
                </a>
            </div>

            <div class="content-column">
                <div class="column-header">
                    <i class="far fa-calendar-alt"></i>
                    <h2>Pendaftaran Volunteer Event </h2>
                </div>
                <p class="column-description">Daftar sebagai volunteer untuk berbagai event kampus</p>
                <div class="card-list">
                    @forelse($events as $event)
                    <div class="registration-card">
                        <div class="card-content">
                            <h3 class="card-title">{{ $event->name }}</h3>
                            <p class="card-description">{{ Str::limit($event->description, 100) }}</p>
                            <div class="card-meta">
                                <span class="meta-item">
                                    <i class="far fa-calendar"></i> Deadline: {{ $event->deadline->format('d F Y') }}
                                </span>
                            </div>
                        </div>
                        <span class="card-status status-open">Dibuka</span>
                    </div>
                    @empty
                         <p style="padding: 0 30px;">Tidak ada pendaftaran volunteer yang dibuka saat ini.</p>
                    @endforelse
                </div>

                {{-- PERBAIKAN 3: Menambahkan link navigasi halaman untuk event --}}
                <div class="pagination-container" style="padding: 0 30px;">
                    {{ $events->links() }}
                </div>

                <a class="btn-view-all" href="{{ route('mahasiswa.vol.step1') }}">
                    <i class="far fa-calendar-alt" ></i> Daftar Volunteer Event
                </a>
            </div>
        </div>
    </section>
    
    <section class="benefits-section">
        </section>
    <footer class="portal-footer">
        <p>Sudah memiliki akun? <a href="{{ route('login') }}" class="footer-link">Login di sini</a></p>
    </footer>
</body>
</html>