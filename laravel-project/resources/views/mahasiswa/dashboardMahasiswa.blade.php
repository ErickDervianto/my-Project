<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-left">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
                <div class="header-title-section">
                    <h1>Dashboard</h1>
                </div>
            </div>
            <div class="header-right">
                <div class="user-profile-header">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ explode(' ', $nama)[0] }}</span>
                </div>
            </div>
        </div>
    </header>

    <main class="dashboard-main">
        <div class="dashboard-container">
            @if(session('success'))
                <div class="alert-dashboard" style="background-color: #E8F5E9; border-color: #A5D6A7;">
                    <i class="fas fa-check-circle" style="color: #2E7D32;"></i>
                    <p style="color: #2E7D32;">{{ session('success') }}</p>
                </div>
            @endif

            <div class="profile-card-dashboard">
                 <div class="profile-header-dash">
                    <div class="profile-info-dash">
                        <h2>{{ $nama }}</h2>
                        <div class="profile-details">
                            <span class="profile-detail-item"><i class="fas fa-id-card"></i> NIM: {{ $nim ?? 'Belum diisi' }}</span>
                            <span class="profile-detail-item"><i class="fas fa-graduation-cap"></i> Semester {{ $semester ?? 'N/A' }} - IPK {{ $ipk ?? 'N/A' }}</span>
                        </div>
                        <div class="profile-badges">
                             <span class="badge-verified"><i class="fas fa-check-circle"></i> Terverifikasi {{ $prodi ?? '' }}</span>
                             <span class="badge-complete"><i class="fas fa-check-circle"></i> Profil {{ $profile_completion }}% lengkap</span>
                        </div>
                    </div>
                </div>
                 <div class="profile-actions">
                    <p class="profile-action-text">Lengkapi profil untuk mempermudah pendaftaran.</p>
                     <a href="{{ route('mahasiswa.profile.edit') }}" class="btn-edit-profile"><i class="fas fa-edit"></i> Edit Profil</a>
                </div>
            </div>
            
            <div class="quick-actions-section">
                 <h3 class="section-title-dash">Aksi Cepat</h3>
                 <div class="quick-actions-grid">
                    <div class="action-card">
                         <a href="{{ route('mahasiswa.org.step1') }}" style="text-decoration:none; color:inherit; display:block; padding: 20px;">
                            <h4>Daftar Organisasi</h4>
                            <p>Bergabung dengan organisasi kampus</p>
                         </a>
                    </div>
                     <div class="action-card">
                         <a href="{{ route('mahasiswa.vol.step1') }}" style="text-decoration:none; color:inherit; display:block; padding: 20px;">
                            <h4>Volunteer Event</h4>
                            <p>Ikut serta dalam event kampus</p>
                         </a>
                    </div>
                 </div>
            </div>

            {{-- Bagian Pendaftaran Organisasi --}}
            <div class="registration-history-section" style="margin-top: 40px;">
                <h3 class="section-title-dash">Status Pendaftaran Organisasi</h3>
                @forelse($orgRegistrations as $registration)
                    <div class="profile-card-dashboard" style="margin-top: 20px;">
                        <div class="profile-header-dash" style="margin-bottom: 0;">
                            <div class="profile-info-dash">
                                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                    <h2>{{ $registration->organization->name }}</h2>
                                    <span class="status-badge status-{{$registration->status}}">{{ $registration->status }}</span>
                                </div>
                                <div class="profile-details" style="margin-top: 10px;">
                                    <span class="profile-detail-item"><i class="fas fa-calendar-alt"></i> Daftar: {{ $registration->created_at->format('d M Y') }}</span>
                                    @if($registration->status == 'approved' && $registration->accepted_division)
                                        <span class="profile-detail-item" style="color: #2E7D32; font-weight: bold;">
                                            <i class="fas fa-check-circle"></i> Diterima di: {{ $registration->accepted_division }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="profile-actions"><p class="profile-action-text">Cek detail pendaftaran dan pengumuman.</p><a href="{{ route('mahasiswa.pendaftaran.detail', $registration->id) }}" class="btn-edit-profile"><i class="fas fa-eye"></i> Detail</a></div>
                    </div>
                @empty
                    <p>Anda belum pernah mendaftar ke organisasi manapun.</p>
                @endforelse
            </div>

            {{-- ===== BAGIAN BARU UNTUK PENDAFTARAN VOLUNTEER ===== --}}
            <div class="registration-history-section" style="margin-top: 40px;">
                <h3 class="section-title-dash">Status Pendaftaran Volunteer</h3>
                @forelse($volRegistrations as $registration)
                    <div class="profile-card-dashboard" style="margin-top: 20px;">
                        <div class="profile-header-dash" style="margin-bottom: 0;">
                            <div class="profile-info-dash">
                                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                    <h2>{{ $registration->event->name }}</h2>
                                    <span class="status-badge status-{{$registration->status}}">{{ $registration->status }}</span>
                                </div>
                                <div class="profile-details" style="margin-top: 10px;">
                                    <span class="profile-detail-item"><i class="fas fa-calendar-alt"></i> Daftar: {{ $registration->created_at->format('d M Y') }}</span>
                                    @if($registration->status == 'approved' && $registration->accepted_role)
                                        <span class="profile-detail-item" style="color: #2E7D32; font-weight: bold;">
                                            <i class="fas fa-check-circle"></i> Diterima sebagai: {{ $registration->accepted_role }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="profile-actions"><p class="profile-action-text">Cek detail pendaftaran event.</p><a href="{{ route('mahasiswa.pendaftaran_volunteer.detail', $registration->id) }}" class="btn-edit-profile"><i class="fas fa-eye"></i> Detail</a></div>
                    </div>
                @empty
                    <p>Anda belum pernah mendaftar sebagai volunteer.</p>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>