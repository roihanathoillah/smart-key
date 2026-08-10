<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
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

        <main class="dashboard-content">
            <header class="dashboard-header">
                <div>
                    <h1>Super Admin Dashboard</h1>
                </div>
                <div class="profile-card">
                    <div class="profile-avatar">S</div>
                    <div>
                        <p>Super Admin</p>
                        <strong>Smart Key</strong>
                    </div>
                </div>
            </header>

            <section class="dashboard-cards">
                @foreach ($stats as $stat)
                    <article class="dashboard-card" style="border-top-color: {{ $stat['accent'] }};">
                        <div class="card-icon">{{ $stat['icon'] }}</div>
                        <div>
                            <p>{{ $stat['label'] }}</p>
                            <h2>{{ $stat['value'] }}</h2>
                        </div>
                        <span>{{ $stat['meta'] }}</span>
                    </article>
                @endforeach
            </section>

            <section class="dashboard-grid">
                <div class="activity-card">
                    <div class="activity-card-header">
                        <div>
                            <p>Aktivitas Terbaru</p>
                            <h2>Latest Activity</h2>
                        </div>
                        <span>Lihat semua</span>
                    </div>
                    <div class="activity-table-wrapper">
                        <table class="activity-table">
                            <thead>
                                <tr>
                                    <th>ID Data</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Nama Box</th>
                                    <th>Jam Chekin</th>
                                    <th>Jam Checkout</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity['id'] }}</td>
                                        <td>{{ $activity['name'] }}</td>
                                        <td>{{ $activity['date'] }}</td>
                                        <td>{{ $activity['box'] }}</td>
                                        <td>{{ $activity['checkin'] }}</td>
                                        <td>{{ $activity['checkout'] }}</td>
                                        <td>{{ $activity['location'] }}</td>
                                        <td><span class="status-pill">{{ $activity['status'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="activity-pagination">
                        <div class="pagination-summary">
                            Showing {{ $activities->firstItem() }} - {{ $activities->lastItem() }} of {{ $activities->total() }}
                        </div>
                        <div class="pagination-links">
                            @if ($activities->onFirstPage())
                                <span class="page disabled">Previous</span>
                            @else
                                <a class="page" href="{{ $activities->previousPageUrl() }}">Previous</a>
                            @endif

                            @php
                                $totalPages = $activities->lastPage();
                                $currentPage = $activities->currentPage();
                                $startPage = max(1, min($currentPage - 1, $totalPages - 3));
                                $endPage = min($totalPages, $startPage + 3);
                            @endphp

                            @foreach (range($startPage, $endPage) as $page)
                                @if ($page == $activities->currentPage())
                                    <span class="page active">{{ $page }}</span>
                                @else
                                    <a class="page" href="{{ $activities->url($page) }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($activities->hasMorePages())
                                <a class="page" href="{{ $activities->nextPageUrl() }}">Next</a>
                            @else
                                <span class="page disabled">Next</span>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
