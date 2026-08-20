<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan</title>
    <link rel="stylesheet" href="/css/dashboard.css">

    <style>
        .employee-data-row {
            cursor: pointer;
            transition: background-color 0.2s ease, box-shadow 0.2s ease;
        }

        .employee-data-row:hover {
            background-color: #f8fafc;
        }

        .employee-data-row.selected {
            background-color: #eff6ff !important;
            box-shadow: inset 3px 0 0 #2563eb;
        }

        .edit-info {
            display: none;
            margin-top: 8px;
            color: #2563eb;
            font-size: 13px;
        }

        .edit-info.show {
            display: block;
        }

        .table-actions {
            display: flex;
            gap: 18px;
            align-items: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }

        .table-actions .action-button {
            border: none;
            border-radius: 30px;
            min-width: 155px;
            padding: 12px 28px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.18);
        }

        .table-actions .action-button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.22);
        }

        .table-actions .action-button:active:not(:disabled) {
            transform: translateY(0);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.18);
        }

        .table-actions .secondary,
        .table-actions .primary,
        .table-actions .danger,
        .table-actions .delete-button {
            background: #ff0000;
            color: #ffffff;
        }

        .table-actions .action-button:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .employee-add-row.editing {
            border: 1px solid #93c5fd;
        }

        .form-success {
            margin: 15px 0;
            padding: 12px 16px;
            border-radius: 10px;
            background: #dcfce7;
            color: #166534;
        }

        .form-error {
            margin: 15px 0;
            padding: 12px 16px;
            border-radius: 10px;
            background: #fee2e2;
            color: #991b1b;
        }

        /* =========================================================
           POPUP HAPUS KARYAWAN
           ========================================================= */

        .delete-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .delete-modal.show {
            display: flex;
        }

        .delete-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.58);
            backdrop-filter: blur(5px);
        }

        .delete-modal-card {
            position: relative;
            z-index: 2;
            width: min(520px, 100%);
            max-height: 85vh;
            overflow: hidden;
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
            animation: deleteModalShow 0.2s ease-out;
        }

        @keyframes deleteModalShow {
            from {
                opacity: 0;
                transform: translateY(15px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .delete-modal-header {
            padding: 25px 28px 18px;
            border-bottom: 1px solid #eef0f4;
            text-align: center;
        }

        .delete-modal-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fee2e2;
            font-size: 28px;
        }

        .delete-modal-header h3 {
            margin: 0;
            color: #1f2937;
            font-size: 22px;
            font-weight: 700;
        }

        .delete-modal-header p {
            margin: 8px 0 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }

        .delete-employee-list {
            max-height: 330px;
            overflow-y: auto;
            padding: 18px 24px;
        }

        .delete-employee-option {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 13px 15px;
            margin-bottom: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.18s ease;
            box-sizing: border-box;
        }

        .delete-employee-option:last-child {
            margin-bottom: 0;
        }

        .delete-employee-option:hover {
            border-color: #fca5a5;
            background: #fff7f7;
        }

        .delete-employee-option.selected {
            border-color: #ef4444;
            background: #fff1f2;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.08);
        }

        .delete-employee-radio {
            width: 18px;
            height: 18px;
            flex: 0 0 auto;
            accent-color: #ef4444;
            cursor: pointer;
        }

        .delete-employee-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
            min-width: 0;
        }

        .delete-employee-name {
            color: #1f2937;
            font-weight: 700;
            font-size: 15px;
        }

        .delete-employee-id {
            color: #6b7280;
            font-size: 13px;
        }

        .delete-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 18px 24px 24px;
            border-top: 1px solid #eef0f4;
        }

        .delete-modal-button {
            min-width: 115px;
            border: none;
            border-radius: 10px;
            padding: 11px 18px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .delete-modal-button.cancel {
            background: #f1f5f9;
            color: #475569;
        }

        .delete-modal-button.cancel:hover {
            background: #e2e8f0;
        }

        .delete-modal-button.confirm {
            background: #ef0000;
            color: #ffffff;
        }

        .delete-modal-button.confirm:hover:not(:disabled) {
            background: #d90000;
            transform: translateY(-1px);
        }

        .delete-modal-button.confirm:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .delete-empty {
            padding: 25px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        body.delete-modal-open {
            overflow: hidden;
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

                        <summary>Setting</summary>

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


        <main class="dashboard-content karyawan-page">

            <header class="dashboard-header page-header">

                <div>
                    <h1>Daftar Karyawan</h1>
                </div>

                <div class="header-actions">

                    <div class="notification-button-wrapper">

                        <button
                            type="button"
                            class="notification-button"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <span class="bell-icon">🔔</span>
                            <span class="notification-dot">4</span>
                        </button>

                        <div class="notification-menu" role="menu">

                            <div class="notification-menu-header">
                                Notifications
                            </div>

                            <a href="#" class="notification-item">
                                <span class="notification-item-title">
                                    New login from Malang
                                </span>

                                <span class="notification-item-time">
                                    2 min ago
                                </span>
                            </a>

                            <a href="#" class="notification-item">
                                <span class="notification-item-title">
                                    Order #6548 updated
                                </span>

                                <span class="notification-item-time">
                                    1 hour ago
                                </span>
                            </a>

                            <a href="#" class="notification-item">
                                <span class="notification-item-title">
                                    System maintenance
                                </span>

                                <span class="notification-item-time">
                                    Yesterday
                                </span>
                            </a>

                        </div>

                    </div>

                    <div class="profile-card">
                        <div class="profile-avatar">A</div>
                    </div>

                </div>

            </header>


            <section class="dashboard-grid">

                <div class="activity-card table-card">

                    <div class="employee-filter">

                        <form
                            method="get"
                            action="{{ route('karyawan') }}"
                            class="search-form"
                        >

                            <div class="search-input-wrapper">

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

                        </form>

                    </div>


                    @if (session('success'))

                        <div class="form-success">
                            {{ session('success') }}
                        </div>

                    @endif


                    @if ($errors->any())

                        <div class="form-error">
                            {{ $errors->first() }}
                        </div>

                    @endif


                    {{-- ========================================= --}}
                    {{-- FORM TAMBAH / EDIT KARYAWAN --}}
                    {{-- ========================================= --}}

                    <form
                        method="POST"
                        action="{{ route('karyawan.store') }}"
                        id="employeeForm"
                    >

                        @csrf

                        <div
                            class="employee-add-row"
                            id="employeeAddRow"
                        >

                            <div
                                class="employee-add-label"
                                id="employeeFormTitle"
                            >
                                Tambah Karyawan
                            </div>


                            <div class="employee-add-grid">

                                <div class="add-field">

                                    <div class="field-label">
                                        DATA ID
                                    </div>

                                    <input
                                        type="text"
                                        name="id_card"
                                        id="id_card"
                                        placeholder="ID Card / RFID"
                                        value="{{ old('id_card') }}"
                                        maxlength="50"
                                        required
                                    >

                                </div>


                                <div class="add-field">

                                    <div class="field-label">
                                        USER
                                    </div>

                                    <input
                                        type="text"
                                        name="nama_lengkap"
                                        id="nama_lengkap"
                                        placeholder="Nama karyawan"
                                        value="{{ old('nama_lengkap') }}"
                                        maxlength="150"
                                        required
                                    >

                                </div>

                            </div>


                            <div
                                class="edit-info"
                                id="editInfo"
                            >
                                Mode Edit aktif. Pilih data karyawan yang ingin diubah, lalu klik Simpan.
                            </div>

                        </div>

                    </form>


                    {{-- ========================================= --}}
                    {{-- TABEL DATA KARYAWAN --}}
                    {{-- ========================================= --}}

                    <div class="activity-table-wrapper">

                        <table class="activity-table">

                            <thead>

                                <tr>
                                    <th>Data ID</th>
                                    <th>User</th>
                                    <th>Status</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($employees as $employee)

                                    <tr
                                        class="employee-data-row"
                                        data-database-id="{{ $employee['database_id'] ?? '' }}"
                                        data-id-card="{{ $employee['id'] }}"
                                        data-name="{{ $employee['name'] }}"
                                    >

                                        <td>
                                            {{ $employee['id'] }}
                                        </td>

                                        <td>
                                            {{ $employee['name'] }}
                                        </td>

                                        <td>

                                            <span
                                                class="employee-status {{ strtolower($employee['status']) }}"
                                            >
                                                {{ $employee['status'] }}
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="3"
                                            style="
                                                text-align:center;
                                                padding:20px;
                                                color:#6b7280;
                                            "
                                        >
                                            Tidak ada karyawan ditemukan.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- ========================================= --}}
                    {{-- PAGINATION --}}
                    {{-- ========================================= --}}

                    <div class="activity-pagination">

                        <div class="pagination-summary">

                            Showing
                            {{ $employees->firstItem() ?: 0 }}
                            -
                            {{ $employees->lastItem() ?: 0 }}
                            of
                            {{ $employees->total() }}

                        </div>


                        <div class="pagination-links">

                            @if ($employees->onFirstPage())

                                <span class="page disabled">
                                    Previous
                                </span>

                            @else

                                <a
                                    class="page"
                                    href="{{ $employees->previousPageUrl() }}"
                                >
                                    Previous
                                </a>

                            @endif


                            @php

                                $totalPages = $employees->lastPage();
                                $currentPage = $employees->currentPage();

                                $startPage = max(
                                    1,
                                    min(
                                        $currentPage - 1,
                                        $totalPages - 3
                                    )
                                );

                                $endPage = min(
                                    $totalPages,
                                    $startPage + 3
                                );

                            @endphp


                            @foreach (
                                range($startPage, $endPage)
                                as $page
                            )

                                @if ($page == $employees->currentPage())

                                    <span class="page active">
                                        {{ $page }}
                                    </span>

                                @else

                                    <a
                                        class="page"
                                        href="{{ $employees->url($page) }}"
                                    >
                                        {{ $page }}
                                    </a>

                                @endif

                            @endforeach


                            @if ($employees->hasMorePages())

                                <a
                                    class="page"
                                    href="{{ $employees->nextPageUrl() }}"
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


                    {{-- ========================================= --}}
                    {{-- TOMBOL AKSI --}}
                    {{-- ========================================= --}}

                    <div class="table-actions">

                        <button
                            type="button"
                            class="action-button secondary"
                            id="editButton"
                        >
                            ✏️ EDIT
                        </button>


                        <button
                            type="submit"
                            class="action-button primary"
                            id="saveButton"
                            form="employeeForm"
                        >
                            💾 SIMPAN
                        </button>


                        <button
                            type="button"
                            class="action-button danger"
                            id="cancelButton"
                        >
                            ✕ BATAL
                        </button>


                        <button
                            type="button"
                            class="action-button delete-button"
                            id="deleteButton"
                        >
                            🗑️ HAPUS
                        </button>

                    </div>

                </div>

            </section>

        </main>

    </div>


    {{-- =========================================================
         POPUP HAPUS KARYAWAN
         ========================================================= --}}

    <div
        class="delete-modal"
        id="deleteModal"
        aria-hidden="true"
    >

        <div
            class="delete-modal-overlay"
            id="deleteModalOverlay"
        ></div>


        <div
            class="delete-modal-card"
            role="dialog"
            aria-modal="true"
            aria-labelledby="deleteModalTitle"
        >

            <div class="delete-modal-header">

                <div class="delete-modal-icon">
                    🗑️
                </div>

                <h3 id="deleteModalTitle">
                    Hapus Karyawan
                </h3>

                <p>
                    Pilih karyawan yang ingin dihapus.
                </p>

            </div>


            <div
                class="delete-employee-list"
                id="deleteEmployeeList"
            >
                {{-- Daftar karyawan dibuat otomatis oleh JavaScript --}}
            </div>


            <div class="delete-modal-footer">

                <button
                    type="button"
                    class="delete-modal-button cancel"
                    id="deleteModalCancel"
                >
                    Batal
                </button>

                <button
                    type="button"
                    class="delete-modal-button confirm"
                    id="deleteModalConfirm"
                    disabled
                >
                    🗑️ Hapus
                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
         FORM DELETE TERPISAH
         Tidak mengganggu form Tambah/Edit
         ========================================================= --}}

    <form
        method="POST"
        id="deleteEmployeeForm"
        style="display:none;"
    >
        @csrf
        @method('DELETE')
    </form>


    <script>

        /* =====================================================
           ELEMENT FORM TAMBAH / EDIT
           ===================================================== */

        const employeeForm =
            document.getElementById('employeeForm');

        const employeeAddRow =
            document.getElementById('employeeAddRow');

        const employeeFormTitle =
            document.getElementById('employeeFormTitle');

        const editInfo =
            document.getElementById('editInfo');

        const idCardInput =
            document.getElementById('id_card');

        const namaInput =
            document.getElementById('nama_lengkap');

        const editButton =
            document.getElementById('editButton');

        const saveButton =
            document.getElementById('saveButton');

        const cancelButton =
            document.getElementById('cancelButton');

        const employeeRows =
            document.querySelectorAll('.employee-data-row');


        let editMode = false;
        let selectedRow = null;
        let originalIdCard = '';
        let originalName = '';


        /* =====================================================
           MODE TAMBAH
           ===================================================== */

        function setAddMode() {

            editMode = false;

            selectedRow = null;

            originalIdCard = '';

            originalName = '';


            employeeRows.forEach(function (row) {

                row.classList.remove('selected');

                row.style.cursor = '';

            });


            employeeForm.action =
                "{{ route('karyawan.store') }}";


            const methodInput =
                employeeForm.querySelector(
                    'input[name="_method"]'
                );


            if (methodInput) {
                methodInput.remove();
            }


            employeeFormTitle.textContent =
                'Tambah Karyawan';


            editInfo.classList.remove('show');


            employeeAddRow.classList.remove('editing');


            editButton.disabled = false;


            idCardInput.disabled = false;

            namaInput.disabled = false;


            idCardInput.value = '';

            namaInput.value = '';


            saveButton.disabled = false;


            idCardInput.focus();

        }


        /* =====================================================
           MODE EDIT
           ===================================================== */

        editButton.addEventListener(
            'click',
            function () {

                if (editMode) {
                    return;
                }


                editMode = true;


                employeeFormTitle.textContent =
                    'Edit Karyawan';


                editInfo.textContent =
                    'Mode Edit aktif. Sekarang klik baris karyawan yang ingin diubah.';


                editInfo.classList.add('show');


                employeeAddRow.classList.add('editing');


                editButton.disabled = true;


                idCardInput.value = '';

                namaInput.value = '';


                idCardInput.disabled = true;

                namaInput.disabled = true;


                saveButton.disabled = true;


                employeeRows.forEach(function (row) {

                    row.style.cursor = 'pointer';

                });

            }
        );


        /* =====================================================
           PILIH DATA KARYAWAN UNTUK EDIT
           ===================================================== */

        employeeRows.forEach(function (row) {

            row.addEventListener(
                'click',
                function () {

                    if (!editMode) {
                        return;
                    }


                    employeeRows.forEach(
                        function (item) {

                            item.classList.remove(
                                'selected'
                            );

                        }
                    );


                    selectedRow = row;


                    row.classList.add('selected');


                    idCardInput.value =
                        row.dataset.idCard || '';


                    namaInput.value =
                        row.dataset.name || '';


                    originalIdCard =
                        idCardInput.value;


                    originalName =
                        namaInput.value;


                    idCardInput.disabled = false;

                    namaInput.disabled = false;


                    saveButton.disabled = false;


                    editInfo.textContent =
                        'Data "' +
                        originalName +
                        '" sedang diedit. Ubah data lalu klik Simpan.';


                    idCardInput.focus();

                }
            );

        });


        /* =====================================================
           SIMPAN
           ===================================================== */

        employeeForm.addEventListener(
            'submit',
            function (event) {

                /*
                 * Jika bukan mode edit,
                 * form berjalan normal menuju storeEmployee()
                 */

                if (!editMode) {
                    return;
                }


                event.preventDefault();


                if (!selectedRow) {

                    alert(
                        'Silakan pilih data karyawan yang ingin diedit terlebih dahulu.'
                    );

                    return;

                }


                const databaseId =
                    selectedRow.dataset.databaseId;


                if (!databaseId) {

                    alert(
                        'ID database karyawan tidak ditemukan.'
                    );

                    return;

                }


                if (
                    !idCardInput.value.trim() ||
                    !namaInput.value.trim()
                ) {

                    alert(
                        'ID Card/RFID dan nama karyawan wajib diisi.'
                    );

                    return;

                }


                employeeForm.action =
                    "{{ url('/karyawan') }}/" +
                    databaseId;


                let methodInput =
                    employeeForm.querySelector(
                        'input[name="_method"]'
                    );


                if (!methodInput) {

                    methodInput =
                        document.createElement('input');

                    methodInput.type = 'hidden';

                    methodInput.name = '_method';

                    employeeForm.appendChild(
                        methodInput
                    );

                }


                methodInput.value = 'PUT';


                idCardInput.disabled = false;

                namaInput.disabled = false;


                employeeForm.submit();

            }
        );


        /* =====================================================
           BATAL
           ===================================================== */

        cancelButton.addEventListener(
            'click',
            function () {

                if (editMode) {

                    setAddMode();

                    return;

                }


                idCardInput.value = '';

                namaInput.value = '';


                idCardInput.focus();

            }
        );


        /* =====================================================
           POPUP HAPUS
           ===================================================== */

        const deleteButton =
            document.getElementById('deleteButton');

        const deleteModal =
            document.getElementById('deleteModal');

        const deleteModalOverlay =
            document.getElementById('deleteModalOverlay');

        const deleteModalCancel =
            document.getElementById('deleteModalCancel');

        const deleteModalConfirm =
            document.getElementById('deleteModalConfirm');

        const deleteEmployeeList =
            document.getElementById('deleteEmployeeList');

        const deleteEmployeeForm =
            document.getElementById('deleteEmployeeForm');


        let selectedDeleteId = null;


        /* =====================================================
           BUKA POPUP HAPUS
           ===================================================== */

        deleteButton.addEventListener(
            'click',
            function () {

                selectedDeleteId = null;

                deleteModalConfirm.disabled = true;

                deleteEmployeeList.innerHTML = '';


                /*
                 * Ambil semua karyawan yang tampil
                 * pada halaman saat ini.
                 */

                const rows =
                    Array.from(employeeRows);


                if (rows.length === 0) {

                    deleteEmployeeList.innerHTML = `
                        <div class="delete-empty">
                            Tidak ada data karyawan yang dapat dihapus.
                        </div>
                    `;

                } else {

                    rows.forEach(
                        function (row, index) {

                            const databaseId =
                                row.dataset.databaseId || '';

                            const idCard =
                                row.dataset.idCard || '-';

                            const name =
                                row.dataset.name || '-';


                            if (!databaseId) {
                                return;
                            }


                            const option =
                                document.createElement('label');

                            option.className =
                                'delete-employee-option';


                            option.innerHTML = `
                                <input
                                    type="radio"
                                    name="delete_employee"
                                    value="${databaseId}"
                                    class="delete-employee-radio"
                                >

                                <span class="delete-employee-info">

                                    <span class="delete-employee-name">
                                        ${escapeHtml(name)}
                                    </span>

                                    <span class="delete-employee-id">
                                        ${escapeHtml(idCard)}
                                    </span>

                                </span>
                            `;


                            const radio =
                                option.querySelector(
                                    'input[type="radio"]'
                                );


                            radio.addEventListener(
                                'change',
                                function () {

                                    document
                                        .querySelectorAll(
                                            '.delete-employee-option'
                                        )
                                        .forEach(
                                            function (item) {
                                                item.classList.remove(
                                                    'selected'
                                                );
                                            }
                                        );


                                    option.classList.add(
                                        'selected'
                                    );


                                    selectedDeleteId =
                                        this.value;


                                    deleteModalConfirm.disabled =
                                        false;

                                }
                            );


                            deleteEmployeeList.appendChild(
                                option
                            );

                        }
                    );

                }


                deleteModal.classList.add('show');

                deleteModal.setAttribute(
                    'aria-hidden',
                    'false'
                );


                document.body.classList.add(
                    'delete-modal-open'
                );

            }
        );


        /* =====================================================
           TUTUP POPUP
           ===================================================== */

        function closeDeleteModal() {

            deleteModal.classList.remove('show');

            deleteModal.setAttribute(
                'aria-hidden',
                'true'
            );


            document.body.classList.remove(
                'delete-modal-open'
            );


            selectedDeleteId = null;

            deleteModalConfirm.disabled = true;

        }


        deleteModalCancel.addEventListener(
            'click',
            function () {

                closeDeleteModal();

            }
        );


        deleteModalOverlay.addEventListener(
            'click',
            function () {

                closeDeleteModal();

            }
        );


        /* =====================================================
           KONFIRMASI HAPUS
           ===================================================== */

        deleteModalConfirm.addEventListener(
    'click',
    function () {

        if (!selectedDeleteId) {
            return;
        }

        deleteEmployeeForm.action =
            "{{ route('karyawan.delete', ':id') }}"
                .replace(':id', selectedDeleteId);

        deleteEmployeeForm.submit();
    }
);


        /* =====================================================
           ESC UNTUK MENUTUP POPUP
           ===================================================== */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape' &&
                    deleteModal.classList.contains('show')
                ) {

                    closeDeleteModal();

                }

            }
        );


        /* =====================================================
           AMANKAN TEKS DARI DATABASE
           ===================================================== */

        function escapeHtml(value) {

            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

        }


        /* =====================================================
           KONDISI AWAL HALAMAN
           ===================================================== */

        editMode = false;

        editButton.disabled = false;

        saveButton.disabled = false;

        idCardInput.disabled = false;

        namaInput.disabled = false;

    </script>

</body>
</html>