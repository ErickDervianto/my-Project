<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Organisasi Anda</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="registration-body">
    <main class="registration-main">
        <div class="form-container" style="max-width: 800px;">
            <div class="form-header">
                <h2 class="form-title">Kelola Organisasi</h2>
                <p class="form-subtitle">Perbarui deskripsi dan divisi yang dicari untuk <strong>{{ $organization->name }}</strong></p>
            </div>

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

            <form action="{{ route('admin.organization.update') }}" method="POST" class="registration-form">
                @csrf
                @method('PUT')

                <div class="form-group-registration">
                    <label for="description" class="form-label-registration">Deskripsi Organisasi *</label>
                    <textarea id="description" name="description" class="form-textarea-registration" rows="4" required>{{ old('description', $organization->description) }}</textarea>
                </div>

                <div class="form-group-registration">
                    <label for="available_divisions" class="form-label-registration">Divisi yang Dicari (pisahkan dengan koma) *</label>
                    <input type="text" id="available_divisions" name="available_divisions" class="form-input-registration" 
                           value="{{ old('available_divisions', implode(', ', $organization->available_divisions)) }}" 
                           placeholder="Contoh: Humas, Riset, Advokasi" required>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.dashboard') }}" class="btn-previous">Batal</a>
                    <button type="submit" class="btn-next">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>