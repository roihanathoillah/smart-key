<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Profile</title>
    <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>
    <div class="dashboard-page">
        <aside class="dashboard-sidebar">
            <div class="brand">
                <span class="brand-logo">SK</span>
                <div>
                    <h1>Smart Key</h1>
                    <p>Super Admin</p>
                </div>
            </div>

            <div class="sidebar-section">
                <h2>MENU</h2>
                <nav class="dashboard-nav">
                    <a href="{{ route('super.admin') }}" class="{{ request()->routeIs('super.admin') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('karyawan.super') }}" class="{{ request()->routeIs('karyawan.super') ? 'active' : '' }}">Daftar Karyawan</a>
                    <a href="{{ route('history.super') }}" class="{{ request()->routeIs('history.super') ? 'active' : '' }}">History</a>
                </nav>
            </div>

            <div class="sidebar-section">
                <h2>MAIN MENU</h2>
                <nav class="dashboard-nav">
                    <details class="sidebar-dropdown" open>
                        <summary>Setting</summary>
                        <div class="sidebar-dropdown-menu">
                            <a href="{{ route('profile.super') }}" class="{{ request()->routeIs('profile.super') ? 'active' : '' }}">Profile</a>
                        </div>
                    </details>
                </nav>
            </div>
        </aside>

        <main class="dashboard-content profile-page">
            @if (session('success'))
                <div class="dashboard-alert success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="dashboard-alert error">{{ $errors->first() }}</div>
            @endif
            <header class="dashboard-header page-header profile-header">
                <div>
                    <p class="page-label">Profil information</p>
                    <h1>Profil information</h1>
                </div>
            </header>

            <section class="profile-content">
                <div class="profile-top-card">
                    <div class="profile-avatar-large" id="profile-avatar-preview">
                        @if (!empty($user['foto_profil']))
                            <img src="{{ asset($user['foto_profil']) }}" alt="Foto profil">
                        @endif
                    </div>
                    <button type="button" class="profile-edit-button" id="profile-photo-trigger">Edit Foto Profil</button>
                    <input type="file" id="profile-photo-input" name="foto_profil" form="profile-form" accept="image/jpeg,image/png,image/webp" hidden>
                </div>

                <form id="profile-form" method="POST" action="{{ route('profile.super.update') }}" class="profile-form-card" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="profile-row">
                        <div class="profile-field">
                            <label>Nama</label>
                            <input type="text" name="username" value="{{ old('username', $user['nama']) }}" required>
                        </div>
                        <div class="profile-field">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user['nama_lengkap']) }}" required>
                        </div>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field full-width">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $user['email']) }}" required>
                        </div>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field">
                            <label>Nomor HP</label>
                            <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $user['nomor_hp']) }}" required>
                        </div>
                        <div class="profile-field">
                            <label>Role</label>
                            <input type="text" value="{{ $user['role'] }}" readonly>
                        </div>
                    </div>

                    <div class="profile-row profile-password-row">
                        <h3>Change Password</h3>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field">
                            <label>Kata Sandi saat ini</label>
                            <div class="profile-password-input">
                                <input type="password" name="current_password" placeholder="Masukkan kata sandi saat ini">
                                <button type="button" class="password-toggle" data-password-toggle aria-label="Lihat password" title="Lihat password">&#128065;</button>
                            </div>
                        </div>
                        <div class="profile-field">
                            <label>Konfirmasi Password</label>
                            <div class="profile-password-input">
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
                                <button type="button" class="password-toggle" data-password-toggle aria-label="Lihat password" title="Lihat password">&#128065;</button>
                            </div>
                        </div>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field full-width">
                            <label>Password</label>
                            <div class="profile-password-input">
                                <input type="password" name="password" placeholder="Masukkan password baru">
                                <button type="button" class="password-toggle" data-password-toggle aria-label="Lihat password" title="Lihat password">&#128065;</button>
                            </div>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <button type="submit" class="profile-save-button">Simpan Perubahan</button>
                    </div>
                </form>
            </section>
        </main>
    </div>
    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                var input = button.parentElement.querySelector('input');
                var isVisible = input.type === 'text';

                input.type = isVisible ? 'password' : 'text';
                button.innerHTML = isVisible ? '&#128065;' : '&#128064;';
                button.title = isVisible ? 'Lihat password' : 'Sembunyikan password';
                button.setAttribute('aria-label', isVisible ? 'Lihat password' : 'Sembunyikan password');
            });
        });

        var photoTrigger = document.getElementById('profile-photo-trigger');
        var photoInput = document.getElementById('profile-photo-input');
        var photoPreview = document.getElementById('profile-avatar-preview');

        if (photoTrigger && photoInput && photoPreview) {
            photoTrigger.addEventListener('click', function () {
                photoInput.click();
            });

            photoInput.addEventListener('change', function () {
                var file = photoInput.files[0];

                if (!file) {
                    return;
                }

                var imageUrl = URL.createObjectURL(file);
                photoPreview.innerHTML = '<img src="' + imageUrl + '" alt="Foto profil">';
            });
        }
    </script>
</body>
</html>
