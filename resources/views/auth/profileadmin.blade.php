<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/css/dashboard.css">

    
    <style>
        /* =========================================================
           PROFILE ADMIN / TEKNISI - PROFESSIONAL LARGE LAPTOP LAYOUT
           Diperbesar untuk ThinkPad 13" / 1366x768 tanpa mengubah struktur
           ========================================================= */

        :root {
            --profile-bg: #f5f7fb;
            --profile-card: #ffffff;
            --profile-border: #e5e7eb;
            --profile-text: #111827;
            --profile-muted: #6b7280;
            --profile-primary: #ef233c;
            --profile-primary-dark: #d90429;
            --profile-input-bg: #ffffff;
            --profile-readonly: #f8fafc;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            background: var(--profile-bg);
        }

        .dashboard-page {
            min-height: 100vh;
        }

        .dashboard-content.profile-page {
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
            padding: 22px 28px 30px;
            overflow-x: hidden;
            background: var(--profile-bg);
        }

        /* Header */
        .profile-header {
            width: 100%;
            box-sizing: border-box;
            align-items: center;
            margin-bottom: 14px;
        }

        .profile-header .page-label {
            margin-bottom: 3px;
            font-size: 12px;
            letter-spacing: .16em;
            color: #64748b;
            text-transform: uppercase;
        }

        .profile-header h1 {
            margin: 0;
            font-size: 31px;
            line-height: 1.15;
            color: var(--profile-text);
        }

        .profile-search-bar {
            display: none !important;
        }

        /* Main profile content */
        .profile-content {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0;
            box-sizing: border-box;
        }

        /* Avatar */
        .profile-top-card {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin: 2px 0 18px;
            box-sizing: border-box;
        }

        .profile-avatar-large {
            width: 126px;
            height: 126px;
            border-radius: 50%;
            overflow: hidden;
            background: #e5e7eb;
            border: 4px solid #ffffff;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: 700;
            color: #64748b;
            flex-shrink: 0;
        }

        .profile-avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Form card */
        .profile-form-card {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 26px 28px 24px;
            background: var(--profile-card);
            border: 1px solid var(--profile-border);
            border-radius: 20px;
            box-sizing: border-box;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .profile-row {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 18px;
            align-items: end;
        }

        .profile-row:last-child {
            margin-bottom: 0;
        }

        .profile-field {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .profile-field.full-width {
            grid-column: 1 / -1;
        }

        .profile-field label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .profile-field input {
            width: 100%;
            min-width: 0;
            height: 46px;
            padding: 0 14px;
            border: 1px solid #d8dee8;
            border-radius: 10px;
            background: var(--profile-input-bg);
            color: #1f2937;
            font-size: 14px;
            line-height: 46px;
            outline: none;
            box-sizing: border-box;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .profile-field input::placeholder {
            color: #9ca3af;
        }

        .profile-field input:focus {
            border-color: var(--profile-primary);
            box-shadow: 0 0 0 3px rgba(239, 35, 60, 0.08);
        }

        .profile-field input[readonly] {
            background: var(--profile-readonly);
            color: #64748b;
            cursor: not-allowed;
        }

        /* Password section */
        .profile-password-row {
            display: block;
            width: 100%;
            margin-top: 4px;
            margin-bottom: 14px;
            padding-top: 8px;
            border-top: 1px solid #eef2f7;
        }

        .profile-password-row h3 {
            margin: 12px 0 0;
            font-size: 18px;
            color: var(--profile-text);
        }

        /* Buttons */
        .profile-edit-button {
            min-width: 178px;
            min-height: 44px;
            padding: 0 20px;
            border: 0;
            border-radius: 10px;
            background: var(--profile-primary);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 14px rgba(239, 35, 60, 0.18);
            transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .profile-edit-button:hover {
            background: var(--profile-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(239, 35, 60, 0.22);
        }

        .profile-save-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 18px;
        }

        /* =========================================================
           THINKPAD 13" / 1366px
           ========================================================= */
        @media (max-width: 1366px) {
            .dashboard-content.profile-page {
                padding: 18px 22px 24px;
            }

            .profile-content {
                max-width: 1120px;
            }

            .profile-header h1 {
                font-size: 28px;
            }

            .profile-avatar-large {
                width: 112px;
                height: 112px;
                font-size: 34px;
            }

            .profile-form-card {
                padding: 22px 24px 20px;
            }

            .profile-row {
                gap: 18px;
                margin-bottom: 16px;
            }

            .profile-field label {
                font-size: 13px;
            }

            .profile-field input {
                height: 44px;
                line-height: 44px;
                font-size: 13px;
            }

            .profile-edit-button {
                min-height: 42px;
                min-width: 166px;
                font-size: 13px;
            }
        }

        /* =========================================================
           LAPTOP KECIL / TABLET LANDSCAPE
           ========================================================= */
        @media (max-width: 1100px) {
            .profile-content {
                max-width: 100%;
            }

            .profile-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .profile-field.full-width {
                grid-column: 1 / -1;
            }
        }

        /* =========================================================
           MOBILE
           ========================================================= */
        @media (max-width: 768px) {
            .dashboard-content.profile-page {
                padding: 14px 12px 20px;
            }

            .profile-header h1 {
                font-size: 23px;
            }

            .profile-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .profile-field.full-width {
                grid-column: auto;
            }

            .profile-form-card {
                padding: 16px;
            }

            .profile-avatar-large {
                width: 92px;
                height: 92px;
            }

            .profile-save-wrapper {
                justify-content: stretch;
            }

            .profile-save-wrapper .profile-edit-button {
                width: 100%;
            }
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
                    <a
                        href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('checkin') }}"
                        class="{{ request()->routeIs('checkin') ? 'active' : '' }}"
                    >
                        Chekin/Chekout
                    </a>
                </nav>
            </div>

            <div class="sidebar-section">
                <h2>Main Menu</h2>

                <nav class="dashboard-nav">
                    <details class="sidebar-dropdown" open>
                        <summary>Setting</summary>

                        <div class="sidebar-dropdown-menu">
                            <a
                                href="{{ route('profile') }}"
                                class="{{ request()->routeIs('profile') ? 'active' : '' }}"
                            >
                                Profile
                            </a>
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

                @if(session('success'))
                    <div style="margin-bottom:16px;padding:14px 16px;border-radius:10px;background:#dcfce7;color:#166534;font-size:14px;font-weight:600;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="margin-bottom:16px;padding:14px 16px;border-radius:10px;background:#fee2e2;color:#b91c1c;font-size:14px;">
                        <strong>Data belum bisa disimpan:</strong>
                        <ul style="margin:8px 0 0 18px;padding:0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('profile.update') }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    <div class="profile-top-card">
                        <div
                            class="profile-avatar-large"
                            style="
                                overflow:hidden;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            "
                        >
                            @if(!empty($user['foto_profil']))
                                <img
                                    src="{{ asset($user['foto_profil']) }}"
                                    alt="Foto Profil"
                                    style="width:100%;height:100%;object-fit:cover;"
                                >
                            @else
                                {{ strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 1)) }}
                            @endif
                        </div>

                        <label
                            for="foto_profil"
                            class="profile-edit-button"
                            style="cursor:pointer;display:inline-flex;align-items:center;justify-content:center;"
                        >
                            Edit Foto Profil
                        </label>

                        <input
                            id="foto_profil"
                            type="file"
                            name="foto_profil"
                            accept=".jpg,.jpeg,.png,.webp"
                            style="display:none;"
                        >
                    </div>

                    <div class="profile-form-card">
                        <div class="profile-row">
                            <div class="profile-field">
                                <label>Nama / Username</label>
                                <input
                                    type="text"
                                    name="username"
                                    value="{{ old('username', $user['nama']) }}"
                                    required
                                >
                            </div>

                            <div class="profile-field">
                                <label>Nama Lengkap</label>
                                <input
                                    type="text"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $user['nama_lengkap']) }}"
                                    required
                                >
                            </div>
                        </div>

                        <div class="profile-row">
                            <div class="profile-field full-width">
                                <label>Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $user['email']) }}"
                                    required
                                >
                            </div>
                        </div>

                        <div class="profile-row">
                            <div class="profile-field">
                                <label>Nomor HP</label>
                                <input
                                    type="text"
                                    name="nomor_hp"
                                    value="{{ old('nomor_hp', $user['nomor_hp']) }}"
                                    placeholder="Masukkan nomor HP"
                                >
                            </div>

                            <div class="profile-field">
                                <label>Role</label>
                                <input
                                    type="text"
                                    value="{{ $user['role'] }}"
                                    readonly
                                >
                            </div>
                        </div>

                        <div class="profile-row profile-password-row">
                            <h3>Change Password</h3>
                        </div>

                        <div class="profile-row">
                            <div class="profile-field">
                                <label>Kata Sandi saat ini</label>
                                <input
                                    type="password"
                                    name="current_password"
                                    placeholder="Isi hanya jika ingin mengganti password"
                                    autocomplete="current-password"
                                >
                            </div>

                            <div class="profile-field">
                                <label>Password Baru</label>
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Minimal 6 karakter"
                                    autocomplete="new-password"
                                >
                            </div>
                        </div>

                        <div class="profile-row">
                            <div class="profile-field full-width">
                                <label>Konfirmasi Password Baru</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Ulangi password baru"
                                    autocomplete="new-password"
                                >
                            </div>
                        </div>

                        <div class="profile-save-wrapper">
                            <button
                                type="submit"
                                class="profile-edit-button"
                                style="border:0;min-width:160px;cursor:pointer;"
                            >
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
