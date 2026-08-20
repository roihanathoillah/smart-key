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
            padding: 24px;
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
            cursor: pointer;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }

        .service-option:hover {
            border-color: #2563eb;
            background: #f8fbff;
        }

        .service-option.active {
            border-color: #2563eb;
            background: #eff6ff;
            color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
        }

        .service-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
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
           SERVICE SELECTED INDICATOR
           ========================================================= */

        .service-selected-indicator {
            display: none;
            margin-left: auto;
            padding: 4px 9px;
            border-radius: 20px;
            background: #2563eb;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
        }

        .service-option.active .service-selected-indicator {
            display: inline-flex;
            align-items: center;
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


                <a href="{{ route('karyawan') }}"
                   class="{{ request()->routeIs('karyawan') ? 'active' : '' }}">

                    Daftar Karyawan

                </a>


                <a href="{{ route('history') }}"
                   class="{{ request()->routeIs('history') ? 'active' : '' }}">

                    History

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


                                <select
                                    id="box_id"
                                    name="box_id"
                                    form="smartbox-form"
                                    onchange="updateSmartBox(this)"
                                >

                                    <option value="">
                                        -- Pilih Smart Box --
                                    </option>


                                    @foreach($smartBoxes as $box)

                                        <option
                                            value="{{ $box->id }}"
                                            data-location="{{ $box->lokasi }}"
                                            {{ (string)$selectedBoxId === (string)$box->id ? 'selected' : '' }}
                                        >

                                            {{ $box->kode_box }}

                                            -
                                            
                                            {{ $box->lokasi }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>



                            <!-- =====================================
                                 DISTRICT
                                 ===================================== -->

                            <div class="smartbox-field">

                                <label for="district">
                                    District
                                </label>


                                <select
                                    id="district"
                                    name="district"
                                    form="smartbox-form"
                                >

                                    <option value="">
                                        -- Pilih District --
                                    </option>


                                    @foreach($districts as $district)

                                        <option
                                            value="{{ $district }}"
                                            {{ $selectedDistrict === $district ? 'selected' : '' }}
                                        >

                                            {{ $district }}

                                        </option>

                                    @endforeach

                                </select>

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

                <div class="service-grid">


                    <!-- =================================================
                         SURVEY
                         ================================================= -->

                    <div class="service-card">

                        <h4>
                            Form Layanan / Pekerjaan
                        </h4>


                        <label
                            class="service-option {{ old('jenis_layanan') === 'Survey' ? 'active' : '' }}"
                            data-service-label="Survey"
                        >

                            <input
                                type="radio"
                                name="service_choice"
                                value="Survey"
                                data-service="Survey"
                                {{ old('jenis_layanan') === 'Survey' ? 'checked' : '' }}
                            >


                            <span>
                                Survey
                            </span>


                            <span class="service-selected-indicator">
                                ✓ Dipilih
                            </span>

                        </label>


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


                        <label
                            class="service-option {{ old('jenis_layanan') === 'Deployment' ? 'active' : '' }}"
                            data-service-label="Deployment"
                        >

                            <input
                                type="radio"
                                name="service_choice"
                                value="Deployment"
                                data-service="Deployment"
                                {{ old('jenis_layanan') === 'Deployment' ? 'checked' : '' }}
                            >


                            <span>
                                Deployment
                            </span>


                            <span class="service-selected-indicator">
                                ✓ Dipilih
                            </span>

                        </label>


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


                        <label
                            class="service-option {{ old('jenis_layanan') === 'Assurance' ? 'active' : '' }}"
                            data-service-label="Assurance"
                        >

                            <input
                                type="radio"
                                name="service_choice"
                                value="Assurance"
                                data-service="Assurance"
                                {{ old('jenis_layanan') === 'Assurance' ? 'checked' : '' }}
                            >


                            <span>
                                Assurance
                            </span>


                            <span class="service-selected-indicator">
                                ✓ Dipilih
                            </span>

                        </label>


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


                        <label
                            class="service-option {{ old('jenis_layanan') === 'Maintenance' ? 'active' : '' }}"
                            data-service-label="Maintenance"
                        >

                            <input
                                type="radio"
                                name="service_choice"
                                value="Maintenance"
                                data-service="Maintenance"
                                {{ old('jenis_layanan') === 'Maintenance' ? 'checked' : '' }}
                            >


                            <span>
                                Maintenance
                            </span>


                            <span class="service-selected-indicator">
                                ✓ Dipilih
                            </span>

                        </label>


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


                        <!-- JENIS LAYANAN -->

                        <input
                            type="hidden"
                            id="submit_jenis_layanan"
                            name="jenis_layanan"
                            value="{{ old('jenis_layanan', '') }}"
                        >


                        <!-- DESKRIPSI PEKERJAAN -->

                        <input
                            type="hidden"
                            id="submit_deskripsi_pekerjaan"
                            name="deskripsi_pekerjaan"
                            value="{{ old('deskripsi_pekerjaan', '') }}"
                        >


                        <button
                            type="submit"
                            class="btn-red"
                            id="submit-checkin-button"

                            @if(!$employee['database_id'] || !$selectedBoxId || !$selectedDistrict)
                                disabled
                            @endif
                        >

                            SIMPAN

                        </button>

                    </form>



                    <!-- =================================================
                         FORM CHECKOUT
                         ================================================= -->

                    <form
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

                            CHEK OUT

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


/* =============================================================
   UPDATE SMART BOX
   ============================================================= */

function updateSmartBox(selectElement)
{

    const selectedOption =
        selectElement.options[
            selectElement.selectedIndex
        ];


    const location =
        selectedOption.getAttribute('data-location');


    const districtSelect =
        document.getElementById('district');


    /*
    |--------------------------------------------------------------------------
    | Jika Smart Box belum dipilih
    |--------------------------------------------------------------------------
    */

    if (!location) {

        districtSelect.value = '';

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Pilih District sesuai lokasi Smart Box
    |--------------------------------------------------------------------------
    */

    for (
        let i = 0;
        i < districtSelect.options.length;
        i++
    ) {

        if (
            districtSelect.options[i].value ===
            location
        ) {

            districtSelect.selectedIndex = i;

            break;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Ambil form Smart Box
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById('smartbox-form');


    /*
    |--------------------------------------------------------------------------
    | Cari input box_id
    |--------------------------------------------------------------------------
    */

    let boxInput =
        form.querySelector(
            'input[name="box_id"]'
        );


    /*
    |--------------------------------------------------------------------------
    | Kalau belum ada, buat input baru
    |--------------------------------------------------------------------------
    */

    if (!boxInput) {

        boxInput =
            document.createElement('input');

        boxInput.type = 'hidden';

        boxInput.name = 'box_id';

        form.appendChild(boxInput);

    }


    /*
    |--------------------------------------------------------------------------
    | Isi nilai Smart Box
    |--------------------------------------------------------------------------
    */

    boxInput.value =
        selectElement.value;


    /*
    |--------------------------------------------------------------------------
    | Submit otomatis
    |--------------------------------------------------------------------------
    */

    form.submit();

}



/* =============================================================
   SERVICE / LAYANAN
   ============================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function ()
    {

        /*
        |--------------------------------------------------------------------------
        | ELEMENT FORM
        |--------------------------------------------------------------------------
        */

        const checkinForm =
            document.getElementById(
                'checkin-form'
            );


        const submitJenisLayanan =
            document.getElementById(
                'submit_jenis_layanan'
            );


        const submitDeskripsiPekerjaan =
            document.getElementById(
                'submit_deskripsi_pekerjaan'
            );


        const submitButton =
            document.getElementById(
                'submit-checkin-button'
            );


        /*
        |--------------------------------------------------------------------------
        | SEMUA PILIHAN SERVICE
        |--------------------------------------------------------------------------
        */

        const serviceOptions =
            document.querySelectorAll(
                '.service-option'
            );


        /*
        |--------------------------------------------------------------------------
        | SEMUA TEXTAREA
        |--------------------------------------------------------------------------
        */

        const serviceDescriptions =
            document.querySelectorAll(
                '.service-description'
            );



        /* =========================================================
           FUNGSI MENGAMBIL SERVICE YANG DIPILIH
           ========================================================= */

        function getSelectedService()
        {

            return document.querySelector(
                'input[name="service_choice"]:checked'
            );

        }



        /* =========================================================
           FUNGSI MENGAMBIL TEXTAREA SERVICE
           ========================================================= */

        function getSelectedDescription(
            serviceName
        )
        {

            return document.querySelector(
                '.service-description[data-service="' +
                serviceName +
                '"]'
            );

        }



        /* =========================================================
           SINKRONISASI DATA KE FORM SIMPAN
           ========================================================= */

        function syncServiceData()
        {

            const selected =
                getSelectedService();


            /*
            |--------------------------------------------------------------------------
            | Kalau belum memilih layanan
            |--------------------------------------------------------------------------
            */

            if (!selected) {

                if (submitJenisLayanan) {

                    submitJenisLayanan.value =
                        '';

                }


                if (submitDeskripsiPekerjaan) {

                    submitDeskripsiPekerjaan.value =
                        '';

                }

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Ambil nama layanan
            |--------------------------------------------------------------------------
            */

            const selectedService =
                selected.getAttribute(
                    'data-service'
                );


            /*
            |--------------------------------------------------------------------------
            | Ambil textarea layanan tersebut
            |--------------------------------------------------------------------------
            */

            const selectedDescription =
                getSelectedDescription(
                    selectedService
                );


            /*
            |--------------------------------------------------------------------------
            | Masukkan jenis layanan ke hidden input
            |--------------------------------------------------------------------------
            */

            if (submitJenisLayanan) {

                submitJenisLayanan.value =
                    selectedService;

            }


            /*
            |--------------------------------------------------------------------------
            | Masukkan deskripsi ke hidden input
            |--------------------------------------------------------------------------
            */

            if (submitDeskripsiPekerjaan) {

                submitDeskripsiPekerjaan.value =
                    selectedDescription
                        ? selectedDescription.value
                        : '';

            }

        }



        /* =========================================================
           UPDATE TAMPILAN CARD SERVICE
           ========================================================= */

        function updateServiceActiveState()
        {

            const selected =
                getSelectedService();


            /*
            |--------------------------------------------------------------------------
            | Hilangkan active dari semua card
            |--------------------------------------------------------------------------
            */

            serviceOptions.forEach(
                function (option)
                {

                    option.classList.remove(
                        'active'
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Kalau ada service yang dipilih,
            | tambahkan active
            |--------------------------------------------------------------------------
            */

            if (selected) {

                const selectedOption =
                    selected.closest(
                        '.service-option'
                    );


                if (selectedOption) {

                    selectedOption.classList.add(
                        'active'
                    );

                }

            }

        }



        /* =========================================================
           EVENT KLIK SERVICE
           ========================================================= */

        serviceOptions.forEach(
            function (option)
            {

                option.addEventListener(
                    'click',
                    function (event)
                    {

                        /*
                        |--------------------------------------------------------------------------
                        | Cari radio button
                        |--------------------------------------------------------------------------
                        */

                        const radio =
                            option.querySelector(
                                'input[type="radio"]'
                            );


                        if (!radio) {

                            return;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Pastikan radio terpilih
                        |--------------------------------------------------------------------------
                        */

                        radio.checked =
                            true;


                        /*
                        |--------------------------------------------------------------------------
                        | Update tampilan
                        |--------------------------------------------------------------------------
                        */

                        updateServiceActiveState();


                        /*
                        |--------------------------------------------------------------------------
                        | Sinkronisasi data
                        |--------------------------------------------------------------------------
                        */

                        syncServiceData();

                    }
                );



                /*
                |--------------------------------------------------------------------------
                | Event change radio
                |--------------------------------------------------------------------------
                */

                const radio =
                    option.querySelector(
                        'input[type="radio"]'
                    );


                if (radio) {

                    radio.addEventListener(
                        'change',
                        function ()
                        {

                            updateServiceActiveState();

                            syncServiceData();

                        }
                    );

                }

            }
        );



        /* =========================================================
           EVENT INPUT TEXTAREA
           ========================================================= */

        serviceDescriptions.forEach(
            function (textarea)
            {

                textarea.addEventListener(
                    'input',
                    function ()
                    {

                        const selected =
                            getSelectedService();


                        /*
                        |--------------------------------------------------------------------------
                        | Hanya sinkronkan textarea
                        | yang sedang dipilih
                        |--------------------------------------------------------------------------
                        */

                        if (
                            selected &&
                            selected.getAttribute(
                                'data-service'
                            ) ===
                            textarea.getAttribute(
                                'data-service'
                            )
                        ) {

                            syncServiceData();

                        }

                    }
                );

            }
        );



        /* =========================================================
           VALIDASI SAAT SIMPAN
           ========================================================= */

        if (checkinForm) {

            checkinForm.addEventListener(
                'submit',
                function (event)
                {

                    /*
                    |--------------------------------------------------------------------------
                    | Ambil layanan yang dipilih
                    |--------------------------------------------------------------------------
                    */

                    const selected =
                        getSelectedService();


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI LAYANAN
                    |--------------------------------------------------------------------------
                    */

                    if (!selected) {

                        event.preventDefault();

                        alert(
                            'Silakan pilih jenis layanan terlebih dahulu.'
                        );

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Sinkronisasi sebelum validasi
                    |--------------------------------------------------------------------------
                    */

                    syncServiceData();


                    /*
                    |--------------------------------------------------------------------------
                    | Ambil jenis layanan
                    |--------------------------------------------------------------------------
                    */

                    const selectedService =
                        selected.getAttribute(
                            'data-service'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Ambil textarea sesuai service
                    |--------------------------------------------------------------------------
                    */

                    const selectedDescription =
                        getSelectedDescription(
                            selectedService
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Ambil isi deskripsi
                    |--------------------------------------------------------------------------
                    */

                    const descriptionValue =
                        selectedDescription
                            ? selectedDescription.value.trim()
                            : '';


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI DESKRIPSI
                    |--------------------------------------------------------------------------
                    */

                    if (!descriptionValue) {

                        event.preventDefault();

                        alert(
                            'Silakan isi deskripsi pekerjaan terlebih dahulu.'
                        );


                        /*
                        | Fokus ke textarea
                        */

                        if (selectedDescription) {

                            selectedDescription.focus();

                        }

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Pastikan hidden input benar
                    |--------------------------------------------------------------------------
                    */

                    submitJenisLayanan.value =
                        selectedService;


                    submitDeskripsiPekerjaan.value =
                        descriptionValue;


                    /*
                    |--------------------------------------------------------------------------
                    | Submit dilanjutkan
                    |--------------------------------------------------------------------------
                    */

                }
            );

        }



        /* =========================================================
           EDIT BUTTON
           ========================================================= */

        const editButton =
            document.getElementById(
                'edit-service-button'
            );


        if (editButton) {

            editButton.addEventListener(
                'click',
                function ()
                {

                    /*
                    |--------------------------------------------------------------------------
                    | Ambil layanan yang sedang dipilih
                    |--------------------------------------------------------------------------
                    */

                    const selected =
                        getSelectedService();


                    /*
                    |--------------------------------------------------------------------------
                    | Kalau belum ada layanan
                    |--------------------------------------------------------------------------
                    */

                    if (!selected) {

                        alert(
                            'Silakan pilih jenis layanan terlebih dahulu.'
                        );

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Fokus ke deskripsi layanan
                    |--------------------------------------------------------------------------
                    */

                    const selectedService =
                        selected.getAttribute(
                            'data-service'
                        );


                    const selectedDescription =
                        getSelectedDescription(
                            selectedService
                        );


                    if (selectedDescription) {

                        selectedDescription.focus();

                    }

                }
            );

        }



        /* =========================================================
           INITIAL STATE
           ========================================================= */

        updateServiceActiveState();

        syncServiceData();

    }
);

</script>


</body>

</html>