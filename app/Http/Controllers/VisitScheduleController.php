<?php

namespace App\Http\Controllers;

use App\Models\VisitSchedule;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request;

class VisitScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitSchedule::with(['resident.household', 'bhw']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('visit_type')) {
            $query->where('visit_type', $request->visit_type);
        }

        if ($request->filled('bhw_id')) {
            $query->where('bhw_user_id', $request->bhw_id);
        }

        $schedules = $query->orderBy('scheduled_date', 'asc')->paginate(15);
        $residents = Resident::orderBy('last_name')->get();
        $bhws = User::where('role', 'bhw')->get();

        return view('visits.index', compact('schedules', 'residents', 'bhws'));
    }

    public function create()
    {
        $residents = Resident::with('household')->orderBy('last_name')->get();
        $bhws = User::where('role', 'bhw')->get();
        return view('visits.create', compact('residents', 'bhws'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'bhw_user_id' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'nullable',
            'visit_type' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'notes' => 'nullable|string',
        ]);

        VisitSchedule::create($validated);

        return redirect()->route('visits.index')->with('success', 'Visit schedule saved successfully.');
    }

    public function updateStatus(Request $request, VisitSchedule $schedule)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,rescheduled,cancelled',
        ]);

        $schedule->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Schedule status updated to ' . ucfirst($validated['status']));
    }
}
