<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkin/Checkout</title>

    <link rel="stylesheet" href="/css/dashboard.css">

    <style>
        /* =========================================================
           SMART BOX & DISTRICT
           ========================================================= */

        .smartbox-panel {
            margin-top: 20px;
            padding: 18px 20px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
        }

        .smartbox-panel-title {
            margin: 0 0 18px 0;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .smartbox-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .smartbox-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .smartbox-field label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .smartbox-field select {
            width: 100%;
            min-height: 48px;
            padding: 0 14px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 15px;
            outline: none;
            cursor: pointer;
        }

        .smartbox-field input {
            width: 100%;
            min-height: 48px;
            padding: 0 14px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 15px;
            outline: none;
        }

        .smartbox-field select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .smartbox-info {
            margin-top: 14px;
            padding: 12px 14px;
            background: #f8fafc;
            border-radius: 10px;
            color: #64748b;
            font-size: 13px;
        }

        .smartbox-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-left: 5px;
            padding: 4px 9px;
            border-radius: 20px;
            background: #dcfce7;
            color: #15803d;
            font-size: 12px;
            font-weight: 700;
        }

        .smartbox-empty {
            padding: 14px;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 14px;
        }



        /* =========================================================
           ODC SEARCHABLE CASCADING DROPDOWN
           ========================================================= */

        .odc-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .odc-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .odc-field label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .odc-field input {
            width: 100%;
            min-height: 48px;
            padding: 0 14px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
        }

        .odc-field input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .odc-field input:disabled,
        .odc-field input[readonly] {
            background: #f8fafc;
            color: #64748b;
        }

        .odc-result {
            margin-top: 14px;
            padding: 12px 14px;
            background: #f8fafc;
            border-radius: 10px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }

        .odc-result strong {
            color: #1f2937;
        }

        .odc-result.ready {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .odc-help {
            margin-top: 4px;
            color: #64748b;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .odc-grid {
                grid-template-columns: 1fr;
            }
        }


        /* =========================================================
           COMPACT SEARCHABLE CODE DROPDOWN
           ========================================================= */

        .odc-code-autocomplete {
            position: relative;
        }

        .odc-code-suggestions {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            z-index: 50;
            max-height: 220px;
            overflow-y: auto;
            background: #ffffff;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.12);
        }

        .odc-code-suggestions.show {
            display: block;
        }

        .odc-code-option {
            width: 100%;
            padding: 10px 14px;
            border: 0;
            background: #ffffff;
            text-align: left;
            font-size: 14px;
            color: #1f2937;
            cursor: pointer;
        }

        .odc-code-option:hover,
        .odc-code-option.active {
            background: #f1f5f9;
        }

        .odc-code-empty {
            padding: 10px 14px;
            font-size: 13px;
            color: #64748b;
        }

        /* =========================================================
           STATUS RFID / IOT
           ========================================================= */

        .rfid-status-panel {
            margin-bottom: 16px;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #1e40af;
            font-size: 14px;
            line-height: 1.55;
        }

        .rfid-status-panel strong {
            display: block;
            margin-bottom: 3px;
            font-size: 14px;
        }

        .rfid-status-panel.ready {
            border-color: #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        .rfid-status-panel.error {
            border-color: #fecaca;
            background: #fef2f2;
            color: #b91c1c;
        }

        .employee-status.waiting {
            background: #e2e8f0;
            color: #475569;
        }


        /* =========================================================
           PROFIL KARYAWAN
           ========================================================= */

        .employee-profile-list {
            display: grid;
            grid-template-columns: 150px 14px minmax(0, 1fr);
            row-gap: 8px;
            align-items: start;
            font-size: 14px;
            color: #1f2937;
        }

        .employee-profile-label {
            font-weight: 700;
        }

        .employee-profile-separator {
            font-weight: 700;
        }

        .employee-profile-value {
            min-width: 0;
            word-break: break-word;
        }

        .employee-profile-content {
            display: grid;
            grid-template-columns: 170px minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .employee-photo-box {
            width: 170px;
            height: 190px;
            border-radius: 8px;
            overflow: hidden;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 5px rgba(15, 23, 42, 0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
        }

        .employee-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .employee-photo-placeholder {
            padding: 12px;
            text-align: center;
            line-height: 1.5;
        }

        @media (max-width: 600px) {
            .employee-profile-list {
                grid-template-columns: 120px 14px minmax(0, 1fr);
            }

            .employee-profile-content {
                grid-template-columns: 1fr;
            }

            .employee-photo-box {
                width: 100%;
                max-width: 170px;
                height: 190px;
            }
        }


        /* =========================================================
           LAYANAN / PEKERJAAN
           ========================================================= */

        .service-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .service-card {
            padding: 20px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-sizing: border-box;
        }

        .service-card h4 {
            margin: 0 0 16px 0;
            font-size: 17px;
            font-weight: 700;
            color: #1f2937;
        }

        .service-option {
            width: 100%;
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 14px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
            font-weight: 700;
            cursor: default;
            box-sizing: border-box;
        }

        .service-option:hover {
            border-color: #d9dee7;
            background: #ffffff;
        }

        .service-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }

        .service-field:last-child {
            margin-bottom: 0;
        }

        .service-field label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .service-field textarea {
            width: 100%;
            box-sizing: border-box;
            min-height: 110px;
            padding: 12px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
            outline: none;
            resize: vertical;
            font-family: inherit;
        }

        .service-field textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .service-help {
            margin-top: 6px;
            font-size: 12px;
            color: #64748b;
        }

        .service-required {
            color: #dc2626;
        }

        .service-error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 12px;
        }



        /* =========================================================
           PENYESUAIAN CHECKIN/CHECKOUT SESUAI FLOWCHART
           ========================================================= */

        .checkin-card {
            background: transparent;
            box-shadow: none;
            border: 0;
            padding: 0;
        }

        .checkin-top {
            background: #ffffff;
            border: 1px solid #d9dee7;
            border-radius: 16px;
            padding: 22px;
            box-sizing: border-box;
        }

        .checkin-info h3 {
            margin: 0 0 18px 0;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .service-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            padding: 20px;
            background: #ffffff;
            border: 1px solid #d9dee7;
            border-radius: 16px;
        }

        .service-card {
            border-radius: 12px;
            box-shadow: none;
        }

        .service-card h4 {
            display: none;
        }

        .service-option {
            margin-bottom: 10px;
            background: #f8fafc;
            cursor: default;
        }

        .service-field textarea {
            min-height: 90px;
        }

        .checkin-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        #edit-service-button {
            display: none;
        }

        #checkout-form button[type="submit"] {
            min-width: 210px;
            min-height: 48px;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: none;
        }
