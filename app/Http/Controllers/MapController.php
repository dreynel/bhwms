<?php

namespace App\Http\Controllers;

use App\Models\VisitLog;
use App\Models\Household;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitLog::with(['resident.household', 'bhw'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        if ($request->filled('purok')) {
            $query->whereHas('resident.household', function ($q) use ($request) {
                $q->where('purok', $request->purok);
            });
        }

        if ($request->filled('bhw_id')) {
            $query->where('bhw_user_id', $request->bhw_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('captured_at', $request->date);
        }

        $visitLogs = $query->orderBy('captured_at', 'desc')->get();

        // Also fetch households with coordinates for map overlay
        $households = Household::whereNotNull('latitude')->whereNotNull('longitude')->get();

        $setting = BarangaySetting::first();
        $puroks = $setting->purok_list ?? ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6', 'Purok 7'];

        // Default map center: New Lucena, Iloilo (approx lat: 10.8872, lon: 122.6108)
        $centerLat = 10.8872;
        $centerLon = 122.6108;

        if ($visitLogs->count() > 0) {
            $centerLat = $visitLogs->first()->latitude;
            $centerLon = $visitLogs->first()->longitude;
        }

        return view('map.index', compact('visitLogs', 'households', 'puroks', 'centerLat', 'centerLon'));
    }
}
