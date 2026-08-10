<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan</title>
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
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('karyawan') }}" class="{{ request()->routeIs('karyawan') ? 'active' : '' }}">Daftar Karyawan</a>
                    <a href="{{ route('history') }}" class="{{ request()->routeIs('history') ? 'active' : '' }}">History</a>
                    <a href="{{ route('checkin') }}" class="{{ request()->routeIs('checkin') ? 'active' : '' }}">Chekin/Chekout</a>
                </nav>
            </div>

            <div class="sidebar-section">
                <h2>Main Menu</h2>
                <nav class="dashboard-nav">
                    <details class="sidebar-dropdown">
                        <summary>Setting</summary>
                        <div class="sidebar-dropdown-menu">
                            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profile</a>
                            <a href="#">Notification</a>
                            <a href="#">Security</a>
                        </div>
                    </details>
                </nav>
            </div>

        </aside>

        <main class="dashboard-content karyawan-page">
            <header class="dashboard-header page-header">
                <div>
                    <h1>Daftar Karyawan</h1>
                </div>
                <div class="header-actions">
                    <div class="notification-button-wrapper">
                        <button type="button" class="notification-button" aria-haspopup="true" aria-expanded="false">
                            <span class="bell-icon">🔔</span>
                            <span class="notification-dot">4</span>
                        </button>
                        <div class="notification-menu" role="menu">
                            <div class="notification-menu-header">Notifications</div>
                            <a href="#" class="notification-item">
                                <span class="notification-item-title">New login from Malang</span>
                                <span class="notification-item-time">2 min ago</span>
                            </a>
                            <a href="#" class="notification-item">
                                <span class="notification-item-title">Order #6548 updated</span>
                                <span class="notification-item-time">1 hour ago</span>
                            </a>
                            <a href="#" class="notification-item">
                                <span class="notification-item-title">System maintenance</span>
                                <span class="notification-item-time">Yesterday</span>
                            </a>
                        </div>
                    </div>
                    <div class="profile-card">
                        <div class="profile-avatar">A</div>
                    </div>
                </div>
            </header>

            <section class="dashboard-grid">
                <div class="activity-card table-card">
                    <div class="employee-filter">
                        <form method="get" action="{{ route('karyawan') }}" class="search-form">
                            <div class="search-input-wrapper">
                                <input type="text" name="q" placeholder="Search by order id" value="{{ $search ?? '' }}">
                                <button type="submit" class="search-button">🔍</button>
                            </div>
                        </form>
                    </div>

                    <div class="employee-add-row">
                        <div class="employee-add-label">Tambah Karyawan</div>
                        <div class="employee-add-grid">
                            <div class="add-field">
                                <div class="field-label">DATA ID</div>
                                <input type="text" readonly value="ID: 679234">
                            </div>
                            <div class="add-field">
                                <div class="field-label">USER</div>
                                <input type="text" placeholder="nama karyawan">
                            </div>
                            <div class="add-field">
                                <div class="field-label">KALENDER</div>
                                <input type="text" placeholder="Pilih Tanggal">
                            </div>
                            <div class="add-field">
                                <div class="field-label">STATUS</div>
                                <select>
                                    <option>Chekin</option>
                                    <option>Checkout</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="activity-table-wrapper">
                        <table class="activity-table">
                            <thead>
                                <tr>
                                    <th>Data ID</th>
                                    <th>User</th>
                                    <th>Kalender</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee['id'] }}</td>
                                        <td>{{ $employee['name'] }}</td>
                                        <td>{{ $employee['calendar'] }}</td>
                                        <td>
                                            <span class="employee-status {{ strtolower($employee['status']) }}">
                                                {{ $employee['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center; padding:20px; color:#6b7280;">Tidak ada karyawan ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="activity-pagination">
                        <div class="pagination-summary">
                            Showing {{ $employees->firstItem() ?: 0 }} - {{ $employees->lastItem() ?: 0 }} of {{ $employees->total() }}
                        </div>
                        <div class="pagination-links">
                            @if ($employees->onFirstPage())
                                <span class="page disabled">Previous</span>
                            @else
                                <a class="page" href="{{ $employees->previousPageUrl() }}">Previous</a>
                            @endif

                            @php
                                $totalPages = $employees->lastPage();
                                $currentPage = $employees->currentPage();
                                $startPage = max(1, min($currentPage - 1, $totalPages - 3));
                                $endPage = min($totalPages, $startPage + 3);
                            @endphp

                            @foreach (range($startPage, $endPage) as $page)
                                @if ($page == $employees->currentPage())
                                    <span class="page active">{{ $page }}</span>
                                @else
                                    <a class="page" href="{{ $employees->url($page) }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($employees->hasMorePages())
                                <a class="page" href="{{ $employees->nextPageUrl() }}">Next</a>
                            @else
                                <span class="page disabled">Next</span>
                            @endif
                        </div>
                    </div>

                    <div class="table-actions">
                        <button type="button" class="action-button secondary">Edit</button>
                        <button type="button" class="action-button primary">Simpan</button>
                        <button type="button" class="action-button danger">Batal</button>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
