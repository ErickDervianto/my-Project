<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Volunteer - Pilih Peran</title>
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
            <div class="progress-header"><span class="progress-step">Step 3 dari 4</span><span class="progress-percentage">75% selesai</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width: 75%;"></div></div>
            <div class="progress-labels">
                <span class="progress-label">Data Pribadi</span><span class="progress-label">Pilih Event</span><span class="progress-label active">Motivasi</span><span class="progress-label">Konfirmasi</span>
            </div>
        </div>
    </section>

    <main class="registration-main">
        <div class="form-container">
            <div class="form-header"><h2 class="form-title">Pilih Peran & Motivasi</h2><p class="form-subtitle">Pilih hingga 2 peran sesuai prioritas dan jelaskan motivasi Anda</p></div>
            <form class="registration-form" method="POST" action="{{ route('mahasiswa.vol.postStep3') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-group-registration">
                        <label class="form-label-registration" for="role_1">Pilihan Peran Pertama <span class="required">*</span></label>
                        <select class="form-select-registration" id="role_1" name="role_1" required>
                            <option value="" disabled selected>Pilih peran pertama</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ (old('role_1', $registrationData['role_1'] ?? '') == $role) ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group-registration">
                        <label class="form-label-registration" for="role_2">Pilihan Peran Kedua</label>
                        <select class="form-select-registration" id="role_2" name="role_2">
                            <option value="" selected>Pilih peran kedua (opsional)</option>
                             @foreach($roles as $role)
                                <option value="{{ $role }}" {{ (old('role_2', $registrationData['role_2'] ?? '') == $role) ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group-registration">
                    <label class="form-label-registration" for="motivation">Motivasi <span class="required">*</span></label>
                    <textarea class="form-textarea-registration" id="motivation" name="motivation" rows="4" placeholder="Jelaskan motivasi Anda untuk menjadi volunteer..." required>{{ old('motivation', $registrationData['motivation'] ?? '') }}</textarea>
                </div>
                <div class="form-group-registration">
                    <label class="form-label-registration" for="volunteer_experience">Pengalaman Volunteer</label>
                    <textarea class="form-textarea-registration" id="volunteer_experience" name="volunteer_experience" rows="4" placeholder="Ceritakan pengalaman volunteer atau kepanitiaan sebelumnya...">{{ old('volunteer_experience', $registrationData['volunteer_experience'] ?? '') }}</textarea>
                </div>
                <div class="form-group-registration">
                    <label class="form-label-registration" for="skills">Keahlian Khusus</label>
                    <textarea class="form-textarea-registration" id="skills" name="skills" rows="3" placeholder="Sebutkan keahlian khusus yang relevan (misal: Desain Grafis, Fotografi)...">{{ old('skills', $registrationData['skills'] ?? '') }}</textarea>
                </div>
                <div class="form-actions">
                    <a class="btn-previous" href="{{ route('mahasiswa.vol.step2') }}"><i class="fas fa-arrow-left"></i> Sebelumnya</a>
                    <button type="submit" class="btn-next">Selanjutnya <i class="fas fa-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>