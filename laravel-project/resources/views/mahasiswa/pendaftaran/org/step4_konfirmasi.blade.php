<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran - Sistem Pendaftaran Mahasiswa</title>
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
            <div class="progress-header"><span class="progress-step">Step 4 dari 4</span><span class="progress-percentage">100% selesai</span></div>
            <div class="progress-bar"><div class="progress-fill" style="width: 100%;"></div></div>
            <div class="progress-labels">
                <span class="progress-label">Data Pribadi</span><span class="progress-label">Pilih Organisasi</span><span class="progress-label">Motivasi</span><span class="progress-label active">Konfirmasi</span>
            </div>
        </div>
    </section>
    <main class="registration-main">
        <div class="form-container">
            <div class="form-header"><h2 class="form-title">Konfirmasi Pendaftaran</h2><p class="form-subtitle">Periksa kembali data Anda sebelum mengirim</p></div>
            @if ($errors->any())
                <div class="info-alert" style="background-color: #ffdddd; border-left: 6px solid #f44336; color: #f44336; margin-bottom: 20px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="info-content">
                        <strong>Terdapat kesalahan:</strong>
                        <ul style="list-style-type: disc; padding-left: 20px; margin-top: 5px;">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <form action="{{ route('mahasiswa.org.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="confirmation-summary">
                    <h3 class="summary-title">Ringkasan Pendaftaran</h3>
                    <div class="summary-grid">
                        <div class="summary-row"><div class="summary-item"><label class="summary-label">Nama Lengkap</label><p class="summary-value">{{ $data['nama'] ?? 'N/A' }}</p></div><div class="summary-item"><label class="summary-label">NIM</label><p class="summary-value">{{ $data['nim'] ?? 'N/A' }}</p></div></div>
                        <div class="summary-row"><div class="summary-item full-width"><label class="summary-label">Program Studi</label><p class="summary-value">{{ $data['prodi'] ?? 'N/A' }}</p></div></div>
                        <div class="summary-row"><div class="summary-item"><label class="summary-label">Semester / IPK</label><p class="summary-value">{{ $data['semester'] ?? 'N/A' }} / {{ $data['ipk'] ?? 'N/A' }}</p></div></div>
                        <div class="summary-row"><div class="summary-item full-width"><label class="summary-label">Organisasi</label><p class="summary-value">{{ $data['organization_name'] ?? 'N/A' }}</p></div></div>
                        <div class="summary-row">
                            <div class="summary-item full-width">
                                <label class="summary-label">Pilihan Divisi</label>
                                <div class="summary-tags">
                                    @if(!empty($data['division_1']))<span class="summary-tag">1: {{ $data['division_1'] }}</span>@endif
                                    @if(!empty($data['division_2']))<span class="summary-tag">2: {{ $data['division_2'] }}</span>@endif
                                    @if(!empty($data['division_3']))<span class="summary-tag">3: {{ $data['division_3'] }}</span>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="document-upload-section">
                    <h3 class="document-title">Dokumen Pendukung (Opsional)</h3>
                    <div class="upload-grid">
                        <div class="upload-box"><label class="upload-label">CV/Resume</label><div class="upload-area" id="cv-upload-area"><i class="fas fa-cloud-upload-alt upload-icon"></i><p class="upload-text">Klik untuk upload CV</p><p class="upload-subtext">PDF, max 2MB</p></div><input type="file" name="cv" id="cv-upload" accept=".pdf" style="display: none;"></div>
                        <div class="upload-box"><label class="upload-label">Portfolio</label><div class="upload-area" id="portfolio-upload-area"><i class="fas fa-cloud-upload-alt upload-icon"></i><p class="upload-text">Klik untuk upload portfolio</p><p class="upload-subtext">PDF, max 5MB</p></div><input type="file" name="portfolio" id="portfolio-upload" accept=".pdf" style="display: none;"></div>
                    </div>
                </div>
                <div class="agreement-section">
                    <div class="agreement-item"><input type="checkbox" name="agree-terms" id="agree-terms" class="agreement-checkbox"><label for="agree-terms" class="agreement-label">Saya menyetujui syarat dan ketentuan pendaftaran <span class="required">*</span></label></div>
                    <div class="agreement-item"><input type="checkbox" name="agree-privacy" id="agree-privacy" class="agreement-checkbox"><label for="agree-privacy" class="agreement-label">Saya menyetujui penggunaan data pribadi <span class="required">*</span></label></div>
                </div>
                <div class="confirmation-alert"><i class="fas fa-info-circle"></i><p>Pastikan semua data yang Anda masukkan sudah benar. Setelah dikirim, data tidak dapat diubah.</p></div>
                <div class="form-actions">
                    <a href="{{ route('mahasiswa.org.step3') }}" class="btn-previous"><i class="fas fa-arrow-left"></i> Sebelumnya</a>
                    <button type="submit" class="btn-submit">Kirim Pendaftaran <i class="fas fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.getElementById('cv-upload-area').addEventListener('click', () => document.getElementById('cv-upload').click());
        document.getElementById('portfolio-upload-area').addEventListener('click', () => document.getElementById('portfolio-upload').click());
        function handleFileUpload(inputId, areaId) {
            document.getElementById(inputId).addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const fileName = e.target.files[0].name;
                    document.getElementById(areaId).innerHTML = `<i class="fas fa-file-pdf upload-icon" style="color: #4CAF50;"></i><p class="upload-text" style="color: #4CAF50;">${fileName}</p><p class="upload-subtext">File berhasil dipilih</p>`;
                }
            });
        }
        handleFileUpload('cv-upload', 'cv-upload-area');
        handleFileUpload('portfolio-upload', 'portfolio-upload-area');
    </script>
</body>
</html>