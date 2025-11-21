<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Event - Pendaftaran Volunteer</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="registration-body">
    <header class="registration-header">
        <div class="header-content-registration">
             <a href="{{ route('pendaftaran') }}" class="back-link-registration"><i class="fas fa-arrow-left"></i> Kembali ke Portal</a>
            <div class="header-title-section"><i class="fas fa-calendar-check"></i><h1>Pendaftaran Volunteer</h1></div>
        </div>
    </header>
    <section class="progress-section">
        <div class="progress-container">
            <div class="progress-header"><span class="progress-step">Step 2 dari 4</span><span class="progress-percentage">50% selesai</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width: 50%;"></div></div>
            <div class="progress-labels">
                <span class="progress-label">Data Pribadi</span><span class="progress-label active">Pilih Event</span><span class="progress-label">Motivasi</span><span class="progress-label">Konfirmasi</span>
            </div>
        </div>
    </section>
    <main class="registration-main">
        <div class="form-container">
            <div class="form-header"><h2 class="form-title">Pilih Event</h2><p class="form-subtitle">Pilih event yang ingin Anda ikuti sebagai volunteer</p></div>
            <form id="eventForm" method="POST" action="{{ route('mahasiswa.vol.postStep2') }}">
                @csrf
                <div class="organization-list">
                    @forelse($events as $event)
                        <div class="organization-option">
                            <input type="radio" name="event_id" id="event{{ $event->id }}" value="{{ $event->id }}" class="org-radio" 
                                   {{ (old('event_id', $registrationData['event_id'] ?? '') == $event->id) ? 'checked' : '' }} required>
                            <label for="event{{ $event->id }}" class="org-label">
                                <div class="org-header">
                                    <div class="org-icon-wrapper"><i class="fas fa-circle"></i></div>
                                    <div class="org-info">
                                        <h3 class="org-title">{{ $event->name }}</h3>
                                        <p class="org-description">{{ $event->description }}</p>
                                    </div>
                                </div>
                                @if($event->available_roles)
                                <div class="org-tags">
                                    @foreach(array_slice($event->available_roles, 0, 3) as $role)
                                        <span class="tag">{{ $role }}</span>
                                    @endforeach
                                    @if(count($event->available_roles) > 3)
                                        <span class="tag">+{{ count($event->available_roles) - 3 }} lainnya</span>
                                    @endif
                                </div>
                                @endif
                            </label>
                        </div>
                    @empty
                        <p>Saat ini tidak ada pendaftaran volunteer yang dibuka.</p>
                    @endforelse
                </div>
                <div class="form-actions">
                    <a href="{{ route('mahasiswa.vol.step1') }}" class="btn-previous"><i class="fas fa-arrow-left"></i> Sebelumnya</a>
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