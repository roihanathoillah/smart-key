<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
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

        <main class="dashboard-content">
            <header class="dashboard-header page-header">
                <div>
                    <h1>History</h1>
                </div>
                <div class="header-actions">
                    <button type="button" class="notification-button">
                        <span class="bell-icon">🔔</span>
                        <span class="notification-dot">4</span>
                    </button>
                    <div class="profile-card">
                        <div class="profile-avatar">A</div>
                    </div>
                </div>
            </header>

            <section class="dashboard-grid">
                <div class="history-search-panel">
                    <form method="get" action="{{ route('history') }}" class="history-search-form">
                        <div class="search-input-wrapper history-search-input">
                            <input type="text" name="q" placeholder="Search by order id" value="{{ $search ?? '' }}">
                            <button type="submit" class="search-button">🔍</button>
                        </div>
                        <div class="history-actions">
                            <button type="button" class="date-filter-button">Filter by date range</button>
                        </div>
                    </form>
                </div>

                <div class="activity-card table-card">
                    <div class="activity-table-wrapper">
                        <table class="activity-table">
                            <thead>
                                <tr>
                                    <th>ID DATA</th>
                                    <th>NAMA</th>
                                    <th>TANGGAL</th>
                                    <th>NAMA BOX</th>
                                    <th>JAM CHEKIN</th>
                                    <th>JAM CHECKOUT</th>
                                    <th>LOKASI</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($history as $item)
                                    <tr>
                                        <td>{{ $item['id'] }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['date'] }}</td>
                                        <td>{{ $item['box'] }}</td>
                                        <td>{{ $item['checkin'] }}</td>
                                        <td>{{ $item['checkout'] }}</td>
                                        <td>{{ $item['location'] }}</td>
                                        <td><span class="status-pill">{{ $item['status'] }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" style="text-align:center; padding:20px; color:#6b7280;">Tidak ada history ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="activity-pagination">
                        <div class="pagination-summary">
                            Showing {{ $history->firstItem() ?: 0 }} - {{ $history->lastItem() ?: 0 }} of {{ $history->total() }}
                        </div>
                        <div class="pagination-links">
                            @if ($history->onFirstPage())
                                <span class="page disabled">Previous</span>
                            @else
                                <a class="page" href="{{ $history->previousPageUrl() }}">Previous</a>
                            @endif

                            @php
                                $totalPages = $history->lastPage();
                                $currentPage = $history->currentPage();
                                $startPage = max(1, min($currentPage - 1, $totalPages - 3));
                                $endPage = min($totalPages, $startPage + 3);
                            @endphp

                            @foreach (range($startPage, $endPage) as $page)
                                @if ($page == $history->currentPage())
                                    <span class="page active">{{ $page }}</span>
                                @else
                                    <a class="page" href="{{ $history->url($page) }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($history->hasMorePages())
                                <a class="page" href="{{ $history->nextPageUrl() }}">Next</a>
                            @else
                                <span class="page disabled">Next</span>
                            @endif
                          </div>
                    </div>
                    <div class="export-bottom">
                        <button type="button" class="export-button" onclick="window.location.href='{{ route('history.export') }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}'">
                            <span>Export PDF</span>
                            <span class="export-icon">📄</span>
                        </button>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.status-pill').forEach(function (pill) {
                var text = pill.textContent.trim().toLowerCase();
                if (text === 'checkout' || text === 'check out') {
                    pill.classList.add('checkout');
                } else if (text === 'checkin' || text === 'chekin' || text === 'check in') {
                    pill.classList.add('checkin');
                }
            });
        });
    </script>
</body>
</html>
