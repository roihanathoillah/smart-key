<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/dashboard.css">

    <style>
        /* =========================================================
           DASHBOARD ADMIN - SESUAI FLOWCHART
           ========================================================= */

        .admin-summary-cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .admin-summary-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 22px;
            box-sizing: border-box;
        }

        .admin-summary-card p {
            margin: 0 0 8px 0;
            color: #6b7280;
            font-size: 14px;
            font-weight: 600;
        }

        .admin-summary-card h2 {
            margin: 0;
            color: #111827;
            font-size: 30px;
            font-weight: 700;
        }

        .user-activity-chart-card,
        .user-activity-table-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 24px;
            box-sizing: border-box;
            width: 100%;
        }

        .user-activity-chart-card {
            margin-bottom: 20px;
        }

        .user-activity-chart-header,
        .user-activity-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .user-activity-chart-header {
            justify-content: center;
            text-align: center;
        }

        .user-activity-chart-header p,
        .user-activity-table-header p {
            margin: 0 0 5px 0;
            color: #6b7280;
            font-size: 13px;
        }

        .user-activity-chart-header h2,
        .user-activity-table-header h2 {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 700;
        }

        .user-activity-chart-wrapper {
            position: relative;
            width: 100%;
            min-height: 360px;
        }

        .user-activity-chart-wrapper canvas {
            width: 100% !important;
            height: 360px !important;
        }

        .admin-activity-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .admin-activity-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        .admin-activity-table th,
        .admin-activity-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            font-size: 13px;
            color: #1f2937;
            white-space: nowrap;
        }

        .admin-activity-table th {
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            background: #f8fafc;
        }

        .admin-activity-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 84px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-pill.checkin {
            background: #dcfce7;
            color: #15803d;
        }

        .status-pill.checkout {
            background: #fee2e2;
            color: #b91c1c;
        }

        .admin-table-empty {
            text-align: center !important;
            padding: 24px !important;
            color: #6b7280 !important;
        }

        @media (max-width: 900px) {
            .admin-summary-cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .user-activity-chart-card,
            .user-activity-table-card {
                padding: 18px;
            }

            .user-activity-chart-wrapper {
                min-height: 300px;
            }

            .user-activity-chart-wrapper canvas {
                height: 300px !important;
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
                    <p>Admin Dashboard</p>
                </div>
            </div>

            <div class="sidebar-section">

                <h2>Menu</h2>

                <nav class="dashboard-nav">

                    <a
                        href="{{ route('dashboard') }}"
                        class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('checkin') }}"
                        class="{{ request()->routeIs('checkin') ? 'active' : '' }}"
                    >
                        Chekin/Chekout
                    </a>

                </nav>

            </div>

            <div class="sidebar-section">

                <h2>Main Menu</h2>

                <nav class="dashboard-nav">

                    <details class="sidebar-dropdown">

                        <summary>Setting</summary>

                        <div class="sidebar-dropdown-menu">

                            <a
                                href="{{ route('profile') }}"
                                class="{{ request()->routeIs('profile') ? 'active' : '' }}"
                            >
                                Profile
                            </a>

                        </div>

                    </details>

                </nav>

            </div>

        </aside>

        <main class="dashboard-content">

            <header class="dashboard-header">

                <div>
                    <h1>Welcome back, Admin</h1>
                </div>

                <div class="profile-card">

                    <div class="profile-avatar">
                        A
                    </div>

                    <div>
                        <p>Administrator</p>
                        <strong>Admin Smart Key</strong>
                    </div>

                </div>

            </header>

            @php
                /*
                |--------------------------------------------------------------------------
                | FALLBACK CARD
                |--------------------------------------------------------------------------
                |
                | Kalau controller baru belum dipasang, Blade masih bisa membaca
                | nilai dari $stats lama agar tidak error.
                |
                */

                $aksesHariIni = $aksesHariIni ?? null;
                $aksesBerhasil = $aksesBerhasil ?? null;
                $aksesDitolak = $aksesDitolak ?? null;

                if ($aksesHariIni === null && isset($stats)) {
                    $aksesHariIni = collect($stats)->firstWhere('label', 'Akses Hari ini')['value'] ?? 0;
                }

                if ($aksesBerhasil === null && isset($stats)) {
                    $aksesBerhasil = collect($stats)->firstWhere('label', 'Akses Berhasil')['value'] ?? 0;
                }

                if ($aksesDitolak === null && isset($stats)) {
                    $aksesDitolak = collect($stats)->firstWhere('label', 'Akses Ditolak')['value'] ?? 0;
                }


                /*
                |--------------------------------------------------------------------------
                | FALLBACK GRAFIK
                |--------------------------------------------------------------------------
                |
                | Controller final nantinya mengirim:
                | $activityChartLabels
                | $activityCheckinData
                | $activityCheckoutData
                |
                */

                $chartLabels = $activityChartLabels ?? [];
                $checkinData = $activityCheckinData ?? [];
                $checkoutData = $activityCheckoutData ?? [];

                if (
                    empty($chartLabels) &&
                    isset($activities)
                ) {
                    $activityCollection = collect($activities->items() ?? []);

                    $groupedActivities = $activityCollection
                        ->groupBy(function ($item) {
                            return $item['date'] ?? '-';
                        });

                    $chartLabels = $groupedActivities
                        ->keys()
                        ->values()
                        ->all();

                    $checkinData = $groupedActivities
                        ->map(function ($items) {
                            return collect($items)->filter(function ($item) {
                                $status = strtolower($item['status'] ?? '');
                                return $status === 'chekin' || $status === 'checkin';
                            })->count();
                        })
                        ->values()
                        ->all();

                    $checkoutData = $groupedActivities
                        ->map(function ($items) {
                            return collect($items)->filter(function ($item) {
                                return strtolower($item['status'] ?? '') === 'checkout';
                            })->count();
                        })
                        ->values()
                        ->all();
                }
            @endphp


            <!-- =====================================================
                 CARD RINGKASAN
                 ===================================================== -->

            <section class="admin-summary-cards">

                <article class="admin-summary-card">

                    <p>
                        Akses Hari Ini
                    </p>

                    <h2>
                        {{ $aksesHariIni ?? 0 }}
                    </h2>

                </article>

                <article class="admin-summary-card">

                    <p>
                        Akses Berhasil
                    </p>

                    <h2>
                        {{ $aksesBerhasil ?? 0 }}
                    </h2>

                </article>

                <article class="admin-summary-card">

                    <p>
                        Akses Ditolak
                    </p>

                    <h2>
                        {{ $aksesDitolak ?? 0 }}
                    </h2>

                </article>

            </section>


            <!-- =====================================================
                 GRAFIK AKTIVITAS
                 ===================================================== -->

            <section class="dashboard-grid">

                <div class="user-activity-chart-card">

                    <div class="user-activity-chart-header">

                        <div>

                            <p>
                                Aktivitas User
                            </p>

                            <h2 style="text-align:center;">
                                Grafik Aktivitas
                                <br>
                                <span style="font-size:14px; font-weight:600;">
                                    Kapan Chekin - Kapan Checkout
                                </span>
                            </h2>

                        </div>

                    </div>

                    <div class="user-activity-chart-wrapper">

                        <canvas id="userActivityChart"></canvas>

                    </div>

                </div>


                <!-- =================================================
                     TABEL AKTIVITAS
                     ================================================= -->

                <div class="user-activity-table-card">

                    <div class="user-activity-table-header">

                        <div>

                            <p>
                                Aktivitas Terbaru
                            </p>

                            <h2>
                                Tabel Aktivitas
                            </h2>

                        </div>

                    </div>

                    <div class="admin-activity-table-wrapper">

                        <table class="admin-activity-table">

                            <thead>

                                <tr>
                                    <th>ID Data</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Jam Chekin</th>
                                    <th>Jam Checkout</th>
                                    <th>Distrik</th>
                                    <th>ODS</th>
                                    <th>Status</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($activities as $activity)

                                    <tr>

                                        <td>
                                            {{ $activity['id'] ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $activity['name'] ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $activity['date'] ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $activity['checkin'] ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $activity['checkout'] ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $activity['district'] ?? ($activity['location'] ?? '-') }}
                                        </td>

                                        <td>
                                            {{ $activity['ods'] ?? '-' }}
                                        </td>

                                        <td>

                                            @php
                                                $activityStatus = strtolower($activity['status'] ?? '');
                                            @endphp

                                            <span
                                                class="status-pill {{ $activityStatus === 'checkout' ? 'checkout' : 'checkin' }}"
                                            >
                                                {{ $activity['status'] ?? '-' }}
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="8"
                                            class="admin-table-empty"
                                        >
                                            Belum ada data aktivitas.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </section>

        </main>

    </div>


    <!-- =============================================================
         CHART.JS
         ============================================================= -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- =============================================================
         JAVASCRIPT GRAFIK
         ============================================================= -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const chartElement =
                document.getElementById('userActivityChart');

            if (!chartElement) {
                return;
            }

            const labels =
                @json($chartLabels);

            const checkinData =
                @json($checkinData);

            const checkoutData =
                @json($checkoutData);


            const maximumValue =
                Math.max(
                    0,
                    ...checkinData,
                    ...checkoutData
                );

            let chartMaximum = 5;
            let chartStep = 1;

            if (maximumValue > 5 && maximumValue <= 10) {
                chartMaximum = 10;
                chartStep = 2;
            } else if (maximumValue > 10) {
                chartMaximum =
                    Math.ceil(maximumValue / 10) * 10;

                chartStep = 10;
            }


            new Chart(
                chartElement,
                {
                    type: 'line',

                    data: {

                        labels: labels,

                        datasets: [

                            {
                                label: 'Chekin',
                                data: checkinData,

                                borderColor: '#2563eb',
                                backgroundColor: '#2563eb',

                                borderWidth: 2.5,

                                tension: 0,

                                pointRadius: 4,
                                pointHoverRadius: 6,

                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#2563eb',
                                pointBorderWidth: 2,

                                // Chekin tetap garis utama.
                                // Checkout diberi bentuk berbeda saat berada di titik sama.
                                order: 1,

                                fill: false
                            },

                            {
                                label: 'Checkout',
                                data: checkoutData,

                                borderColor: '#16a34a',
                                backgroundColor: '#16a34a',

                                // Dibuat putus-putus agar tetap terlihat saat
                                // nilainya sama persis dengan garis Chekin.
                                borderDash: [8, 6],
                                borderWidth: 3,

                                tension: 0,

                                // Titik Checkout dibuat lebih besar dan hijau penuh
                                // supaya tidak tertutup titik Chekin ketika overlap.
                                pointRadius: 7,
                                pointHoverRadius: 9,
                                pointStyle: 'rectRot',

                                pointBackgroundColor: '#16a34a',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,

                                // Pastikan dataset Checkout digambar di atas Chekin.
                                order: 0,

                                fill: false
                            }

                        ]
                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {
                            mode: 'index',
                            intersect: false
                        },

                        layout: {
                            padding: {
                                top: 0,
                                right: 10,
                                bottom: 0,
                                left: 10
                            }
                        },

                        plugins: {

                            legend: {
                                display: true,
                                position: 'top',
                                align: 'start',

                                labels: {
                                    usePointStyle: false,
                                    boxWidth: 34,
                                    boxHeight: 2,
                                    padding: 14
                                }
                            },

                            tooltip: {
                                enabled: true
                            }
                        },

                        scales: {

                            y: {

                                beginAtZero: true,

                                max: chartMaximum,

                                ticks: {
                                    stepSize: chartStep,
                                    precision: 0
                                },

                                title: {
                                    display: false
                                },

                                grid: {
                                    display: false
                                },

                                border: {
                                    display: true
                                }
                            },

                            x: {

                                title: {
                                    display: false
                                },

                                grid: {
                                    display: false
                                },

                                border: {
                                    display: true
                                }
                            }
                        }
                    }
                }
            );

        });

    </script>

</body>
</html>
