<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/css/login.css">
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
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('karyawan') }}">Daftar Karyawan</a>
                    <a href="{{ route('history') }}">History</a>
                    <a href="{{ route('checkin') }}">Chekin/Chekout</a>
                </nav>
            </div>

            <div class="sidebar-section">
                <h2>Main Menu</h2>
                <nav class="dashboard-nav">
                    <details class="sidebar-dropdown" open>
                        <summary>Setting</summary>
                        <div class="sidebar-dropdown-menu">
                            <a href="{{ route('profile') }}" class="active">Profile</a>
                            <a href="#">Notification</a>
                            <a href="#">Security</a>
                        </div>
                    </details>
                </nav>
            </div>
        </aside>

        <main class="dashboard-content profile-page">
            <header class="dashboard-header page-header profile-header">
                <div>
                    <p class="page-label">Profile information</p>
                    <h1>Profil information</h1>
                </div>
                <div class="search-bar profile-search-bar">
                    <input type="text" placeholder="Search by order id">
                    <button class="search-button">🔍</button>
                </div>
            </header>

            <section class="profile-content">
                <div class="profile-top-card">
                    <div class="profile-avatar-large"></div>
                    <button type="button" class="profile-edit-button">Edit Foto Profil</button>
                </div>

                <div class="profile-form-card">
                    <div class="profile-row">
                        <div class="profile-field">
                            <label>Nama</label>
                            <input type="text" value="{{ $user['nama'] }}" readonly>
                        </div>
                        <div class="profile-field">
                            <label>Nama Lengkap</label>
                            <input type="text" value="{{ $user['nama_lengkap'] }}" readonly>
                        </div>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field full-width">
                            <label>Email</label>
                            <input type="text" value="{{ $user['email'] }}" readonly>
                        </div>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field">
                            <label>Nomor HP</label>
                            <input type="text" value="{{ $user['nomor_hp'] }}" readonly>
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
                            <input type="password" placeholder="••••••••••••" readonly>
                        </div>
                        <div class="profile-field">
                            <label>Konfirmasi Password</label>
                            <input type="password" placeholder="••••••••••••" readonly>
                        </div>
                    </div>

                    <div class="profile-row">
                        <div class="profile-field full-width">
                            <label>Password</label>
                            <input type="password" placeholder="••••••••••••" readonly>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
