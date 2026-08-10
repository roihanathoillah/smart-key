<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan Super Admin</title>
    <link rel="stylesheet" href="/css/login.css">
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
                    <a href="{{ route('super.admin') }}" class="{{ request()->routeIs('super.admin') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('karyawan.super') }}" class="{{ request()->routeIs('karyawan.super') ? 'active' : '' }}">Daftar Karyawan</a>
                    <a href="{{ route('history.super') }}" class="{{ request()->routeIs('history.super') ? 'active' : '' }}">History</a>
                </nav>
            </div>

            <div class="sidebar-section">
                <h2>ADMIN</h2>
                <nav class="dashboard-nav">
                    <details class="sidebar-dropdown">
                        <summary>Setting</summary>
                        <div class="sidebar-dropdown-menu">
                            <a href="{{ route('profile.super') }}" class="{{ request()->routeIs('profile.super') ? 'active' : '' }}">Profile</a>
                            <a href="#">Notification</a>
                            <a href="#">Security</a>
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
                    <form method="get" action="{{ route('karyawan.super') }}" class="search-form">
                        <div class="search-input-wrapper">
                            <input type="text" name="q" placeholder="Search by order id" value="{{ $search ?? '' }}">
                            <button type="submit" class="search-button">🔍</button>
                        </div>
                    </form>
                </div>
                <div class="header-actions">
                    <button type="button" class="notification-button" aria-haspopup="true" aria-expanded="false">
                        <span class="bell-icon">🔔</span>
                        <span class="notification-dot">4</span>
                    </button>
                    <div class="profile-card">
                        <div class="profile-avatar">S</div>
                        <strong>Super Admin</strong>
                    </div>
                </div>
            </header>

            <section class="activity-card table-card">
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
                                    <td class="status-cell">
                                        <span class="employee-status {{ strtolower($employee['status']) }}">
                                            {{ $employee['status'] == 'Berhasil' ? 'Di Setujui' : ($employee['status'] == 'Ditolak' ? 'Ditolak' : 'Pending') }}
                                        </span>
                                        <button type="button" class="status-action">Tolak</button>
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

                        @foreach (range(max(1, $employees->currentPage() - 1), min($employees->lastPage(), $employees->currentPage() + 2)) as $page)
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
            </section>
        </main>
    </div>
</body>
</html>
