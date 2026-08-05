<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                    <a href="#" class="active">Dashboard</a>
                    <a href="#">SmartBox</a>
                    <a href="#">Akun</a>
                    <a href="#">Pengaturan</a>
                </nav>
            </div>

            <div class="sidebar-section">
                <h2>Quick Links</h2>
                <a href="#">Pengguna</a>
                <a href="#">Laporan</a>
                <a href="#">Support</a>
            </div>
        </aside>

        <main class="dashboard-content">
            <header class="dashboard-header">
                <div>
                    <h1>Welcome back, Admin</h1>
                </div>
                <div class="profile-card">
                    <div class="profile-avatar">A</div>
                    <div>
                        <p>Administrator</p>
                        <strong>Admin Smart Key</strong>
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

                            @foreach (range(1, $activities->lastPage()) as $page)
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
