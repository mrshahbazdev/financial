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

        $tap = Tap::findOrFail($validated['tap_id']);

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
            $fix = $bleed < 0 ? 'Decrease' : 'Increase'; // Correct logic? 
            // User said: Bleed = Actual - PF$.
            // If Actual (100) > PF$ (80), Bleed is +20 (Positive). "The Bleed".
            // If Bleed is positive, do we Increase or Decrease?
            // Usually if Expense is higher than PF, we need to DECREASE expense.
            // If Profit is higher than PF, that's good?
            // Wait, "The Fix (Increase / Decrease suggestion)".
            // If Actual Expense > Target (PF), bleed is positive. We need to Decrease expense.
            // If Actual Profit < Target, bleed is negative. We need to Increase profit.
            // But the prompt says: "$fix = $bleed < 0 ? 'Increase' : 'Decrease';"
            // Let's follow the prompt's formula explicitly for now.
            // PROMPT: "$fix = $bleed < 0 ? 'Increase' : 'Decrease';"

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
}
