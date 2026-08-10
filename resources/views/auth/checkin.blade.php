<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Checkin/Chekout</title>
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

        <main class="dashboard-content">
            <header class="dashboard-header page-header">
                <div>
                    <h1>Checkin/Chekout</h1>
                </div>
                <div class="header-actions">
                    <div class="notification-button-wrapper">
                        <button type="button" class="notification-button" aria-haspopup="true" aria-expanded="false">
                            <span class="bell-icon">🔔</span>
                            <span class="notification-dot">4</span>
                        </button>
                    </div>
                    <div class="profile-card">
                        <div class="profile-avatar">A</div>
                    </div>
                </div>
            </header>

            <section class="dashboard-grid">
                <div class="history-search-panel checkin-search-panel">
                    <form method="get" action="{{ route('checkin') }}" class="history-search-form checkin-search-form">
                        <div class="search-input-wrapper">
                            <input type="text" name="q" placeholder="Search by employee name" value="{{ request('q') }}">
                            <button type="submit" class="search-button">🔍</button>
                        </div>
                    </form>
                </div>

                <div class="activity-card checkin-card">
                    <div class="checkin-top">
                        <div class="checkin-info">
                            <h3>Data Karyawan</h3>
                            <div class="checkin-row">
                                <div>
                                    <p><strong>ID Card</strong> : {{ $employee['id_card'] }}</p>
                                    <p><strong>Nama Lengkap</strong> : {{ $employee['name'] }}</p>
                                    <p><strong>NIK</strong> : {{ $employee['nik'] }}</p>
                                    <p><strong>Jabatan</strong> : {{ $employee['position'] }}</p>
                                    <p><strong>Devisi</strong> : {{ $employee['division'] }}</p>
                                    <p><strong>Status</strong> : <span class="employee-status berhasil">{{ $employee['status'] }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="checkin-badge">
                            <div class="badge">ID Card Terbaca<br><small>Top ID Card Berhasil</small></div>
                            <div class="badge-meta">Waktu Scan<br><small>{{ now()->format('d/m/Y H:i') }}</small></div>
                        </div>
                    </div>

                    <div class="service-grid">
                        @foreach ($services as $s)
                            <div class="service-card">
                                <h4>From layanan/ Pekerjaan</h4>
                                <p><strong>{{ $s['title'] }}</strong></p>
                                <label>Diskripsi Pekerjaan</label>
                                <div class="service-desc">{{ $s['desc'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="checkin-actions">
                        <button class="btn-red">EDIT</button>
                        <button class="btn-red">SIMPAN</button>
                        <button class="btn-red">CHEK OUT</button>
                    </div>
                </div>
            </section>
        </main>
    </div>
</html>
