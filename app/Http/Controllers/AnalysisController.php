<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Tap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{
    public function index()
    {
        $analyses = Analysis::where('user_id', Auth::id())->with('rows')->latest()->get();
        return view('analysis.index', compact('analyses'));
    }

    public function create()
    {
        // Fetch System Taps + User's Custom Taps
        $taps = Tap::whereNull('user_id')->orWhere('user_id', Auth::id())->get();
        return view('analysis.create', compact('taps'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'real_revenue' => 'required|numeric|min:0',
            'tap_id' => 'required|exists:taps,id',
            'actual_profit' => 'required|numeric',
            'actual_pay' => 'required|numeric',
            'actual_tax' => 'required|numeric',
            'actual_opex' => 'required|numeric',
        ]);

        // Auto-detect TAP based on Real Revenue
        $tap = Tap::where(function ($query) use ($validated) {
            $query->where('min_revenue', '<=', $validated['real_revenue'])
                ->where('max_revenue', '>=', $validated['real_revenue']);
        })->orWhere(function ($query) use ($validated) {
            // Fallback for custom TAPS without ranges or if no range matches (picking first matching custom or system)
            $query->whereNull('min_revenue')->where('id', $validated['tap_id'] ?? 0);
        })->first();

        // If no TAP found via range, fallback to the submitted ID or fail
        if (!$tap) {
            $tap = Tap::findOrFail($validated['tap_id']);
        }

        // Create Analysis Header
        $analysis = Analysis::create([
            'user_id' => Auth::id(),
            'real_revenue' => $validated['real_revenue'],
        ]);

        // Categories to process
        $categories = [
            'Profit' => ['actual' => $validated['actual_profit'], 'tap' => $tap->profit],
            'Owner Pay' => ['actual' => $validated['actual_pay'], 'tap' => $tap->owner_pay],
            'Tax' => ['actual' => $validated['actual_tax'], 'tap' => $tap->tax],
            'Operating Expenses' => ['actual' => $validated['actual_opex'], 'tap' => $tap->opex],
        ];

        foreach ($categories as $name => $data) {
            $pf_amount = $validated['real_revenue'] * ($data['tap'] / 100);
            $bleed = $data['actual'] - $pf_amount;

            // Fix Logic per user request:
            // Delta (bleed) < 0 => Increase (erhöhen)
            // Delta (bleed) > 0 => Decrease (verringern)
            $fix = $bleed < 0 ? 'Increase' : 'Decrease';

            if ($bleed == 0) {
                $fix = 'On Track';
            }

            $analysis->rows()->create([
                'category' => $name,
                'actual_amount' => $data['actual'],
                'taps_percentage' => $data['tap'],
                'pf_amount' => $pf_amount,
                'bleed' => $bleed,
                'fix' => $bleed < 0 ? 'Increase' : 'Decrease',
                'haps' => ($validated['real_revenue'] > 0) ? ($data['actual'] / $validated['real_revenue'] * 100) : 0,
                // Initialize CAPS with TAPS for now (simplification)
                'q1_caps' => $data['tap'],
                'q2_caps' => $data['tap'],
                'q3_caps' => $data['tap'],
                'q4_caps' => $data['tap'],
            ]);
        }

        return redirect()->route('analyses.show', $analysis);
    }

    public function show(Analysis $analysis)
    {
        if ($analysis->user_id !== Auth::id()) {
            abort(403);
        }
        $analysis->load('rows');
        return view('analysis.show', compact('analysis'));
    }

    public function downloadPdf(Analysis $analysis)
    {
        if ($analysis->user_id !== Auth::id()) {
            abort(403);
        }
        $analysis->load('rows');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('analysis.pdf', compact('analysis'));
        return $pdf->download('profit-first-analysis-' . $analysis->id . '.pdf');
    }
    public function updateTargets(Request $request, Analysis $analysis)
    {
        if ($analysis->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'q1_revenue_data' => 'nullable|array',
            'monthly_caps' => 'nullable|array',
        ]);

        // Save Q1 Revenue Data
        if (isset($validated['q1_revenue_data'])) {
            $analysis->update(['q1_revenue_data' => $validated['q1_revenue_data']]);
        }

        // Save Custom Caps per Row
        // monthly_caps comes as { jan: { 'Profit': 5, ... }, feb: ... }
        if (isset($validated['monthly_caps'])) {
            foreach ($analysis->rows as $row) {
                $category = $row->category; // e.g., 'Profit'
                $customData = [];

                // Extract this category's caps for each month
                foreach (['jan', 'feb', 'mar'] as $month) {
                    if (isset($validated['monthly_caps'][$month][$category])) {
                        $customData[$month] = $validated['monthly_caps'][$month][$category];
                    }
                }

                if (!empty($customData)) {
                    $row->update(['custom_caps_data' => $customData]);
                }
            }
        }

        return response()->json(['message' => 'Targets updated successfully']);
    }
}
