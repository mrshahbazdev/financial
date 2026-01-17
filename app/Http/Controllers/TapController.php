<?php

namespace App\Http\Controllers;

use App\Models\Tap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show System Defaults (user_id = null) and User's Custom Taps
        $systemTaps = Tap::whereNull('user_id')->get();
        $myTaps = Tap::where('user_id', Auth::id())->get();

        return view('taps.index', compact('systemTaps', 'myTaps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('taps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'industry' => 'required|string|max:255',
            'profit' => 'required|numeric|min:0|max:100',
            'owner_pay' => 'required|numeric|min:0|max:100',
            'tax' => 'required|numeric|min:0|max:100',
            'opex' => 'required|numeric|min:0|max:100',
        ]);

        // Simple validation: Ensure sum is 100% (Optional, but good practice)
        $sum = $validated['profit'] + $validated['owner_pay'] + $validated['tax'] + $validated['opex'];
        if ($sum != 100) {
            return back()->withErrors(['industry' => "Total percentage must equal 100%. Current sum: $sum%"])->withInput();
        }

        Tap::create([
            'user_id' => Auth::id(),
            'industry' => $validated['industry'],
            'profit' => $validated['profit'],
            'owner_pay' => $validated['owner_pay'],
            'tax' => $validated['tax'],
            'opex' => $validated['opex'],
        ]);

        return redirect()->route('taps.index')->with('success', 'Industry created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tap $tap)
    {
        if ($tap->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $tap->delete();

        return redirect()->route('taps.index')->with('success', 'Industry deleted successfully.');
    }
}
