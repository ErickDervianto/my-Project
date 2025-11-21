<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Organisasi</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="registration-body">
    <main class="registration-main">
        <div class="form-container" style="max-width: 800px;">
            <div class="form-header"><h2 class="form-title">Edit Organisasi: {{ $organization->name }}</h2></div>
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
            <form action="{{ route('superadmin.organizations.update', $organization->id) }}" method="POST" class="registration-form">
                @csrf
                @method('PUT')
                <div class="form-group-registration">
                    <label for="name" class="form-label-registration">Nama Organisasi *</label>
                    <input type="text" id="name" name="name" class="form-input-registration" value="{{ old('name', $organization->name) }}" required>
                </div>
                <div class="form-group-registration">
                    <label for="description" class="form-label-registration">Deskripsi *</label>
                    <textarea id="description" name="description" class="form-textarea-registration" rows="4" required>{{ old('description', $organization->description) }}</textarea>
                </div>
                <div class="form-grid">
                    <div class="form-group-registration">
                        <label for="type" class="form-label-registration">Tipe Organisasi *</label>
                        <select id="type" name="type" class="form-select-registration" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="Universitas" @if(old('type', $organization->type) == 'Universitas') selected @endif>Universitas</option>
                            <option value="Fakultas" @if(old('type', $organization->type) == 'Fakultas') selected @endif>Fakultas</option>
                            <option value="Prodi" @if(old('type', $organization->type) == 'Prodi') selected @endif>Program Studi</option>
                        </select>
                    </div>
                    <div class="form-group-registration">
                        <label for="deadline" class="form-label-registration">Deadline Pendaftaran *</label>
                        <input type="date" id="deadline" name="deadline" class="form-input-registration" value="{{ old('deadline', $organization->deadline) }}" required>
                    </div>
                </div>
                <div class="form-group-registration">
                    <label for="available_divisions" class="form-label-registration">Divisi yang Tersedia (pisahkan dengan koma) *</label>
                    <input type="text" id="available_divisions" name="available_divisions" class="form-input-registration" value="{{ old('available_divisions', implode(', ', $organization->available_divisions)) }}" required>
                </div>
                <div class="form-group-registration">
                    <label for="is_open" class="form-label-registration">Status Pendaftaran *</label>
                    <select id="is_open" name="is_open" class="form-select-registration" required>
                        <option value="1" @if(old('is_open', $organization->is_open) == 1) selected @endif>Dibuka</option>
                        <option value="0" @if(old('is_open', $organization->is_open) == 0) selected @endif>Ditutup</option>
                    </select>
                </div>
                <div class="form-actions">
                    <a href="{{ route('superadmin.organizations.index') }}" class="btn-previous">Batal</a>
                    <button type="submit" class="btn-next">Update Organisasi</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>