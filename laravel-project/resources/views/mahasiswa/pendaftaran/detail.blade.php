<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pendaftaran - {{ $registration->organization->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .detail-card h4 { margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .detail-item { display: flex; margin-bottom: 10px; }
        .detail-item strong { width: 200px; color: #555; }
        .motivation-text { white-space: pre-wrap; background-color: #f9f9f9; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body class="dashboard-main" style="padding-top: 30px;">
    <div class="dashboard-container">
        
        <a href="{{ route('mahasiswa.dashboard') }}" class="btn-edit-profile" style="margin-bottom: 20px; display: inline-block;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        {{-- ===== NOTIFIKASI PENERIMAAN DITAMBAHKAN DI SINI ===== --}}
        @if ($registration->status == 'approved' && $registration->accepted_division)
            <div class="alert-dashboard" style="background-color: #E8F5E9; border-color: #A5D6A7; color: #2E7D32;">
                <i class="fas fa-check-circle"></i>
                <div class="alert-content">
                    <strong>Selamat, Anda Diterima!</strong>
                    <p>Anda telah diterima di <strong>Divisi: {{ $registration->accepted_division }}</strong>. Informasi lebih lanjut akan disampaikan oleh pihak organisasi.</p>
                </div>
            </div>
        @endif

        <div class="profile-card-dashboard">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="margin: 0;">Detail Pendaftaran: {{ $registration->organization->name }}</h2>
                    <p style="margin: 5px 0 0 0; color: #777;">Didaftarkan pada {{ $registration->created_at->format('d F Y') }}</p>
                </div>
                <span class="status-badge status-{{ $registration->status }}">{{ $registration->status }}</span>
            </div>
        </div>

        <div class="profile-card-dashboard detail-card">
            <h4><i class="fas fa-tasks"></i> Pilihan Divisi & Motivasi</h4>
            <div class="detail-item"><strong>Divisi Pilihan 1:</strong> <span>{{ $registration->division_1 }}</span></div>
            @if($registration->division_2)<div class="detail-item"><strong>Divisi Pilihan 2:</strong> <span>{{ $registration->division_2 }}</span></div>@endif
            @if($registration->division_3)<div class="detail-item"><strong>Divisi Pilihan 3:</strong> <span>{{ $registration->division_3 }}</span></div>@endif
            <hr style="border: 1px solid #eee; margin: 20px 0;">
            <div class="detail-item"><strong>Motivasi:</strong></div>
            <p class="motivation-text">{{ $registration->motivation }}</p>
        </div>

        <div class="profile-card-dashboard detail-card">
            <h4><i class="fas fa-file-alt"></i> Dokumen Terlampir</h4>
            <div class="detail-item"><strong>CV/Resume:</strong><span>@if($registration->cv_path)<a href="{{ asset('storage/' . $registration->cv_path) }}" target="_blank">Lihat CV</a>@else Tidak Dilampirkan @endif</span></div>
            <div class="detail-item"><strong>Portfolio:</strong><span>@if($registration->portfolio_path)<a href="{{ asset('storage/' . $registration->portfolio_path) }}" target="_blank">Lihat Portfolio</a>@else Tidak Dilampirkan @endif</span></div>
        </div>
    </div>
</body>
</html>