<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Superadmin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-title-section"><h1>Superadmin Dashboard</h1><p>Manajemen Sistem ORION</p></div>
            <form action="{{ route('logout') }}" method="POST"> @csrf <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button></form>
        </div>
    </header>
    <main class="dashboard-main">
        <div class="dashboard-container">
            <div class="quick-actions-section">
                 <h3 class="section-title-dash">Menu Manajemen Utama</h3>
                 <div class="quick-actions-grid">
                    <div class="action-card">
                         <a href="{{ route('superadmin.admins.index') }}" style="text-decoration:none; color:inherit; display:block; padding: 20px;">
                            <h4><i class="fas fa-users-cog"></i> Kelola Admin</h4>
                            <p>Tambah, edit, atau hapus akun admin untuk setiap organisasi.</p>
                         </a>
                    </div>
                     <div class="action-card">
                         <a href="{{ route('superadmin.organizations.index') }}" style="text-decoration:none; color:inherit; display:block; padding: 20px;">
                            <h4><i class="fas fa-sitemap"></i> Kelola Organisasi</h4>
                            <p>Atur data organisasi yang membuka pendaftaran anggota.</p>
                         </a>
                    </div>
                 </div>
            </div>
        </div>
    </main>
</body>
</html>