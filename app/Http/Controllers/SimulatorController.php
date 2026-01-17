<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimulatorController extends Controller
{
    public function index()
    {
        // Fetch the simulation base (Latest Analysis)
        $analysis = Analysis::where('user_id', Auth::id())
            ->with(['rows'])
            ->latest()
            ->first();

        if (!$analysis) {
            return redirect()->route('dashboard')->with('error', 'Please create an analysis first to unlock the simulator.');
        }

        // Prepare Base Data for JS
        $baseData = [
            'revenue' => $analysis->real_revenue,
            'profit' => $analysis->rows->where('category', 'Profit')->first()->actual_amount ?? 0,
            'opex' => $analysis->rows->where('category', 'Operating Expenses')->first()->actual_amount ?? 0,
            'tax' => $analysis->rows->where('category', 'Tax')->first()->actual_amount ?? 0,
            'owner_pay' => $analysis->rows->where('category', 'Owner Pay')->first()->actual_amount ?? 0,
        ];

        return view('simulator', compact('baseData'));
    }
}
