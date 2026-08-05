<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
}
