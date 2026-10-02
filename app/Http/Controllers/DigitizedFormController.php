<?php

namespace App\Http\Controllers;

use App\Models\BarangaySetting;
use Illuminate\Http\Request;

class DigitizedFormController extends Controller
{
    public function index()
    {
        $setting = BarangaySetting::first() ?? new BarangaySetting();
        return view('forms.index', compact('setting'));
    }

    public function targetClientListMaternal()
    {
        $setting = BarangaySetting::first();
        return view('forms.target_client_maternal', compact('setting'));
    }

    public function childImmunizationTracker()
    {
        $setting = BarangaySetting::first();
        return view('forms.child_immunization', compact('setting'));
    }

    public function householdSurveyForm()
    {
        $setting = BarangaySetting::first();
        return view('forms.household_survey', compact('setting'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'barangay_name' => 'required|string',
            'municipality' => 'required|string',
            'province' => 'required|string',
            'captain_name' => 'required|string',
            'health_officer_name' => 'required|string',
            'contact_phone' => 'required|string',
            'office_address' => 'required|string',
            'system_announcement' => 'nullable|string',
        ]);

        $setting = BarangaySetting::first() ?? new BarangaySetting();
        $setting->fill($validated);
        $setting->save();

        return redirect()->back()->with('success', 'Barangay System settings updated successfully.');
    }
}
