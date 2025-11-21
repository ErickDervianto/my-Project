<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Mahasiswa</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .edit-profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-left">
                <a href="{{ route('mahasiswa.dashboard') }}" class="btn-logout" style="text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div class="header-title-section">
                    <h1>Edit Profile</h1>
                    <p>Perbarui informasi profile Anda</p>
                </div>
            </div>
        </div>
    </header>

    <main class="dashboard-main">
        <div class="edit-profile-container">
            @if ($errors->any())
                <div class="info-alert" style="background-color: #ffdddd; border-left: 6px solid #f44336; color: #f44336; margin-bottom: 20px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="info-content">
                        <strong>Gagal memperbarui profil:</strong>
                        <ul style="list-style-type: disc; padding-left: 20px; margin-top: 5px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('mahasiswa.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group-registration">
                    <label for="nama" class="form-label-registration">Nama Lengkap *</label>
                    <input type="text" id="nama" name="nama" class="form-input-registration" value="{{ old('nama', $user->nama) }}" required>
                </div>

                <div class="form-group-registration">
                    <label for="email" class="form-label-registration">Email</label>
                    <input type="email" id="email" class="form-input-registration" value="{{ $user->email }}" disabled>
                </div>

                <div class="form-group-registration">
                    <label for="nim" class="form-label-registration">NIM *</label>
                    <input type="text" id="nim" name="nim" class="form-input-registration" value="{{ old('nim', $user->nim) }}" required>
                </div>

                <div class="form-group-registration">
                    <label for="telepon" class="form-label-registration">Nomor Telepon</label>
                    <input type="text" id="telepon" name="telepon" class="form-input-registration" value="{{ old('telepon', $user->telepon) }}">
                </div>

                <div class="form-group-registration">
                    <label for="fakultas" class="form-label-registration">Fakultas</label>
                    <input type="text" id="fakultas" name="fakultas" class="form-input-registration" value="{{ old('fakultas', $user->fakultas) }}">
                </div>
                
                <div class="form-group-registration">
                    <label for="prodi" class="form-label-registration">Program Studi</label>
                    <input type="text" id="prodi" name="prodi" class="form-input-registration" value="{{ old('prodi', $user->prodi) }}">
                </div>

                <div class="form-group-registration">
                    <label for="semester" class="form-label-registration">Semester</label>
                    <input type="number" id="semester" name="semester" class="form-input-registration" min="1" max="14" value="{{ old('semester', $user->semester) }}">
                </div>

                <div class="form-group-registration">
                    <label for="ipk" class="form-label-registration">IPK</label>
                    <input type="number" id="ipk" name="ipk" class="form-input-registration" step="0.01" min="0" max="4" value="{{ old('ipk', $user->ipk) }}">
                </div>

                <div class="form-actions" style="border-top: none; padding-top: 10px;">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn-previous">Batal</a>
                    <button type="submit" class="btn-next"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>