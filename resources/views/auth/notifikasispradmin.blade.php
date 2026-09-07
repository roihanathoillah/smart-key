<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Notifikasi Super Admin</title>
	<link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>
	<div class="dashboard-page notification-page">
		<aside class="dashboard-sidebar">
			<div class="brand">
				<span class="brand-logo">SK</span>
				<div>
					<h1>Smart Key</h1>
					<p>Super Admin</p>
				</div>
			</div>

			<div class="sidebar-section">
				<h2>MENU</h2>
				<nav class="dashboard-nav">
					<a href="{{ route('super.admin') }}">Dashboard</a>
					<a href="{{ route('karyawan.super') }}">Daftar Karyawan</a>
					<a href="{{ route('history.super') }}">History</a>
				</nav>
			</div>

			<div class="sidebar-section">
				<h2>MAIN MENU</h2>
				<nav class="dashboard-nav">
					<details class="sidebar-dropdown" open>
						<summary>Setting</summary>
						<div class="sidebar-dropdown-menu">
							<a href="{{ route('profile.super') }}">Profile</a>
						</div>
					</details>
				</nav>
			</div>
		</aside>

		<main class="dashboard-content notification-content">
			<header class="dashboard-header page-header">
				<div>
					<p class="page-label">SETTING</p>
					<h1>Notifikasi</h1>
				</div>
				<div class="notification-summary">
					<span class="notification-summary-dot"></span>
					{{ $notifications->total() }} aktivitas terbaru
				</div>
			</header>

			<section class="notification-panel">
				<div class="notification-panel-header">
					<div>
						<p>AKTIVITAS ADMIN</p>
						<h2>Check-in & Check-out</h2>
					</div>
					<span class="notification-panel-count">{{ $notifications->total() }} total</span>
				</div>

				<div class="notification-list">
					@forelse ($notifications as $notification)
						<article class="notification-item-card">
							<div class="notification-item-icon {{ $notification['tone'] }}">
								{{ $notification['tone'] === 'checkout' ? '↗' : '↘' }}
							</div>
							<div class="notification-item-body">
								<div class="notification-item-heading">
									<h3>{{ $notification['title'] }}</h3>
									<span>{{ $notification['date'] }} · {{ $notification['time'] }}</span>
								</div>
								<p><strong>{{ $notification['name'] }}</strong> · ID {{ $notification['id'] }}</p>
								<div class="notification-item-meta">
									<span>ODC: {{ $notification['odc'] }}</span>
									<span>District: {{ $notification['district'] }}</span>
									<b class="notification-type {{ $notification['tone'] }}">{{ $notification['type'] }}</b>
								</div>
							</div>
						</article>
					@empty
						<div class="notification-empty">
							<strong>Belum ada notifikasi</strong>
							<span>Aktivitas check-in dan check-out admin akan muncul di sini.</span>
						</div>
					@endforelse
				</div>

				<div class="activity-pagination notification-pagination">
					<div class="pagination-summary">
						Showing {{ $notifications->firstItem() ?: 0 }} - {{ $notifications->lastItem() ?: 0 }} of {{ $notifications->total() }}
					</div>
					<div class="pagination-links">
						@if ($notifications->onFirstPage())
							<span class="page disabled">Previous</span>
						@else
							<a class="page" href="{{ $notifications->previousPageUrl() }}">Previous</a>
						@endif

						@php
							$totalPages = $notifications->lastPage();
							$currentPage = $notifications->currentPage();
							$startPage = max(1, min($currentPage - 1, $totalPages - 3));
							$endPage = min($totalPages, $startPage + 3);
						@endphp

						@foreach (range($startPage, $endPage) as $page)
							@if ($page == $currentPage)
								<span class="page active">{{ $page }}</span>
							@else
								<a class="page" href="{{ $notifications->url($page) }}">{{ $page }}</a>
							@endif
						@endforeach

						@if ($notifications->hasMorePages())
							<a class="page" href="{{ $notifications->nextPageUrl() }}">Next</a>
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
