<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pendaftar Volunteer: {{ $registration->user->nama }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
        .detail-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .main-content, .sidebar-content { display: flex; flex-direction: column; gap: 20px; }
        .card { background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); padding: 25px; }
        .card h3 { margin: 0 0 20px 0; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .detail-item { display: flex; margin-bottom: 12px; font-size: 15px; }
        .detail-item strong { width: 150px; color: #555; }
        .detail-item span { flex: 1; }
        .motivation-text { white-space: pre-wrap; background-color: #f9f9f9; padding: 15px; border-radius: 5px; line-height: 1.6; }
        .btn-primary { background-color: #FF5722; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
    </style>
</head>
<body class="dashboard-main" style="padding-top: 30px;">
    <div class="dashboard-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div><h2>Detail Pendaftar Volunteer</h2><p style="margin: 5px 0 0; color: #777;">Tinjau data pendaftar untuk event: <strong>{{ $registration->event->name }}</strong></p></div>
            <a href="{{ route('admin.dashboard') }}" class="btn-primary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
        
        <div class="detail-grid">
            <div class="main-content">
                 <div class="card">
                    <h3><i class="fas fa-user"></i> Informasi Pendaftar</h3>
                    <div class="detail-item"><strong>Nama:</strong> <span>{{ $registration->user->nama }}</span></div>
                    <div class="detail-item"><strong>NIM:</strong> <span>{{ $registration->user->nim }}</span></div>
                </div>
                 <div class="card">
                    <h3><i class="fas fa-tasks"></i> Pilihan Peran & Motivasi</h3>
                    <div class="detail-item"><strong>Peran Pilihan 1:</strong> <span>{{ $registration->role_1 }}</span></div>
                    @if($registration->role_2)<div class="detail-item"><strong>Peran Pilihan 2:</strong> <span>{{ $registration->role_2 }}</span></div>@endif
                    <hr style="margin: 20px 0;"><div class="detail-item"><strong>Motivasi:</strong></div><p class="motivation-text">{{ $registration->motivation }}</p>
                </div>
            </div>

            <div class="sidebar-content">
                <div class="card">
                    <h3><i class="fas fa-cogs"></i> Aksi Admin</h3>
                     @if ($errors->any())
                        <div class="info-alert" style="background-color: #ffdddd; border-left: 6px solid #f44336; color: #f44336; margin-bottom: 15px;">
                            <div class="info-content">
                                <ul style="list-style-type: none; padding-left: 0;">
                                    @foreach ($errors->all() as $error)
                                        <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                    <div class="detail-item"><strong>Status Saat Ini:</strong> <span class="status-badge status-{{ $registration->status }}">{{ $registration->status }}</span></div>
                     @if($registration->status == 'approved' && $registration->accepted_role)
                        <div class="detail-item"><strong>Diterima sebagai:</strong> <span style="font-weight: bold; color: #2E7D32;">{{ $registration->accepted_role }}</span></div>
                    @endif
                    <hr style="margin: 20px 0;">
                    
                    <form action="{{ route('admin.registration.update', ['type' => 'volunteer', 'id' => $registration->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="status" style="display:block; margin-bottom:10px;"><strong>Ubah Status:</strong></label>
                        <select name="status" id="status" class="form-select-registration" required onchange="toggleRoleSelect(this.value)">
                            <option value="pending" @if($registration->status == 'pending') selected @endif>Pending</option>
                            <option value="interview" @if($registration->status == 'interview') selected @endif>Interview</option>
                            <option value="approved" @if($registration->status == 'approved') selected @endif>Approved</option>
                            <option value="rejected" @if($registration->status == 'rejected') selected @endif>Rejected</option>
                        </select>

                        <div id="role-select-wrapper" style="display: none; margin-top: 15px;">
                            <label for="accepted_role" style="display:block; margin-bottom:10px;"><strong>Tempatkan di Peran: *</strong></label>
                            <select name="accepted_role" id="accepted_role" class="form-select-registration">
                                <option value="">-- Pilih Peran --</option>
                                @if($registration->role_1)<option value="{{ $registration->role_1 }}" {{ $registration->accepted_role == $registration->role_1 ? 'selected' : '' }}>Pilihan 1: {{ $registration->role_1 }}</option>@endif
                                @if($registration->role_2)<option value="{{ $registration->role_2 }}" {{ $registration->accepted_role == $registration->role_2 ? 'selected' : '' }}>Pilihan 2: {{ $registration->role_2 }}</option>@endif
                            </select>
                        </div>
                        
                        <button type="submit" class="btn-primary" style="width:100%; margin-top:15px;"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    </form>
                </div>
                <div class="card">
                    <h3><i class="fas fa-file-alt"></i> Dokumen</h3>
                    <div class="detail-item"><strong>CV:</strong> <span>@if($registration->cv_path)<a href="{{ asset('storage/' . $registration->cv_path) }}" target="_blank">Unduh CV</a>@else Tidak Ada @endif</span></div>
                    <div class="detail-item"><strong>Portfolio:</strong> <span>@if($registration->portfolio_path)<a href="{{ asset('storage/' . $registration->portfolio_path) }}" target="_blank">Unduh Portfolio</a>@else Tidak Ada @endif</span></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleRoleSelect(status) {
            const wrapper = document.getElementById('role-select-wrapper');
            const select = document.getElementById('accepted_role');
            if (status === 'approved') {
                wrapper.style.display = 'block';
                select.required = true;
            } else {
                wrapper.style.display = 'none';
                select.required = false;
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleRoleSelect(document.getElementById('status').value);
        });
    </script>
</body>
</html>