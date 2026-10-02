<?php

namespace App\Http\Controllers;

use App\Models\BhwAssignment;
use App\Models\User;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;

class BhwAssignmentController extends Controller
{
    public function index()
    {
        $assignments = BhwAssignment::with('user')->orderBy('purok')->get();
        $bhws = User::where('role', 'bhw')->get();
        $setting = BarangaySetting::first();
        $puroks = $setting->purok_list ?? ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6', 'Purok 7'];

        return view('assignments.index', compact('assignments', 'bhws', 'puroks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'purok' => 'required|string',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['barangay'] = 'Poblacion';
        $validated['status'] = 'active';

        BhwAssignment::create($validated);

        return redirect()->route('assignments.index')->with('success', 'BHW Assignment recorded.');
    }

    public function destroy(BhwAssignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Assignment removed.');
    }
}
