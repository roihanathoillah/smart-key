<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Super Admin - Smart Key</title>
    <link rel="stylesheet" href="/css/dashboard.css">
    <style>
        * { box-sizing: border-box; }
        .sa-content { padding-bottom: 40px; }
        .sa-toolbar { display:flex; align-items:center; justify-content:space-between; gap:16px; margin:22px 0; flex-wrap:wrap; }
        .sa-title p { margin:5px 0 0; color:#64748b; font-size:14px; }
        .sa-actions { display:flex; gap:10px; flex-wrap:wrap; }
        .sa-search { display:flex; gap:8px; }
        .sa-search input { min-width:260px; padding:11px 13px; border:1px solid #dbe2ea; border-radius:10px; outline:none; }
        .sa-btn { border:0; border-radius:10px; padding:11px 15px; font-weight:700; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
        .sa-btn-primary { background:#dc2626; color:white; }
        .sa-btn-light { background:#f1f5f9; color:#334155; }
        .sa-btn-danger { background:#fee2e2; color:#b91c1c; }
        .sa-btn-edit { background:#fff7ed; color:#c2410c; }
        .sa-card { background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(15,23,42,.05); }
        .sa-card-head { padding:18px 20px; border-bottom:1px solid #eef2f7; display:flex; justify-content:space-between; align-items:center; }
        .sa-card-head h2 { margin:0; font-size:18px; }
        .sa-table-wrap { overflow:auto; }
        .sa-table { width:100%; border-collapse:collapse; min-width:850px; }
        .sa-table th { text-align:left; padding:13px 16px; background:#f8fafc; color:#64748b; font-size:12px; text-transform:uppercase; letter-spacing:.04em; }
        .sa-table td { padding:14px 16px; border-top:1px solid #eef2f7; vertical-align:middle; }
        .sa-person { display:flex; align-items:center; gap:11px; }
        .sa-avatar { width:40px; height:40px; border-radius:50%; background:#fee2e2; color:#b91c1c; display:grid; place-items:center; font-weight:800; flex:none; }
        .sa-person strong { display:block; color:#0f172a; }
        .sa-person small { color:#64748b; }
        .sa-badge { display:inline-flex; padding:6px 10px; border-radius:999px; background:#dcfce7; color:#166534; font-size:12px; font-weight:800; }
        .sa-you { margin-left:6px; background:#e0f2fe; color:#075985; }
        .sa-row-actions { display:flex; gap:7px; }
        .sa-alert { margin:18px 0; padding:13px 15px; border-radius:11px; font-size:14px; font-weight:600; }
        .sa-success { background:#dcfce7; color:#166534; }
        .sa-error { background:#fee2e2; color:#991b1b; }
        .sa-pagination { padding:16px 20px; }
        .sa-pagination nav { display:flex; gap:6px; flex-wrap:wrap; }
        .sa-pagination nav > div:first-child { display:none; }
        .sa-modal { position:fixed; inset:0; background:rgba(15,23,42,.55); display:none; align-items:center; justify-content:center; z-index:1000; padding:18px; }
        .sa-modal.open { display:flex; }
        .sa-modal-card { width:min(620px,100%); max-height:92vh; overflow:auto; background:#fff; border-radius:18px; padding:22px; box-shadow:0 24px 70px rgba(0,0,0,.25); }
        .sa-modal-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
        .sa-modal-head h2 { margin:0; }
        .sa-close { border:0; background:#f1f5f9; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:20px; }
        .sa-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .sa-field { margin-bottom:14px; }
        .sa-field.full { grid-column:1/-1; }
        .sa-field label { display:block; margin-bottom:7px; font-size:13px; font-weight:700; color:#334155; }
        .sa-field input { width:100%; padding:11px 12px; border:1px solid #dbe2ea; border-radius:10px; outline:none; }
        .sa-field input:focus { border-color:#dc2626; box-shadow:0 0 0 3px rgba(220,38,38,.08); }
        .sa-form-actions { display:flex; justify-content:flex-end; gap:9px; margin-top:8px; }
        .sa-empty { text-align:center; color:#64748b; padding:32px !important; }
        @media (max-width: 760px) {
            .sa-grid { grid-template-columns:1fr; }
            .sa-search { width:100%; }
            .sa-search input { min-width:0; width:100%; }
            .sa-actions { width:100%; }
        }
    </style>
</head>
<body>
<div class="dashboard-page">
    <aside class="dashboard-sidebar">
        <div class="brand">
            <span class="brand-logo">SK</span>
            <div>
                <h1>Smart Key</h1>
                <p>Admin Dashboard</p>
            </div>
        </div>

        <div class="sidebar-section">
            <h2>Menu</h2>
            <nav class="dashboard-nav">
                <a href="{{ route('super.admin') }}">Dashboard</a>
                <a href="{{ route('karyawan.super') }}">Daftar Karyawan</a>
                <a href="{{ route('history.super') }}">History</a>
                <a href="{{ route('super.users') }}" class="active">Kelola Super Admin</a>
            </nav>
        </div>

        <div class="sidebar-section">
            <h2>ADMIN</h2>
            <nav class="dashboard-nav">
                <details class="sidebar-dropdown">
                    <summary>Setting</summary>
                    <div class="sidebar-dropdown-menu">
                        <a href="{{ route('profile.super') }}">Profile</a>
                        <a href="#">Notification</a>
                        <a href="#">Security</a>
                    </div>
                </details>
            </nav>
        </div>
    </aside>

    <main class="dashboard-content sa-content">
        <header class="dashboard-header">
            <div>
                <h1>Kelola Super Admin</h1>
            </div>
            <div class="profile-card">
                <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->username ?? 'S', 0, 1)) }}</div>
                <div>
                    <p>{{ Auth::user()->nama_lengkap ?? Auth::user()->username ?? 'Super Admin' }}</p>
                    <strong>Super Admin</strong>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="sa-alert sa-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="sa-alert sa-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="sa-toolbar">
            <div class="sa-title">
                <h2 style="margin:0">Daftar Super Admin</h2>
                <p>Kelola akun yang mempunyai akses penuh ke Dashboard Super Admin.</p>
            </div>

            <div class="sa-actions">
                <form class="sa-search" method="GET" action="{{ route('super.users') }}">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, username, email...">
                    <button class="sa-btn sa-btn-light" type="submit">Cari</button>
                </form>
                <button class="sa-btn sa-btn-primary" type="button" onclick="openCreateModal()">+ Tambah Super Admin</button>
            </div>
        </div>

        <section class="sa-card">
            <div class="sa-card-head">
                <h2>Super Admin</h2>
                <span>{{ $superAdmins->total() }} akun</span>
            </div>

            <div class="sa-table-wrap">
                <table class="sa-table">
                    <thead>
                    <tr>
                        <th>Super Admin</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($superAdmins as $admin)
                        <tr>
                            <td>
                                <div class="sa-person">
                                    <div class="sa-avatar">{{ strtoupper(substr($admin->nama_lengkap ?? $admin->username ?? 'S', 0, 1)) }}</div>
                                    <div>
                                        <strong>
                                            {{ $admin->nama_lengkap ?? '-' }}
                                            @if(Auth::id() === $admin->id)
                                                <span class="sa-badge sa-you">Anda</span>
                                            @endif
                                        </strong>
                                        <small>ID User #{{ $admin->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $admin->username ?? '-' }}</td>
                            <td>{{ $admin->email ?? '-' }}</td>
                            <td>{{ $admin->nomor_hp ?? '-' }}</td>
                            <td><span class="sa-badge">Super Admin</span></td>
                            <td>
                                <div class="sa-row-actions">
                                    <button
                                        type="button"
                                        class="sa-btn sa-btn-edit"
                                        data-id="{{ $admin->id }}"
                                        data-username="{{ $admin->username ?? '' }}"
                                        data-nama="{{ $admin->nama_lengkap ?? '' }}"
                                        data-email="{{ $admin->email ?? '' }}"
                                        data-nomor-hp="{{ $admin->nomor_hp ?? '' }}"
                                        onclick="openEditModalFromButton(this)"
                                    >Edit</button>

                                    @if(Auth::id() !== $admin->id)
                                        <form method="POST" action="{{ route('super.users.delete', $admin->id) }}" onsubmit="return confirm('Yakin ingin menghapus Super Admin ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="sa-btn sa-btn-danger" type="submit">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="sa-empty">Belum ada data Super Admin.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($superAdmins->hasPages())
                <div class="sa-pagination">
                    {{ $superAdmins->links() }}
                </div>
            @endif
        </section>
    </main>
</div>

<div class="sa-modal" id="createModal">
    <div class="sa-modal-card">
        <div class="sa-modal-head">
            <div>
                <h2>Tambah Super Admin</h2>
                <small>Akun baru otomatis memiliki role Super Admin.</small>
            </div>
            <button class="sa-close" type="button" onclick="closeModal('createModal')">×</button>
        </div>

        <form method="POST" action="{{ route('super.users.store') }}">
            @csrf
            <div class="sa-grid">
                <div class="sa-field">
                    <label>Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required>
                </div>
                <div class="sa-field">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                </div>
                <div class="sa-field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="sa-field">
                    <label>No. Telepon</label>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" required>
                </div>
                <div class="sa-field">
                    <label>Password</label>
                    <input type="password" name="password" minlength="6" required>
                </div>
                <div class="sa-field">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" minlength="6" required>
                </div>
            </div>

            <div class="sa-form-actions">
                <button class="sa-btn sa-btn-light" type="button" onclick="closeModal('createModal')">Batal</button>
                <button class="sa-btn sa-btn-primary" type="submit">Simpan Super Admin</button>
            </div>
        </form>
    </div>
</div>

<div class="sa-modal" id="editModal">
    <div class="sa-modal-card">
        <div class="sa-modal-head">
            <div>
                <h2>Edit Super Admin</h2>
                <small>Kosongkan password jika tidak ingin menggantinya.</small>
            </div>
            <button class="sa-close" type="button" onclick="closeModal('editModal')">×</button>
        </div>

        <form id="editForm" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="sa-grid">
                <div class="sa-field">
                    <label>Username</label>
                    <input id="editUsername" type="text" name="username" required>
                </div>
                <div class="sa-field">
                    <label>Nama Lengkap</label>
                    <input id="editNamaLengkap" type="text" name="nama_lengkap" required>
                </div>
                <div class="sa-field">
                    <label>Email</label>
                    <input id="editEmail" type="email" name="email" required>
                </div>
                <div class="sa-field">
                    <label>No. Telepon</label>
                    <input id="editNomorHp" type="text" name="nomor_hp" required>
                </div>
                <div class="sa-field">
                    <label>Password Baru</label>
                    <input type="password" name="password" minlength="6">
                </div>
                <div class="sa-field">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" minlength="6">
                </div>
            </div>

            <div class="sa-form-actions">
                <button class="sa-btn sa-btn-light" type="button" onclick="closeModal('editModal')">Batal</button>
                <button class="sa-btn sa-btn-primary" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.add('open');
    }

    function openEditModalFromButton(button) {
        document.getElementById('editUsername').value = button.dataset.username || '';
        document.getElementById('editNamaLengkap').value = button.dataset.nama || '';
        document.getElementById('editEmail').value = button.dataset.email || '';
        document.getElementById('editNomorHp').value = button.dataset.nomorHp || '';
        document.getElementById('editForm').action = "{{ url('/super-admin/users') }}/" + button.dataset.id;
        document.getElementById('editModal').classList.add('open');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
    }

    document.querySelectorAll('.sa-modal').forEach(function(modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('open');
            }
        });
    });

    @if($errors->any() && old('username'))
        openCreateModal();
    @endif
</script>
</body>
</html>
