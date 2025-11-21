<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota Organisasi - Step 1</title>
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
            <div class="progress-header"><span class="progress-step">Step 1 dari 4</span><span class="progress-percentage">25% selesai</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width: 25%;"></div></div>
            <div class="progress-labels">
                <span class="progress-label active">Data Pribadi</span><span class="progress-label">Pilih Organisasi</span><span class="progress-label">Motivasi</span><span class="progress-label">Konfirmasi</span>
            </div>
        </div>
    </section>
    <main class="registration-main">
        <div class="form-container">
            <div class="form-header"><h2 class="form-title">Data Pribadi</h2><p class="form-subtitle">Lengkapi informasi pribadi Anda</p></div>
            @if ($errors->any())
                <div class="info-alert" style="background-color: #ffdddd; border-left: 6px solid #f44336; color: #f44336;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="info-content">
                        <strong>Terdapat kesalahan:</strong>
                        <ul style="list-style-type: disc; padding-left: 20px;">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <form action="{{ route('mahasiswa.org.postStep1') }}" method="POST" class="registration-form">
                @csrf
                <div class="form-grid">
                    <div class="form-group-registration">
                        <label for="nama" class="form-label-registration">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="nama" name="nama" class="form-input-registration" placeholder="Masukkan nama lengkap" value="{{ old('nama', $registrationData['nama'] ?? '') }}" required>
                    </div>
                    <div class="form-group-registration">
                        <label for="nim" class="form-label-registration">NIM <span class="required">*</span></label>
                        <input type="text" id="nim" name="nim" class="form-input-registration" placeholder="Contoh: 23.N1.0005" value="{{ old('nim', $registrationData['nim'] ?? '') }}" required>
                    </div>
                    <div class="form-group-registration">
                        <label for="email" class="form-label-registration">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-input-registration" placeholder="nama@kampus.ac.id" value="{{ old('email', $registrationData['email'] ?? '') }}" required>
                    </div>
                    <div class="form-group-registration">
                        <label for="telepon" class="form-label-registration">Nomor Telepon <span class="required">*</span></label>
                        <input type="tel" id="telepon" name="telepon" class="form-input-registration" placeholder="08xxxxxxxxxx" value="{{ old('telepon', $registrationData['telepon'] ?? '') }}" required>
                    </div>
                    <div class="form-group-registration">
                        <label for="fakultas" class="form-label-registration">Fakultas <span class="required">*</span></label>
                        <input type="text" id="fakultas" name="fakultas" class="form-input-registration" placeholder="Fakultas Anda" value="{{ old('fakultas', $registrationData['fakultas'] ?? '') }}" required>
                    </div>
                    <div class="form-group-registration">
                        <label for="prodi" class="form-label-registration">Program Studi <span class="required">*</span></label>
                        <input type="text" id="prodi" name="prodi" class="form-input-registration" placeholder="Program Studi Anda" value="{{ old('prodi', $registrationData['prodi'] ?? '') }}" required>
                    </div>
                    <div class="form-group-registration">
                        <label for="semester" class="form-label-registration">Semester <span class="required">*</span></label>
                        <input type="number" id="semester" name="semester" class="form-input-registration" placeholder="Semester saat ini" value="{{ old('semester', $registrationData['semester'] ?? '') }}" required>
                    </div>
                    <div class="form-group-registration">
                        <label for="ipk" class="form-label-registration">IPK <span class="required">*</span></label>
                        <input type="text" id="ipk" name="ipk" class="form-input-registration" placeholder="Contoh: 3.75" value="{{ old('ipk', $registrationData['ipk'] ?? '') }}" required>
                    </div>
                </div>
                <div class="form-actions">
                     <a href="{{ route('pendaftaran') }}" class="btn-previous"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn-next">Selanjutnya <i class="fas fa-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>