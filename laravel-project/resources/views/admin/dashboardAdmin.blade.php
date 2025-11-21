<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - {{ $organizationName }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-title-section"><h1>Admin Dashboard: {{ $organizationName }}</h1></div>
            <form action="{{ route('logout') }}" method="POST"> @csrf <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button></form>
        </div>
        <style>
        .filter-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .filter-bar a {
            padding: 8px 15px;
            text-decoration: none;
            color: #FF5722;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .filter-bar a:hover {
            background-color: #FFF3E0;
        }
        .filter-bar a.active {
            background-color: #FF5722;
            color: white;
            border-color: #FF5722;
        }
    </style>
    </header>

    <main class="dashboard-main">
        <div class="dashboard-container">
            @if(session('success'))
                <div class="alert-dashboard" style="background-color: #E8F5E9; border-color: #A5D6A7; color: #2E7D32;"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
             @if(session('error'))
                <div class="alert-dashboard" style="background-color: #ffdddd; border-color: #f44336; color: #c62828;"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</div>
            @endif
            
            {{-- Bagian Kontrol Admin --}}
            <div class="quick-actions-section" style="margin-bottom: 20px;">
                <div class="quick-actions-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                    {{-- Tombol Buka/Tutup Pendaftaran --}}
                    @if ($organization)
                    <div class="action-card" style="padding: 0;">
                        <form action="{{ route('admin.organization.toggleStatus') }}" method="POST" style="padding: 20px;">
                            @csrf
                            @method('PUT')
                            <h4>Status Pendaftaran</h4>
                            <p>Saat ini: 
                                @if($organization->is_open) <span style="color: green; font-weight: bold;">Dibuka</span> 
                                @else <span style="color: red; font-weight: bold;">Ditutup</span> @endif
                            </p>
                            <button type="submit" class="btn-edit-profile" style="width: 100%; justify-content: center; margin-top: 10px;">
                                @if($organization->is_open) <i class="fas fa-lock"></i> Tutup Sekarang 
                                @else <i class="fas fa-lock-open"></i> Buka Sekarang @endif
                            </button>
                        </form>
                    </div>
                    @endif

                    {{-- Tombol Kelola Divisi --}}
                    <div class="action-card">
                         <a href="{{ route('admin.organization.edit') }}" style="text-decoration:none; color:inherit; display:block; padding: 20px;">
                            <h4><i class="fas fa-sitemap"></i> Kelola Divisi</h4>
                            <p>Ubah deskripsi dan daftar divisi yang sedang dicari.</p>
                         </a>
                    </div>
                    
                    {{-- Tombol Kelola Event --}}
                    <div class="action-card">
                         <a href="{{ route('admin.events.index') }}" style="text-decoration:none; color:inherit; display:block; padding: 20px;">
                            <h4><i class="fas fa-calendar-alt"></i> Kelola Event</h4>
                            <p>Buat atau edit event untuk mencari volunteer.</p>
                         </a>
                    </div>
                </div>
            </div>

             {{-- ===== TOMBOL FILTER DITAMBAHKAN DI SINI ===== --}}
            <div class="filter-bar">
                <a href="{{ route('admin.dashboard') }}" class="{{ !$statusFilter ? 'active' : '' }}">Semua</a>
                <a href="{{ route('admin.dashboard', ['status' => 'pending']) }}" class="{{ $statusFilter == 'pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('admin.dashboard', ['status' => 'interview']) }}" class="{{ $statusFilter == 'interview' ? 'active' : '' }}">Interview</a>
                <a href="{{ route('admin.dashboard', ['status' => 'approved']) }}" class="{{ $statusFilter == 'approved' ? 'active' : '' }}">Approved</a>
                <a href="{{ route('admin.dashboard', ['status' => 'rejected']) }}" class="{{ $statusFilter == 'rejected' ? 'active' : '' }}">Rejected</a>
            </div>
            
            {{-- Bagian Tabs Pendaftar --}}
            <div class="tabs-navigation">
                <button class="tab-btn active" onclick="showTab('organisasi')">Pendaftar Organisasi ({{ $orgRegistrations->count() }})</button>
                <button class="tab-btn" onclick="showTab('volunteer')">Pendaftar Volunteer ({{ $volRegistrations->count() }})</button>
            </div>

            <div id="organisasi" class="content-section">
                <h3>Daftar Pendaftar Organisasi</h3>
                <div class="application-list" style="margin-top: 20px;">
                    @forelse ($orgRegistrations as $reg)
                    <div class="application-item">
                        <div class="applicant-info" style="flex-grow: 1;"><h4>{{ $reg->user->nama }} (<span class="status-badge status-{{ $reg->status }}">{{ $reg->status }}</span>)</h4><p>Pilihan Divisi: {{ $reg->division_1 }}</p></div>
                        <div class="application-actions"><a href="{{ route('admin.org_registration.show', $reg->id) }}" class="btn-action btn-view"><i class="fas fa-eye"></i> Detail</a></div>
                    </div>
                    @empty 
                        <p>Tidak ada pendaftar dengan status "{{ $statusFilter ?? 'apapun' }}" saat ini.</p> 
                    @endforelse
                </div>
            </div>

            <div id="volunteer" class="content-section" style="display: none;">
                <h3>Daftar Pendaftar Volunteer</h3>
                <div class="application-list" style="margin-top: 20px;">
                    @forelse ($volRegistrations as $reg)
                    <div class="application-item">
                         <div class="applicant-info" style="flex-grow: 1;"><h4>{{ $reg->user->nama }} (<span class="status-badge status-{{ $reg->status }}">{{ $reg->status }}</span>)</h4><p>Event: {{ $reg->event->name }} | Pilihan Peran: {{ $reg->role_1 }}</p></div>
                        <div class="application-actions"><a href="{{ route('admin.vol_registration.show', $reg->id) }}" class="btn-action btn-view"><i class="fas fa-eye"></i> Detail</a></div>
                    </div>
                    @empty 
                        <p>Tidak ada pendaftar dengan status "{{ $statusFilter ?? 'apapun' }}" saat ini.</p> 
                    @endforelse
                </div>
            </div>
        </div>
    </main>
    <script>
        function showTab(tabName) {
            document.getElementById('organisasi').style.display = 'none';
            document.getElementById('volunteer').style.display = 'none';
            document.querySelector('.tab-btn.active').classList.remove('active');
            
            document.getElementById(tabName).style.display = 'block';
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>