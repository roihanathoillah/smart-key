<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link rel="stylesheet" href="/css/dashboard.css">
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

            <section class="dashboard-cards super-admin-stats">
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
                <div class="activity-card activity-chart-card">
                    <div class="activity-card-header">
                        <div>
                            <p>Dashboard</p>
                            <h2>Grafik Aktivitas</h2>
                        </div>
                        <span>Checkin dan Checkout</span>
                    </div>
                    <div class="activity-chart" aria-label="Grafik aktivitas checkin dan checkout">
                        <div class="chart-legend">
                            <span><i class="legend-dot checkin"></i>Checkin</span>
                            <span><i class="legend-dot checkout"></i>Checkout</span>
                        </div>
                        <div class="chart-bars">
                            @foreach ($chart as $day)
                                @php
                                    $maxValue = max(1, $chart->max(fn ($item) => max($item['checkin'], $item['checkout'])));
                                    $checkinHeight = ($day['checkin'] / $maxValue) * 100;
                                    $checkoutHeight = ($day['checkout'] / $maxValue) * 100;
                                @endphp
                                <div class="chart-column">
                                    <div class="chart-bar-group">
                                        <span class="chart-bar checkin" style="height: {{ max(4, $checkinHeight) }}%;" title="{{ $day['checkin'] }} checkin"></span>
                                        <span class="chart-bar checkout" style="height: {{ max(4, $checkoutHeight) }}%;" title="{{ $day['checkout'] }} checkout"></span>
                                    </div>
                                    <small>{{ $day['label'] }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

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
                                @forelse ($activities as $activity)
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
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-activity">Belum ada aktivitas checkin atau checkout.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
