<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkin/Checkout</title>

    <link rel="stylesheet" href="/css/dashboard.css">

    <style>
        /* =========================================================
           SMART BOX & DISTRICT
           ========================================================= */

        .smartbox-panel {
            margin-top: 20px;
            padding: 18px 20px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
        }

        .smartbox-panel-title {
            margin: 0 0 18px 0;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .smartbox-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .smartbox-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .smartbox-field label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .smartbox-field select {
            width: 100%;
            min-height: 48px;
            padding: 0 14px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 15px;
            outline: none;
            cursor: pointer;
        }

        .smartbox-field input {
            width: 100%;
            min-height: 48px;
            padding: 0 14px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 15px;
            outline: none;
        }

        .smartbox-field select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .smartbox-info {
            margin-top: 14px;
            padding: 12px 14px;
            background: #f8fafc;
            border-radius: 10px;
            color: #64748b;
            font-size: 13px;
        }

        .smartbox-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-left: 5px;
            padding: 4px 9px;
            border-radius: 20px;
            background: #dcfce7;
            color: #15803d;
            font-size: 12px;
            font-weight: 700;
        }

        .smartbox-empty {
            padding: 14px;
            border-radius: 10px;
            background: #fef2f2;
            color: #b91c1c;
            font-size: 14px;
        }


        /* =========================================================
           PROFIL KARYAWAN
           ========================================================= */

        .employee-profile-list {
            display: grid;
            grid-template-columns: 150px 14px minmax(0, 1fr);
            row-gap: 8px;
            align-items: start;
            font-size: 14px;
            color: #1f2937;
        }

        .employee-profile-label {
            font-weight: 700;
        }

        .employee-profile-separator {
            font-weight: 700;
        }

        .employee-profile-value {
            min-width: 0;
            word-break: break-word;
        }

        .employee-profile-content {
            display: grid;
            grid-template-columns: 170px minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .employee-photo-box {
            width: 170px;
            height: 190px;
            border-radius: 8px;
            overflow: hidden;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 5px rgba(15, 23, 42, 0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
        }

        .employee-photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .employee-photo-placeholder {
            padding: 12px;
            text-align: center;
            line-height: 1.5;
        }

        @media (max-width: 600px) {
            .employee-profile-list {
                grid-template-columns: 120px 14px minmax(0, 1fr);
            }

            .employee-profile-content {
                grid-template-columns: 1fr;
            }

            .employee-photo-box {
                width: 100%;
                max-width: 170px;
                height: 190px;
            }
        }


        /* =========================================================
           LAYANAN / PEKERJAAN
           ========================================================= */

        .service-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .service-card {
            padding: 20px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-sizing: border-box;
        }

        .service-card h4 {
            margin: 0 0 16px 0;
            font-size: 17px;
            font-weight: 700;
            color: #1f2937;
        }

        .service-option {
            width: 100%;
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            margin-bottom: 14px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
            font-weight: 700;
            cursor: default;
            box-sizing: border-box;
        }

        .service-option:hover {
            border-color: #d9dee7;
            background: #ffffff;
        }

        .service-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }

        .service-field:last-child {
            margin-bottom: 0;
        }

        .service-field label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .service-field textarea {
            width: 100%;
            box-sizing: border-box;
            min-height: 110px;
            padding: 12px;
            border: 1px solid #d9dee7;
            border-radius: 10px;
            background: #ffffff;
            color: #1f2937;
            font-size: 14px;
            outline: none;
            resize: vertical;
            font-family: inherit;
        }

        .service-field textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .service-help {
            margin-top: 6px;
            font-size: 12px;
            color: #64748b;
        }

        .service-required {
            color: #dc2626;
        }

        .service-error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 12px;
        }



        /* =========================================================
           PENYESUAIAN CHECKIN/CHECKOUT SESUAI FLOWCHART
           ========================================================= */

        .checkin-card {
            background: transparent;
            box-shadow: none;
            border: 0;
            padding: 0;
        }

        .checkin-top {
            background: #ffffff;
            border: 1px solid #d9dee7;
            border-radius: 16px;
            padding: 22px;
            box-sizing: border-box;
        }

        .checkin-info h3 {
            margin: 0 0 18px 0;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .service-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            padding: 20px;
            background: #ffffff;
            border: 1px solid #d9dee7;
            border-radius: 16px;
        }

        .service-card {
            border-radius: 12px;
            box-shadow: none;
        }

        .service-card h4 {
            display: none;
        }

        .service-option {
            margin-bottom: 10px;
            background: #f8fafc;
            cursor: default;
        }

        .service-field textarea {
            min-height: 90px;
        }

        .checkin-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        #edit-service-button {
            display: none;
        }

        #submit-checkin-button,
        #checkout-form button[type="submit"] {
            min-width: 210px;
            min-height: 48px;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: none;
        }

        #submit-checkin-button {
            background: #2563eb;
        }

        #submit-checkin-button:hover:not(:disabled) {
            background: #1d4ed8;
        }

        #checkout-form button[type="submit"] {
            background: #16a34a;
        }

        #checkout-form button[type="submit"]:hover:not(:disabled) {
            background: #15803d;
        }

        #submit-checkin-button:disabled,
        #checkout-form button[type="submit"]:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .service-grid {
                grid-template-columns: 1fr;
            }

            #submit-checkin-button,
            #checkout-form button[type="submit"] {
                width: 100%;
                min-width: 0;
            }
        }


        /* =========================================================
           BUTTON DISABLED
           ========================================================= */

        .btn-red:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }


        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 768px) {

            .smartbox-grid,
            .service-grid {
                grid-template-columns: 1fr;
            }

        }
    </style>
