<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $analyses = Analysis::where('user_id', Auth::id())
            ->with(['rows'])
            ->latest()
            ->take(10) // Limit to last 10 for trends
            ->get();

        if ($analyses->isEmpty()) {
            return view('dashboard', [
                'hasData' => false,
                'metrics' => [],
                'chartData' => [],
                'advisor' => "Start your first analysis to unlock insights!",
            ]);
        }

        // --- 1. KPI Calculations ---
        $totalRevenueRecorded = $analyses->sum('real_revenue');
        $averageRevenue = $analyses->avg('real_revenue');

        $latestAnalysis = $analyses->first();
        // Find Profit row
        $profitRow = $latestAnalysis->rows->where('category', 'Profit')->first();
        $profitMargin = $latestAnalysis->real_revenue > 0 ? ($profitRow->actual_amount / $latestAnalysis->real_revenue) * 100 : 0;

        // --- 2. Trend Data (Chronological) ---
        $trendData = $analyses->reverse(); // Oldest first for chart
        $labels = $trendData->map(fn($a) => $a->created_at->format('M d'));
        $profitActuals = $trendData->map(function ($a) {
            return $a->rows->where('category', 'Profit')->first()->actual_amount ?? 0;
        });
        $profitTargets = $trendData->map(function ($a) {
            return $a->rows->where('category', 'Profit')->first()->pf_amount ?? 0;
        });

        // --- 3. AI Advisor Logic ---
        $advisorMessage = "Analyzing your recent performance...";
        $status = "neutral"; // positive, warning, neutral

        if ($profitRow->bleed < 0) {
            // Negative bleed = Actual < Target (For Profit, this is bad in PF terms if we treat bleed as "Actual - Target"??)
            // Wait, previous logic: Bleed = Actual - PF.
            // If Profit Actual (80) < Target (100) = -20 Bleed. 
            // Negative bleed in profit means SHORTFALL.
            $advisorMessage = "⚠️ Alert: Your profit is below target by $" . number_format(abs($profitRow->bleed)) . ". Look at cutting OPEX.";
            $status = "warning";
        } elseif ($profitRow->bleed >= 0) {
            $advisorMessage = "🚀 Great job! You hit your profit target this period. Consider increasing your Owner Pay allocation next.";
            $status = "positive";
        }

        return view('dashboard', [
            'hasData' => true,
            'metrics' => [
                'total_revenue' => $totalRevenueRecorded,
                'latest_revenue' => $latestAnalysis->real_revenue,
                'profit_margin' => $profitMargin,
                'latest_date' => $latestAnalysis->created_at->format('M d, Y'),
            ],
            'chartData' => [
                'labels' => $labels->values(),
                'profitActuals' => $profitActuals->values(),
                'profitTargets' => $profitTargets->values(),
            ],
            'advisor' => [
                'message' => $advisorMessage,
                'status' => $status
            ]
        ]);
    }
}
