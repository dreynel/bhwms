<?php

namespace App\Http\Controllers;

use App\Models\VisitLog;
use App\Models\VisitSchedule;
use App\Models\User;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $setting = BarangaySetting::first() ?? new BarangaySetting();
        $bhws = User::where('role', 'bhw')->get();
        return view('reports.index', compact('setting', 'bhws'));
    }

    public function completedVisits(Request $request)
    {
        $query = VisitLog::with(['resident.household', 'bhw', 'schedule']);

        if ($request->filled('start_date')) {
            $query->whereDate('captured_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('captured_at', '<=', $request->end_date);
        }
        if ($request->filled('purok')) {
            $query->whereHas('resident.household', function ($q) use ($request) {
                $q->where('purok', $request->purok);
            });
        }
        if ($request->filled('bhw_id')) {
            $query->where('bhw_user_id', $request->bhw_id);
        }

        $logs = $query->orderBy('captured_at', 'desc')->get();
        $setting = BarangaySetting::first();

        return view('reports.completed_visits', compact('logs', 'setting'));
    }

    public function pendingFollowups(Request $request)
    {
        $query = VisitLog::with(['resident.household', 'bhw'])
            ->where('follow_up_needed', true);

        if ($request->filled('purok')) {
            $query->whereHas('resident.household', function ($q) use ($request) {
                $q->where('purok', $request->purok);
            });
        }

        $logs = $query->orderBy('follow_up_date', 'asc')->get();
        $setting = BarangaySetting::first();

        return view('reports.pending_followups', compact('logs', 'setting'));
    }

    public function workerActivities(Request $request)
    {
        $bhws = User::where('role', 'bhw')
            ->withCount(['visitLogs', 'visits'])
            ->get();

        $setting = BarangaySetting::first();
        return view('reports.worker_activities', compact('bhws', 'setting'));
    }
}
