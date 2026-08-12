<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            ['label' => 'Total Smart Box', 'value' => '128', 'meta' => '8.5% Up from yesterday', 'icon' => '📦', 'accent' => '#2563eb'],
            ['label' => 'Akses Hari ini', 'value' => '256', 'meta' => '8.5% Up from yesterday', 'icon' => '⚡', 'accent' => '#f59e0b'],
            ['label' => 'Akses Berhasil', 'value' => '232', 'meta' => '1.8% Up from yesterday', 'icon' => '✅', 'accent' => '#10b981'],
            ['label' => 'Akses Ditolak', 'value' => '24', 'meta' => '4.3% Down from yesterday', 'icon' => '❌', 'accent' => '#ef4444'],
        ];

        $rawActivities = collect(range(1, 20))->map(function ($index) {
            return [
                'id' => '#6548',
                'name' => 'Roi Kiyosi',
                'date' => '22/08/2026',
                'box' => 'BoX-miq-01',
                'checkin' => 'BoX-miq-01',
                'checkout' => 'BoX-miq-01',
                'location' => 'Malang',
                'status' => 'Chekin',
            ];
        });

        $perPage = 4;
        $page = $request->query('page', 1);
        $currentItems = $rawActivities->slice(($page - 1) * $perPage, $perPage)->values();

        $activities = new LengthAwarePaginator(
            $currentItems,
            $rawActivities->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('dashboard', compact('stats', 'activities'));
    }

    public function superAdmin(Request $request)
    {
        $stats = [
            ['label' => 'Total Smart Box', 'value' => '128', 'meta' => '8.5% Up from yesterday', 'icon' => '📦', 'accent' => '#2563eb'],
            ['label' => 'Akses Hari ini', 'value' => '256', 'meta' => '8.5% Up from yesterday', 'icon' => '⚡', 'accent' => '#f59e0b'],
            ['label' => 'Akses Berhasil', 'value' => '232', 'meta' => '1.8% Up from yesterday', 'icon' => '✅', 'accent' => '#10b981'],
            ['label' => 'Akses Ditolak', 'value' => '24', 'meta' => '4.3% Down from yesterday', 'icon' => '❌', 'accent' => '#ef4444'],
        ];

        $rawActivities = collect(range(1, 20))->map(function ($index) {
            return [
                'id' => '#6548',
                'name' => 'Roi Kiyosi',
                'date' => '22/08/2026',
                'box' => 'BoX-miq-01',
                'checkin' => 'BoX-miq-01',
                'checkout' => 'BoX-miq-01',
                'location' => 'Malang',
                'status' => 'Chekin',
            ];
        });

        $perPage = 4;
        $page = $request->query('page', 1);
        $currentItems = $rawActivities->slice(($page - 1) * $perPage, $perPage)->values();

        $activities = new LengthAwarePaginator(
            $currentItems,
            $rawActivities->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('auth.dashboardspradmin', compact('stats', 'activities'));
    }

    public function employees(Request $request)
    {
        $search = $request->query('q');
        $perPage = 5;

        $query = User::query()->where('id', '!=', 1);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $employees = $query->orderBy('id')->paginate($perPage)->withQueryString();

        $employees->setCollection($employees->getCollection()->map(function (User $user) {
            $statusOptions = ['Berhasil', 'Pending', 'Ditolak'];
            $status = $statusOptions[$user->id % count($statusOptions)];
            $role = $user->id % 2 === 1 ? 'Admin' : 'Teknisi';

            return [
                'id' => sprintf('#%04d', $user->id),
                'name' => $user->name,
                'calendar' => $user->created_at ? $user->created_at->format('d/m/Y') : now()->format('d/m/Y'),
                'role' => $role,
                'status' => $status,
            ];
        }));

        return view('auth.karyawan', compact('employees', 'search', 'perPage'));
    }

    public function superAdminEmployees(Request $request)
    {
        $search = $request->query('q');
        $perPage = 8;

        $fixedEmployees = collect([
            ['id' => '#6548', 'name' => 'Muhammad', 'calendar' => '22/08/2026', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'Ahmad Wildan', 'calendar' => '30/08/2026', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'ALfauzi', 'calendar' => '01/01/2027', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'Anas Fikri', 'calendar' => '02/01/2027', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'Maulana Malik', 'calendar' => '03/01/2027', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'Ilham', 'calendar' => '10/01/2027', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'Rizky Ridho', 'calendar' => '17/01/2027', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'Nanda', 'calendar' => '21/01/2027', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'Taufik Quridho', 'calendar' => '23/01/2027', 'status' => 'Berhasil'],
            ['id' => '#6548', 'name' => 'Dewi Santoso', 'calendar' => '25/01/2027', 'status' => 'Berhasil'],
        ]);

        $filtered = $fixedEmployees->filter(function ($employee) use ($search) {
            if (! $search) {
                return true;
            }

            return str_contains(strtolower($employee['id']), strtolower($search)) || str_contains(strtolower($employee['name']), strtolower($search));
        })->values();

        $page = $request->query('page', 1);
        $currentItems = $filtered->slice(($page - 1) * $perPage, $perPage)->values();

        $employees = new LengthAwarePaginator(
            $currentItems,
            $filtered->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('auth.karyawanspradmin', compact('employees', 'search', 'perPage'));
    }

    public function superAdminHistory(Request $request)
    {
        $search = $request->query('q');
        $perPage = 4;

        $rawHistory = collect(range(1, 50))->map(function ($index) {
            $statusOptions = ['Chekin', 'Checkout'];
            $status = $statusOptions[$index % 2];
            $names = ['Roi Kiyosi', 'Muhammad', 'Ahmad Wildan', 'ALfauzi', 'Anas Fikri', 'Maulana Malik', 'Ilham', 'Rizky Ridho', 'Nanda', 'Taufik Quridho'];
            $boxes = ['BoX-mlg-01', 'BoX-mlg-02', 'BoX-mlg-03'];
            $locations = ['Malang', 'Surabaya', 'Jakarta'];

            return [
                'id' => '#6548',
                'name' => $names[$index % count($names)],
                'date' => now()->subDays($index)->format('d/m/Y'),
                'box' => $boxes[$index % count($boxes)],
                'checkin' => 'BoX-mlg-01',
                'checkout' => 'BoX-mlg-01',
                'location' => $locations[$index % count($locations)],
                'status' => $status,
            ];
        });

        $history = $rawHistory->filter(function ($item) use ($search) {
            return ! $search || str_contains(strtolower($item['id']), strtolower($search)) || str_contains(strtolower($item['name']), strtolower($search));
        })->values();

        $page = $request->query('page', 1);
        $currentItems = $history->slice(($page - 1) * $perPage, $perPage)->values();

        $history = new LengthAwarePaginator(
            $currentItems,
            $history->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('auth.historyspradmin', compact('history', 'search', 'perPage'));
    }

    public function history(Request $request)
    {
        $search = $request->query('q');
        $perPage = 4;

        $rawHistory = collect(range(1, 50))->map(function ($index) {
            $statusOptions = ['Chekin', 'Checkout'];
            $status = $statusOptions[$index % 2];
            $names = ['Roi Kiyosi', 'Muhammad', 'Ahmad Wildan', 'ALfauzi', 'Anas Fikri', 'Maulana Malik', 'Ilham', 'Rizky Ridho', 'Nanda', 'Taufik Quridho'];
            $boxes = ['BoX-mlg-01', 'BoX-mlg-02', 'BoX-mlg-03'];
            $locations = ['Malang', 'Surabaya', 'Jakarta'];

            return [
                'id' => '#6548',
                'name' => $names[$index % count($names)],
                'date' => now()->subDays($index)->format('d/m/Y'),
                'box' => $boxes[$index % count($boxes)],
                'checkin' => 'BoX-mlg-01',
                'checkout' => 'BoX-mlg-01',
                'location' => $locations[$index % count($locations)],
                'status' => $status,
            ];
        });

        $history = $rawHistory->filter(function ($item) use ($search) {
            return ! $search || str_contains(strtolower($item['id']), strtolower($search)) || str_contains(strtolower($item['name']), strtolower($search));
        })->values();

        $page = $request->query('page', 1);
        $currentItems = $history->slice(($page - 1) * $perPage, $perPage)->values();

        $history = new LengthAwarePaginator(
            $currentItems,
            $history->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('auth.history', compact('history', 'search', 'perPage'));
    }

    public function historyExport(Request $request)
    {
        $search = $request->query('q');

        $rawHistory = collect(range(1, 50))->map(function ($index) {
            $statusOptions = ['Chekin', 'Checkout'];
            $status = $statusOptions[$index % 2];
            $names = ['Roi Kiyosi', 'Muhammad', 'Ahmad Wildan', 'ALfauzi', 'Anas Fikri', 'Maulana Malik', 'Ilham', 'Rizky Ridho', 'Nanda', 'Taufik Quridho'];
            $boxes = ['BoX-mlg-01', 'BoX-mlg-02', 'BoX-mlg-03'];
            $locations = ['Malang', 'Surabaya', 'Jakarta'];

            return [
                'id' => '#6548',
                'name' => $names[$index % count($names)],
                'date' => now()->subDays($index)->format('d/m/Y'),
                'box' => $boxes[$index % count($boxes)],
                'checkin' => 'BoX-mlg-01',
                'checkout' => 'BoX-miq-01',
                'location' => $locations[$index % count($locations)],
                'status' => $status,
            ];
        });

        $history = $rawHistory->filter(function ($item) use ($search) {
            return ! $search || str_contains(strtolower($item['id']), strtolower($search)) || str_contains(strtolower($item['name']), strtolower($search));
        })->values();

        $excel = $this->buildHistoryExcel($history);

        return response($excel, 200)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="history-report.xls"');
    }

    private function buildHistoryExcel($history)
    {
        $headers = ['ID DATA', 'NAMA', 'TANGGAL', 'NAMA BOX', 'JAM CHEKIN', 'JAM CHECKOUT', 'LOKASI', 'STATUS'];

        $rows = '';
        foreach ($history as $item) {
            $cells = [
                $item['id'],
                $item['name'],
                $item['date'],
                $item['box'],
                $item['checkin'],
                $item['checkout'],
                $item['location'],
                $item['status'],
            ];

            $escaped = array_map(function ($value) {
                return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }, $cells);

            $rows .= '<tr>';
            foreach ($escaped as $index => $cell) {
                // For date column (index 2) force text format in Excel and prevent wrapping
                if ($index === 2) {
                    $rows .= '<td style="padding:8px;border:1px solid #d1d5db;white-space:nowrap;mso-number-format:\'\\@\';text-align:left;">' . $cell . '</td>';
                } else {
                    $rows .= '<td style="padding:8px;border:1px solid #d1d5db;white-space:nowrap;">' . $cell . '</td>';
                }
            }
            $rows .= '</tr>';
        }

        $headerCells = '';
        foreach ($headers as $header) {
            $headerCells .= '<th style="padding:12px 10px;border:1px solid #d1d5db;background:#f3f4f6;color:#111827;text-align:left;font-weight:700;">' . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . '</th>';
        }

        $html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><style>body{font-family:Segoe UI,Calibri,Arial,sans-serif;color:#111827;}table{border-collapse:collapse;width:100%;table-layout:auto;}th,td{font-size:12px;padding:10px 10px;border:1px solid #d1d5db;vertical-align:middle;}tr:nth-child(even){background:#fbfbfb;}th{background:#f3f4f6;}</style></head><body><h1 style="font-size:20px;margin-bottom:18px;color:#111827;font-weight:700;">History Report</h1><table><thead><tr>' . $headerCells . '</tr></thead><tbody>' . $rows . '</tbody></table></body></html>';

        return $html;
    }

    private function buildHistoryPdf($history)
    {
        $rows = [];
        $rows[] = $this->formatPdfRow(['ID DATA', 'NAMA', 'TANGGAL', 'NAMA BOX', 'JAM CHEKIN', 'JAM CHECKOUT', 'LOKASI', 'STATUS']);
        $rows[] = $this->formatPdfRow(['----------', str_repeat('-', 20), '--------', '---------', '---------', '----------', '--------', '------']);

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
        $objects[] = "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj";
        $objects[] = "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj";
        $objects[] = "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj";
        $objects[] = "4 0 obj\n<< /Length {$contentLength} >>\nstream\n{$contentStream}\nendstream\nendobj";
        $objects[] = "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Courier >>\nendobj";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        $currentOffset = strlen($pdf);

        foreach ($objects as $object) {
            $pdf .= $object . "\n";
            $offsets[] = $currentOffset;
            $currentOffset += strlen($object) + 1;
        }

        $xrefOffset = $currentOffset;
        $pdf .= "xref\n0 " . count($offsets) . "\n0000000000 65535 f \n";

        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size " . count($offsets) . " /Root 1 0 R >>\nstartxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }

    private function formatPdfRow(array $columns)
    {
        $widths = [10, 20, 10, 11, 9, 10, 8, 6];
        $row = [];

        foreach ($columns as $index => $value) {
            $row[] = str_pad($value, $widths[$index]);
        }

        return implode(' ', $row);
    }

    private function pdfTextLine($text, $fontSize, $x, $y)
    {
        return sprintf("/%s Tf %d Tf %d %d Td (%s) Tj ET", 'F1', $fontSize, $x, $y, $this->pdfEscape($text));
    }

    private function pdfEscape($text)
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
    
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

        return view('auth.profilespradmin', ['user' => $profile]);
    }

    public function profile()
    {
        $user = [
            'nama' => 'Admin Smart Key',
            'nama_lengkap' => 'Administrator Smart Key',
            'email' => 'admin@smartkey.com',
            'nomor_hp' => '081234567890',
            'role' => 'Administrator',
        ];

        return view('auth.profileadmin', compact('user'));
    }

    public function checkin(Request $request)
    {
        $employee = [
            'id_card' => '0076245',
            'name' => 'Wito',
            'nik' => '3424976329453975',
            'position' => 'Teknisi',
            'division' => 'Smart Key',
            'status' => 'Aktif',
        ];

        $services = collect([
            ['title' => 'Survei', 'desc' => ''],
            ['title' => 'Deployment', 'desc' => ''],
            ['title' => 'Assurance', 'desc' => ''],
            ['title' => 'Maintance', 'desc' => ''],
        ]);

        return view('auth.checkin', compact('employee', 'services'));
    }
}
