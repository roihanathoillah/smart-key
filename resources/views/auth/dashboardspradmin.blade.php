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
                        </div>
                    </details>
                </nav>
            </div>

        </aside>

        <main class="dashboard-content">
            <header class="dashboard-header">
                <div class="header-actions">
                    <a href="{{ route('notifikasi.super') }}" class="notification-button" aria-label="Notifikasi" title="Notifikasi dari Setting">
                        <span class="bell-icon">🔔</span>
                        <span class="notification-dot">{{ $notificationCount }}</span>
                    </a>
                    <a href="{{ route('profile.super') }}" class="profile-card" aria-label="Edit profile">
                        <div class="profile-avatar">
                            @if (!empty($profileUser?->foto_profil))
                                <img src="{{ asset($profileUser->foto_profil) }}" alt="Foto profil">
                            @endif
                        </div>
                        <div>
                            <p>{{ $profileUser?->username ?? $profileUser?->nama_lengkap ?? 'Super Admin' }}</p>
                        </div>
                    </a>
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
                        <span>Kapan Checkin - Kapan Checkout</span>
                    </div>
                    <div class="activity-chart" aria-label="Grafik aktivitas checkin dan checkout">
                        <div class="chart-legend">
                            <span><i class="legend-dot checkin"></i>Checkin</span>
                            <span><i class="legend-dot checkout"></i>Checkout</span>
                        </div>
                        @php
                            $chartMax = max(4, (int) $chart->max(fn ($item) => max($item['checkin'], $item['checkout'])));
                            $chartPoints = function ($key) use ($chart, $chartMax) {
                                return $chart->values()->map(function ($item, $index) use ($key, $chartMax) {
                                    $x = 28 + ($index * 104);
                                    $y = 190 - (($item[$key] / $chartMax) * 160);
                                    return number_format($x, 2) . ',' . number_format($y, 2);
                                })->implode(' ');
                            };
                        @endphp
                        <div class="line-chart-wrapper">
                            <div class="line-chart-y-labels" aria-hidden="true">
                                <span>{{ $chartMax }}</span><span>{{ round($chartMax * .75) }}</span><span>{{ round($chartMax * .5) }}</span><span>{{ round($chartMax * .25) }}</span><span>0</span>
                            </div>
                            <svg class="line-chart" viewBox="0 0 700 230" role="img" aria-label="Perbandingan jumlah checkin dan checkout hari ini">
                                <g class="chart-grid-lines">
                                    <line x1="28" y1="30" x2="652" y2="30"></line>
                                    <line x1="28" y1="70" x2="652" y2="70"></line>
                                    <line x1="28" y1="110" x2="652" y2="110"></line>
                                    <line x1="28" y1="150" x2="652" y2="150"></line>
                                    <line x1="28" y1="190" x2="652" y2="190"></line>
                                </g>
                                <polyline class="chart-line checkin" points="{{ $chartPoints('checkin') }}"></polyline>
                                <polyline class="chart-line checkout" points="{{ $chartPoints('checkout') }}"></polyline>
                                @foreach ($chart as $index => $point)
                                    @php $x = 28 + ($index * 104); @endphp
                                    <circle class="chart-point checkin" cx="{{ $x }}" cy="{{ 190 - (($point['checkin'] / $chartMax) * 160) }}" r="3.5" title="{{ $point['checkin'] }} checkin"></circle>
                                    <circle class="chart-point checkout" cx="{{ $x }}" cy="{{ 190 - (($point['checkout'] / $chartMax) * 160) }}" r="3.5" title="{{ $point['checkout'] }} checkout"></circle>
                                    <text class="chart-x-label" x="{{ $x }}" y="218" text-anchor="middle">{{ $point['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                    </div>
                </div>

            </section>
        </main>
    </div>
</body>
</html>
