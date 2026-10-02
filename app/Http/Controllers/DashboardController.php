<?php

namespace App\Http\Controllers;

use App\Models\Household;
use App\Models\Resident;
use App\Models\VisitSchedule;
use App\Models\VisitLog;
use App\Models\User;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $setting = BarangaySetting::first() ?? new BarangaySetting();
        $totalHouseholds = Household::count();
        $totalResidents = Resident::count();
        $totalBhws = User::where('role', 'bhw')->count();

        // Vulnerability Counts
        $pregnantCount = Resident::where('is_pregnant', true)->count();
        $infantCount = Resident::where('is_infant', true)->count();
        $seniorCount = Resident::where('is_senior', true)->count();
        $pwdCount = Resident::where('is_pwd', true)->count();
        $chronicCount = Resident::where('has_hypertension', true)->orWhere('has_diabetes', true)->count();

        // Visit Counters
        $pendingVisits = VisitSchedule::where('status', 'scheduled')->count();
        $completedVisits = VisitSchedule::where('status', 'completed')->count();
        $pendingFollowups = VisitLog::where('follow_up_needed', true)
            ->where(function ($q) {
                $q->whereNull('follow_up_date')
                  ->orWhere('follow_up_date', '>=', now()->toDateString());
            })->count();

        // Recent Schedules
        $recentSchedules = VisitSchedule::with(['resident', 'bhw'])
            ->orderBy('scheduled_date', 'asc')
            ->limit(5)
            ->get();

        // Recent Completed Visits with Location
        $recentVisits = VisitLog::with(['resident', 'bhw', 'schedule'])
            ->orderBy('captured_at', 'desc')
            ->limit(5)
            ->get();

        $residents = Resident::orderBy('last_name')->get();
        $bhws = User::where('role', 'bhw')->get();

        return view('dashboard.index', compact(
            'setting', 'totalHouseholds', 'totalResidents', 'totalBhws',
            'pregnantCount', 'infantCount', 'seniorCount', 'pwdCount', 'chronicCount',
            'pendingVisits', 'completedVisits', 'pendingFollowups',
            'recentSchedules', 'recentVisits', 'residents', 'bhws'
        ));
    }
}
