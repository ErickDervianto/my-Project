<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Organisasi - Pendaftaran Anggota Organisasi</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="registration-body">
    <header class="registration-header">
        <div class="header-content-registration">
             <a href="{{ route('pendaftaran') }}" class="back-link-registration"><i class="fas fa-arrow-left"></i> Kembali ke Portal</a>
            <div class="header-title-section"><i class="fas fa-users"></i><h1>Pendaftaran Anggota Organisasi</h1></div>
        </div>
    </header>

    <section class="progress-section">
        <div class="progress-container">
            <div class="progress-header"><span class="progress-step">Step 2 dari 4</span><span class="progress-percentage">50% selesai</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width: 50%;"></div></div>
            <div class="progress-labels">
                <span class="progress-label">Data Pribadi</span><span class="progress-label active">Pilih Organisasi</span><span class="progress-label">Motivasi</span><span class="progress-label">Konfirmasi</span>
            </div>
        </div>
    </section>

    <main class="registration-main">
        <div class="form-container">
            <div class="form-header"><h2 class="form-title">Pilih Organisasi</h2><p class="form-subtitle">Pilih organisasi yang ingin Anda ikuti</p></div>
            <form class="registration-form" id="organizationForm" method="POST" action="{{ route('mahasiswa.org.postStep2') }}">
                @csrf
                <div class="organization-list">
                    @forelse($organizations as $org)
                        <div class="organization-option">
                            <input type="radio" name="organization_id" id="org{{ $org->id }}" value="{{ $org->id }}" class="org-radio" 
                                   {{ (old('organization_id', $registrationData['organization_id'] ?? '') == $org->id) ? 'checked' : '' }} required>
                            <label for="org{{ $org->id }}" class="org-label">
                                <div class="org-header">
                                    <div class="org-icon-wrapper"><i class="fas fa-circle"></i></div>
                                    <div class="org-info">
                                        <h3 class="org-title">{{ $org->name }}</h3>
                                        <p class="org-description">{{ $org->description }}</p>
                                    </div>
                                </div>
                                @if($org->available_divisions)
                                <div class="org-tags">
                                    @foreach(array_slice($org->available_divisions, 0, 3) as $division)
                                        <span class="tag">{{ $division }}</span>
                                    @endforeach
                                    @if(count($org->available_divisions) > 3)
                                        <span class="tag">+{{ count($org->available_divisions) - 3 }} lainnya</span>
                                    @endif
                                </div>
                                @endif
                            </label>
                        </div>
                    @empty
                        <p>Saat ini tidak ada pendaftaran organisasi yang dibuka.</p>
                    @endforelse
                </div>

                <div class="form-actions">
                    <a href="{{ route('mahasiswa.org.step1') }}" class="btn-previous"><i class="fas fa-arrow-left"></i> Sebelumnya</a>
                    <button type="submit" class="btn-next">Selanjutnya <i class="fas fa-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.org-radio').forEach(radio => {
                if(radio.checked) {
                    radio.closest('.organization-option').classList.add('selected');
                }
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.organization-option').forEach(option => option.classList.remove('selected'));
                    if(this.checked) {
                        this.closest('.organization-option').classList.add('selected');
                    }
                });
            });
        });
    </script>
</body>
</html>