</head>


<body>

<div class="dashboard-page">


    <!-- =========================================================
         SIDEBAR
         ========================================================= -->

    <aside class="dashboard-sidebar">

        <div class="brand">

            <span class="brand-logo">
                SK
            </span>

            <div>

                <h1>
                    Smart Key
                </h1>

                <p>
                    Admin Dashboard
                </p>

            </div>

        </div>


        <div class="sidebar-section">

            <h2>
                Menu
            </h2>

            <nav class="dashboard-nav">

                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    Dashboard

                </a>


                <a href="{{ route('checkin') }}"
                   class="{{ request()->routeIs('checkin') ? 'active' : '' }}">

                    Chekin/Chekout

                </a>

            </nav>

        </div>


        <div class="sidebar-section">

            <h2>
                Main Menu
            </h2>

            <nav class="dashboard-nav">

                <details class="sidebar-dropdown">

                    <summary>
                        Setting
                    </summary>

                    <div class="sidebar-dropdown-menu">

                        <a href="{{ route('profile') }}"
                           class="{{ request()->routeIs('profile') ? 'active' : '' }}">

                            Profile

                        </a>

                    </div>

                </details>

            </nav>

        </div>

    </aside>



    <!-- =========================================================
         MAIN CONTENT
         ========================================================= -->

    <main class="dashboard-content">


        <!-- =========================================================
             HEADER
             ========================================================= -->

        <header class="dashboard-header page-header">

            <div>

                <h1>
                    Checkin/Checkout
                </h1>

            </div>


            <div class="header-actions">

                <div class="notification-button-wrapper">

                    <button
                        type="button"
                        class="notification-button"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >

                        <span class="bell-icon">
                            🔔
                        </span>

                        <span class="notification-dot">
                            4
                        </span>

                    </button>

                </div>


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
                 SEARCH KARYAWAN
                 ===================================================== -->

            <div class="history-search-panel checkin-search-panel">

                <form
                    method="get"
                    action="{{ route('checkin') }}"
                    class="history-search-form checkin-search-form"
                >

                    <div class="search-input-wrapper">

                        <input
                            type="text"
                            name="q"
                            placeholder="Search by employee name / RFID"
                            value="{{ request('q') }}"
                        >


                        @if(request('box_id'))

                            <input
                                type="hidden"
                                name="box_id"
                                value="{{ request('box_id') }}"
                            >

                        @endif


                        <button
                            type="submit"
                            class="search-button"
                        >
                            🔍
                        </button>

                    </div>

                </form>

            </div>



            <!-- =====================================================
                 CARD CHECKIN
                 ===================================================== -->

            <div class="activity-card checkin-card">


                <!-- =================================================
                     DATA KARYAWAN
                     ================================================= -->

                <div class="checkin-top">

                    <div class="checkin-info">

                        <h3>
                            Profil Karyawan
                        </h3>

                        <p style="margin:-10px 0 16px 0; color:#64748b; font-size:12px;">
                            Data karyawan setelah ID Card terbaca
                        </p>


                        <div class="checkin-row">

                            <div class="employee-profile-content">

                                <div class="employee-photo-box">

                                    @if(!empty($employee['photo']))

                                        <img
                                            src="{{ asset($employee['photo']) }}"
                                            alt="Foto {{ $employee['name'] ?? 'Karyawan' }}"
                                        >

                                    @else

                                        <div class="employee-photo-placeholder">
                                            Foto Karyawan
                                        </div>

                                    @endif

                                </div>


                                <div class="employee-profile-list">

                                    <div class="employee-profile-label">
                                        Nama Lengkap
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['name'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Tanggal Lahir
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['birth_date'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Jenis Kelamin
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['gender'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        NIK
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['nik'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Email
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['email'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Jabatan
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['position'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Alamat
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['address'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        ODS
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">
                                        {{ $employee['ods'] ?? '-' }}
                                    </div>


                                    <div class="employee-profile-label">
                                        Status
                                    </div>
                                    <div class="employee-profile-separator">:</div>
                                    <div class="employee-profile-value">

                                        <span class="employee-status berhasil">
                                            {{ $employee['status'] ?? '-' }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        </div>

                    </div>



                    <!-- =================================================
                         ID CARD BADGE
                         ================================================= -->

                    <div class="checkin-badge">

                        <div class="badge">

                            ID Card Terbaca

                            <br>

                            <small>
                                Top ID Card Berhasil
                            </small>

                        </div>


                        <div class="badge-meta">

                            Waktu Scan

                            <br>

                            <small>
                                {{ now()->format('d/m/Y H:i') }}
                            </small>

                        </div>

                    </div>

                </div>



                <!-- =================================================
                     SMART BOX + DISTRICT
                     ================================================= -->

                <div class="smartbox-panel">

                    <h3 class="smartbox-panel-title">
                        Pilih Smart Box
                    </h3>


                    @if($smartBoxes->count() > 0)

                        <div class="smartbox-grid">


                            <!-- =====================================
                                 SMART BOX
                                 ===================================== -->

                            <div class="smartbox-field">

                                <label for="box_id">
                                    Smart Box
                                </label>


                                <input
                                    id="box_id"
                                    name="box_id"
                                    form="smartbox-form"
                                    type="number"
                                    placeholder="-- Isi Smart Box --"
                                    value="{{ $selectedBoxId ?? '' }}"
                                />

                            </div>



                            <!-- =====================================
                                 DISTRICT
                                 ===================================== -->

                            <div class="smartbox-field">

                                <label for="district">
                                    District
                                </label>


                                <input
                                    id="district"
                                    name="district"
                                    form="smartbox-form"
                                    type="text"
                                    placeholder="-- Isi District --"
                                    value="{{ $selectedDistrict ?? '' }}"
                                />

                            </div>

                        </div>



                        <!-- =========================================
                             INFO SMART BOX
                             ========================================= -->

                        <div class="smartbox-info">

                            @if($selectedBox)

                                Smart Box yang dipilih:

                                <strong>
                                    {{ $selectedBox->kode_box }}
                                </strong>

                                |

                                District:

                                <strong id="selected-location">
                                    {{ $selectedBox->lokasi }}
                                </strong>


                                <span class="smartbox-status">
                                    ● Aktif
                                </span>

                            @else

                                Silakan pilih Smart Box yang akan digunakan
                                untuk proses Checkin/Checkout.

                            @endif

                        </div>

                    @else

                        <div class="smartbox-empty">

                            Tidak ada Smart Box yang aktif.

                            Silakan tambahkan atau aktifkan Smart Box
                            terlebih dahulu.

                        </div>

                    @endif

                </div>



                <!-- =================================================
                     FORM SMART BOX
                     ================================================= -->

                <form
                    id="smartbox-form"
                    method="get"
                    action="{{ route('checkin') }}"
                    style="display:none;"
                >

                    <input
                        type="hidden"
                        name="q"
                        value="{{ request('q') }}"
                    >


                    @if(request('box_id'))

                        <input
                            type="hidden"
                            name="box_id"
                            value="{{ request('box_id') }}"
                        >

                    @endif

                </form>



                <!-- =================================================
                     LAYANAN / PEKERJAAN
                     ================================================= -->

                <div style="margin-top: 22px;">
                    <h3 style="margin:0 0 10px 0; font-size:18px; font-weight:700; color:#1f2937;">
                        Form Layanan / Pekerjaan
                    </h3>
                </div>

                <div class="service-grid">


                    <!-- =================================================
                         SURVEY
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <div
                            class="service-option"
                            data-service-label="Survey"
                        >

                            <span>
                                Survey
                            </span>

                        </div>


                        <div class="service-field">

                            <label for="deskripsi_survey">
                                Deskripsi Pekerjaan
                            </label>


                            <textarea
                                id="deskripsi_survey"
                                class="service-description"
                                data-service="Survey"
                                placeholder="Masukkan deskripsi pekerjaan..."
                            >{{ old('jenis_layanan') === 'Survey' ? old('deskripsi_pekerjaan') : '' }}</textarea>

                        </div>

                    </div>



                    <!-- =================================================
                         DEPLOYMENT
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <div
                            class="service-option"
                            data-service-label="Deployment"
                        >

                            <span>
                                Deployment
                            </span>

                        </div>


                        <div class="service-field">

                            <label for="deskripsi_deployment">
                                Deskripsi Pekerjaan
                            </label>


                            <textarea
                                id="deskripsi_deployment"
                                class="service-description"
                                data-service="Deployment"
                                placeholder="Masukkan deskripsi pekerjaan..."
                            >{{ old('jenis_layanan') === 'Deployment' ? old('deskripsi_pekerjaan') : '' }}</textarea>

                        </div>

                    </div>



                    <!-- =================================================
                         ASSURANCE
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <div
                            class="service-option"
                            data-service-label="Assurance"
                        >

                            <span>
                                Assurance
                            </span>

                        </div>


                        <div class="service-field">

                            <label for="deskripsi_assurance">
                                Deskripsi Pekerjaan
                            </label>


                            <textarea
                                id="deskripsi_assurance"
                                class="service-description"
                                data-service="Assurance"
                                placeholder="Masukkan deskripsi pekerjaan..."
                            >{{ old('jenis_layanan') === 'Assurance' ? old('deskripsi_pekerjaan') : '' }}</textarea>

                        </div>

                    </div>



                    <!-- =================================================
                         MAINTENANCE
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <div
                            class="service-option"
                            data-service-label="Maintenance"
                        >

                            <span>
                                Maintenance
                            </span>

                        </div>


                        <div class="service-field">

                            <label for="deskripsi_maintenance">
                                Deskripsi Pekerjaan
                            </label>


                            <textarea
                                id="deskripsi_maintenance"
                                class="service-description"
                                data-service="Maintenance"
                                placeholder="Masukkan deskripsi pekerjaan..."
                            >{{ old('jenis_layanan') === 'Maintenance' ? old('deskripsi_pekerjaan') : '' }}</textarea>

                        </div>

                    </div>

                </div>



                <!-- =================================================
                     ACTION BUTTON
                     ================================================= -->

                <div class="checkin-actions">


                    <!-- =================================================
                         EDIT
                         ================================================= -->

                    <button
                        type="button"
                        class="btn-red"
                        id="edit-service-button"
                    >
                        EDIT
                    </button>



                    <!-- =================================================
                         FORM SIMPAN CHECKIN
                         ================================================= -->

                    <form
                        id="checkin-form"
                        method="POST"
                        action="{{ route('checkin.store') }}"
                        style="display: inline;"
                    >

                        @csrf


                        <!-- ID KARYAWAN -->

                        <input
                            type="hidden"
                            name="karyawan_id"
                            value="{{ $employee['database_id'] }}"
                        >


                        <!-- ID SMART BOX -->

                        <input
                            type="hidden"
                            name="box_id"
                            value="{{ $selectedBoxId }}"
                        >


                        <!-- DISTRICT -->

                        <input
                            type="hidden"
                            name="district"
                            value="{{ $selectedDistrict }}"
                        >


                        <!-- CONTAINER FOR DYNAMIC SERVICE HIDDEN INPUTS -->
                        <div id="dynamic-service-inputs"></div>


                        <button
                            type="submit"
                            class="btn-red"
                            id="submit-checkin-button"

                            @if(!$employee['database_id'] || !$selectedBoxId || !$selectedDistrict)
                                disabled
                            @endif
                        >

                            SIMPAN (CHEKIN)

                        </button>

                    </form>



                    <!-- =================================================
                         FORM CHECKOUT
                         ================================================= -->

                    <form
                        id="checkout-form"
                        method="POST"
                        action="{{ route('checkin.checkout') }}"
                        style="display: inline;"
                    >

                        @csrf


                        <!-- ID KARYAWAN -->

                        <input
                            type="hidden"
                            name="karyawan_id"
                            value="{{ $employee['database_id'] }}"
                        >


                        <!-- ID SMART BOX -->

                        <input
                            type="hidden"
                            name="box_id"
                            value="{{ $selectedBoxId }}"
                        >


                        <!-- DISTRICT -->

                        <input
                            type="hidden"
                            name="district"
                            value="{{ $selectedDistrict }}"
                        >


                        <button
                            type="submit"
                            class="btn-red"

                            @if(!$employee['database_id'] || !$selectedBoxId || !$selectedDistrict)
                                disabled
                            @endif
                        >

                            CHECKOUT

                        </button>

                    </form>


                </div>

            </div>

        </section>

    </main>

</div>



<!-- =============================================================
     JAVASCRIPT
     ============================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const visibleBoxInput =
        document.getElementById('box_id');

    const visibleDistrictInput =
        document.getElementById('district');

    const checkinForm =
        document.getElementById('checkin-form');

    const checkoutForm =
        document.getElementById('checkout-form');

    const submitCheckinButton =
        document.getElementById('submit-checkin-button');

    const serviceDescriptions =
        document.querySelectorAll('.service-description');

    const dynamicServiceInputs =
        document.getElementById('dynamic-service-inputs');


    /*
    |--------------------------------------------------------------------------
    | HELPER UPDATE HIDDEN INPUT
    |--------------------------------------------------------------------------
    */

    function setHiddenValue(form, name, value)
    {
        if (!form) {
            return;
        }

        const input =
            form.querySelector(
                'input[name="' + name + '"]'
            );

        if (input) {
            input.value = value;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SMART BOX + DISTRICT MANUAL
    |--------------------------------------------------------------------------
    */

    function syncManualLocation()
    {
        const boxValue =
            visibleBoxInput
                ? visibleBoxInput.value.trim()
                : '';

        const districtValue =
            visibleDistrictInput
                ? visibleDistrictInput.value.trim()
                : '';

        setHiddenValue(
            checkinForm,
            'box_id',
            boxValue
        );

        setHiddenValue(
            checkinForm,
            'district',
            districtValue
        );

        setHiddenValue(
            checkoutForm,
            'box_id',
            boxValue
        );

        setHiddenValue(
            checkoutForm,
            'district',
            districtValue
        );

        const employeeIdInput =
            checkinForm
                ? checkinForm.querySelector(
                    'input[name="karyawan_id"]'
                )
                : null;

        const employeeId =
            employeeIdInput
                ? employeeIdInput.value.trim()
                : '';

        const canSubmit =
            employeeId !== '' &&
            boxValue !== '' &&
            districtValue !== '';

        if (submitCheckinButton) {
            submitCheckinButton.disabled =
                !canSubmit;
        }

        if (checkoutForm) {

            const checkoutButton =
                checkoutForm.querySelector(
                    'button[type="submit"]'
                );

            if (checkoutButton) {
                checkoutButton.disabled =
                    !canSubmit;
            }
        }
    }


    if (visibleBoxInput) {

        visibleBoxInput.addEventListener(
            'input',
            syncManualLocation
        );

        visibleBoxInput.addEventListener(
            'change',
            syncManualLocation
        );
    }


    if (visibleDistrictInput) {

        visibleDistrictInput.addEventListener(
            'input',
            syncManualLocation
        );

        visibleDistrictInput.addEventListener(
            'change',
            syncManualLocation
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SEMUA LAYANAN BERDASARKAN TEXTAREA YANG DIISI
    |--------------------------------------------------------------------------
    |
    | Tidak ada lagi pilihan satu layanan.
    | Admin boleh mengisi 1, 2, 3, atau semua layanan.
    |--------------------------------------------------------------------------
    */

    function buildServiceInputs()
    {
        if (!dynamicServiceInputs) {
            return false;
        }

        while (dynamicServiceInputs.firstChild) {
            dynamicServiceInputs.removeChild(
                dynamicServiceInputs.firstChild
            );
        }

        let anyFilled = false;

        serviceDescriptions.forEach(
            function (textarea)
            {
                const value =
                    textarea.value.trim();

                const serviceName =
                    textarea.getAttribute(
                        'data-service'
                    );

                if (
                    value === '' ||
                    !serviceName
                ) {
                    return;
                }

                anyFilled = true;

                const serviceInput =
                    document.createElement(
                        'input'
                    );

                serviceInput.type =
                    'hidden';

                serviceInput.name =
                    'jenis_layanan[]';

                serviceInput.value =
                    serviceName;

                dynamicServiceInputs.appendChild(
                    serviceInput
                );


                const descriptionInput =
                    document.createElement(
                        'input'
                    );

                descriptionInput.type =
                    'hidden';

                descriptionInput.name =
                    'deskripsi_pekerjaan[]';

                descriptionInput.value =
                    value;

                dynamicServiceInputs.appendChild(
                    descriptionInput
                );
            }
        );

        return anyFilled;
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN CHECKIN
    |--------------------------------------------------------------------------
    */

    if (checkinForm) {

        checkinForm.addEventListener(
            'submit',
            function (event)
            {
                syncManualLocation();

                const hasService =
                    buildServiceInputs();

                if (!hasService) {

                    event.preventDefault();

                    alert(
                        'Silakan isi minimal satu deskripsi pekerjaan.'
                    );

                    return;
                }
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    if (checkoutForm) {

        checkoutForm.addEventListener(
            'submit',
            function ()
            {
                syncManualLocation();
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT BUTTON
    |--------------------------------------------------------------------------
    */

    const editButton =
        document.getElementById(
            'edit-service-button'
        );

    if (editButton) {

        editButton.addEventListener(
            'click',
            function ()
            {
                let target = null;

                serviceDescriptions.forEach(
                    function (textarea)
                    {
                        if (
                            !target &&
                            textarea.value.trim() !== ''
                        ) {
                            target = textarea;
                        }
                    }
                );

                if (
                    !target &&
                    serviceDescriptions.length > 0
                ) {
                    target =
                        serviceDescriptions[0];
                }

                if (target) {
                    target.focus();
                }
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL STATE
    |--------------------------------------------------------------------------
    */

    syncManualLocation();

});

</script>


</body>

</html>