#checkout-form button[type="submit"] {
            background: #16a34a;
        }

        #checkout-form button[type="submit"]:hover:not(:disabled) {
            background: #15803d;
        }

        #checkout-form button[type="submit"]:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .service-grid {
                grid-template-columns: 1fr;
            }

            #checkout-form button[type="submit"] {
                width: 100%;
                min-width: 0;
            }
        }


        /* =========================================================
           BUTTON DISABLED
           ========================================================= */

        .btn-red:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }


        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 768px) {

            .smartbox-grid,
            .service-grid {
                grid-template-columns: 1fr;
            }

        }
    </style>

    <style>
        /* =========================================================
           HEADER ACTIONS - NOTIFICATION + PROFILE
           ========================================================= */

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification-button-wrapper,
        .header-profile-wrapper {
            position: relative;
        }

        .notification-button,
        .header-profile-button {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            box-shadow: 0 5px 16px rgba(15, 23, 42, 0.07);
            cursor: pointer;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .notification-button:hover,
        .header-profile-button:hover {
            transform: translateY(-1px);
            border-color: #d1d5db;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.10);
        }

        .notification-button {
            position: relative;
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .bell-icon {
            font-size: 18px;
        }

        .notification-dot {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #ef233c;
            color: #ffffff;
            border: 2px solid #ffffff;
            font-size: 10px;
            font-weight: 800;
            box-sizing: border-box;
        }

        .notification-menu,
        .header-profile-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            z-index: 200;
            display: none;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
            overflow: hidden;
        }

        .notification-menu.show,
        .header-profile-menu.show {
            display: block;
        }

        .notification-menu {
            width: 350px;
            max-height: 430px;
        }

        .notification-menu-header {
            padding: 16px 18px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eef2f7;
        }

        .notification-menu-header strong {
            font-size: 15px;
            color: #111827;
        }

        .notification-menu-header span {
            font-size: 11px;
            color: #64748b;
        }

        .notification-list {
            max-height: 315px;
            overflow-y: auto;
        }

        .notification-item-form {
            margin: 0;
        }

        .notification-item {
            width: 100%;
            border: 0;
            border-bottom: 1px solid #f1f5f9;
            background: #ffffff;
            padding: 13px 16px;
            text-align: left;
            cursor: pointer;
            display: block;
            box-sizing: border-box;
        }

        .notification-item:hover {
            background: #f8fafc;
        }

        .notification-item.unread {
            background: #fff7f7;
        }

        .notification-item-title {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
            font-weight: 750;
            color: #111827;
        }

        .notification-item-message {
            display: block;
            font-size: 12px;
            line-height: 1.45;
            color: #64748b;
        }

        .notification-item-time {
            display: block;
            margin-top: 6px;
            font-size: 10px;
            color: #94a3b8;
        }

        .notification-empty {
            padding: 28px 18px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }

        .notification-menu-footer {
            padding: 10px 12px;
            border-top: 1px solid #eef2f7;
            background: #fafafa;
        }

        .notification-read-all {
            width: 100%;
            border: 0;
            background: transparent;
            color: #ef233c;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            padding: 8px;
        }

        .header-profile-button {
            min-width: 132px;
            height: 48px;
            border-radius: 14px;
            padding: 5px 10px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .header-profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
        }

        .header-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-profile-copy {
            min-width: 0;
            flex: 1;
            text-align: left;
        }

        .header-profile-copy strong {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 78px;
            font-size: 12px;
            color: #111827;
        }

        .header-profile-copy span {
            display: block;
            margin-top: 1px;
            font-size: 10px;
            color: #64748b;
        }

        .header-profile-arrow {
            color: #94a3b8;
            font-size: 10px;
        }

        .header-profile-menu {
            width: 260px;
        }

        .header-profile-summary {
            padding: 16px;
            background: #fafafa;
            border-bottom: 1px solid #eef2f7;
        }

        .header-profile-summary strong {
            display: block;
            color: #111827;
            font-size: 14px;
        }

        .header-profile-summary span {
            display: block;
            margin-top: 4px;
            color: #64748b;
            font-size: 11px;
            word-break: break-word;
        }

        .header-profile-link,
        .header-logout-button {
            width: 100%;
            min-height: 44px;
            padding: 0 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 0;
            background: #ffffff;
            color: #374151;
            font-size: 12px;
            font-weight: 650;
            text-decoration: none;
            cursor: pointer;
            box-sizing: border-box;
        }

        .header-profile-link:hover,
        .header-logout-button:hover {
            background: #f8fafc;
        }

        .header-logout-button {
            color: #dc2626;
            border-top: 1px solid #eef2f7;
        }

        @media (max-width: 900px) {
            .header-profile-copy,
            .header-profile-arrow {
                display: none;
            }

            .header-profile-button {
                min-width: 46px;
                width: 46px;
                padding: 5px;
                justify-content: center;
            }

            .notification-menu {
                width: min(340px, calc(100vw - 28px));
            }
        }
    </style>

</head>


<body>

<div class="dashboard-page">


    <!-- =========================================================
         SIDEBAR
         ========================================================= -->

    <aside class="dashboard-sidebar">

        <div class="brand">

            <span class="brand-logo">
                SK
            </span>

            <div>

                <h1>
                    Smart Key
                </h1>

                <p>
                    Admin Dashboard
                </p>

            </div>

        </div>


        <div class="sidebar-section">

            <h2>
                Menu
            </h2>

            <nav class="dashboard-nav">

                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    Dashboard

                </a>


                <a href="{{ route('checkin') }}"
                   class="{{ request()->routeIs('checkin') ? 'active' : '' }}">

                    Chekin/Chekout

                </a>

            </nav>

        </div>


        <div class="sidebar-section">

            <h2>
                Main Menu
            </h2>

            <nav class="dashboard-nav">

                <details class="sidebar-dropdown">

                    <summary>
                        Setting
                    </summary>

                    <div class="sidebar-dropdown-menu">

                        <a href="{{ route('profile') }}"
                           class="{{ request()->routeIs('profile') ? 'active' : '' }}">

                            Profile

                        </a>

                    </div>

                </details>

            </nav>

        </div>

    </aside>



    <!-- =========================================================
         MAIN CONTENT
         ========================================================= -->

    <main class="dashboard-content">


        <!-- =========================================================
             HEADER
             ========================================================= -->

        <header class="dashboard-header page-header">

            <div>

                <h1>
                    Checkin/Checkout
                </h1>

            </div>


            <div class="header-actions">

                <!-- =====================================================
                     NOTIFIKASI
                     ===================================================== -->
                <div class="notification-button-wrapper">

                    <button
                        type="button"
                        class="notification-button"
                        id="notification-toggle"
                        aria-haspopup="true"
                        aria-expanded="false"
                        aria-label="Buka notifikasi"
                    >
                        <span class="bell-icon">🔔</span>

                        @if(($unreadNotificationCount ?? 0) > 0)
                            <span class="notification-dot">
                                {{ ($unreadNotificationCount ?? 0) > 99 ? '99+' : $unreadNotificationCount }}
                            </span>
                        @endif
                    </button>

                    <div
                        class="notification-menu"
                        id="notification-menu"
                        role="menu"
                    >
                        <div class="notification-menu-header">
                            <strong>Notifikasi</strong>
                            <span>
                                {{ $unreadNotificationCount ?? 0 }} belum dibaca
                            </span>
                        </div>

                        <div class="notification-list">
                            @forelse(($notifications ?? collect()) as $notification)
                                <form
                                    method="POST"
                                    action="{{ route('notifications.read', $notification->id) }}"
                                    class="notification-item-form"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="notification-item {{ (int) $notification->is_read === 0 ? 'unread' : '' }}"
                                    >
                                        <span class="notification-item-title">
                                            {{ $notification->title }}
                                        </span>

                                        <span class="notification-item-message">
                                            {{ $notification->message }}
                                        </span>

                                        <span class="notification-item-time">
                                            {{ !empty($notification->created_at) ? \Carbon\Carbon::parse($notification->created_at)->diffForHumans() : '-' }}
                                        </span>
                                    </button>
                                </form>
                            @empty
                                <div class="notification-empty">
                                    Belum ada notifikasi.
                                </div>
                            @endforelse
                        </div>

                        @if(($unreadNotificationCount ?? 0) > 0)
                            <div class="notification-menu-footer">
                                <form
                                    method="POST"
                                    action="{{ route('notifications.readAll') }}"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="notification-read-all"
                                    >
                                        Tandai semua sudah dibaca
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>


                <!-- =====================================================
                     PROFILE
                     ===================================================== -->
                <div class="header-profile-wrapper">

                    @php
                        $headerName =
                            $headerUser?->nama_lengkap
                            ?? $headerUser?->username
                            ?? 'Admin';

                        $headerInitial =
                            strtoupper(
                                substr(
                                    trim((string) $headerName),
                                    0,
                                    1
                                )
                            );

                        $headerRole =
                            strtolower((string) ($headerUser?->role ?? 'admin')) === 'super_admin'
                                ? 'Super Admin'
                                : 'Admin / Teknisi';
                    @endphp

                    <button
                        type="button"
                        class="header-profile-button"
                        id="profile-toggle"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <span class="header-profile-avatar">
                            @if(!empty($headerUser?->foto_profil))
                                <img
                                    src="{{ asset($headerUser->foto_profil) }}"
                                    alt="Foto profil"
                                >
                            @else
                                {{ $headerInitial ?: 'A' }}
                            @endif
                        </span>

                        <span class="header-profile-copy">
                            <strong>{{ $headerName }}</strong>
                            <span>{{ $headerRole }}</span>
                        </span>

                        <span class="header-profile-arrow">▼</span>
                    </button>

                    <div
                        class="header-profile-menu"
                        id="profile-menu"
                    >
                        <div class="header-profile-summary">
                            <strong>{{ $headerName }}</strong>
                            <span>{{ $headerUser?->email ?? '-' }}</span>
                        </div>

                        <a
                            href="{{ route('profile') }}"
                            class="header-profile-link"
                        >
                            👤 &nbsp; Profil Saya
                        </a>

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                            style="margin:0;"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="header-logout-button"
                            >
                                ↪ &nbsp; Keluar
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </header>



        <!-- =========================================================
             CONTENT
             ========================================================= -->

        <section class="dashboard-grid">

            {{-- =====================================================
                 NOTIFIKASI / VALIDASI
                 ===================================================== --}}
            @if(session('success'))
                <div style="margin-bottom:16px;padding:14px 16px;border-radius:10px;background:#dcfce7;color:#166534;font-size:14px;font-weight:600;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="margin-bottom:16px;padding:14px 16px;border-radius:10px;background:#fee2e2;color:#b91c1c;font-size:14px;font-weight:600;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="margin-bottom:16px;padding:14px 16px;border-radius:10px;background:#fee2e2;color:#b91c1c;font-size:14px;">
                    <strong>Data belum bisa diproses:</strong>
                    <ul style="margin:8px 0 0 18px;padding:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- =====================================================
                 STATUS RFID / IOT
                 ===================================================== -->

            <div class="rfid-status-panel
                {{ ($rfidState ?? 'waiting') === 'ready' ? 'ready' : '' }}
                {{ in_array(($rfidState ?? 'waiting'), ['mismatch', 'not_found']) ? 'error' : '' }}
            ">
                <strong>
                    @if(($rfidState ?? 'waiting') === 'ready')
                        ID Card Terverifikasi
                    @elseif(($rfidState ?? 'waiting') === 'mismatch')
                        ID Card Ditolak
                    @elseif(($rfidState ?? 'waiting') === 'not_found')
                        ID Card Tidak Ditemukan
                    @else
                        Menunggu ID Card
                    @endif
                </strong>

                {{ $rfidMessage ?? 'Menunggu pembacaan RFID.' }}
            </div>


            <!-- =====================================================
                 SEARCH KARYAWAN
                 ===================================================== -->

            <div class="history-search-panel checkin-search-panel">

                <form
                    method="get"
                    action="{{ route('checkin') }}"
                    class="history-search-form checkin-search-form"
                >

                    <div class="search-input-wrapper">

                        <input
                            type="text"
                            name="q"
                            placeholder="Simulasi RFID: masukkan ID Card / nama karyawan"
                            value="{{ request('q') }}"
                        >


                        @if(request('box_id'))

                            <input
                                type="hidden"
                                name="box_id"
                                value="{{ request('box_id') }}"
                            >

                        @endif


                        <button
                            type="submit"
                            class="search-button"
                        >
                            🔍
                        </button>

                    </div>

                </form>

            </div>



            <!-- =====================================================
                 CARD CHECKIN
                 ===================================================== -->

            <div class="activity-card checkin-card">


                <!-- =================================================
                     DATA KARYAWAN
                     ================================================= -->

                <div class="checkin-top">

                    <div class="checkin-info">

                        <h3>
                            Profil Karyawan
                        </h3>

                        <p style="margin:-10px 0 16px 0; color:#64748b; font-size:12px;">
                            Data karyawan setelah ID Card terbaca
                        </p>


                        <div class="checkin-row">

                            <div class="employee-profile-content">

                                <div class="employee-photo-box">

                                    @if(!empty($employee['photo']))

                                        <img
                                            src="{{ asset($employee['photo']) }}"
                                            alt="Foto {{ $employee['name'] ?? 'Karyawan' }}"
                                        >

                                    @else

                                        <div class="employee-photo-placeholder">
                                            Foto Karyawan
                                        </div>

                                    @endif

                                </div>


                                <div class="employee-profile-list">

                                    <div class="employee-profile-label">
                                        Nama Lengkap
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['name'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Tanggal Lahir
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['birth_date'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Jenis Kelamin
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['gender'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        NIK
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['nik'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Email
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['email'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Jabatan
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['position'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Alamat
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['address'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Status
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">

                                        <span class="employee-status {{ empty($employee['database_id']) ? 'waiting' : 'berhasil' }}">
                                            {{ $employee['status'] ?? '-' }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        </div>

                    </div>



                    <!-- =================================================
                         ID CARD BADGE
                         ================================================= -->

                    @if(($rfidState ?? 'waiting') === 'ready' && !empty($employee['database_id']))
                        <div class="checkin-badge">

                            <div class="badge">

                                ID Card Terbaca

                                <br>

                                <small>
                                    ID Card Berhasil Diverifikasi
                                </small>

                            </div>


                            <div class="badge-meta">

                                Waktu Scan

                                <br>

                                <small>
                                    {{ now()->format('d/m/Y H:i') }}
                                </small>

                            </div>

                        </div>
                    @endif

                </div>



                <!-- =================================================
                     ODC / SERVICE AREA / STO / KODE
                     SEARCHABLE CASCADING DROPDOWN
                     ================================================= -->

                <div class="smartbox-panel">

                    <h3 class="smartbox-panel-title">
                        Pilih ODC
                    </h3>

                    <div class="odc-grid">

                        <!-- 1. JENIS -->
                        <div class="odc-field">
                            <label for="odc_prefix">
                                Jenis
                            </label>

                            <input
                                id="odc_prefix"
                                type="text"
                                value="ODC"
                                readonly
                            >

                            <div class="odc-help">
                                Jenis perangkat diawali dengan ODC.
                            </div>
                        </div>


                        <!-- 2. SERVICE AREA -->
                        <div class="odc-field">
                            <label for="service_area">
                                Service Area
                            </label>

                            <input
                                id="service_area"
                                type="search"
                                list="service-area-list"
                                autocomplete="off"
                                placeholder="Cari / pilih Service Area..."
                            >

                            <datalist id="service-area-list">
                                <option value="TUREN"></option>
                                <option value="KEPANJEN"></option>
                                <option value="BATU"></option>
                                <option value="BLIMBING"></option>
                                <option value="SINGOSARI"></option>
                                <option value="KLOJEN"></option>
                                <option value="MALANG"></option>
                                <option value="BLITAR"></option>
                                <option value="TULUNG AGUNG"></option>
                            </datalist>

                            <div class="odc-help">
                                Bisa diklik atau langsung diketik untuk mencari.
                            </div>
                        </div>


                        <!-- 3. DATA DI BAWAH SERVICE AREA / STO -->
                        <div class="odc-field">
                            <label for="sto_location">
                                Lokasi / STO
                            </label>

                            <input
                                id="sto_location"
                                type="search"
                                list="sto-location-list"
                                autocomplete="off"
                                placeholder="Pilih Service Area terlebih dahulu..."
                                disabled
                            >

                            <datalist id="sto-location-list"></datalist>

                            <div class="odc-help">
                                Pilihan otomatis mengikuti Service Area.
                            </div>
                        </div>
                        <!-- 4. KODE ODC -->
                        <div class="odc-field">
                            <label for="odc_suffix">
                                Kode
                            </label>

                            <div class="odc-code-autocomplete">
                                <input
                                    id="odc_suffix"
                                    type="text"
                                    autocomplete="off"
                                    placeholder="Ketik kode, contoh: FA / FB / FAA..."
                                    disabled
                                >

                                <div
                                    id="odc-code-suggestions"
                                    class="odc-code-suggestions"
                                ></div>
                            </div>

                            <div class="odc-help">
                                Ketik inisial kode. Pilihan yang cocok saja yang akan muncul.
                            </div>
                        </div>

                    </div>


                    <!-- HASIL KODE ODC -->
                    <div class="odc-result" id="odc-result">
                        Pilih Service Area, Lokasi/STO, dan Kode untuk membentuk ID ODC.
                        <br>
                        <strong id="odc-final-code">-</strong>
                    </div>

                </div>

                <!-- =================================================
                     LAYANAN / PEKERJAAN
                     ================================================= -->

                <div style="margin-top: 22px;">
                    <h3 style="margin:0 0 10px 0; font-size:18px; font-weight:700; color:#1f2937;">
                        Form Layanan / Pekerjaan
                    </h3>
                </div>

                <div class="service-grid">


                    <!-- =================================================
                         SURVEY
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <div
                            class="service-option"
                            data-service-label="Survey"
                        >

                            <span>
                                Survey
                            </span>

                        </div>


                        <div class="service-field">

                            <label for="deskripsi_survey">
                                Deskripsi Pekerjaan
                            </label>


                            <textarea
                                id="deskripsi_survey"
                                class="service-description"
                                data-service="Survey"
                                placeholder="Masukkan deskripsi pekerjaan..."
                            >{{ old('jenis_layanan') === 'Survey' ? old('deskripsi_pekerjaan') : '' }}</textarea>

                        </div>

                    </div>



                    <!-- =================================================
                         DEPLOYMENT
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <div
                            class="service-option"
                            data-service-label="Deployment"
                        >

                            <span>
                                Deployment
                            </span>

                        </div>


                        <div class="service-field">

                            <label for="deskripsi_deployment">
                                Deskripsi Pekerjaan
                            </label>


                            <textarea
                                id="deskripsi_deployment"
                                class="service-description"
                                data-service="Deployment"
                                placeholder="Masukkan deskripsi pekerjaan..."
                            >{{ old('jenis_layanan') === 'Deployment' ? old('deskripsi_pekerjaan') : '' }}</textarea>

                        </div>

                    </div>



                    <!-- =================================================
                         ASSURANCE
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <div
                            class="service-option"
                            data-service-label="Assurance"
                        >

                            <span>
                                Assurance
                            </span>

                        </div>


                        <div class="service-field">

                            <label for="deskripsi_assurance">
                                Deskripsi Pekerjaan
                            </label>


                            <textarea
                                id="deskripsi_assurance"
                                class="service-description"
                                data-service="Assurance"
                                placeholder="Masukkan deskripsi pekerjaan..."
                            >{{ old('jenis_layanan') === 'Assurance' ? old('deskripsi_pekerjaan') : '' }}</textarea>

                        </div>

                    </div>



                    <!-- =================================================
                         MAINTENANCE
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <div
                            class="service-option"
                            data-service-label="Maintenance"
                        >

                            <span>
                                Maintenance
                            </span>

                        </div>


                        <div class="service-field">

                            <label for="deskripsi_maintenance">
                                Deskripsi Pekerjaan
                            </label>


                            <textarea
                                id="deskripsi_maintenance"
                                class="service-description"
                                data-service="Maintenance"
                                placeholder="Masukkan deskripsi pekerjaan..."
                            >{{ old('jenis_layanan') === 'Maintenance' ? old('deskripsi_pekerjaan') : '' }}</textarea>

                        </div>

                    </div>

                </div>



                <!-- =================================================
                     ACTION BUTTON
                     ================================================= -->

                <div class="checkin-actions">


                    <!-- =================================================
                         EDIT
                         ================================================= -->

                    <button
                        type="button"
                        class="btn-red"
                        id="edit-service-button"
                    >
                        EDIT
                    </button>



                    <!-- =================================================
                         FORM CHECKOUT
                         ================================================= -->

                    <form
                        id="checkout-form"
                        method="POST"
                        action="{{ route('checkin.checkout') }}"
                        style="display: inline;"
                    >

                        @csrf


                        <!-- ID KARYAWAN -->

                        <input
                            type="hidden"
                            name="karyawan_id"
                            value="{{ $employee['database_id'] ?? '' }}"
                        >


                        <!-- ID SMART BOX -->

                        <input
                            type="hidden"
                            name="box_id"
                            id="checkout_box_id"
                            value="{{ $smartBoxes->first()->id ?? '' }}"
                        >

                        <input
                            type="hidden"
                            name="odc_code"
                            id="checkout_odc_code"
                            value=""
                        >

                        <input
                            type="hidden"
                            name="service_area"
                            id="checkout_service_area"
                            value=""
                        >

                        <input
                            type="hidden"
                            name="sto_code"
                            id="checkout_sto_code"
                            value=""
                        >

                        <input
                            type="hidden"
                            name="odc_suffix"
                            id="checkout_odc_suffix"
                            value=""
                        >


                        <!-- DISTRICT -->

                        <input
                            type="hidden"
                            name="district"
                            id="checkout_district"
                            value=""
                        >


                        <button
                            type="submit"
                            class="btn-red"

                            @if(empty($employee['database_id']))
                                disabled
                            @endif
                        >

                            CHECKOUT

                        </button>

                    </form>


                </div>

            </div>

        </section>

    </main>

</div>



<!-- =============================================================
     JAVASCRIPT
     ============================================================= -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATA SERVICE AREA DARI FILE KANTOR
    |--------------------------------------------------------------------------
    | Label "SA" hanya sebagai pengelompokan dan tidak ikut ke kode ODC akhir.
    |--------------------------------------------------------------------------
    */

    const serviceAreaData = {
        'TUREN': [
            { code: 'APG', name: 'AMPELGADING' },
            { code: 'BNR', name: 'BANTUR' },
            { code: 'SBM', name: 'SUMBERMANJING' },
            { code: 'DPT', name: 'DAMPIT' },
            { code: 'GDI', name: 'GONDANGLEGI' },
            { code: 'TUR', name: 'TUREN' }
        ],
        'KEPANJEN': [
            { code: 'GKW', name: 'GUNUNGKAWI' },
            { code: 'KPN', name: 'KEPANJEN' },
            { code: 'PGK', name: 'PAGAK' },
            { code: 'DNO', name: 'DONOMULYO' },
            { code: 'SBP', name: 'SUMBERPUCUNG' },
            { code: 'GDG', name: 'GADANG' }
        ],
        'BATU': [
            { code: 'BTU', name: 'BATU' },
            { code: 'KPO', name: 'KARANGPLOSO' },
            { code: 'NTG', name: 'NGANTANG' }
        ],
        'BLIMBING': [
            { code: 'BLB', name: 'BLIMBING' }
        ],
        'SINGOSARI': [
            { code: 'SGS', name: 'SINGOSARI' },
            { code: 'TMP', name: 'TUMPANG' },
            { code: 'LWG', name: 'LAWANG' },
            { code: 'PKS', name: 'PAKIS' }
        ],
        'KLOJEN': [
            { code: 'KLJ', name: 'KLOJEN' }
        ],
        'MALANG': [
            { code: 'MLG', name: 'MALANG' },
            { code: 'BRG', name: 'BURING' },
            { code: 'SWJ', name: 'SAWOJAJAR' }
        ],
        'BLITAR': [
            { code: 'BLR', name: 'BLITAR' },
            { code: 'BNU', name: 'BINANGUN' },
            { code: 'KBN', name: 'KESAMBEN' },
            { code: 'LDY', name: 'LODOYO' },
            { code: 'PAN', name: 'PANATARAN' },
            { code: 'SNT', name: 'SRENGAT' },
            { code: 'WGI', name: 'WLINGI' }
        ],
        'TULUNG AGUNG': [
            { code: 'CAT', name: 'CAMPURDARAT' },
            { code: 'KWR', name: 'KALIDAWIR' },
            { code: 'NGU', name: 'NGUNUT' },
            { code: 'TUL', name: 'TULUNGAGUNG' }
        ]
    };

    const validOdcSuffixes = ['FA', 'FB', 'FC', 'FD', 'FE', 'FF', 'FG', 'FH', 'FI', 'FJ', 'FK', 'FL', 'FM', 'FN', 'FO', 'FP', 'FQ', 'FR', 'FS', 'FT', 'FU', 'FV', 'FW', 'FX', 'FY', 'FZ', 'FAA', 'FAB', 'FAC', 'FAD', 'FAE', 'FAF', 'FAG', 'FAH', 'FAI', 'FAJ', 'FAK', 'FAL', 'FAM', 'FAN', 'FAO', 'FAP', 'FAQ', 'FAR', 'FAS', 'FAT', 'FAU', 'FAV', 'FAW', 'FAX', 'FAY', 'FAZ'];

    const serviceAreaInput = document.getElementById('service_area');
    const stoInput = document.getElementById('sto_location');
    const stoList = document.getElementById('sto-location-list');
    const suffixInput = document.getElementById('odc_suffix');
    const codeSuggestions = document.getElementById('odc-code-suggestions');

    let codeActiveIndex = -1;


    const odcResult = document.getElementById('odc-result');
    const odcFinalCode = document.getElementById('odc-final-code');

    const checkoutForm = document.getElementById('checkout-form');
    const checkoutButton = checkoutForm
        ? checkoutForm.querySelector('button[type="submit"]')
        : null;

    const employeeInput = checkoutForm
        ? checkoutForm.querySelector('input[name="karyawan_id"]')
        : null;

    const hiddenBoxId = document.getElementById('checkout_box_id');
    const hiddenDistrict = document.getElementById('checkout_district');
    const hiddenOdcCode = document.getElementById('checkout_odc_code');
    const hiddenServiceArea = document.getElementById('checkout_service_area');
    const hiddenStoCode = document.getElementById('checkout_sto_code');
    const hiddenOdcSuffix = document.getElementById('checkout_odc_suffix');


    function normalize(value) {
        return (value || '').trim().toUpperCase();
    }


    function resolveServiceArea() {
        const typed = normalize(serviceAreaInput ? serviceAreaInput.value : '');

        return Object.keys(serviceAreaData).find(function (key) {
            return normalize(key) === typed;
        }) || '';
    }


    function getSelectedSto() {
        const serviceArea = resolveServiceArea();

        if (!serviceArea || !stoInput) {
            return null;
        }

        const typed = normalize(stoInput.value);

        return serviceAreaData[serviceArea].find(function (item) {
            const display = item.code + ' - ' + item.name;

            return normalize(display) === typed ||
                   normalize(item.code) === typed ||
                   normalize(item.name) === typed;
        }) || null;
    }


    function resolveSuffix() {
        const suffix = normalize(suffixInput ? suffixInput.value : '');

        return validOdcSuffixes.includes(suffix)
            ? suffix
            : '';
    }



    function hideCodeSuggestions() {
        if (!codeSuggestions) {
            return;
        }

        codeSuggestions.classList.remove('show');
        codeSuggestions.innerHTML = '';
        codeActiveIndex = -1;
    }


    function renderCodeSuggestions() {
        if (!suffixInput || !codeSuggestions || suffixInput.disabled) {
            hideCodeSuggestions();
            return;
        }

        const query = normalize(suffixInput.value);

        /*
        |--------------------------------------------------------------------------
        | Tidak tampilkan seluruh daftar saat input masih kosong.
        | Baru tampil setelah user mengetik minimal 1 karakter.
        |--------------------------------------------------------------------------
        */
        if (query.length < 1) {
            hideCodeSuggestions();
            return;
        }

        const matches = validOdcSuffixes
            .filter(function (code) {
                return code.startsWith(query);
            })
            .slice(0, 8);

        codeSuggestions.innerHTML = '';
        codeActiveIndex = -1;

        if (matches.length === 0) {
            const empty = document.createElement('div');
            empty.className = 'odc-code-empty';
            empty.textContent = 'Kode tidak ditemukan.';
            codeSuggestions.appendChild(empty);
            codeSuggestions.classList.add('show');
            return;
        }

        matches.forEach(function (code) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'odc-code-option';
            button.textContent = code;

            button.addEventListener('mousedown', function (event) {
                event.preventDefault();
            });

            button.addEventListener('click', function () {
                suffixInput.value = code;
                hideCodeSuggestions();
                updateSelection();
            });

            codeSuggestions.appendChild(button);
        });

        codeSuggestions.classList.add('show');
    }


    function moveCodeActive(direction) {
        if (!codeSuggestions) {
            return;
        }

        const options = Array.from(
            codeSuggestions.querySelectorAll('.odc-code-option')
        );

        if (options.length === 0) {
            return;
        }

        codeActiveIndex += direction;

        if (codeActiveIndex < 0) {
            codeActiveIndex = options.length - 1;
        }

        if (codeActiveIndex >= options.length) {
            codeActiveIndex = 0;
        }

        options.forEach(function (option, index) {
            option.classList.toggle(
                'active',
                index === codeActiveIndex
            );
        });

        options[codeActiveIndex].scrollIntoView({
            block: 'nearest'
        });
    }


    function populateStoOptions() {
        if (!stoInput || !stoList) {
            return;
        }

        const serviceArea = resolveServiceArea();

        stoList.innerHTML = '';
        stoInput.value = '';

        if (!serviceArea) {
            stoInput.disabled = true;
            stoInput.placeholder = 'Pilih Service Area terlebih dahulu...';

            if (suffixInput) {
                suffixInput.disabled = true;
                suffixInput.value = '';
                hideCodeSuggestions();
            }

            updateSelection();
            return;
        }

        serviceAreaData[serviceArea].forEach(function (item) {
            const option = document.createElement('option');
            option.value = item.code + ' - ' + item.name;
            stoList.appendChild(option);
        });

        stoInput.disabled = false;
        stoInput.placeholder = 'Cari / pilih Lokasi atau kode STO...';

        if (suffixInput) {
            suffixInput.disabled = true;
            suffixInput.value = '';
            hideCodeSuggestions();
        }

        updateSelection();
    }


    function handleStoChange() {
        const selectedSto = getSelectedSto();

        if (suffixInput) {
            suffixInput.disabled = !selectedSto;

            if (!selectedSto) {
                suffixInput.value = '';
                hideCodeSuggestions();
            }
        }

        updateSelection();
    }


    function updateSelection() {
        const serviceArea = resolveServiceArea();
        const sto = getSelectedSto();
        const suffix = resolveSuffix();

        const employeeId = employeeInput
            ? employeeInput.value.trim()
            : '';

        const boxId = hiddenBoxId
            ? hiddenBoxId.value.trim()
            : '';

        let finalCode = '';

        if (sto && suffix) {
            finalCode = 'ODC-' + sto.code + '-' + suffix;
        }

        if (hiddenDistrict) {
            hiddenDistrict.value = serviceArea;
        }

        if (hiddenServiceArea) {
            hiddenServiceArea.value = serviceArea;
        }

        if (hiddenStoCode) {
            hiddenStoCode.value = sto ? sto.code : '';
        }

        if (hiddenOdcSuffix) {
            hiddenOdcSuffix.value = suffix;
        }

        if (hiddenOdcCode) {
            hiddenOdcCode.value = finalCode;
        }

        if (odcFinalCode) {
            odcFinalCode.textContent = finalCode || '-';
        }

        if (odcResult) {
            if (finalCode) {
                odcResult.classList.add('ready');
                odcResult.firstChild.textContent = 'ODC siap digunakan untuk proses Checkout. ';
            } else {
                odcResult.classList.remove('ready');
            }
        }

        const canCheckout =
            employeeId !== '' &&
            boxId !== '' &&
            serviceArea !== '' &&
            sto !== null &&
            suffix !== '' &&
            finalCode !== '';

        if (checkoutButton) {
            checkoutButton.disabled = !canCheckout;
        }
    }


    if (serviceAreaInput) {
        serviceAreaInput.addEventListener('input', function () {
            const exactArea = resolveServiceArea();

            if (exactArea) {
                populateStoOptions();
            } else {
                if (stoInput) {
                    stoInput.disabled = true;
                    stoInput.value = '';
                }

                if (suffixInput) {
                    suffixInput.disabled = true;
                    suffixInput.value = '';
                }

                updateSelection();
            }
        });

        serviceAreaInput.addEventListener('change', populateStoOptions);
    }


    if (stoInput) {
        stoInput.addEventListener('input', handleStoChange);
        stoInput.addEventListener('change', handleStoChange);
    }


    if (suffixInput) {
        suffixInput.addEventListener('input', function () {
            /*
            |--------------------------------------------------------------------------
            | Otomatis kapital, contoh: fa -> FA
            |--------------------------------------------------------------------------
            */
            const caret = suffixInput.selectionStart;
            suffixInput.value = suffixInput.value.toUpperCase();

            if (typeof caret === 'number') {
                suffixInput.setSelectionRange(caret, caret);
            }

            renderCodeSuggestions();
            updateSelection();
        });

        suffixInput.addEventListener('focus', function () {
            renderCodeSuggestions();
        });

        suffixInput.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                moveCodeActive(1);
                return;
            }

            if (event.key === 'ArrowUp') {
                event.preventDefault();
                moveCodeActive(-1);
                return;
            }

            if (event.key === 'Enter') {
                const options = codeSuggestions
                    ? Array.from(
                        codeSuggestions.querySelectorAll('.odc-code-option')
                    )
                    : [];

                if (
                    codeActiveIndex >= 0 &&
                    options[codeActiveIndex]
                ) {
                    event.preventDefault();
                    options[codeActiveIndex].click();
                }

                return;
            }

            if (event.key === 'Escape') {
                hideCodeSuggestions();
            }
        });

        suffixInput.addEventListener('blur', function () {
            window.setTimeout(hideCodeSuggestions, 120);
        });
    }


    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (event) {
            updateSelection();

            const serviceArea = resolveServiceArea();
            const sto = getSelectedSto();
            const suffix = resolveSuffix();
            const finalCode = hiddenOdcCode
                ? hiddenOdcCode.value.trim()
                : '';

            if (!serviceArea) {
                event.preventDefault();
                alert('Silakan pilih Service Area yang valid.');
                return;
            }

            if (!sto) {
                event.preventDefault();
                alert('Silakan pilih Lokasi / STO yang valid.');
                return;
            }

            if (!suffix) {
                event.preventDefault();
                alert('Silakan pilih Kode ODC yang valid.');
                return;
            }

            if (!finalCode) {
                event.preventDefault();
                alert('Kode ODC belum terbentuk.');
                return;
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT BUTTON
    |--------------------------------------------------------------------------
    */

    const serviceDescriptions =
        document.querySelectorAll('.service-description');

    const editButton =
        document.getElementById('edit-service-button');

    if (editButton) {
        editButton.addEventListener('click', function () {
            let target = null;

            serviceDescriptions.forEach(function (textarea) {
                if (
                    !target &&
                    textarea.value.trim() !== ''
                ) {
                    target = textarea;
                }
            });

            if (
                !target &&
                serviceDescriptions.length > 0
            ) {
                target = serviceDescriptions[0];
            }

            if (target) {
                target.focus();
            }
        });
    }


    updateSelection();
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const notificationToggle = document.getElementById('notification-toggle');
    const notificationMenu = document.getElementById('notification-menu');

    const profileToggle = document.getElementById('profile-toggle');
    const profileMenu = document.getElementById('profile-menu');

    function closeHeaderMenus(except = null) {
        if (except !== 'notification' && notificationMenu) {
            notificationMenu.classList.remove('show');

            if (notificationToggle) {
                notificationToggle.setAttribute('aria-expanded', 'false');
            }
        }

        if (except !== 'profile' && profileMenu) {
            profileMenu.classList.remove('show');

            if (profileToggle) {
                profileToggle.setAttribute('aria-expanded', 'false');
            }
        }
    }

    if (notificationToggle && notificationMenu) {
        notificationToggle.addEventListener('click', function (event) {
            event.stopPropagation();

            const willOpen =
                !notificationMenu.classList.contains('show');

            closeHeaderMenus('notification');
            notificationMenu.classList.toggle('show', willOpen);

            notificationToggle.setAttribute(
                'aria-expanded',
                willOpen ? 'true' : 'false'
            );
        });

        notificationMenu.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    }

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener('click', function (event) {
            event.stopPropagation();

            const willOpen =
                !profileMenu.classList.contains('show');

            closeHeaderMenus('profile');
            profileMenu.classList.toggle('show', willOpen);

            profileToggle.setAttribute(
                'aria-expanded',
                willOpen ? 'true' : 'false'
            );
        });

        profileMenu.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    }

    document.addEventListener('click', function () {
        closeHeaderMenus();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeHeaderMenus();
        }
    });
});
</script>

</body>

</html>