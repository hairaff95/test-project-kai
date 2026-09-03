<?php

namespace App\Http\Controllers;

use App\Models\KaiAsset;
use App\Models\KaiContract;
use App\Models\ContractFinancial;
use App\Models\MonthlySchedule;
use App\Models\Penyewa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── 1. Statistik 4 Kartu Utama ──────────────────────────────────
        $totalContracts = KaiContract::count();
        $totalContractPrice = (float) KaiContract::sum('price');
        $totalAssets = KaiContract::where('jenis_kontrak', 'like', '%sewa%')->count() ?: KaiContract::count();
        $avgArea = round((float) KaiAsset::avg('size_area'));

        // Format Total Nilai Kontrak (M / Jt)
        if ($totalContractPrice >= 1_000_000_000) {
            $totalNilaiKontrakFormatted = 'Rp ' . number_format($totalContractPrice / 1_000_000_000, 1, ',', '.') . ' M';
        } elseif ($totalContractPrice >= 1_000_000) {
            $totalNilaiKontrakFormatted = 'Rp ' . number_format($totalContractPrice / 1_000_000, 1, ',', '.') . ' Jt';
        } else {
            $totalNilaiKontrakFormatted = 'Rp ' . number_format($totalContractPrice, 0, ',', '.');
        }

        // ── 2. Distribusi Pendapatan Bulanan Jan-Des & SVG Generator ────
        $monthlyRaw = [
            ['key' => 'Jan', 'val' => (float) MonthlySchedule::sum('januari')],
            ['key' => 'Feb', 'val' => (float) MonthlySchedule::sum('febuari')],
            ['key' => 'Mar', 'val' => (float) MonthlySchedule::sum('maret')],
            ['key' => 'Apr', 'val' => (float) MonthlySchedule::sum('april')],
            ['key' => 'Mei', 'val' => (float) MonthlySchedule::sum('mei')],
            ['key' => 'Jun', 'val' => (float) MonthlySchedule::sum('juni')],
            ['key' => 'Jul', 'val' => (float) MonthlySchedule::sum('juli')],
            ['key' => 'Agu', 'val' => (float) MonthlySchedule::sum('agustus')],
            ['key' => 'Sep', 'val' => (float) MonthlySchedule::sum('september')],
            ['key' => 'Okt', 'val' => (float) MonthlySchedule::sum('oktober')],
            ['key' => 'Nov', 'val' => (float) MonthlySchedule::sum('november')],
            ['key' => 'Des', 'val' => (float) MonthlySchedule::sum('desember')],
        ];

        $vals = array_column($monthlyRaw, 'val');
        $maxVal = max($vals) ?: 1;
        $minVal = min($vals);

        // Skala Y Axis (6 grid lines)
        if ($maxVal >= 1_000_000_000) {
            $yTop = ceil($maxVal / 200_000_000) * 200_000_000;
            $yBottom = max(0, floor($minVal / 200_000_000) * 200_000_000);
        } else {
            $yTop = ceil($maxVal / 50_000_000) * 50_000_000;
            $yBottom = max(0, floor($minVal / 50_000_000) * 50_000_000 - 50_000_000);
        }
        if ($yTop <= $yBottom) {
            $yTop = $yBottom + 100_000_000;
        }

        $yGridLabels = [];
        $step = ($yTop - $yBottom) / 5;
        for ($i = 5; $i >= 0; $i--) {
            $cur = $yBottom + ($i * $step);
            if ($cur >= 1_000_000_000) {
                $yGridLabels[] = rtrim(rtrim(number_format($cur / 1_000_000_000, 1, ',', '.'), '0'), ',') . 'M';
            } elseif ($cur >= 1_000_000) {
                $yGridLabels[] = round($cur / 1_000_000) . 'jt';
            } else {
                $yGridLabels[] = (string) round($cur);
            }
        }

        // Koordinat titik kurva (ViewBox 1000 x 200)
        $points = [];
        foreach ($monthlyRaw as $idx => $m) {
            $x = round($idx * (1000 / 11), 1);
            $normalized = ($m['val'] - $yBottom) / max(1, ($yTop - $yBottom));
            $normalized = max(0.05, min(0.95, $normalized));
            $y = round(175 - ($normalized * 135), 1);
            $points[] = ['x' => $x, 'y' => $y, 'val' => $m['val'], 'key' => $m['key']];
        }

        // Generate smooth SVG Path
        $primaryWavePath = "M " . $points[0]['x'] . "," . $points[0]['y'];
        $lightWavePath   = "M " . $points[0]['x'] . "," . max(20, $points[0]['y'] - 15);

        for ($i = 0; $i < count($points) - 1; $i++) {
            $p0 = $i > 0 ? $points[$i - 1] : $points[$i];
            $p1 = $points[$i];
            $p2 = $points[$i + 1];
            $p3 = $i < count($points) - 2 ? $points[$i + 2] : $p2;

            $cp1x = round($p1['x'] + ($p2['x'] - $p0['x']) / 6, 1);
            $cp1y = round($p1['y'] + ($p2['y'] - $p0['y']) / 6, 1);
            $cp2x = round($p2['x'] - ($p3['x'] - $p1['x']) / 6, 1);
            $cp2y = round($p2['y'] - ($p3['y'] - $p1['y']) / 6, 1);

            $primaryWavePath .= " C {$cp1x},{$cp1y} {$cp2x},{$cp2y} {$p2['x']},{$p2['y']}";
            
            $lightY1 = max(15, $cp1y - 15);
            $lightY2 = max(15, $cp2y - 15);
            $lightP2Y = max(15, $p2['y'] - 15);
            $lightWavePath   .= " C {$cp1x},{$lightY1} {$cp2x},{$lightY2} {$p2['x']},{$lightP2Y}";
        }

        $gradientFillPath = $primaryWavePath . " L 1000,200 L 0,200 Z";

        // Badges pada titik puncak (misal Mar = index 2 dan Okt = index 9)
        $badge1 = [
            'leftPct' => 18,
            'topPct'  => round(($points[2]['y'] / 200) * 100),
            'label'   => round($points[2]['val'] / 1_000_000),
        ];
        $badge2 = [
            'leftPct' => 81,
            'topPct'  => round(($points[9]['y'] / 200) * 100),
            'label'   => round($points[9]['val'] / 1_000_000),
        ];

        // ── 3. Jatuh Tempo Terdekat ──────────────────────────────────────
        $upcomingContracts = KaiContract::with(['tenant', 'asset'])
            ->orderBy('end_datetime_baru', 'asc')
            ->orderBy('end_datetime', 'asc')
            ->take(7)
            ->get()
            ->map(function ($c) {
                $endDate = $c->end_datetime_baru ?? $c->end_datetime ?? now()->addYear();
                $diffText = '';
                if ($endDate->isPast()) {
                    $diffText = 'Sudah Jatuh Tempo';
                } else {
                    $diffMonths = (int) now()->diffInMonths($endDate);
                    $diffDays = ((int) now()->diffInDays($endDate)) % 30;
                    $diffText = "{$diffMonths} bulan {$diffDays} hari";
                }

                return [
                    'jenis_kontrak' => $c->jenis_kontrak ?? 'Kontrak Sewa',
                    'nama'          => $c->tenant?->fullname ?? $c->tenant?->name ?? 'Penyewa',
                    'jatuh_tempo'   => $endDate->format('d-m-Y'),
                    'sisa'          => $diffText,
                ];
            });

        // ── 4. Distribusi Jenis Pendapatan & Persentase Pencapaian ───────
        $revenueCategories = [
            ['name' => 'Row',                 'color' => '#0D63E5', 'sub' => 'row'],
            ['name' => 'Non Row',             'color' => '#94B4FF', 'sub' => 'non row'],
            ['name' => 'Rumah Perusahaan',    'color' => '#EB4D4B', 'sub' => 'rumah'],
            ['name' => 'Utilitas Pengawasan', 'color' => '#F99827', 'sub' => 'pengawasan'],
            ['name' => 'Iklan / Lainnya',     'color' => '#00C49F', 'sub' => 'iklan'],
        ];

        $totalRevenue = (float) (ContractFinancial::sum('nilai_2026') ?: 1);
        $revenueBreakdown = [];

        foreach ($revenueCategories as $cat) {
            $catSum = (float) ContractFinancial::where('jenis_pendapatan', 'like', "%{$cat['sub']}%")->sum('nilai_2026');
            $pct = round(($catSum / $totalRevenue) * 100);

            // Hitung rata-rata persentase pencapaian riil dari database
            $rawPct = (float) ContractFinancial::where('jenis_pendapatan', 'like', "%{$cat['sub']}%")->avg('persentase');
            if ($rawPct <= 0) {
                $rawPct = 0.9;
            }
            $pencapaianVal = $rawPct <= 2.0 ? round($rawPct * 100, 1) : round($rawPct, 1);
            $pencapaianFormatted = number_format($pencapaianVal, 1, ',', '.') . '%';

            $revenueBreakdown[] = [
                'name'       => $cat['name'],
                'color'      => $cat['color'],
                'percentage' => max(8, min(80, $pct ?: 15)),
                'pencapaian' => $pencapaianFormatted,
            ];
        }

        // ── 5. Pencapaian RKA & Backlog ──────────────────────────────────
        $totalBacklog = (float) ContractFinancial::sum('nilai_backlog');
        $totalPendapatan2026 = (float) ContractFinancial::sum('nilai_2026');

        $totalBacklogFormatted = $totalBacklog >= 1_000_000_000
            ? 'Rp ' . number_format($totalBacklog / 1_000_000_000, 1, ',', '.') . 'M'
            : 'Rp ' . number_format($totalBacklog / 1_000_000, 1, ',', '.') . 'Jt';

        $totalPendapatanFormatted = $totalPendapatan2026 >= 1_000_000_000
            ? 'Rp ' . number_format($totalPendapatan2026 / 1_000_000_000, 1, ',', '.') . 'M'
            : 'Rp ' . number_format($totalPendapatan2026 / 1_000_000, 1, ',', '.') . 'Jt';

        $rkaPercentage = 45;
        if ($totalPendapatan2026 + $totalBacklog > 0) {
            $computedPct = round(($totalPendapatan2026 / ($totalPendapatan2026 + $totalBacklog)) * 100);
            $rkaPercentage = max(10, min(100, $computedPct));
        }

        return view('dashboard.index', compact(
            'totalContracts',
            'totalNilaiKontrakFormatted',
            'totalAssets',
            'avgArea',
            'yGridLabels',
            'primaryWavePath',
            'lightWavePath',
            'gradientFillPath',
            'badge1',
            'badge2',
            'upcomingContracts',
            'revenueBreakdown',
            'totalBacklogFormatted',
            'totalPendapatanFormatted',
            'rkaPercentage'
        ));
    }
}
