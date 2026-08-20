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

                <span class="brand-logo">
                    SK
                </span>

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
                        href="{{ route('karyawan') }}"
                        class="{{ request()->routeIs('karyawan') ? 'active' : '' }}"
                    >
                        Daftar Karyawan
                    </a>

                    <a
                        href="{{ route('history') }}"
                        class="{{ request()->routeIs('history') ? 'active' : '' }}"
                    >
                        History
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

                        <summary>
                            Setting
                        </summary>

                        <div class="sidebar-dropdown-menu">

                            <a
                                href="{{ route('profile') }}"
                                class="{{ request()->routeIs('profile') ? 'active' : '' }}"
                            >
                                Profile
                            </a>

                            <a href="#">
                                Notification
                            </a>

                            <a href="#">
                                Security
                            </a>

                        </div>

                    </details>

                </nav>

            </div>

        </aside>



        <main class="dashboard-content">


            <!-- =========================================================
                 HEADER
                 ========================================================= -->

            <header class="dashboard-header page-header">

                <div>
                    <h1>History</h1>
                </div>


                <div class="header-actions">

                    <button
                        type="button"
                        class="notification-button"
                    >

                        <span class="bell-icon">
                            🔔
                        </span>

                        <span class="notification-dot">
                            4
                        </span>

                    </button>


                    <div class="profile-card">

                        <div class="profile-avatar">
                            A
                        </div>

                    </div>

                </div>

            </header>



            <!-- =========================================================
                 CONTENT
                 ========================================================= -->

            <section class="dashboard-grid">


                <!-- =====================================================
                     SEARCH
                     ===================================================== -->

                <div class="history-search-panel">

                    <form
                        method="get"
                        action="{{ route('history') }}"
                        class="history-search-form"
                    >

                        <div class="search-input-wrapper history-search-input">

                            <input
                                type="text"
                                name="q"
                                placeholder="Search by order id"
                                value="{{ $search ?? '' }}"
                            >

                            <button
                                type="submit"
                                class="search-button"
                            >
                                🔍
                            </button>

                        </div>


                        <div class="history-actions">

                            <input
                                type="date"
                                name="tanggal_awal"
                                value="{{ request('tanggal_awal') }}"
                                aria-label="Tanggal awal"
                            >

                            <input
                                type="date"
                                name="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}"
                                aria-label="Tanggal akhir"
                            >

                            <button
                                type="submit"
                                class="date-filter-button"
                            >
                                Filter by date range
                            </button>

                        </div>

                    </form>

                </div>



                <!-- =====================================================
                     TABLE HISTORY
                     ===================================================== -->

                <div class="activity-card table-card">


                    <div class="activity-table-wrapper">

                        <table class="activity-table">


                            <!-- =========================================
                                 TABLE HEADER
                                 ========================================= -->

                            <thead>

                                <tr>

                                    <th>
                                        ID DATA
                                    </th>

                                    <th>
                                        NAMA
                                    </th>

                                    <th>
                                        TANGGAL
                                    </th>

                                    <th>
                                        NAMA BOX
                                    </th>

                                    <th>
                                        JAM CHEKIN
                                    </th>

                                    <th>
                                        JAM CHECKOUT
                                    </th>

                                    <th>
                                        DISTRIK
                                    </th>

                                    <th>
                                        ODS
                                    </th>

                                    <th>
                                        STATUS
                                    </th>

                                </tr>

                            </thead>



                            <!-- =========================================
                                 TABLE BODY
                                 ========================================= -->

                            <tbody>

                                @forelse ($history as $item)

                                    <tr>


                                        <!-- ID DATA -->

                                        <td>
                                            {{ $item['id'] }}
                                        </td>


                                        <!-- NAMA -->

                                        <td>
                                            {{ $item['name'] }}
                                        </td>


                                        <!-- TANGGAL -->

                                        <td>
                                            {{ $item['date'] }}
                                        </td>


                                        <!-- NAMA BOX -->

                                        <td>
                                            {{ $item['box'] }}
                                        </td>


                                        <!-- JAM CHECKIN -->

                                        <td>
                                            {{ $item['checkin'] }}
                                        </td>


                                        <!-- JAM CHECKOUT -->

                                        <td>
                                            {{ $item['checkout'] }}
                                        </td>


                                        <!-- DISTRIK -->

                                        <td>
                                            {{ $item['district'] ?? '-' }}
                                        </td>


                                        <!-- ODS -->

                                        <td>
                                            {{ $item['ods'] ?? '-' }}
                                        </td>


                                        <!-- STATUS -->

                                        <td>

                                            <span class="status-pill">

                                                {{ $item['status'] }}

                                            </span>

                                        </td>

                                    </tr>


                                @empty


                                    <tr>

                                        <td
                                            colspan="9"
                                            style="
                                                text-align:center;
                                                padding:20px;
                                                color:#6b7280;
                                            "
                                        >

                                            Tidak ada history ditemukan.

                                        </td>

                                    </tr>


                                @endforelse

                            </tbody>

                        </table>

                    </div>



                    <!-- =================================================
                         PAGINATION
                         ================================================= -->

                    <div class="activity-pagination">


                        <!-- =============================================
                             SUMMARY
                             ============================================= -->

                        <div class="pagination-summary">

                            Showing

                            {{ $history->firstItem() ?: 0 }}

                            -

                            {{ $history->lastItem() ?: 0 }}

                            of

                            {{ $history->total() }}

                        </div>



                        <!-- =============================================
                             PAGINATION LINKS
                             ============================================= -->

                        <div class="pagination-links">


                            <!-- PREVIOUS -->

                            @if ($history->onFirstPage())

                                <span class="page disabled">

                                    Previous

                                </span>

                            @else

                                <a
                                    class="page"
                                    href="{{ $history->previousPageUrl() }}"
                                >

                                    Previous

                                </a>

                            @endif



                            <!-- PAGE NUMBER -->

                            @php

                                $totalPages =
                                    $history->lastPage();

                                $currentPage =
                                    $history->currentPage();

                                $startPage =
                                    max(
                                        1,
                                        min(
                                            $currentPage - 1,
                                            $totalPages - 3
                                        )
                                    );

                                $endPage =
                                    min(
                                        $totalPages,
                                        $startPage + 3
                                    );

                            @endphp



                            @if($totalPages > 0)

                                @foreach (range($startPage, $endPage) as $page)

                                    @if ($page == $history->currentPage())

                                        <span class="page active">

                                            {{ $page }}

                                        </span>

                                    @else

                                        <a
                                            class="page"
                                            href="{{ $history->url($page) }}"
                                        >

                                            {{ $page }}

                                        </a>

                                    @endif

                                @endforeach

                            @endif



                            <!-- NEXT -->

                            @if ($history->hasMorePages())

                                <a
                                    class="page"
                                    href="{{ $history->nextPageUrl() }}"
                                >

                                    Next

                                </a>

                            @else

                                <span class="page disabled">

                                    Next

                                </span>

                            @endif

                        </div>

                    </div>



                    <!-- =================================================
                         EXPORT EXCEL
                         ================================================= -->

                    <div class="export-bottom">

                        <button
                            type="button"
                            class="export-button"
                            onclick="window.location.href='{{ route('history.export') }}{{ request()->getQueryString() ? '?'.request()->getQueryString() : '' }}'"
                        >

                            <span>
                                Export to Excel
                            </span>

                            <span class="export-icon">
                                📊
                            </span>

                        </button>

                    </div>


                </div>

            </section>

        </main>

    </div>



    <!-- =============================================================
         JAVASCRIPT
         ============================================================= -->

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function ()
            {

                document
                    .querySelectorAll('.status-pill')
                    .forEach(
                        function (pill)
                        {

                            var text =
                                pill
                                    .textContent
                                    .trim()
                                    .toLowerCase();


                            /*
                            |--------------------------------------------------------------------------
                            | CHECKOUT
                            |--------------------------------------------------------------------------
                            */

                            if (
                                text === 'checkout' ||
                                text === 'check out'
                            ) {

                                pill.classList.add(
                                    'checkout'
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | CHECKIN
                            |--------------------------------------------------------------------------
                            */

                            else if (
                                text === 'checkin' ||
                                text === 'chekin' ||
                                text === 'check in'
                            ) {

                                pill.classList.add(
                                    'checkin'
                                );

                            }

                        }
                    );

            }
        );

    </script>

</body>
</html>