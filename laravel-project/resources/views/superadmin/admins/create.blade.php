<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Admin Baru</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="registration-body">
    <main class="registration-main">
        <div class="form-container" style="max-width: 600px;">
            <div class="form-header"><h2 class="form-title">Tambah Admin Baru</h2><p class="form-subtitle">Buat akun untuk ketua ORMAWA</p></div>
            @if ($errors->any())
                <div class="info-alert" style="background-color: #ffdddd; border-left: 6px solid #f44336; color: #f44336; margin-bottom: 20px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="info-content">
                        <strong>Gagal menyimpan data:</strong>
                        <ul style="list-style-type: disc; padding-left: 20px; margin-top: 5px;">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <form action="{{ route('superadmin.admins.store') }}" method="POST" class="registration-form">
                @csrf
                <div class="form-group-registration">
                    <label for="nama" class="form-label-registration">Nama Lengkap *</label>
                    <input type="text" id="nama" name="nama" class="form-input-registration" value="{{ old('nama') }}" required>
                </div>
                <div class="form-group-registration">
                    <label for="email" class="form-label-registration">Email *</label>
                    <input type="email" id="email" name="email" class="form-input-registration" value="{{ old('email') }}" required>
                </div>
                <div class="form-group-registration">
                    <label for="organization_id" class="form-label-registration">Organisasi yang Dikelola *</label>
                    <select name="organization_id" id="organization_id" class="form-select-registration" required>
                        <option value="">-- Pilih Organisasi --</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group-registration">
                    <label for="password" class="form-label-registration">Password *</label>
                    <input type="password" id="password" name="password" class="form-input-registration" required>
                </div>
                <div class="form-group-registration">
                    <label for="password_confirmation" class="form-label-registration">Konfirmasi Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input-registration" required>
                </div>
                <div class="form-actions">
                    <a href="{{ route('superadmin.admins.index') }}" class="btn-previous">Batal</a>
                    <button type="submit" class="btn-next">Simpan</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>