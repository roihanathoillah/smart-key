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

                            <a href="#">
                                Notification
                            </a>

                            <a href="#">
                                Security
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

                    <button
                        type="button"
                        class="notification-button"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >

                        <span class="bell-icon">
                            🔔
                        </span>

                        <span class="notification-dot">
                            4
                        </span>

                    </button>


                    <div class="profile-card">

                        <div class="profile-avatar">
                            S
                        </div>

                        <strong>
                            Super Admin
                        </strong>

                    </div>

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
                                    User
                                </th>

                                <th>
                                    Kalender
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($employees as $employee)

                                <tr>
                                    <td>
                                        {{ $employee['id'] }}
                                    </td>


                                    <td>
                                        {{ $employee['name'] }}
                                    </td>


                                    <td>
                                        {{ $employee['calendar'] }}
                                    </td>


                                    <td class="status-cell">

                                        {{-- =================================
                                             STATUS KARYAWAN
                                             HANYA 2 TAMPILAN:
                                             DI SETUJUI / DITOLAK
                                             ================================= --}}

                                        @if ($employee['status'] === 'aktif')

                                            <span class="employee-status aktif">
                                                Di Setujui
                                            </span>

                                        @elseif ($employee['status'] === 'nonaktif')

                                            <span class="employee-status nonaktif">
                                                Ditolak
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

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="4"
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
    <div class="employee-modal" id="employee-modal" aria-hidden="true">
        <div class="employee-modal-backdrop" data-modal-close="employee-modal"></div>
        <section class="employee-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="employee-modal-title">
            <div class="employee-modal-header">
                <h2 id="employee-modal-title">Form Tambah Karyawan</h2>
                <button type="button" class="employee-modal-close" data-modal-close="employee-modal" aria-label="Tutup">&times;</button>
            </div>
            <form method="post" action="{{ route('karyawan.super.store') }}" class="employee-modal-form">
                @csrf
                <div class="employee-form-field"><label for="employee-name">Nama</label><input id="employee-name" type="text" name="name" placeholder="Masukkan nama" value="{{ old('name') }}" required></div>
                <div class="employee-form-field"><label for="employee-alamat">Alamat</label><input id="employee-alamat" type="text" name="alamat" placeholder="Masukkan alamat" value="{{ old('alamat') }}" required></div>
                <div class="employee-form-field"><label for="employee-tanggal">Tanggal Lahir</label><input id="employee-tanggal" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required></div>
                <div class="employee-form-field"><label for="employee-gender">Jenis Kelamin</label><select id="employee-gender" name="jenis_kelamin" required><option value="">Pilih jenis kelamin</option><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select></div>
                <div class="employee-form-field"><label for="employee-nik">NIK</label><input id="employee-nik" type="text" name="nik" placeholder="Masukkan NIK" value="{{ old('nik') }}" required></div>
                <div class="employee-form-field"><label for="employee-ods">ODS</label><select id="employee-ods" name="ods" required><option value="">Pilih ODS</option><option value="ODS 1">ODS 1</option><option value="ODS 2">ODS 2</option><option value="ODS 3">ODS 3</option></select></div>
                <div class="employee-form-field"><label for="employee-email">Email</label><input id="employee-email" type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required></div>
                <div class="employee-form-field"><label for="employee-status">Status</label><select id="employee-status" name="status" required><option value="">Pilih status</option><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select></div>
                <div class="employee-form-field"><label for="employee-jabatan">Jabatan</label><select id="employee-jabatan" name="jabatan" required><option value="">Pilih jabatan</option><option value="HSA">HSA</option><option value="Officer 3">Officer 3</option><option value="Korlap">Korlap</option><option value="Korlap B2B">Korlap B2B</option><option value="Teknisi B2B">Teknisi B2B</option></select></div>
                <div class="employee-form-field employee-password-field"><label for="employee-password">Password Login</label><input id="employee-password" type="password" name="password" placeholder="Masukkan password" required></div>
                <div class="employee-modal-actions"><button type="button" class="employee-cancel-button" data-modal-close="employee-modal">Batal</button><button type="submit" class="employee-save-button">Simpan</button></div>
            </form>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('employee-modal');

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
                }
            });

            @if ($errors->any())
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            @endif
        });
    </script>
</body>
</html>