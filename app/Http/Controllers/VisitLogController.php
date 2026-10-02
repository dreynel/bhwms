<?php

namespace App\Http\Controllers;

use App\Models\VisitLog;
use App\Models\VisitSchedule;
use App\Models\Resident;
use App\Services\GeoLocationService;
use Illuminate\Http\Request;

class VisitLogController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitLog::with(['resident.household', 'bhw', 'schedule']);

        if ($request->filled('purok')) {
            $query->whereHas('resident.household', function ($q) use ($request) {
                $q->where('purok', $request->purok);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('resident', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $logs = $query->orderBy('captured_at', 'desc')->paginate(15);
        $residents = Resident::with('household')->orderBy('last_name')->get();
        $bhws = \App\Models\User::where('role', 'bhw')->get();
        return view('visit_logs.index', compact('logs', 'residents', 'bhws'));
    }

    public function create(Request $request)
    {
        $schedule = null;
        if ($request->has('schedule_id')) {
            $schedule = VisitSchedule::with('resident.household', 'bhw')->find($request->schedule_id);
        }

        $residents = Resident::with('household')->orderBy('last_name')->get();
        return view('visit_logs.create', compact('schedule', 'residents'));
    }

    public function store(Request $request, GeoLocationService $geoService)
    {
        $validated = $request->validate([
            'visit_schedule_id' => 'nullable|exists:visit_schedules,id',
            'resident_id' => 'required|exists:residents,id',
            'bhw_user_id' => 'required|exists:users,id',
            'vitals_bp' => 'nullable|string',
            'vitals_weight_kg' => 'nullable|numeric',
            'vitals_temp_c' => 'nullable|numeric',
            'vitals_blood_sugar' => 'nullable|string',
            'health_notes' => 'required|string',
            'services_rendered' => 'required|string',
            'follow_up_needed' => 'nullable|boolean',
            'follow_up_date' => 'nullable|date',
            'follow_up_reason' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy_meters' => 'required|numeric',
            'geo_permission_granted' => 'nullable|boolean',
        ]);

        $validated['follow_up_needed'] = $request->boolean('follow_up_needed');
        $validated['geo_permission_granted'] = $request->boolean('geo_permission_granted', true);
        $validated['captured_at'] = now();

        // Verify location against household if registered
        $resident = Resident::with('household')->find($validated['resident_id']);
        if ($resident && $resident->household && $resident->household->latitude && $resident->household->longitude) {
            $visitPoint = new \App\ValueObjects\GeoCoordinates($validated['latitude'], $validated['longitude']);
            $householdPoint = new \App\ValueObjects\GeoCoordinates($resident->household->latitude, $resident->household->longitude);
            $validated['geo_verified'] = $geoService->isWithinThreshold(
                $visitPoint,
                $householdPoint,
                300.0
            );
        } else {
            $validated['geo_verified'] = true;
        }

        $log = VisitLog::create($validated);

        // Update schedule status if linked
        if ($log->visit_schedule_id) {
            VisitSchedule::where('id', $log->visit_schedule_id)->update(['status' => 'completed']);
        }

        return redirect()->route('visit-logs.show', $log)->with('success', 'Visit Activity and Geo-Location recorded successfully!');
    }

    public function show(VisitLog $visitLog)
    {
        $visitLog->load('resident.household', 'bhw', 'schedule');
        return view('visit_logs.show', compact('visitLog'));
    }
}
