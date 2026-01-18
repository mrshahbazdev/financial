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

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('analysis.pdf', compact('analysis'))->setPaper('a4', 'landscape');
        return $pdf->download('profit-first-analysis-' . $analysis->id . '.pdf');
    }
    public function updateTargets(Request $request, Analysis $analysis)
    {
        if ($analysis->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'client_name' => 'nullable|string|max:255',
            'q1_revenue_data' => 'nullable|array',
            'q2_revenue_data' => 'nullable|array',
            'q3_revenue_data' => 'nullable|array',
            'q4_revenue_data' => 'nullable|array',
            'rows_data' => 'nullable|array',
            'rows_data.*.id' => 'required|exists:analysis_rows,id',
            'rows_data.*.q1_caps' => 'required|numeric',
            'rows_data.*.q2_caps' => 'nullable|numeric',
            'rows_data.*.q3_caps' => 'nullable|numeric',
            'rows_data.*.q4_caps' => 'nullable|numeric',
        ]);

        $analysis->update([
            'client_name' => $validated['client_name'] ?? $analysis->client_name,
            'q1_revenue_data' => $validated['q1_revenue_data'] ?? $analysis->q1_revenue_data,
            'q2_revenue_data' => $validated['q2_revenue_data'] ?? $analysis->q2_revenue_data,
            'q3_revenue_data' => $validated['q3_revenue_data'] ?? $analysis->q3_revenue_data,
            'q4_revenue_data' => $validated['q4_revenue_data'] ?? $analysis->q4_revenue_data,
        ]);

        if (isset($validated['rows_data'])) {
            foreach ($validated['rows_data'] as $rowData) {
                $row = $analysis->rows()->find($rowData['id']);
                if ($row) {
                    $row->update([
                        'q1_caps' => $rowData['q1_caps'],
                        'q2_caps' => $rowData['q2_caps'] ?? $row->q2_caps,
                        'q3_caps' => $rowData['q3_caps'] ?? $row->q3_caps,
                        'q4_caps' => $rowData['q4_caps'] ?? $row->q4_caps,
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Targets updated successfully']);
    }
}
