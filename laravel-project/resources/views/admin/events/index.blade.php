<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Event</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-main">
    <header class="dashboard-header">
        <div class="dashboard-header-content">
            <div class="header-title-section"><h1>Kelola Event</h1></div>
            <a href="{{ route('admin.dashboard') }}" class="btn-logout">Kembali ke Dashboard</a>
        </div>
    </header>
    <main class="dashboard-main">
        <div class="dashboard-container">
            <div class="table-container">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3>Daftar Event Organisasi Anda</h3>
                    <a href="{{ route('admin.events.create') }}" class="btn-add"><i class="fas fa-plus"></i> Tambah Event</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Event</th>
                            <th>Tanggal Event</th>
                            <th>Status Pendaftaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d F Y') }}</td>
                            <td>{!! $event->is_open ? '<span class="status-badge status-approved">Dibuka</span>' : '<span class="status-badge status-rejected">Ditutup</span>' !!}</td>
                            <td class="action-buttons">
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus event ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align: center;">Anda belum membuat event apapun.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>