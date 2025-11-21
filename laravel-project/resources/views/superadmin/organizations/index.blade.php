<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Organisasi</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-main">
    <header class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-title-section"><h1>Kelola Organisasi</h1></div>
            <a href="{{ route('superadmin.dashboard') }}" class="btn-logout">Kembali ke Dashboard</a>
        </div>
    </header>
    <main class="dashboard-main">
        <div class="dashboard-container">
            @if(session('success'))
                <div class="alert-dashboard" style="background-color: #E8F5E9; border-color: #A5D6A7; color: #2E7D32;"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-dashboard" style="background-color: #ffdddd; border-color: #f44336; color: #c62828;"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</div>
            @endif
            <div class="table-container">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3>Daftar Organisasi</h3>
                    <a href="{{ route('superadmin.organizations.create') }}" class="btn-add"><i class="fas fa-plus"></i> Tambah Organisasi</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Organisasi</th>
                            <th>Tipe</th>
                            <th>Status Pendaftaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($organizations as $org)
                        <tr>
                            <td>{{ $org->name }}</td>
                            <td>{{ $org->type }}</td>
                            <td>{!! $org->is_open ? '<span class="status-badge status-approved">Dibuka</span>' : '<span class="status-badge status-rejected">Ditutup</span>' !!}</td>
                            <td class="action-buttons">
                                <a href="{{ route('superadmin.organizations.edit', $org->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('superadmin.organizations.destroy', $org->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus organisasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align: center;">Belum ada data organisasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $organizations->links() }}
            </div>
        </div>
    </main>
</body>
</html>