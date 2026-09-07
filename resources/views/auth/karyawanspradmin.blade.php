<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan Super Admin</title>
    <link rel="stylesheet" href="/css/dashboard.css">

    <style>
        /* ==============================
           STATUS KARYAWAN
           ============================== */

        .status-cell {
            white-space: nowrap;
        }

        .employee-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 82px;
            height: 30px;
            padding: 0 14px;
            margin-right: 8px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1;
            vertical-align: middle;
        }

        /* Status Disetujui */
        .employee-status.aktif {
            background: #16a34a;
            color: #ffffff;
        }

        /* Status Ditolak */
        .employee-status.nonaktif {
            background: #dc2626;
            color: #ffffff;
        }

        /* ==============================
           TOMBOL AKSI
           ============================== */

        .status-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 86px;
            height: 30px;
            padding: 0 16px;
            margin-left: 4px;
            border: none;
            border-radius: 999px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            transition: all 0.2s ease;
            vertical-align: middle;
        }

        /* Tombol Di Setujui */
        .status-approve {
            background: #16a34a;
            color: #ffffff;
        }

        .status-approve:hover {
            background: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);
        }

        /* Tombol Tolak */
        .status-reject {
            background: #dc2626;
            color: #ffffff;
        }

        .status-reject:hover {
            background: #b91c1c;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.22);
        }

        .status-action:active {
            transform: translateY(0);
        }

        .status-action:focus {
            outline: none;
        }

        .status-cell form {
            display: inline-block !important;
            margin: 0;
            padding: 0;
            vertical-align: middle;
        }


        /* ==============================
           DETAIL KARYAWAN
           ============================== */

        .employee-detail-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 76px;
            height: 30px;
            padding: 0 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .employee-detail-button:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        .employee-detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px 22px;
            padding: 6px 0 4px;
        }

        .employee-detail-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .employee-detail-item span {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
        }

        .employee-detail-item strong {
            color: #111827;
            font-size: 14px;
            font-weight: 700;
            word-break: break-word;
        }


        /* ==============================
           AKSI STATUS PROFESIONAL
           ============================== */

        .employee-detail-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #e5e7eb;
        }

        .employee-status-toggle {
            min-height: 40px;
            padding: 0 18px;
            border: 0;
            border-radius: 8px;
            color: #ffffff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .employee-status-toggle.deactivate {
            background: #dc2626;
        }

        .employee-status-toggle.deactivate:hover {
            background: #b91c1c;
        }

        .employee-status-toggle.activate {
            background: #16a34a;
        }

        .employee-status-toggle.activate:hover {
            background: #15803d;
        }

        .employee-status-toggle[hidden] {
            display: none !important;
        }

        .employee-confirm-text {
            margin: 0;
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
        }

        .employee-confirm-name {
            font-weight: 700;
            color: #111827;
        }

        .employee-confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
        }

        .employee-confirm-cancel,
        .employee-confirm-submit {
            min-height: 40px;
            padding: 0 18px;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .employee-confirm-cancel {
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
        }

        .employee-confirm-submit {
            border: 0;
            color: #ffffff;
        }

        .employee-confirm-submit.deactivate {
            background: #dc2626;
        }

        .employee-confirm-submit.activate {
            background: #16a34a;
        }


        /* ==============================
           CRUD KARYAWAN PROFESIONAL
           ============================== */

        .employee-row-actions {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 6px;
            white-space: nowrap;
            padding-right: 0;
        }

        .activity-table th:last-child,
        .activity-table td:last-child {
            min-width: 220px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .dashboard-page:has(.employee-row-actions) .activity-table {
            min-width: 0;
        }

        .employee-action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 58px;
            height: 32px;
            padding: 0 8px;
            border-radius: 9px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.1px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
        }

        .employee-action-button.detail {
            border: 1px solid #2563eb;
            background: #eff6ff;
            color: #1d4ed8;
        }

        .employee-action-button.detail:hover {
            background: #dbeafe;
            border-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.18);
        }

        .employee-action-button.edit {
            border: 1px solid #f59e0b;
            background: #fffbeb;
            color: #b45309;
        }

        .employee-action-button.edit:hover {
            background: #fef3c7;
            border-color: #d97706;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.18);
        }

        .employee-action-button.delete {
            border: 1px solid #ef4444;
            background: #fef2f2;
            color: #b91c1c;
        }

        .employee-action-button.delete:hover {
            background: #fee2e2;
            border-color: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.18);
        }

        .employee-action-button:active {
            transform: translateY(0);
            box-shadow: 0 1px 4px rgba(15, 23, 42, 0.08);
        }

        .employee-action-button:focus-visible {
            outline: 2px solid #94a3b8;
            outline-offset: 2px;
        }

        .employee-delete-warning {
            margin-top: 12px;
            padding: 12px 14px;
            border-radius: 8px;
            background: #fff7ed;
            color: #9a3412;
            font-size: 12px;
            line-height: 1.5;
        }

        .employee-edit-note {
            margin: 0 0 14px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.5;
        }

        /* ==============================
           RESPONSIVE
           ============================== */

        @media (max-width: 900px) {
            .status-cell {
                white-space: normal;
            }

            .status-cell form {
                margin-top: 5px;
            }

            .employee-status {
                margin-bottom: 5px;
            }

            .employee-row-actions {
                flex-wrap: wrap;
                gap: 8px;
                padding-right: 0;
            }

            .activity-table th:last-child,
            .activity-table td:last-child {
                min-width: 210px;
                padding-right: 16px;
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
                    <p>Super Admin</p>
                </div>
            </div>


            <div class="sidebar-section">

                <h2>MAIN MENU</h2>

                <nav class="dashboard-nav">

                    <a
                        href="{{ route('super.admin') }}"
                        class="{{ request()->routeIs('super.admin') ? 'active' : '' }}"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('karyawan.super') }}"
                        class="{{ request()->routeIs('karyawan.super') ? 'active' : '' }}"
                    >
                        Daftar Karyawan
                    </a>

                    <a
                        href="{{ route('history.super') }}"
                        class="{{ request()->routeIs('history.super') ? 'active' : '' }}"
                    >
                        History
                    </a>

                </nav>

            </div>


            <div class="sidebar-section">

                <h2>ADMIN</h2>

                <nav class="dashboard-nav">

                    <details class="sidebar-dropdown">

                        <summary>Setting</summary>

                        <div class="sidebar-dropdown-menu">

                            <a
                                href="{{ route('profile.super') }}"
                                class="{{ request()->routeIs('profile.super') ? 'active' : '' }}"
                            >
                                Profile
                            </a>

                        </div>

                    </details>

                </nav>

            </div>

        </aside>


        <main class="dashboard-content karyawan-page">

            <header class="dashboard-header page-header karyawan-header">

                <div>
                    <h1>Daftar Karyawan</h1>
                </div>


                <div class="search-bar">

                    <form
                        method="get"
                        action="{{ route('karyawan.super') }}"
                        class="search-form"
                    >

                        <div class="search-input-wrapper">

                            <input
                                id="employee-search-input"
                                type="text"
                                name="q"
                                placeholder="Search by order id"
                                value="{{ $search ?? '' }}"
                            >

                            <button
                                type="submit"
                                class="search-button"
                            >
                                🔍
                            </button>

                        </div>

                    </form>

                </div>


                <div class="header-actions">

                    <button type="button" class="notification-button" aria-haspopup="true" aria-expanded="false">

                        <span class="bell-icon">
                            🔔
                        </span>

                        <span class="notification-dot">
                            4
                        </span>

                    </button>

                    <a href="{{ route('profile.super') }}" class="profile-card" aria-label="Edit profile">
                        <div class="profile-avatar">
                            @if (!empty($profileUser?->foto_profil))
                                <img src="{{ asset($profileUser->foto_profil) }}" alt="Foto profil">
                            @endif
                        </div>
                        <div><p>{{ $profileUser?->username ?? $profileUser?->nama_lengkap ?? 'Super Admin' }}</p></div>
                    </a>

                </div>

            </header>

            @if (session('success'))
                <div class="dashboard-alert success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="dashboard-alert error">{{ $errors->first() }}</div>
            @endif

            <section class="employee-add-panel">
                <div>
                    <p class="page-label">Registrasi Berhasil</p>
                    <h2>Daftar Karyawan</h2>
                </div>
                <button type="button" class="employee-add-trigger" data-modal-open="employee-modal">+ Tambah Karyawan</button>
            </section>

            <section class="activity-card table-card">

                <div class="activity-table-wrapper">

                    <table class="activity-table">

                        <thead>

                            <tr>

                                <th>
                                    Data ID
                                </th>

                                <th>
                                    Nama
                                </th>

                                <th>
                                    Jabatan
                                </th>

                                <th>
                                    District
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($employees as $employee)

                                <tr>
                                    <td>
                                        {{ $employee['id'] ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $employee['name'] ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $employee['position'] ?? ($employee['jabatan'] ?? '-') }}
                                    </td>


                                    <td>
                                        {{ $employee['ods'] ?? '-' }}
                                    </td>


                                    <td class="status-cell">

                                        {{-- =================================
                                             STATUS KARYAWAN
                                             HANYA 2 TAMPILAN:
                                             DI SETUJUI / DITOLAK
                                             ================================= --}}

                                        @if ($employee['status'] === 'aktif')

                                            <span class="employee-status aktif">
                                                Aktif
                                            </span>

                                        @elseif ($employee['status'] === 'nonaktif')

                                            <span class="employee-status nonaktif">
                                                Nonaktif
                                            </span>

                                        @endif


                                        {{-- =================================
                                             TOMBOL DI SETUJUI
                                             ================================= --}}

                                        @if ($employee['status'] !== 'aktif' && $employee['status'] !== 'nonaktif')

                                            <form
                                                method="POST"
                                                action="{{ route('karyawan.approve', $employee['database_id']) }}"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="status-action status-approve"
                                                >
                                                    Di Setujui
                                                </button>

                                            </form>

                                        @endif


                                        {{-- =================================
                                             TOMBOL TOLAK
                                             ================================= --}}

                                        @if ($employee['status'] !== 'aktif' && $employee['status'] !== 'nonaktif')

                                            <form
                                                method="POST"
                                                action="{{ route('karyawan.reject', $employee['database_id']) }}"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="status-action status-reject"
                                                >
                                                    Tolak
                                                </button>

                                            </form>

                                        @endif

                                    </td>

                                    <td>
                                        <div class="employee-row-actions">

                                            <button
                                                type="button"
                                                class="employee-action-button detail"
                                                data-detail-open
                                                data-database-id="{{ $employee['database_id'] ?? '' }}"
                                                data-status-url="{{ isset($employee['database_id']) ? route('karyawan.super.status', $employee['database_id']) : '' }}"
                                                data-id="{{ $employee['id'] ?? '-' }}"
                                                data-name="{{ $employee['name'] ?? '-' }}"
                                                data-gender="{{ $employee['gender'] ?? ($employee['jenis_kelamin'] ?? '-') }}"
                                                data-nik="{{ $employee['nik'] ?? '-' }}"
                                                data-email="{{ $employee['email'] ?? '-' }}"
                                                data-position="{{ $employee['position'] ?? ($employee['jabatan'] ?? '-') }}"
                                                data-address="{{ $employee['address'] ?? ($employee['alamat'] ?? '-') }}"
                                                data-ods="{{ $employee['ods'] ?? '-' }}"
                                                data-ods-id="{{ $employee['ods_id'] ?? '' }}"
                                                data-status="{{ $employee['status'] ?? '-' }}"
                                            >
                                                Detail
                                            </button>

                                            <button
                                                type="button"
                                                class="employee-action-button edit"
                                                data-edit-open
                                                data-update-url="{{ isset($employee['database_id']) ? route('karyawan.super.update', $employee['database_id']) : '' }}"
                                                data-name="{{ $employee['name'] ?? '' }}"
                                                data-gender="{{ $employee['gender'] ?? '' }}"
                                                data-nik="{{ $employee['nik'] ?? '' }}"
                                                data-email="{{ $employee['email'] ?? '' }}"
                                                data-position="{{ $employee['position'] ?? '' }}"
                                                data-address="{{ $employee['address'] ?? '' }}"
                                                data-ods-id="{{ $employee['ods_id'] ?? '' }}"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                type="button"
                                                class="employee-action-button delete"
                                                data-delete-open
                                                data-delete-url="{{ isset($employee['database_id']) ? route('karyawan.super.delete', $employee['database_id']) : '' }}"
                                                data-name="{{ $employee['name'] ?? '-' }}"
                                            >
                                                Hapus
                                            </button>

                                        </div>
                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        style="text-align:center; padding:20px; color:#6b7280;"
                                    >
                                        Tidak ada karyawan ditemukan.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="activity-pagination">

                    <div class="pagination-summary">

                        Showing
                        {{ $employees->firstItem() ?: 0 }}
                        -
                        {{ $employees->lastItem() ?: 0 }}
                        of
                        {{ $employees->total() }}

                    </div>


                    <div class="pagination-links">

                        @if ($employees->onFirstPage())

                            <span class="page disabled">
                                Previous
                            </span>

                        @else

                            <a
                                class="page"
                                href="{{ $employees->previousPageUrl() }}"
                            >
                                Previous
                            </a>

                        @endif


                        @foreach (
                            range(
                                max(1, $employees->currentPage() - 1),
                                min($employees->lastPage(), $employees->currentPage() + 2)
                            ) as $page
                        )

                            @if ($page == $employees->currentPage())

                                <span class="page active">
                                    {{ $page }}
                                </span>

                            @else

                                <a
                                    class="page"
                                    href="{{ $employees->url($page) }}"
                                >
                                    {{ $page }}
                                </a>

                            @endif

                        @endforeach


                        @if ($employees->hasMorePages())

                            <a
                                class="page"
                                href="{{ $employees->nextPageUrl() }}"
                            >
                                Next
                            </a>

                        @else

                            <span class="page disabled">
                                Next
                            </span>

                        @endif

                    </div>

                </div>

            </section>

        </main>

    </div>

    <div class="employee-modal" id="employee-detail-modal" aria-hidden="true">
        <div class="employee-modal-backdrop" data-detail-close></div>

        <section
            class="employee-modal-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="employee-detail-title"
        >
            <div class="employee-modal-header">
                <h2 id="employee-detail-title">Detail Karyawan</h2>
                <button
                    type="button"
                    class="employee-modal-close"
                    data-detail-close
                    aria-label="Tutup"
                >
                    &times;
                </button>
            </div>

            <div style="padding:20px 24px 24px;">
                <div class="employee-detail-grid">

                    <div class="employee-detail-item">
                        <span>Data ID</span>
                        <strong id="detail-id">-</strong>
                    </div>

                    <div class="employee-detail-item">
                        <span>Nama</span>
                        <strong id="detail-name">-</strong>
                    </div>

                    <div class="employee-detail-item">
                        <span>Jenis Kelamin</span>
                        <strong id="detail-gender">-</strong>
                    </div>

                    <div class="employee-detail-item">
                        <span>NIK</span>
                        <strong id="detail-nik">-</strong>
                    </div>

                    <div class="employee-detail-item">
                        <span>Email</span>
                        <strong id="detail-email">-</strong>
                    </div>

                    <div class="employee-detail-item">
                        <span>Jabatan</span>
                        <strong id="detail-position">-</strong>
                    </div>

                    <div class="employee-detail-item">
                        <span>Alamat</span>
                        <strong id="detail-address">-</strong>
                    </div>

                    <div class="employee-detail-item">
                        <span>District</span>
                        <strong id="detail-ods">-</strong>
                    </div>

                    <div class="employee-detail-item">
                        <span>Status</span>
                        <strong id="detail-status">-</strong>
                    </div>

                </div>

                <div class="employee-detail-actions">
                    <button
                        type="button"
                        id="detail-status-toggle"
                        class="employee-status-toggle deactivate"
                        hidden
                    >
                        Nonaktifkan Karyawan
                    </button>
                </div>
            </div>
        </section>
    </div>

    <div class="employee-modal" id="employee-status-confirm-modal" aria-hidden="true">
        <div class="employee-modal-backdrop" data-status-confirm-close></div>

        <section
            class="employee-modal-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="employee-status-confirm-title"
        >
            <div class="employee-modal-header">
                <h2 id="employee-status-confirm-title">Konfirmasi Status Karyawan</h2>
                <button
                    type="button"
                    class="employee-modal-close"
                    data-status-confirm-close
                    aria-label="Tutup"
                >
                    &times;
                </button>
            </div>

            <div style="padding:20px 24px 24px;">
                <p class="employee-confirm-text" id="employee-status-confirm-text">
                    Apakah Anda yakin ingin mengubah status karyawan?
                </p>

                <form
                    id="employee-status-form"
                    method="POST"
                    action=""
                >
                    @csrf
                    @method('PATCH')

                    <input
                        type="hidden"
                        name="status"
                        id="employee-status-value"
                        value=""
                    >

                    <div class="employee-confirm-actions">
                        <button
                            type="button"
                            class="employee-confirm-cancel"
                            data-status-confirm-close
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            id="employee-status-confirm-submit"
                            class="employee-confirm-submit deactivate"
                        >
                            Ya, Nonaktifkan
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>


    <div class="employee-modal" id="employee-edit-modal" aria-hidden="true">
        <div class="employee-modal-backdrop" data-edit-close></div>

        <section
            class="employee-modal-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="employee-edit-title"
        >
            <div class="employee-modal-header">
                <h2 id="employee-edit-title">Edit Karyawan</h2>
                <button
                    type="button"
                    class="employee-modal-close"
                    data-edit-close
                    aria-label="Tutup"
                >
                    &times;
                </button>
            </div>

            <form
                id="employee-edit-form"
                method="POST"
                action=""
                class="employee-modal-form employee-edit-form"
            >
                @csrf
                @method('PUT')

                <p class="employee-edit-note">
                    Ubah data yang diperlukan lalu klik Simpan Perubahan.
                    Status Aktif/Nonaktif tetap dikelola dari menu Detail.
                </p>

                <div class="employee-form-field">
                    <label for="edit-employee-name">Nama</label>
                    <input id="edit-employee-name" type="text" name="name" required>
                </div>

                <div class="employee-form-field">
                    <label for="edit-employee-alamat">Alamat</label>
                    <input id="edit-employee-alamat" type="text" name="alamat" required>
                </div>

                <div class="employee-form-field">
                    <label for="edit-employee-gender">Jenis Kelamin</label>
                    <select id="edit-employee-gender" name="jenis_kelamin" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="employee-form-field">
                    <label for="edit-employee-nik">NIK</label>
                    <input id="edit-employee-nik" type="text" name="nik" required maxlength="16">
                </div>

                <div class="employee-form-field">
                    <label for="edit-employee-ods">District</label>
                    <input id="edit-employee-ods" type="text" name="ods_manual" placeholder="Masukkan district (kode atau nama)" required>
                </div>

                <div class="employee-form-field">
                    <label for="edit-employee-email">Email</label>
                    <input id="edit-employee-email" type="email" name="email" required>
                </div>

                <div class="employee-form-field">
                    <label for="edit-employee-jabatan">Jabatan</label>
                    <select id="edit-employee-jabatan" name="jabatan" required>
                        <option value="Teknisi B2C">Teknisi B2C</option>
                        <option value="Teknisi B2B">Teknisi B2B</option>
                    </select>
                </div>

                <div class="employee-form-field">
                    <label for="edit-employee-password">Password Login Baru</label>
                    <input
                        id="edit-employee-password"
                        type="password"
                        name="password"
                        placeholder="Kosongkan jika password tidak diubah"
                        minlength="6"
                    >
                </div>

                <div class="employee-modal-actions">
                    <button
                        type="button"
                        class="employee-cancel-button"
                        data-edit-close
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="employee-save-button"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
    </div>

    <div class="employee-modal" id="employee-delete-modal" aria-hidden="true">
        <div class="employee-modal-backdrop" data-delete-close></div>

        <section
            class="employee-modal-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="employee-delete-title"
        >
            <div class="employee-modal-header">
                <h2 id="employee-delete-title">Hapus Karyawan</h2>
                <button
                    type="button"
                    class="employee-modal-close"
                    data-delete-close
                    aria-label="Tutup"
                >
                    &times;
                </button>
            </div>

            <div style="padding:20px 24px 24px;">
                <p class="employee-confirm-text">
                    Yakin ingin menghapus
                    <span class="employee-confirm-name" id="employee-delete-name">-</span>?
                </p>

                <div class="employee-delete-warning">
                    Penghapusan hanya diperbolehkan jika karyawan belum memiliki
                    riwayat Checkin/Checkout. Jika sudah memiliki riwayat, gunakan
                    fitur Nonaktifkan Karyawan agar histori tetap aman.
                </div>

                <form id="employee-delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <div class="employee-confirm-actions">
                        <button
                            type="button"
                            class="employee-confirm-cancel"
                            data-delete-close
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="employee-confirm-submit deactivate"
                        >
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <div class="employee-modal" id="employee-modal" aria-hidden="true">
        <div class="employee-modal-backdrop" data-modal-close="employee-modal"></div>
        <section class="employee-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="employee-modal-title">
            <div class="employee-modal-header">
                <h2 id="employee-modal-title">Form Tambah Karyawan</h2>
                <button type="button" class="employee-modal-close" data-modal-close="employee-modal" aria-label="Tutup">&times;</button>
            </div>
            <form method="post" action="{{ route('karyawan.super.store') }}" class="employee-modal-form employee-add-form">
                @csrf
                <div class="employee-form-field employee-add-name-field"><label for="employee-name">Nama</label><input id="employee-name" type="text" name="name" placeholder="Masukkan nama" value="{{ old('name') }}" required></div>
                <div class="employee-form-field employee-add-address-field"><label for="employee-alamat">Alamat</label><input id="employee-alamat" type="text" name="alamat" placeholder="Masukkan alamat" value="{{ old('alamat') }}" required></div>
                <div class="employee-form-field employee-add-gender-field"><label for="employee-gender">Jenis Kelamin</label><select id="employee-gender" name="jenis_kelamin" required><option value="" disabled hidden {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih jenis kelamin</option><option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option><option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option></select></div>
                <div class="employee-form-field employee-add-nik-field"><label for="employee-nik">NIK</label><input id="employee-nik" type="text" name="nik" placeholder="Masukkan NIK" value="{{ old('nik') }}" required maxlength="16"></div>
                <div class="employee-form-field employee-add-email-field"><label for="employee-email">Email</label><input id="employee-email" type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required></div>
                <div class="employee-form-field employee-add-position-field"><label for="employee-jabatan">Jabatan</label><select id="employee-jabatan" name="jabatan" required><option value="Teknisi B2C">Teknisi B2C</option><option value="Teknisi B2B">Teknisi B2B</option></select></div>
                <div class="employee-form-field employee-add-odc-field"><label for="employee-ods">District</label><input id="employee-ods" type="text" name="ods_manual" placeholder="Masukkan district (kode atau nama)" value="{{ old('ods_manual') }}" required></div>
                <div class="employee-form-field employee-add-status-field"><label for="employee-status">Status</label><select id="employee-status" name="status" required><option value="">Pilih status</option><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select></div>
                <div class="employee-form-field employee-password-field employee-add-password-field"><label for="employee-password">Password Login</label><input id="employee-password" type="password" name="password" placeholder="Masukkan password" required></div>
                <div class="employee-modal-actions"><button type="button" class="employee-cancel-button" data-modal-close="employee-modal">Batal</button><button type="submit" class="employee-save-button">Simpan</button></div>
            </form>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('employee-modal');
            var detailModal = document.getElementById('employee-detail-modal');
            var statusConfirmModal = document.getElementById('employee-status-confirm-modal');
            var statusToggleButton = document.getElementById('detail-status-toggle');
            var statusForm = document.getElementById('employee-status-form');
            var statusValueInput = document.getElementById('employee-status-value');
            var statusConfirmText = document.getElementById('employee-status-confirm-text');
            var statusConfirmSubmit = document.getElementById('employee-status-confirm-submit');

            var editModal = document.getElementById('employee-edit-modal');
            var editForm = document.getElementById('employee-edit-form');

            var deleteModal = document.getElementById('employee-delete-modal');
            var deleteForm = document.getElementById('employee-delete-form');
            var deleteName = document.getElementById('employee-delete-name');

            var selectedEmployee = {
                name: '',
                status: '',
                statusUrl: ''
            };

            function setDetailValue(id, value) {
                var element = document.getElementById(id);

                if (element) {
                    element.textContent = value && value !== '' ? value : '-';
                }
            }

            document.querySelectorAll('[data-detail-open]').forEach(function (button) {
                button.addEventListener('click', function () {
                    setDetailValue('detail-id', button.dataset.id);
                    setDetailValue('detail-name', button.dataset.name);
                    setDetailValue('detail-gender', button.dataset.gender);
                    setDetailValue('detail-nik', button.dataset.nik);
                    setDetailValue('detail-email', button.dataset.email);
                    setDetailValue('detail-position', button.dataset.position);
                    setDetailValue('detail-address', button.dataset.address);
                    setDetailValue('detail-ods', button.dataset.ods);
                    setDetailValue('detail-status', button.dataset.status);

                    selectedEmployee.name = button.dataset.name || '-';
                    selectedEmployee.status = (button.dataset.status || '').toLowerCase();
                    selectedEmployee.statusUrl = button.dataset.statusUrl || '';

                    if (statusToggleButton) {
                        statusToggleButton.hidden = true;

                        if (selectedEmployee.status === 'aktif') {
                            statusToggleButton.hidden = false;
                            statusToggleButton.textContent = 'Nonaktifkan Karyawan';
                            statusToggleButton.classList.remove('activate');
                            statusToggleButton.classList.add('deactivate');
                        } else if (selectedEmployee.status === 'nonaktif') {
                            statusToggleButton.hidden = false;
                            statusToggleButton.textContent = 'Aktifkan Kembali';
                            statusToggleButton.classList.remove('deactivate');
                            statusToggleButton.classList.add('activate');
                        }
                    }

                    detailModal.classList.add('is-open');
                    detailModal.setAttribute('aria-hidden', 'false');
                });
            });

            document.querySelectorAll('[data-detail-close]').forEach(function (button) {
                button.addEventListener('click', function () {
                    detailModal.classList.remove('is-open');
                    detailModal.setAttribute('aria-hidden', 'true');

                    statusConfirmModal.classList.remove('is-open');
                    statusConfirmModal.setAttribute('aria-hidden', 'true');

                    editModal.classList.remove('is-open');
                    editModal.setAttribute('aria-hidden', 'true');

                    deleteModal.classList.remove('is-open');
                    deleteModal.setAttribute('aria-hidden', 'true');
                });
            });

            if (statusToggleButton) {
                statusToggleButton.addEventListener('click', function () {
                    if (!selectedEmployee.statusUrl) {
                        return;
                    }

                    var willDeactivate = selectedEmployee.status === 'aktif';
                    var nextStatus = willDeactivate ? 'nonaktif' : 'aktif';

                    statusForm.setAttribute('action', selectedEmployee.statusUrl);
                    statusValueInput.value = nextStatus;

                    if (willDeactivate) {
                        statusConfirmText.innerHTML =
                            'Yakin ingin menonaktifkan <span class="employee-confirm-name"></span>? Karyawan yang nonaktif tidak dapat melakukan Checkin/Checkout.';
                        statusConfirmText.querySelector('.employee-confirm-name').textContent = selectedEmployee.name;

                        statusConfirmSubmit.textContent = 'Ya, Nonaktifkan';
                        statusConfirmSubmit.classList.remove('activate');
                        statusConfirmSubmit.classList.add('deactivate');
                    } else {
                        statusConfirmText.innerHTML =
                            'Yakin ingin mengaktifkan kembali <span class="employee-confirm-name"></span>?';
                        statusConfirmText.querySelector('.employee-confirm-name').textContent = selectedEmployee.name;

                        statusConfirmSubmit.textContent = 'Ya, Aktifkan';
                        statusConfirmSubmit.classList.remove('deactivate');
                        statusConfirmSubmit.classList.add('activate');
                    }

                    statusConfirmModal.classList.add('is-open');
                    statusConfirmModal.setAttribute('aria-hidden', 'false');
                });
            }

            document.querySelectorAll('[data-status-confirm-close]').forEach(function (button) {
                button.addEventListener('click', function () {
                    statusConfirmModal.classList.remove('is-open');
                    statusConfirmModal.setAttribute('aria-hidden', 'true');
                });
            });


            document.querySelectorAll('[data-edit-open]').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (!editForm || !button.dataset.updateUrl) {
                        return;
                    }

                    editForm.setAttribute('action', button.dataset.updateUrl);

                    document.getElementById('edit-employee-name').value =
                        button.dataset.name || '';

                    document.getElementById('edit-employee-alamat').value =
                        button.dataset.address === '-' ? '' : (button.dataset.address || '');

                    document.getElementById('edit-employee-gender').value =
                        button.dataset.gender === '-' ? 'Laki-laki' : (button.dataset.gender || 'Laki-laki');

                    document.getElementById('edit-employee-nik').value =
                        button.dataset.nik === '-' ? '' : (button.dataset.nik || '');

                    document.getElementById('edit-employee-email').value =
                        button.dataset.email === '-' ? '' : (button.dataset.email || '');

                    document.getElementById('edit-employee-jabatan').value =
                        button.dataset.position === '-' ? 'HSA' : (button.dataset.position || 'HSA');

                    document.getElementById('edit-employee-ods').value =
                        (button.dataset.ods && button.dataset.ods !== '-') ? (button.dataset.ods) : (button.dataset.odsId || '');

                    editModal.classList.add('is-open');
                    editModal.setAttribute('aria-hidden', 'false');
                });
            });

            document.querySelectorAll('[data-edit-close]').forEach(function (button) {
                button.addEventListener('click', function () {
                    editModal.classList.remove('is-open');
                    editModal.setAttribute('aria-hidden', 'true');
                });
            });

            document.querySelectorAll('[data-delete-open]').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (!deleteForm || !button.dataset.deleteUrl) {
                        return;
                    }

                    deleteForm.setAttribute('action', button.dataset.deleteUrl);
                    deleteName.textContent = button.dataset.name || '-';

                    deleteModal.classList.add('is-open');
                    deleteModal.setAttribute('aria-hidden', 'false');
                });
            });

            document.querySelectorAll('[data-delete-close]').forEach(function (button) {
                button.addEventListener('click', function () {
                    deleteModal.classList.remove('is-open');
                    deleteModal.setAttribute('aria-hidden', 'true');
                });
            });

            document.querySelectorAll('[data-modal-open]').forEach(function (button) {
                button.addEventListener('click', function () {
                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                    modal.querySelector('input, select').focus();
                });
            });

            document.querySelectorAll('[data-modal-close]').forEach(function (button) {
                button.addEventListener('click', function () {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');

                    detailModal.classList.remove('is-open');
                    detailModal.setAttribute('aria-hidden', 'true');
                }
            });

            // Reset listing to default when search input is cleared
            (function () {
                var searchInput = document.getElementById('employee-search-input');
                var searchForm = document.querySelector('.search-form');

                if (!searchInput || !searchForm) return;

                var lastValue = searchInput.value || '';

                searchInput.addEventListener('input', function () {
                    var v = (this.value || '').trim();

                    if (v === '' && lastValue !== '') {
                        // go to the base listing URL (form action) to clear any query
                        window.location.href = searchForm.action;
                    }

                    lastValue = v;
                });
            })();

            @if ($errors->any())
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            @endif
        });
    </script>
</body>
</html>