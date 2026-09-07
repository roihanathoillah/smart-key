<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\CheckinCheckout;
use App\Models\LayananPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK DASHBOARD ADMIN
        |--------------------------------------------------------------------------
        */

        $today = now()->format('Y-m-d');

        $aksesHariIni = DB::table('checkin_checkouts')
            ->whereDate('tanggal', $today)
            ->count();

        $aksesBerhasil = DB::table('checkin_checkouts')
            ->whereDate('tanggal', $today)
            ->where('akses_hasil', 'berhasil')
            ->count();

        $aksesDitolak = DB::table('checkin_checkouts')
            ->whereDate('tanggal', $today)
            ->where('akses_hasil', 'ditolak')
            ->count();

        $stats = [
            [
                'label' => 'Akses Hari ini',
                'value' => (string) $aksesHariIni,
                'meta' => 'Aktivitas hari ini',
                'icon' => '⚡',
                'accent' => '#f59e0b'
            ],
            [
                'label' => 'Akses Berhasil',
                'value' => (string) $aksesBerhasil,
                'meta' => 'Total akses berhasil',
                'icon' => '✅',
                'accent' => '#10b981'
            ],
            [
                'label' => 'Akses Ditolak',
                'value' => (string) $aksesDitolak,
                'meta' => 'Total akses ditolak',
                'icon' => '❌',
                'accent' => '#ef4444'
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | TABEL AKTIVITAS
        |--------------------------------------------------------------------------
        */

        $rawActivities = DB::table('checkin_checkouts')
            ->leftJoin(
                'karyawans',
                'checkin_checkouts.karyawan_id',
                '=',
                'karyawans.id'
            )
            ->leftJoin(
                'smart_boxes',
                'checkin_checkouts.smart_box_id',
                '=',
                'smart_boxes.id'
            )
            ->leftJoin(
                'districts',
                'checkin_checkouts.district_id',
                '=',
                'districts.id'
            )
            ->leftJoin(
                'ods',
                'checkin_checkouts.ods_id',
                '=',
                'ods.id'
            )
            ->select(
                'checkin_checkouts.id',
                'checkin_checkouts.kode_data',
                'checkin_checkouts.tanggal',
                'checkin_checkouts.jam_checkin',
                'checkin_checkouts.jam_checkout',
                'checkin_checkouts.lokasi',
                'checkin_checkouts.status',
                'karyawans.nama_lengkap',
                'smart_boxes.kode_box',
                'districts.nama_district',
                'ods.kode_ods',
                'ods.nama_ods'
            )
            ->orderByDesc('checkin_checkouts.id')
            ->limit(50)
            ->get()
            ->map(function ($item) {

                $tanggal = '-';

                if (!empty($item->tanggal)) {

                    $timestamp = strtotime($item->tanggal);

                    if ($timestamp !== false) {
                        $tanggal = date('d/m/Y', $timestamp);
                    }
                }

                $status = strtolower((string) ($item->status ?? ''));

                if ($status === 'chekin' || $status === 'checkin') {

                    $statusLabel = 'Chekin';

                } elseif ($status === 'checkout') {

                    $statusLabel = 'Checkout';

                } else {

                    $statusLabel = $item->status
                        ? ucfirst($item->status)
                        : '-';
                }

                $odsLabel = '-';

                if (!empty($item->kode_ods) && !empty($item->nama_ods)) {

                    $odsLabel =
                        $item->kode_ods . ' - ' . $item->nama_ods;

                } elseif (!empty($item->kode_ods)) {

                    $odsLabel = $item->kode_ods;

                } elseif (!empty($item->nama_ods)) {

                    $odsLabel = $item->nama_ods;
                }

                return [
                    'id' => $item->kode_data ?? ('#' . $item->id),
                    'name' => $item->nama_lengkap ?? '-',
                    'date' => $tanggal,
                    'box' => $item->kode_box ?? '-',
                    'checkin' => $item->jam_checkin ?? '-',
                    'checkout' => $item->jam_checkout ?? '-',
                    'location' => $item->lokasi ?? '-',
                    'district' => $item->nama_district ?? ($item->lokasi ?? '-'),
                    'ods' => $odsLabel,
                    'status' => $statusLabel,
                ];
            });

        $perPage = 4;

        $page = (int) $request->query('page', 1);

        if ($page < 1) {
            $page = 1;
        }

        $currentItems = $rawActivities
            ->slice(
                ($page - 1) * $perPage,
                $perPage
            )
            ->values();

        $activities = new LengthAwarePaginator(
            $currentItems,
            $rawActivities->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | GRAFIK AKTIVITAS PER JAM
        |--------------------------------------------------------------------------
        |
        | Sesuai flowchart:
        | 00:00 | 04:00 | 08:00 | 12:00 | 16:00 | 20:00 | 24:00
        |
        | Grafik menggunakan aktivitas pada tanggal terakhir yang tersedia
        | di database agar tetap tampil meskipun hari ini belum ada transaksi.
        |
        */

        // Gunakan tanggal hari ini agar grafik sinkron dengan statistik
        // dan aktivitas Checkin/Checkout yang baru dilakukan.
        $chartDate = $today;

        $activityChartLabels = [
            '00:00',
            '04:00',
            '08:00',
            '12:00',
            '16:00',
            '20:00',
            '24:00',
        ];

        $activityCheckinData = array_fill(0, 7, 0);
        $activityCheckoutData = array_fill(0, 7, 0);

        if ($chartDate) {

            $chartActivities = DB::table('checkin_checkouts')
                ->whereDate('tanggal', $chartDate)
                ->select(
                    'jam_checkin',
                    'jam_checkout'
                )
                ->get();

            foreach ($chartActivities as $activity) {

                if (!empty($activity->jam_checkin)) {

                    $hour = (int) date(
                        'H',
                        strtotime($activity->jam_checkin)
                    );

                    $index = min(
                        6,
                        (int) floor($hour / 4)
                    );

                    $activityCheckinData[$index]++;
                }

                if (!empty($activity->jam_checkout)) {

                    $hour = (int) date(
                        'H',
                        strtotime($activity->jam_checkout)
                    );

                    $index = min(
                        6,
                        (int) floor($hour / 4)
                    );

                    $activityCheckoutData[$index]++;
                }
            }
        }

        return view(
            'dashboard',
            compact(
                'stats',
                'activities',
                'aksesHariIni',
                'aksesBerhasil',
                'aksesDitolak',
                'activityChartLabels',
                'activityCheckinData',
                'activityCheckoutData'
            )
        );
    }


    public function superAdmin(Request $request)
    {
        $today = now()->toDateString();
        $hasCheckinTable = Schema::hasTable('checkin_checkouts');
        $hasEmployeeTable = Schema::hasTable('karyawans');

        $totalToday = 0;
        $successfulToday = 0;
        $rejectedToday = 0;
        $chart = collect(['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'])->map(function ($label) {
            return [
                'label' => $label,
                'checkin' => 0,
                'checkout' => 0,
            ];
        })->values();

        if ($hasCheckinTable) {
            $historyColumns = ['jam_checkin', 'jam_checkout', 'status'];
            if (Schema::hasColumn('checkin_checkouts', 'akses_hasil')) {
                $historyColumns[] = 'akses_hasil';
            }

            $todayActivities = DB::table('checkin_checkouts')
                ->whereDate('tanggal', $today)
                ->get($historyColumns);

            $totalToday = $todayActivities->count();
            $successfulToday = $todayActivities->filter(function ($activity) {
                $result = strtolower((string) ($activity->akses_hasil ?? $activity->status ?? ''));

                return in_array($result, ['berhasil', 'success', 'checkin', 'chekin', 'checkout'], true);
            })->count();
            $rejectedToday = $todayActivities->filter(function ($activity) {
                return in_array(strtolower((string) ($activity->akses_hasil ?? $activity->status ?? '')), ['ditolak', 'rejected', 'gagal', 'failed'], true);
            })->count();

            $chart = $chart->map(function ($item, $index) use ($todayActivities) {
                $startHour = $index * 4;
                $endHour = $startHour + 4;
                $inRange = function ($time) use ($startHour, $endHour) {
                    if (! $time || $startHour >= 24) {
                        return false;
                    }

                    $hour = (int) date('G', strtotime((string) $time));

                    return $hour >= $startHour && $hour < min(24, $endHour);
                };

                return [
                    'label' => $item['label'],
                    'checkin' => $todayActivities->filter(fn ($activity) => $inRange($activity->jam_checkin))->count(),
                    'checkout' => $todayActivities->filter(fn ($activity) => $inRange($activity->jam_checkout))->count(),
                ];
            });
        }

        $stats = [
            ['label' => 'Akses Hari Ini (Total)', 'value' => $totalToday, 'meta' => 'Total akses hari ini', 'icon' => '⚡', 'accent' => '#f59e0b'],
            ['label' => 'Akses Berhasil', 'value' => $successfulToday, 'meta' => 'Akses yang berhasil', 'icon' => '✅', 'accent' => '#10b981'],
            ['label' => 'Akses Ditolak', 'value' => $rejectedToday, 'meta' => 'Akses yang ditolak', 'icon' => '❌', 'accent' => '#ef4444'],
        ];

        $activities = collect();

        if ($hasCheckinTable) {
            $activityQuery = DB::table('checkin_checkouts')
                ->select(
                    'checkin_checkouts.id',
                    'checkin_checkouts.kode_data',
                    'checkin_checkouts.tanggal',
                    'checkin_checkouts.smart_box_id',
                    'checkin_checkouts.jam_checkin',
                    'checkin_checkouts.jam_checkout',
                    'checkin_checkouts.lokasi',
                    'checkin_checkouts.status'
                )
                ->orderByDesc('checkin_checkouts.id');

            if ($hasEmployeeTable) {
                $activityQuery->leftJoin('karyawans', 'checkin_checkouts.karyawan_id', '=', 'karyawans.id')
                    ->addSelect('karyawans.nama_lengkap');
            }

            $activities = $activityQuery->limit(20)->get()->map(function ($item) {
                $status = strtolower((string) ($item->status ?? ''));

                return [
                    'id' => $item->kode_data ?? ('#' . $item->id),
                    'name' => $item->nama_lengkap ?? '-',
                    'date' => $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : '-',
                    'box' => $item->smart_box_id ? '#' . $item->smart_box_id : '-',
                    'checkin' => $item->jam_checkin ?? '-',
                    'checkout' => $item->jam_checkout ?? '-',
                    'location' => $item->lokasi ?? '-',
                    'status' => $status === 'checkout' ? 'Checkout' : ($status === 'checkin' || $status === 'chekin' ? 'Chekin' : ucfirst($status ?: '-')),
                ];
            });
        }

        return view('auth.dashboardspradmin', compact('stats', 'activities', 'chart'));
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR KARYAWAN ADMIN
    |--------------------------------------------------------------------------
    */

    public function employees(Request $request)
    {
        $search = $request->query('q');
        $perPage = 5;

        $query = Karyawan::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('id_card', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('devisi', 'like', "%{$search}%");
            });
        }

        $employees = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $employees->setCollection(
            $employees->getCollection()->map(function (Karyawan $karyawan) {

                $status = match ($karyawan->status) {
                    'aktif' => 'Aktif',
                    'nonaktif' => 'Nonaktif',
                    'pending' => 'Pending',
                    default => ucfirst($karyawan->status ?? 'Pending'),
                };

                return [
                    'id' => '#' . $karyawan->id_card,
                    'database_id' => $karyawan->id,
                    'name' => $karyawan->nama_lengkap,
                    'calendar' => $karyawan->created_at
                        ? $karyawan->created_at->format('d/m/Y')
                        : '-',
                    'status' => $status,
                ];
            })
        );

        return view(
            'auth.karyawan',
            compact('employees', 'search', 'perPage')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA KARYAWAN DARI ADMIN
    |--------------------------------------------------------------------------
    */

    public function storeEmployee(Request $request)
    {
        $validated = $request->validate([
            'id_card' => 'required|string|max:50|unique:karyawans,id_card',
            'nama_lengkap' => 'required|string|max:150',
            'nik' => 'nullable|string|max:16',
            'jabatan' => 'nullable|in:Teknisi B2C',
            'devisi' => 'nullable|string|max:100',
            'foto' => 'nullable|string|max:255',
        ]);

        $karyawan = new Karyawan();

        $karyawan->id_card = $validated['id_card'];
        $karyawan->nama_lengkap = $validated['nama_lengkap'];
        $karyawan->nik = $validated['nik'] ?? null;
        $karyawan->jabatan = $validated['jabatan'] ?? null;
        $karyawan->devisi = $validated['devisi'] ?? null;
        $karyawan->foto = $validated['foto'] ?? null;
        $karyawan->status = 'pending';

        $karyawan->save();

        return redirect()
            ->route('karyawan')
            ->with('success', 'Karyawan berhasil didaftarkan dan menunggu persetujuan Super Admin.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA KARYAWAN DARI ADMIN
    |--------------------------------------------------------------------------
    */

    public function updateEmployee(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validated = $request->validate([
            'id_card' => 'required|string|max:50|unique:karyawans,id_card,' . $karyawan->id,
            'nama_lengkap' => 'required|string|max:150',
        ]);

        $karyawan->id_card = $validated['id_card'];
        $karyawan->nama_lengkap = $validated['nama_lengkap'];

        $karyawan->save();

        return redirect()
            ->route('karyawan')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA KARYAWAN DARI ADMIN
    |--------------------------------------------------------------------------
    */

    public function deleteEmployee($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->delete();

        return redirect()
            ->route('karyawan')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | DAFTAR KARYAWAN SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    public function superAdminEmployees(Request $request)
    {
        $search = $request->query('q');
        $perPage = 8;

        $query = Karyawan::query();

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('id_card', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('devisi', 'like', "%{$search}%");
            });
        }

        $employees = $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        $employees->setCollection(
            $employees->getCollection()->map(function (Karyawan $karyawan) {

                $birthDate = '-';

                if (!empty($karyawan->tanggal_lahir)) {
                    $timestamp = strtotime($karyawan->tanggal_lahir);

                    if ($timestamp !== false) {
                        $birthDate = date('d/m/Y', $timestamp);
                    }
                }

                $odsLabel = '-';

                if (!empty($karyawan->ods_id) && Schema::hasTable('ods')) {
                    $ods = DB::table('ods')
                        ->where('id', $karyawan->ods_id)
                        ->first();

                    if ($ods) {
                        if (!empty($ods->kode_ods) && !empty($ods->nama_ods)) {
                            $odsLabel = $ods->kode_ods . ' - ' . $ods->nama_ods;
                        } elseif (!empty($ods->kode_ods)) {
                            $odsLabel = $ods->kode_ods;
                        } elseif (!empty($ods->nama_ods)) {
                            $odsLabel = $ods->nama_ods;
                        }
                    }
                }

                return [
                    'id' => '#' . $karyawan->id_card,
                    'database_id' => $karyawan->id,
                    'name' => $karyawan->nama_lengkap,
                    'calendar' => $karyawan->created_at
                        ? $karyawan->created_at->format('d/m/Y')
                        : '-',
                    'birth_date' => $birthDate,
                    'birth_date_raw' => !empty($karyawan->tanggal_lahir)
                        ? date('Y-m-d', strtotime($karyawan->tanggal_lahir))
                        : '',
                    'gender' => $karyawan->jenis_kelamin ?? '-',
                    'nik' => $karyawan->nik ?? '-',
                    'email' => $karyawan->email ?? '-',
                    'position' => $karyawan->jabatan ?? '-',
                    'address' => $karyawan->alamat ?? '-',
                    'ods' => $odsLabel,
                    'ods_id' => $karyawan->ods_id ?? null,
                    'status' => strtolower((string) ($karyawan->status ?? 'pending')),
                ];
            })
        );

        $odsOptions = Schema::hasTable('ods')
            ? DB::table('ods')
                ->orderBy('id')
                ->get(['id', 'kode_ods', 'nama_ods'])
            : collect();

        return view(
            'auth.karyawanspradmin',
            compact('employees', 'search', 'perPage', 'odsOptions')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function approveEmployee($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->status = 'aktif';
        $karyawan->save();

        return redirect()
            ->route('karyawan.super')
            ->with('success', 'Karyawan berhasil disetujui.');
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT KARYAWAN
    |--------------------------------------------------------------------------
    */

    public function rejectEmployee($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $karyawan->status = 'nonaktif';
        $karyawan->save();

        return redirect()
            ->route('karyawan.super')
            ->with('success', 'Karyawan berhasil ditolak.');
    }

    /*
    |--------------------------------------------------------------------------
    | UBAH STATUS KARYAWAN SUPER ADMIN
    |--------------------------------------------------------------------------
    |
    | Digunakan dari modal Detail Karyawan.
    | Data karyawan tidak dihapus. Hanya status aktif/nonaktif yang diubah
    | agar riwayat Checkin/Checkout tetap aman.
    |
    */

    public function updateSuperAdminEmployeeStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $karyawan = Karyawan::findOrFail($id);

        $oldStatus = strtolower((string) ($karyawan->status ?? ''));
        $newStatus = $validated['status'];

        if ($oldStatus === $newStatus) {
            return redirect()
                ->route('karyawan.super')
                ->with(
                    'success',
                    $newStatus === 'aktif'
                        ? 'Karyawan sudah dalam status aktif.'
                        : 'Karyawan sudah dalam status nonaktif.'
                );
        }

        $karyawan->status = $newStatus;
        $karyawan->save();

        return redirect()
            ->route('karyawan.super')
            ->with(
                'success',
                $newStatus === 'aktif'
                    ? 'Karyawan berhasil diaktifkan kembali.'
                    : 'Karyawan berhasil dinonaktifkan.'
            );
    }

    public function storeSuperAdminEmployee(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nik' => 'required|string|max:16|unique:karyawans,nik',
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('karyawans', 'email'),
                Rule::unique('users', 'email'),
            ],
            'jabatan' => 'required|in:Teknisi B2C',
            'alamat' => 'required|string|max:255',
            'ods_manual' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
            'password' => 'required|string|min:6',
        ]);

        DB::transaction(function () use ($data) {
            $karyawan = new Karyawan();

            $karyawan->id_card = 'EMP-' . $data['nik'];
            $karyawan->nama_lengkap = $data['name'];
            $karyawan->tanggal_lahir = $data['tanggal_lahir'];
            $karyawan->jenis_kelamin = $data['jenis_kelamin'];
            $karyawan->nik = $data['nik'];
            $karyawan->email = $data['email'];
            $karyawan->jabatan = $data['jabatan'];
            $karyawan->alamat = $data['alamat'];

            // Map manual ODS input to ods_id
            $odsInput = trim($data['ods_manual'] ?? '');
            $odsId = null;

            if ($odsInput !== '') {
                $existing = DB::table('ods')
                    ->where('kode_ods', $odsInput)
                    ->orWhere('nama_ods', $odsInput)
                    ->first();

                if ($existing) {
                    $odsId = $existing->id;
                } else {
                    $odsId = DB::table('ods')->insertGetId([
                        'kode_ods' => $odsInput,
                        'nama_ods' => '',
                    ]);
                }
            }

            $karyawan->ods_id = $odsId;
            $karyawan->status = strtolower($data['status']);
            $karyawan->save();

            /*
            |--------------------------------------------------------------------------
            | BUAT AKUN LOGIN ADMIN
            |--------------------------------------------------------------------------
            |
            | Data profil tetap disimpan di tabel karyawans.
            | Data autentikasi disimpan di tabel users agar Auth::attempt()
            | dapat digunakan seperti login yang sudah berjalan.
            |
            */
            User::create([
                'username' => $this->generateUniqueEmployeeUsername($data['name']),
                'nama_lengkap' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'admin',
            ]);
        });

        return redirect()
            ->route('karyawan.super')
            ->with(
                'success',
                strtolower($data['status']) === 'aktif'
                    ? 'Data karyawan berhasil ditambahkan dan akun login Admin sudah aktif.'
                    : 'Data karyawan berhasil ditambahkan. Akun login tersimpan, tetapi akses login menunggu status Aktif.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA KARYAWAN SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    public function updateSuperAdminEmployee(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        // Simpan email lama untuk menemukan pasangan akun users.
        $oldEmail = $karyawan->email;

        $linkedUser = !empty($oldEmail)
            ? User::where('email', $oldEmail)->first()
            : null;

        $data = $request->validate([
            'name' => 'required|string|max:150',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nik' => [
                'required',
                'string',
                'max:16',
                Rule::unique('karyawans', 'nik')->ignore($karyawan->id),
            ],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('karyawans', 'email')->ignore($karyawan->id),
                Rule::unique('users', 'email')->ignore($linkedUser?->id),
            ],
            'jabatan' => 'required|in:Teknisi B2C',
            'alamat' => 'required|string|max:255',
            'ods_manual' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($data, $karyawan, $linkedUser) {
            $karyawan->id_card = 'EMP-' . $data['nik'];
            $karyawan->nama_lengkap = $data['name'];
            $karyawan->tanggal_lahir = $data['tanggal_lahir'];
            $karyawan->jenis_kelamin = $data['jenis_kelamin'];
            $karyawan->nik = $data['nik'];
            $karyawan->email = $data['email'];
            $karyawan->jabatan = $data['jabatan'];
            $karyawan->alamat = $data['alamat'];

            // Map manual ODS input to ods_id
            $odsInput = trim($data['ods_manual'] ?? '');
            $odsId = null;

            if ($odsInput !== '') {
                $existing = DB::table('ods')
                    ->where('kode_ods', $odsInput)
                    ->orWhere('nama_ods', $odsInput)
                    ->first();

                if ($existing) {
                    $odsId = $existing->id;
                } else {
                    $odsId = DB::table('ods')->insertGetId([
                        'kode_ods' => $odsInput,
                        'nama_ods' => '',
                    ]);
                }
            }

            $karyawan->ods_id = $odsId;
            $karyawan->save();

            /*
            |--------------------------------------------------------------------------
            | SINKRONKAN AKUN LOGIN
            |--------------------------------------------------------------------------
            */
            if ($linkedUser) {
                $linkedUser->nama_lengkap = $data['name'];
                $linkedUser->email = $data['email'];
                $linkedUser->role = 'admin';

                if (!empty($data['password'])) {
                    $linkedUser->password = $data['password'];
                }

                $linkedUser->save();
            }
        });

        return redirect()
            ->route('karyawan.super')
            ->with('success', 'Data karyawan dan akun login berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA KARYAWAN SUPER ADMIN
    |--------------------------------------------------------------------------
    |
    | Penghapusan diblokir jika karyawan sudah mempunyai riwayat
    | Checkin/Checkout. Dalam kondisi tersebut gunakan Nonaktifkan Karyawan.
    |
    */

    public function deleteSuperAdminEmployee($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $hasHistory = Schema::hasTable('checkin_checkouts')
            && DB::table('checkin_checkouts')
                ->where('karyawan_id', $karyawan->id)
                ->exists();

        if ($hasHistory) {
            return redirect()
                ->route('karyawan.super')
                ->withErrors([
                    'delete' => 'Karyawan tidak dapat dihapus karena sudah memiliki riwayat Checkin/Checkout. Gunakan fitur Nonaktifkan Karyawan.',
                ]);
        }

        $name = $karyawan->nama_lengkap;
        $email = $karyawan->email;

        DB::transaction(function () use ($karyawan, $email) {
            if (!empty($email)) {
                User::where('email', $email)
                    ->where('role', 'admin')
                    ->delete();
            }

            $karyawan->delete();
        });

        return redirect()
            ->route('karyawan.super')
            ->with('success', 'Karyawan ' . $name . ' beserta akun loginnya berhasil dihapus.');
    }

    public function superAdminHistory(Request $request)
    {
        $search = $request->query('q');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $perPage = 4;

        $historyQuery = Schema::hasTable('checkin_checkouts')
            ? DB::table('checkin_checkouts')->select('checkin_checkouts.*')
            : null;

        if ($historyQuery) {
            if (Schema::hasTable('karyawans')) {
                $historyQuery->leftJoin('karyawans', 'checkin_checkouts.karyawan_id', '=', 'karyawans.id')
                    ->addSelect('karyawans.nama_lengkap');
            }
            if ($search) {
                $historyQuery->where(function ($builder) use ($search) {
                    $builder->where('checkin_checkouts.kode_data', 'like', "%{$search}%")
                        ->orWhere('checkin_checkouts.lokasi', 'like', "%{$search}%");
                });
            }
            if ($dateFrom) {
                $historyQuery->whereDate('checkin_checkouts.tanggal', '>=', $dateFrom);
            }
            if ($dateTo) {
                $historyQuery->whereDate('checkin_checkouts.tanggal', '<=', $dateTo);
            }

            $history = $historyQuery->orderByDesc('checkin_checkouts.id')->paginate($perPage)->withQueryString();
            $history->setCollection($history->getCollection()->map(fn ($item) => $this->mapCheckinActivity($item)));
        } else {
            $history = new LengthAwarePaginator([], 0, $perPage, 1, ['path' => $request->url(), 'query' => $request->query()]);
        }

        return view('auth.historyspradmin', compact('history', 'search', 'dateFrom', 'dateTo', 'perPage'));
    }

    private function mapCheckinActivity(object $item): array
    {
        $status = strtolower((string) ($item->status ?? ''));

        return [
            'id' => $item->kode_data ?? ('#' . $item->id),
            'name' => $item->nama_lengkap ?? '-',
            'date' => $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : '-',
            'box' => $item->smart_box_id ? '#' . $item->smart_box_id : '-',
            'checkin' => $item->jam_checkin ?? '-',
            'checkout' => $item->jam_checkout ?? '-',
            'location' => $item->lokasi ?? '-',
            'status' => $status === 'checkout' ? 'Checkout' : ($status === 'checkin' || $status === 'chekin' ? 'Chekin' : ucfirst($status ?: '-')),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | HISTORY ADMIN
    |--------------------------------------------------------------------------
    */

    public function history(Request $request)
    {
        $search = $request->query('q');
        $tanggalAwal = $request->query('tanggal_awal');
        $tanggalAkhir = $request->query('tanggal_akhir');
        $perPage = 4;

        /*
        |--------------------------------------------------------------------------
        | AMBIL HISTORY ASLI DARI DATABASE
        |--------------------------------------------------------------------------
        |
        | Data utama tetap berasal dari tabel checkin_checkouts.
        | Data karyawan, Smart Box, District, dan ODS hanya digabungkan
        | untuk kebutuhan tampilan History.
        |
        */

        $query = DB::table('checkin_checkouts')
            ->leftJoin(
                'karyawans',
                'checkin_checkouts.karyawan_id',
                '=',
                'karyawans.id'
            )
            ->leftJoin(
                'smart_boxes',
                'checkin_checkouts.smart_box_id',
                '=',
                'smart_boxes.id'
            )
            ->leftJoin(
                'districts',
                'checkin_checkouts.district_id',
                '=',
                'districts.id'
            )
            ->leftJoin(
                'ods',
                'checkin_checkouts.ods_id',
                '=',
                'ods.id'
            )
            ->select(
                'checkin_checkouts.id',
                'checkin_checkouts.kode_data',
                'checkin_checkouts.tanggal',
                'checkin_checkouts.jam_checkin',
                'checkin_checkouts.jam_checkout',
                'checkin_checkouts.lokasi',
                'checkin_checkouts.status',
                'checkin_checkouts.district_id',
                'checkin_checkouts.ods_id',
                'karyawans.nama_lengkap',
                'smart_boxes.kode_box',
                'districts.nama_district',
                'ods.kode_ods',
                'ods.nama_ods'
            );

        /*
        |--------------------------------------------------------------------------
        | SEARCH HISTORY
        |--------------------------------------------------------------------------
        |
        | Search tetap menggunakan parameter q seperti struktur sebelumnya.
        | Sekarang juga bisa mencari berdasarkan District dan ODS.
        |
        */

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'checkin_checkouts.kode_data',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'karyawans.nama_lengkap',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'smart_boxes.kode_box',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'checkin_checkouts.lokasi',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'checkin_checkouts.status',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'districts.nama_district',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'ods.kode_ods',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'ods.nama_ods',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        |
        | Filter menggunakan kolom tanggal pada tabel checkin_checkouts.
        | Bisa digunakan tanggal awal saja, tanggal akhir saja,
        | atau keduanya sekaligus.
        |
        */

        if ($tanggalAwal) {

            $query->whereDate(
                'checkin_checkouts.tanggal',
                '>=',
                $tanggalAwal
            );
        }

        if ($tanggalAkhir) {

            $query->whereDate(
                'checkin_checkouts.tanggal',
                '<=',
                $tanggalAkhir
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $history = $query
            ->orderByDesc('checkin_checkouts.id')
            ->paginate($perPage)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA UNTUK BLADE
        |--------------------------------------------------------------------------
        |
        | Key lama tetap dipertahankan supaya history.blade.php yang sekarang
        | tidak rusak. Ditambahkan key "district" dan "ods" untuk tahap berikutnya.
        |
        */

        $history->setCollection(
            $history->getCollection()->map(function ($item) {

                $tanggal = '-';

                if (!empty($item->tanggal)) {

                    $timestamp = strtotime($item->tanggal);

                    if ($timestamp !== false) {
                        $tanggal = date('d/m/Y', $timestamp);
                    }
                }

                $status = strtolower((string) ($item->status ?? ''));

                if ($status === 'chekin' || $status === 'checkin') {

                    $statusLabel = 'Chekin';

                } elseif ($status === 'checkout') {

                    $statusLabel = 'Checkout';

                } else {

                    $statusLabel = $item->status
                        ? ucfirst($item->status)
                        : '-';
                }

                /*
                |--------------------------------------------------------------------------
                | FORMAT ODS
                |--------------------------------------------------------------------------
                |
                | Jika kode dan nama ODS tersedia, tampilkan keduanya.
                | Jika belum ada relasi ODS, tampilkan "-".
                |
                */

                $odsLabel = '-';

                if (!empty($item->kode_ods) && !empty($item->nama_ods)) {

                    $odsLabel = $item->kode_ods . ' - ' . $item->nama_ods;

                } elseif (!empty($item->kode_ods)) {

                    $odsLabel = $item->kode_ods;

                } elseif (!empty($item->nama_ods)) {

                    $odsLabel = $item->nama_ods;
                }

                return [
                    'id' => $item->kode_data ?? ('#' . $item->id),
                    'name' => $item->nama_lengkap ?? '-',
                    'date' => $tanggal,
                    'box' => $item->kode_box ?? '-',
                    'checkin' => $item->jam_checkin ?? '-',
                    'checkout' => $item->jam_checkout ?? '-',

                    /*
                    |--------------------------------------------------------------------------
                    | Key lama tetap ada
                    |--------------------------------------------------------------------------
                    */

                    'location' => $item->lokasi ?? '-',

                    /*
                    |--------------------------------------------------------------------------
                    | Key baru untuk History sesuai kebutuhan klien
                    |--------------------------------------------------------------------------
                    */

                    'district' => $item->nama_district ?? '-',
                    'ods' => $odsLabel,

                    'status' => $statusLabel,
                ];
            })
        );

        return view(
            'auth.history',
            compact('history', 'search', 'perPage')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HISTORY EXPORT
    |--------------------------------------------------------------------------
    */

    public function historyExport(Request $request)
    {
        $search = $request->query('q');
        $tanggalAwal = $request->query('tanggal_awal');
        $tanggalAkhir = $request->query('tanggal_akhir');

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA HISTORY ASLI DARI DATABASE
        |--------------------------------------------------------------------------
        |
        | Export menggunakan sumber data yang sama dengan halaman History.
        | Data diambil dari checkin_checkouts lalu digabungkan dengan
        | karyawan, Smart Box, District, ODS, dan layanan pekerjaan.
        |
        */

        $query = DB::table('checkin_checkouts')
            ->leftJoin(
                'karyawans',
                'checkin_checkouts.karyawan_id',
                '=',
                'karyawans.id'
            )
            ->leftJoin(
                'smart_boxes',
                'checkin_checkouts.smart_box_id',
                '=',
                'smart_boxes.id'
            )
            ->leftJoin(
                'districts',
                'checkin_checkouts.district_id',
                '=',
                'districts.id'
            )
            ->leftJoin(
                'ods',
                'checkin_checkouts.ods_id',
                '=',
                'ods.id'
            )
            ->leftJoin(
                'layanan_pekerjaans',
                'checkin_checkouts.id',
                '=',
                'layanan_pekerjaans.checkin_checkout_id'
            )
            ->select(
                'checkin_checkouts.id',
                'checkin_checkouts.kode_data',
                'checkin_checkouts.tanggal',
                'checkin_checkouts.jam_checkin',
                'checkin_checkouts.jam_checkout',
                'checkin_checkouts.lokasi',
                'checkin_checkouts.status',
                'karyawans.nama_lengkap',
                'smart_boxes.kode_box',
                'districts.nama_district',
                'ods.kode_ods',
                'ods.nama_ods',
                // aggregate layanan rows into a single concatenated string
                DB::raw("GROUP_CONCAT(CONCAT_WS('::', layanan_pekerjaans.jenis_layanan, layanan_pekerjaans.deskripsi_pekerjaan) SEPARATOR '|||') as layanan_all")
            )
            ->groupBy(
                'checkin_checkouts.id',
                'checkin_checkouts.kode_data',
                'checkin_checkouts.tanggal',
                'checkin_checkouts.jam_checkin',
                'checkin_checkouts.jam_checkout',
                'checkin_checkouts.lokasi',
                'checkin_checkouts.status',
                'karyawans.nama_lengkap',
                'smart_boxes.kode_box',
                'districts.nama_district',
                'ods.kode_ods',
                'ods.nama_ods'
            );

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($search) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'checkin_checkouts.kode_data',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'karyawans.nama_lengkap',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'smart_boxes.kode_box',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'checkin_checkouts.lokasi',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'checkin_checkouts.status',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'districts.nama_district',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'ods.kode_ods',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'ods.nama_ods',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'layanan_pekerjaans.jenis_layanan',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'layanan_pekerjaans.deskripsi_pekerjaan',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($tanggalAwal) {

            $query->whereDate(
                'checkin_checkouts.tanggal',
                '>=',
                $tanggalAwal
            );
        }

        if ($tanggalAkhir) {

            $query->whereDate(
                'checkin_checkouts.tanggal',
                '<=',
                $tanggalAkhir
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA DATA SESUAI FILTER
        |--------------------------------------------------------------------------
        |
        | Export tidak menggunakan pagination agar seluruh data yang sesuai
        | filter dapat masuk ke file Excel.
        |
        */

        $rawHistory = $query
            ->orderByDesc('checkin_checkouts.id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA UNTUK EXCEL
        |--------------------------------------------------------------------------
        */

        $history = $rawHistory->map(function ($item) {

            $tanggal = '-';

            if (!empty($item->tanggal)) {

                $timestamp = strtotime($item->tanggal);

                if ($timestamp !== false) {
                    $tanggal = date('d/m/Y', $timestamp);
                }
            }

            $status = strtolower((string) ($item->status ?? ''));

            if ($status === 'chekin' || $status === 'checkin') {

                $statusLabel = 'Chekin';

            } elseif ($status === 'checkout') {

                $statusLabel = 'Checkout';

            } else {

                $statusLabel = $item->status
                    ? ucfirst($item->status)
                    : '-';
            }

            $odsLabel = '-';

            if (!empty($item->kode_ods) && !empty($item->nama_ods)) {

                $odsLabel = $item->kode_ods . ' - ' . $item->nama_ods;

            } elseif (!empty($item->kode_ods)) {

                $odsLabel = $item->kode_ods;

            } elseif (!empty($item->nama_ods)) {

                $odsLabel = $item->nama_ods;
            }

            return [
                'id' => $item->kode_data ?? ('#' . $item->id),
                'name' => $item->nama_lengkap ?? '-',
                'date' => $tanggal,
                'box' => $item->kode_box ?? '-',
                'checkin' => $item->jam_checkin ?? '-',
                'checkout' => $item->jam_checkout ?? '-',
                'district' => $item->nama_district ?? '-',
                'ods' => $odsLabel,
                'location' => $item->lokasi ?? '-',
                'status' => $statusLabel,

                /*
                |--------------------------------------------------------------------------
                | SEMUA LAYANAN UNTUK EXCEL
                |--------------------------------------------------------------------------
                |
                | Query menggunakan GROUP_CONCAT menjadi layanan_all.
                | Pecah kembali agar seluruh jenis layanan dan deskripsinya
                | tampil di satu baris Excel untuk satu data checkin.
                |
                */

                'service' => $this->formatAllServicesForExcel(
                    $item->layanan_all ?? null,
                    'service'
                ),

                'description' => $this->formatAllServicesForExcel(
                    $item->layanan_all ?? null,
                    'description'
                ),

                /*
                |--------------------------------------------------------------------------
                | DESKRIPSI PER JENIS LAYANAN
                |--------------------------------------------------------------------------
                |
                | Digunakan oleh Excel untuk membuat header:
                |
                | DESKRIPSI PEKERJAAN
                | Survey | Deployment | Assurance | Maintenance
                |
                */

                'survey_description' => $this->getServiceDescriptionForExcel(
                    $item->layanan_all ?? null,
                    'Survey'
                ),

                'deployment_description' => $this->getServiceDescriptionForExcel(
                    $item->layanan_all ?? null,
                    'Deployment'
                ),

                'assurance_description' => $this->getServiceDescriptionForExcel(
                    $item->layanan_all ?? null,
                    'Assurance'
                ),

                'maintenance_description' => $this->getServiceDescriptionForExcel(
                    $item->layanan_all ?? null,
                    'Maintenance'
                ),
            ];
        });

        $excel = $this->buildHistoryExcel($history);

        return response($excel, 200)
            ->header(
                'Content-Type',
                'application/vnd.ms-excel; charset=UTF-8'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename="history-report.xls"'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORMAT SEMUA LAYANAN UNTUK EXCEL
    |--------------------------------------------------------------------------
    */

    private function formatAllServicesForExcel($layananAll, $type)
    {
        if (empty($layananAll)) {
            return '-';
        }

        $items = explode('|||', $layananAll);

        $services = [];
        $descriptions = [];

        foreach ($items as $item) {

            $parts = explode('::', $item, 2);

            $service =
                trim((string) ($parts[0] ?? ''));

            $description =
                trim((string) ($parts[1] ?? ''));

            if ($service === '') {
                continue;
            }

            $services[] = $service;

            $descriptions[] =
                $service . ': ' .
                ($description !== '' ? $description : '-');
        }

        if ($type === 'service') {
            return !empty($services)
                ? implode(', ', $services)
                : '-';
        }

        return !empty($descriptions)
            ? implode("\n", $descriptions)
            : '-';
    }


    /*
    |--------------------------------------------------------------------------
    | AMBIL DESKRIPSI PER JENIS LAYANAN UNTUK EXCEL
    |--------------------------------------------------------------------------
    */

    private function getServiceDescriptionForExcel($layananAll, $targetService)
    {
        if (empty($layananAll)) {
            return '-';
        }

        $items = explode('|||', $layananAll);

        foreach ($items as $item) {

            $parts = explode('::', $item, 2);

            $service =
                trim((string) ($parts[0] ?? ''));

            $description =
                trim((string) ($parts[1] ?? ''));

            if (
                strcasecmp(
                    $service,
                    $targetService
                ) === 0
            ) {
                return $description !== ''
                    ? $description
                    : '-';
            }
        }

        return '-';
    }


    private function buildHistoryExcel($history)
    {
        /*
        |--------------------------------------------------------------------------
        | BARIS DATA
        |--------------------------------------------------------------------------
        */

        $rows = '';

        foreach ($history as $item) {

            $normalCells = [
                $item['id'],
                $item['name'],
                $item['date'],
                $item['box'],
                $item['checkin'],
                $item['checkout'],
                $item['district'],
                $item['ods'],
                $item['location'],
                $item['status'],
            ];

            $descriptionCells = [
                $item['survey_description'] ?? '-',
                $item['deployment_description'] ?? '-',
                $item['assurance_description'] ?? '-',
                $item['maintenance_description'] ?? '-',
            ];


            $rows .= '<tr>';


            /*
            |--------------------------------------------------------------------------
            | KOLOM DATA UTAMA
            |--------------------------------------------------------------------------
            */

            foreach ($normalCells as $index => $value) {

                $cell = htmlspecialchars(
                    (string) $value,
                    ENT_QUOTES,
                    'UTF-8'
                );

                if ($index === 2) {

                    $rows .=
                        '<td style="' .
                            'padding:8px;' .
                            'border:1px solid #d1d5db;' .
                            'white-space:nowrap;' .
                            'mso-number-format:\'\@\';' .
                            'text-align:left;' .
                            'vertical-align:top;' .
                        '">' .
                            $cell .
                        '</td>';

                } else {

                    $rows .=
                        '<td style="' .
                            'padding:8px;' .
                            'border:1px solid #d1d5db;' .
                            'white-space:nowrap;' .
                            'vertical-align:top;' .
                        '">' .
                            $cell .
                        '</td>';
                }
            }


            /*
            |--------------------------------------------------------------------------
            | 4 KOLOM DESKRIPSI PEKERJAAN
            |--------------------------------------------------------------------------
            */

            foreach ($descriptionCells as $value) {

                $cell = htmlspecialchars(
                    (string) $value,
                    ENT_QUOTES,
                    'UTF-8'
                );

                $rows .=
                    '<td style="' .
                        'padding:8px;' .
                        'border:1px solid #d1d5db;' .
                        'white-space:normal;' .
                        'min-width:220px;' .
                        'vertical-align:top;' .
                    '">' .
                        nl2br($cell) .
                    '</td>';
            }


            $rows .= '</tr>';
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER 2 TINGKAT
        |--------------------------------------------------------------------------
        |
        | Baris 1:
        | ID DATA ... STATUS | DESKRIPSI PEKERJAAN
        |
        | Baris 2:
        |                    | SURVEY | DEPLOYMENT | ASSURANCE | MAINTENANCE
        |
        */

        $mainHeaders = [
            'ID DATA',
            'NAMA',
            'TANGGAL',
            'NAMA BOX',
            'JAM CHEKIN',
            'JAM CHECKOUT',
            'DISTRIK',
            'ODS',
            'LOKASI',
            'STATUS',
        ];

        $mainHeaderCells = '';

        foreach ($mainHeaders as $header) {

            $mainHeaderCells .=
                '<th rowspan="2" style="' .
                    'padding:12px 10px;' .
                    'border:1px solid #d1d5db;' .
                    'background:#f3f4f6;' .
                    'color:#111827;' .
                    'text-align:center;' .
                    'vertical-align:middle;' .
                    'font-weight:700;' .
                    'white-space:nowrap;' .
                '">' .
                    htmlspecialchars(
                        $header,
                        ENT_QUOTES,
                        'UTF-8'
                    ) .
                '</th>';
        }


        $descriptionParentHeader =
            '<th colspan="4" style="' .
                'padding:12px 10px;' .
                'border:1px solid #d1d5db;' .
                'background:#f3f4f6;' .
                'color:#111827;' .
                'text-align:center;' .
                'vertical-align:middle;' .
                'font-weight:700;' .
                'white-space:nowrap;' .
            '">' .
                'DESKRIPSI PEKERJAAN' .
            '</th>';


        $descriptionSubHeaders = [
            'SURVEY',
            'DEPLOYMENT',
            'ASSURANCE',
            'MAINTENANCE',
        ];

        $descriptionSubHeaderCells = '';

        foreach ($descriptionSubHeaders as $header) {

            $descriptionSubHeaderCells .=
                '<th style="' .
                    'padding:10px;' .
                    'border:1px solid #d1d5db;' .
                    'background:#f8fafc;' .
                    'color:#111827;' .
                    'text-align:center;' .
                    'vertical-align:middle;' .
                    'font-weight:700;' .
                    'white-space:nowrap;' .
                    'min-width:220px;' .
                '">' .
                    htmlspecialchars(
                        $header,
                        ENT_QUOTES,
                        'UTF-8'
                    ) .
                '</th>';
        }


        /*
        |--------------------------------------------------------------------------
        | HTML EXCEL
        |--------------------------------------------------------------------------
        */

        $html =
            '<html>' .

            '<head>' .

            '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' .

            '<style>' .

            'body{' .
                'font-family:Segoe UI,Calibri,Arial,sans-serif;' .
                'color:#111827;' .
            '}' .

            'table{' .
                'border-collapse:collapse;' .
                'width:100%;' .
                'table-layout:auto;' .
            '}' .

            'th,td{' .
                'font-size:12px;' .
                'padding:10px 10px;' .
                'border:1px solid #d1d5db;' .
                'vertical-align:middle;' .
            '}' .

            'tr:nth-child(even){' .
                'background:#fbfbfb;' .
            '}' .

            '</style>' .

            '</head>' .

            '<body>' .

            '<h1 style="' .
                'font-size:20px;' .
                'margin-bottom:18px;' .
                'color:#111827;' .
                'font-weight:700;' .
            '">' .
                'History Report' .
            '</h1>' .

            '<table>' .

            '<thead>' .

            '<tr>' .
                $mainHeaderCells .
                $descriptionParentHeader .
            '</tr>' .

            '<tr>' .
                $descriptionSubHeaderCells .
            '</tr>' .

            '</thead>' .

            '<tbody>' .
                $rows .
            '</tbody>' .

            '</table>' .

            '</body>' .

            '</html>';


        return $html;
    }

    private function buildHistoryPdf($history)
    {
        $rows = [];

        $rows[] = $this->formatPdfRow([
            'ID DATA',
            'NAMA',
            'TANGGAL',
            'NAMA BOX',
            'JAM CHEKIN',
            'JAM CHECKOUT',
            'LOKASI',
            'STATUS'
        ]);

        $rows[] = $this->formatPdfRow([
            '----------',
            str_repeat('-', 20),
            '--------',
            '---------',
            '---------',
            '----------',
            '--------',
            '------'
        ]);

        foreach ($history as $item) {

            $rows[] = $this->formatPdfRow([
                substr($item['id'], 0, 10),
                substr($item['name'], 0, 20),
                substr($item['date'], 0, 10),
                substr($item['box'], 0, 11),
                substr($item['checkin'], 0, 9),
                substr($item['checkout'], 0, 10),
                substr($item['location'], 0, 8),
                substr($item['status'], 0, 6),
            ]);
        }

        $lines = [];

        $lines[] = 'BT';
        $lines[] = '/F1 10 Tf';
        $lines[] = '40 760 Td';
        $lines[] = '(' . $this->pdfEscape('History Report') . ') Tj';
        $lines[] = '0 -18 Td';

        foreach ($rows as $row) {

            $lines[] = '(' . $this->pdfEscape($row) . ') Tj';
            $lines[] = '0 -14 Td';
        }

        $lines[] = 'ET';

        $contentStream = implode("\n", $lines);
        $contentLength = strlen($contentStream);

        $objects = [];

        $objects[] =
            "1 0 obj\n" .
            "<< /Type /Catalog /Pages 2 0 R >>\n" .
            "endobj";

        $objects[] =
            "2 0 obj\n" .
            "<< /Type /Pages /Kids [3 0 R] /Count 1 >>\n" .
            "endobj";

        $objects[] =
            "3 0 obj\n" .
            "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\n" .
            "endobj";

        $objects[] =
            "4 0 obj\n" .
            "<< /Length {$contentLength} >>\n" .
            "stream\n" .
            "{$contentStream}\n" .
            "endstream\n" .
            "endobj";

        $objects[] =
            "5 0 obj\n" .
            "<< /Type /Font /Subtype /Type1 /BaseFont /Courier >>\n" .
            "endobj";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        $currentOffset = strlen($pdf);

        foreach ($objects as $object) {

            $pdf .= $object . "\n";

            $offsets[] = $currentOffset;

            $currentOffset += strlen($object) + 1;
        }

        $xrefOffset = $currentOffset;

        $pdf .=
            "xref\n0 " .
            count($offsets) .
            "\n0000000000 65535 f \n";

        foreach (array_slice($offsets, 1) as $offset) {

            $pdf .= sprintf(
                "%010d 00000 n \n",
                $offset
            );
        }

        $pdf .=
            "trailer\n<< /Size " .
            count($offsets) .
            " /Root 1 0 R >>\n" .
            "startxref\n" .
            "{$xrefOffset}\n" .
            "%%EOF";

        return $pdf;
    }

    private function formatPdfRow(array $columns)
    {
        $widths = [
            10,
            20,
            10,
            11,
            9,
            10,
            8,
            6
        ];

        $row = [];

        foreach ($columns as $index => $value) {
            $row[] = str_pad(
                $value,
                $widths[$index]
            );
        }

        return implode(' ', $row);
    }

    private function pdfTextLine($text, $fontSize, $x, $y)
    {
        return sprintf(
            "/%s Tf %d Tf %d %d Td (%s) Tj ET",
            'F1',
            $fontSize,
            $x,
            $y,
            $this->pdfEscape($text)
        );
    }

    private function pdfEscape($text)
    {
        return str_replace(
            ['\\', '(', ')'],
            ['\\\\', '\\(', '\\)'],
            $text
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE SUPER ADMIN
    |--------------------------------------------------------------------------
    */

    public function superAdminProfile()
    {
        $user = Auth::user();

        $profile = [
            'nama' => $user?->name ?? 'Super Admin',
            'nama_lengkap' => $user?->name ?? 'Administrator Smart Key',
            'email' => $user?->email ?? 'admin@smartkey.com',
            'nomor_hp' => '081234567890',
            'role' => 'Super Admin',
        ];

        return view(
            'auth.profilespradmin',
            ['user' => $profile]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE ADMIN
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        $user = [
            'nama' => 'Admin Smart Key',
            'nama_lengkap' => 'Administrator Smart Key',
            'email' => 'admin@smartkey.com',
            'nomor_hp' => '081234567890',
            'role' => 'Administrator',
        ];

        return view(
            'auth.profileadmin',
            compact('user')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CHECKIN
    |--------------------------------------------------------------------------
    */

    public function checkin(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | STATUS RFID / IOT
        |--------------------------------------------------------------------------
        |
        | Saat halaman pertama kali dibuka, profil tidak langsung mengambil
        | karyawan aktif pertama. Sistem menunggu ID Card.
        |
        | Selama perangkat IoT belum selesai, kolom pencarian tetap dapat
        | dipakai sebagai simulasi pembacaan RFID.
        |
        */

        $karyawan = null;
        $rfidState = 'waiting';
        $rfidMessage = 'Perangkat RFID/IoT belum terhubung. Tempelkan ID Card saat perangkat sudah siap. Untuk sementara, kolom pencarian dapat digunakan sebagai simulasi RFID.';

        /*
        |--------------------------------------------------------------------------
        | KARYAWAN YANG TERHUBUNG DENGAN AKUN LOGIN
        |--------------------------------------------------------------------------
        |
        | Karyawan baru yang dibuat Super Admin mempunyai email yang sama
        | pada tabel karyawans dan users.
        |
        */

        $loggedInKaryawan = null;

        if (Auth::check()) {
            $loggedInKaryawan = Karyawan::where('email', Auth::user()->email)
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | SIMULASI PEMBACAAN RFID
        |--------------------------------------------------------------------------
        */

        if ($request->filled('q')) {
            $search = trim((string) $request->q);

            $candidate = Karyawan::query()
                ->where('status', 'aktif')
                ->where(function ($query) use ($search) {
                    $query->where('id_card', $search)
                        ->orWhere('nama_lengkap', 'like', '%' . $search . '%');
                })
                ->first();

            if (!$candidate) {
                $rfidState = 'not_found';
                $rfidMessage = 'ID Card atau karyawan tidak ditemukan, atau status karyawan sedang nonaktif.';
            } elseif ($loggedInKaryawan && (int) $candidate->id !== (int) $loggedInKaryawan->id) {
                /*
                | Keamanan:
                | Jika akun login memang terhubung dengan data karyawan,
                | kartu yang dibaca harus milik akun tersebut.
                */
                $rfidState = 'mismatch';
                $rfidMessage = 'ID Card tidak sesuai dengan akun yang sedang login. Gunakan ID Card milik akun Anda.';
            } else {
                $karyawan = $candidate;
                $rfidState = 'ready';
                $rfidMessage = 'ID Card berhasil diverifikasi. Profil karyawan siap digunakan untuk proses Checkin/Checkout.';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA KARYAWAN UNTUK BLADE
        |--------------------------------------------------------------------------
        */

        if (!$karyawan) {
            $employee = [
                'id_card' => '-',
                'name' => '-',
                'birth_date' => '-',
                'gender' => '-',
                'nik' => '-',
                'email' => '-',
                'position' => '-',
                'division' => '-',
                'address' => '-',
                'ods' => '-',
                'ods_id' => null,
                'status' => $rfidState === 'waiting' ? 'Menunggu ID Card' : 'Belum Terverifikasi',
                'database_id' => null,
                'photo' => null,
            ];
        } else {
            $birthDate = '-';

            if (!empty($karyawan->tanggal_lahir)) {
                $timestamp = strtotime($karyawan->tanggal_lahir);

                if ($timestamp !== false) {
                    $birthDate = date('d/m/Y', $timestamp);
                }
            }

            $ods = null;

            if (!empty($karyawan->ods_id)) {
                $ods = DB::table('ods')
                    ->where('id', $karyawan->ods_id)
                    ->first();
            }

            $odsLabel = '-';

            if ($ods) {
                if (!empty($ods->kode_ods) && !empty($ods->nama_ods)) {
                    $odsLabel = $ods->kode_ods . ' - ' . $ods->nama_ods;
                } elseif (!empty($ods->kode_ods)) {
                    $odsLabel = $ods->kode_ods;
                } elseif (!empty($ods->nama_ods)) {
                    $odsLabel = $ods->nama_ods;
                }
            }

            $employee = [
                'id_card' => $karyawan->id_card,
                'name' => $karyawan->nama_lengkap,
                'birth_date' => $birthDate,
                'gender' => $karyawan->jenis_kelamin ?? '-',
                'nik' => $karyawan->nik ?? '-',
                'email' => $karyawan->email ?? '-',
                'position' => $karyawan->jabatan ?? '-',
                'division' => $karyawan->devisi ?? '-',
                'address' => $karyawan->alamat ?? '-',
                'ods' => $odsLabel,
                'ods_id' => $karyawan->ods_id ?? null,
                'status' => ucfirst($karyawan->status),
                'database_id' => $karyawan->id,
                'photo' => $karyawan->foto ?? null,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | DATA SMART BOX
        |--------------------------------------------------------------------------
        */

        $smartBoxes = DB::table('smart_boxes')
            ->where('status', 'aktif')
            ->orderBy('kode_box')
            ->get();

        $selectedBoxId = $request->input('box_id');
        $selectedBox = null;

        if ($selectedBoxId) {
            $selectedBox = $smartBoxes->firstWhere('id', (int) $selectedBoxId);
        }

        $districts = $smartBoxes
            ->pluck('lokasi')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $selectedDistrict = $selectedBox
            ? $selectedBox->lokasi
            : $request->input('district');

        $services = collect([
            ['title' => 'Survey', 'desc' => ''],
            ['title' => 'Deployment', 'desc' => ''],
            ['title' => 'Assurance', 'desc' => ''],
            ['title' => 'Maintenance', 'desc' => ''],
        ]);

        return view(
            'auth.checkin',
            compact(
                'employee',
                'services',
                'smartBoxes',
                'districts',
                'selectedBoxId',
                'selectedBox',
                'selectedDistrict',
                'rfidState',
                'rfidMessage',
                'loggedInKaryawan'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA CHECKIN + LAYANAN PEKERJAAN
    |--------------------------------------------------------------------------
    */

    public function storeCheckin(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA
        |--------------------------------------------------------------------------
        |
        | Struktur form lama tetap dipertahankan.
        |
        */

        $validated = $request->validate([
            'karyawan_id' => 'required|integer|exists:karyawans,id',
            'box_id' => 'required|integer|exists:smart_boxes,id',
            'district' => 'required|string|max:100',

            'jenis_layanan' => 'required|array|min:1',
            'jenis_layanan.*' => [
                'required',
                'string',
                'in:Survey,Deployment,Assurance,Maintenance',
            ],

            'deskripsi_pekerjaan' => 'required|array|min:1',
            'deskripsi_pekerjaan.*' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        if (
            count($validated['jenis_layanan']) !==
            count($validated['deskripsi_pekerjaan'])
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data jenis layanan dan deskripsi pekerjaan tidak sesuai.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN KARYAWAN YANG BENAR
        |--------------------------------------------------------------------------
        |
        | Jika akun login terhubung dengan tabel karyawans, ID karyawan WAJIB
        | mengikuti akun yang sedang login. Dengan begitu data Faizul tidak akan
        | pernah lagi tersimpan sebagai Ahmad Fauzan karena hidden input lama.
        |
        */

        $loggedInKaryawan = null;

        if (Auth::check()) {
            $loggedInKaryawan = Karyawan::where('email', Auth::user()->email)
                ->first();
        }

        if ($loggedInKaryawan) {

            if (strtolower((string) $loggedInKaryawan->status) !== 'aktif') {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Akun karyawan sedang nonaktif dan tidak dapat melakukan Checkin.'
                    );
            }

            if ((int) $validated['karyawan_id'] !== (int) $loggedInKaryawan->id) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'ID Card tidak sesuai dengan akun yang sedang login.'
                    );
            }

            $karyawan = $loggedInKaryawan;

        } else {

            $karyawan = Karyawan::query()
                ->where('id', $validated['karyawan_id'])
                ->where('status', 'aktif')
                ->first();

            if (!$karyawan) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Karyawan tidak aktif atau tidak ditemukan.'
                    );
            }
        }

        $smartBox = DB::table('smart_boxes')
            ->where('id', $validated['box_id'])
            ->where('status', 'aktif')
            ->first();

        if (!$smartBox) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Smart Box tidak aktif atau tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CEK APAKAH MASIH ADA CHECKIN AKTIF
        |--------------------------------------------------------------------------
        */

        $activeCheckin = DB::table('checkin_checkouts')
            ->where('karyawan_id', $karyawan->id)
            ->whereIn('status', ['chekin', 'checkin'])
            ->whereNull('jam_checkout')
            ->orderByDesc('id')
            ->first();

        if ($activeCheckin) {
            return redirect()
                ->route('checkin', [
                    'q' => $karyawan->id_card,
                    'box_id' => $activeCheckin->smart_box_id,
                    'district' => $activeCheckin->lokasi,
                ])
                ->with(
                    'error',
                    'Karyawan masih memiliki Checkin aktif. Lakukan Checkout terlebih dahulu.'
                );
        }

        try {

            DB::beginTransaction();

            do {

                $kodeData = '#' . str_pad(
                    (string) random_int(1, 9999),
                    4,
                    '0',
                    STR_PAD_LEFT
                );

                $kodeExists = DB::table('checkin_checkouts')
                    ->where('kode_data', $kodeData)
                    ->exists();

            } while ($kodeExists);

            $now = now();

            $checkinId = DB::table('checkin_checkouts')->insertGetId([

                'kode_data' => $kodeData,

                'karyawan_id' => $karyawan->id,

                'smart_box_id' => $smartBox->id,

                'district_id' => $smartBox->district_id ?? null,

                'ods_id' => $karyawan->ods_id ?? ($smartBox->ods_id ?? null),

                'tanggal' => $now->format('Y-m-d'),

                'jam_checkin' => $now->format('H:i:s'),

                'jam_checkout' => null,

                'waktu_scan' => $now,

                'id_card_terbaca' => 1,

                'lokasi' => $validated['district'],

                'status' => 'chekin',

                'approval_status' => 'pending',

                'approved_by' => null,

                'approved_at' => null,

                'akses_hasil' => 'berhasil',

                'created_at' => $now,

                'updated_at' => $now,
            ]);

            $serviceRows = [];

            foreach ($validated['jenis_layanan'] as $index => $jenisLayanan) {

                $deskripsi = trim(
                    (string) $validated['deskripsi_pekerjaan'][$index]
                );

                $serviceRows[] = [
                    'checkin_checkout_id' => $checkinId,
                    'jenis_layanan' => $jenisLayanan,
                    'deskripsi_pekerjaan' => $deskripsi,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('layanan_pekerjaans')
                ->insert($serviceRows);

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data Checkin dan layanan pekerjaan gagal disimpan: ' .
                    $e->getMessage()
                );
        }

        return redirect()
            ->route('checkin', [
                'q' => $karyawan->id_card,
                'box_id' => $smartBox->id,
                'district' => $validated['district'],
            ])
            ->with(
                'success',
                'Checkin dan semua layanan pekerjaan berhasil disimpan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function storeCheckout(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'karyawan_id' => 'required|integer|exists:karyawans,id',
            'box_id' => 'required|integer|exists:smart_boxes,id',
            'district' => 'required|string|max:100',
        ]);

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN KARYAWAN DARI AKUN LOGIN
        |--------------------------------------------------------------------------
        |
        | Faizul login -> email akun dicocokkan ke karyawans -> ID 20.
        | Jadi Checkout tidak lagi bergantung pada data Ahmad Fauzan / ID 1.
        |
        */

        $loggedInKaryawan = null;

        if (Auth::check()) {
            $loggedInKaryawan = Karyawan::where('email', Auth::user()->email)
                ->first();
        }

        if ($loggedInKaryawan) {

            if (strtolower((string) $loggedInKaryawan->status) !== 'aktif') {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Akun karyawan sedang nonaktif dan tidak dapat melakukan Checkout.'
                    );
            }

            if ((int) $validated['karyawan_id'] !== (int) $loggedInKaryawan->id) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'ID Card tidak sesuai dengan akun yang sedang login.'
                    );
            }

            $karyawan = $loggedInKaryawan;

        } else {

            $karyawan = Karyawan::query()
                ->where('id', $validated['karyawan_id'])
                ->where('status', 'aktif')
                ->first();

            if (!$karyawan) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Karyawan tidak aktif atau tidak ditemukan.'
                    );
            }
        }

        $smartBox = DB::table('smart_boxes')
            ->where('id', $validated['box_id'])
            ->where('status', 'aktif')
            ->first();

        if (!$smartBox) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Smart Box tidak aktif atau tidak ditemukan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | CARI CHECKIN AKTIF MILIK KARYAWAN YANG BENAR
        |--------------------------------------------------------------------------
        */

        $checkin = DB::table('checkin_checkouts')
            ->where('karyawan_id', $karyawan->id)
            ->whereIn('status', ['chekin', 'checkin'])
            ->whereNull('jam_checkout')
            ->orderByDesc('id')
            ->first();

        if (!$checkin) {
            return redirect()
                ->route('checkin', [
                    'q' => $karyawan->id_card,
                    'box_id' => $smartBox->id,
                    'district' => $validated['district'],
                ])
                ->with(
                    'error',
                    'Belum ada Checkin aktif untuk ' .
                    $karyawan->nama_lengkap .
                    '. Checkout hanya dapat dilakukan setelah proses Checkin RFID berhasil dibuat.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN SMART BOX SESUAI DENGAN CHECKIN
        |--------------------------------------------------------------------------
        */

        if ((int) $checkin->smart_box_id !== (int) $smartBox->id) {

            $checkinBox = DB::table('smart_boxes')
                ->where('id', $checkin->smart_box_id)
                ->first();

            return redirect()
                ->route('checkin', [
                    'q' => $karyawan->id_card,
                    'box_id' => $smartBox->id,
                    'district' => $validated['district'],
                ])
                ->with(
                    'error',
                    'Smart Box tidak sesuai. Checkin aktif dilakukan melalui ' .
                    ($checkinBox->kode_box ?? ('Box #' . $checkin->smart_box_id)) .
                    '.'
                );
        }

        $now = now();

        $updated = DB::table('checkin_checkouts')
            ->where('id', $checkin->id)
            ->where('karyawan_id', $karyawan->id)
            ->whereIn('status', ['chekin', 'checkin'])
            ->whereNull('jam_checkout')
            ->update([
                'jam_checkout' => $now->format('H:i:s'),
                'updated_at' => $now,
                'status' => 'checkout',
            ]);

        if ($updated === 0) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data Checkout gagal diperbarui atau sesi Checkin sudah ditutup.'
                );
        }

        return redirect()
            ->route('checkin', [
                'q' => $karyawan->id_card,
                'box_id' => $smartBox->id,
                'district' => $validated['district'],
            ])
            ->with(
                'success',
                'Checkout ' . $karyawan->nama_lengkap . ' berhasil disimpan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | USERNAME UNIK UNTUK AKUN KARYAWAN
    |--------------------------------------------------------------------------
    |
    | Login tetap menggunakan email. Username dibuat otomatis karena kolom
    | username pada tabel users wajib dan unique.
    |
    */

    private function generateUniqueEmployeeUsername(string $name): string
    {
        $base = Str::lower(Str::ascii($name));
        $base = preg_replace('/[^a-z0-9]/', '', $base) ?: 'karyawan';
        $base = substr($base, 0, 40);

        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $suffix = (string) $counter;
            $username = substr($base, 0, 50 - strlen($suffix)) . $suffix;
            $counter++;
        }

        return $username;
    }

}