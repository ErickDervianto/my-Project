<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota Organisasi - Pilih Divisi</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="registration-body">
    <header class="registration-header">
        <div class="header-content-registration">
            <a href="{{ route('pendaftaran') }}" class="back-link-registration"><i class="fas fa-arrow-left"></i> Kembali ke Portal</a>
            <div class="header-title-section"><i class="fas fa-clipboard-list"></i><h1>Pendaftaran Anggota Organisasi</h1></div>
        </div>
    </header>
    
    <section class="progress-section">
        <div class="progress-container">
            <div class="progress-header"><span class="progress-step">Step 3 dari 4</span><span class="progress-percentage">75% selesai</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width: 75%;"></div></div>
            <div class="progress-labels">
                <span class="progress-label">Data Pribadi</span><span class="progress-label">Pilih Organisasi</span><span class="progress-label active">Motivasi</span><span class="progress-label">Konfirmasi</span>
            </div>
        </div>
    </section>

    <main class="registration-main">
        <div class="form-container">
            <div class="form-header"><h2 class="form-title">Pilih Divisi & Motivasi</h2><p class="form-subtitle">Pilih hingga 3 divisi sesuai prioritas dan jelaskan motivasi Anda</p></div>
            <form class="registration-form" method="POST" action="{{ route('mahasiswa.org.postStep3') }}">
                @csrf
                <div class="form-grid form-grid-three">
                    <div class="form-group-registration">
                        <label class="form-label-registration" for="division_1">Pilihan Pertama <span class="required">*</span></label>
                        <select class="form-select-registration" id="division_1" name="division_1" required>
                            <option value="" disabled selected>Pilih pilihan pertama</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division }}" {{ (old('division_1', $registrationData['division_1'] ?? '') == $division) ? 'selected' : '' }}>{{ $division }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-registration">
                        <label class="form-label-registration" for="division_2">Pilihan Kedua</label>
                        <select class="form-select-registration" id="division_2" name="division_2">
                            <option value="" selected>Pilih pilihan kedua (opsional)</option>
                             @foreach($divisions as $division)
                                <option value="{{ $division }}" {{ (old('division_2', $registrationData['division_2'] ?? '') == $division) ? 'selected' : '' }}>{{ $division }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-registration">
                        <label class="form-label-registration" for="division_3">Pilihan Ketiga</label>
                        <select class="form-select-registration" id="division_3" name="division_3">
                            <option value="" selected>Pilih pilihan ketiga (opsional)</option>
                             @foreach($divisions as $division)
                                <option value="{{ $division }}" {{ (old('division_3', $registrationData['division_3'] ?? '') == $division) ? 'selected' : '' }}>{{ $division }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group-registration">
                    <label class="form-label-registration" for="motivation">Motivasi <span class="required">*</span></label>
                    <textarea class="form-textarea-registration" id="motivation" name="motivation" rows="4" placeholder="Jelaskan motivasi Anda untuk bergabung..." required>{{ old('motivation', $registrationData['motivation'] ?? '') }}</textarea>
                </div>
                <div class="form-group-registration">
                    <label class="form-label-registration" for="organization_experience">Pengalaman Organisasi</label>
                    <textarea class="form-textarea-registration" id="organization_experience" name="organization_experience" rows="4" placeholder="Ceritakan pengalaman organisasi atau kepanitiaan sebelumnya...">{{ old('organization_experience', $registrationData['organization_experience'] ?? '') }}</textarea>
                </div>
                <div class="form-group-registration">
                    <label class="form-label-registration" for="skills">Keahlian Khusus</label>
                    <textarea class="form-textarea-registration" id="skills" name="skills" rows="3" placeholder="Sebutkan keahlian khusus yang Anda miliki (opsional)...">{{ old('skills', $registrationData['skills'] ?? '') }}</textarea>
                </div>
                <div class="form-actions">
                    <a class="btn-previous" href="{{ route('mahasiswa.org.step2') }}"><i class="fas fa-arrow-left"></i> Sebelumnya</a>
                    <button type="submit" class="btn-next">Selanjutnya <i class="fas fa-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>