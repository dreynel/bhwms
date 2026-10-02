<?php

namespace App\Http\Controllers;

use App\Contracts\HouseholdRepositoryInterface;
use App\Models\Household;
use App\Models\BarangaySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller managing Household HTTP interactions (OOP Principle: Single Responsibility & Dependency Injection)
 */
class HouseholdController extends Controller
{
    private HouseholdRepositoryInterface $householdRepo;

    public function __construct(HouseholdRepositoryInterface $householdRepo)
    {
        $this->householdRepo = $householdRepo;
    }

    public function index(Request $request)
    {
        $households = $this->householdRepo->getFilteredPaginated(
            $request->query('search'),
            $request->query('purok'),
            15
        );

        $setting = BarangaySetting::first();
        $puroks = $setting->purok_list ?? ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6', 'Purok 7'];

        return view('households.index', compact('households', 'puroks'));
    }

    public function create()
    {
        $setting = BarangaySetting::first();
        $puroks = $setting->purok_list ?? ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6', 'Purok 7'];
        return view('households.create', compact('puroks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'household_number' => 'required|unique:households,household_number',
            'head_name' => 'required|string|max:255',
            'purok' => 'required|string',
            'water_source' => 'required|string',
            'sanitary_toilet' => 'required|string',
            'income_bracket' => 'required|string',
            'address_details' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $validated['barangay'] = 'Poblacion';
        $validated['municipality'] = 'New Lucena';
        $validated['province'] = 'Iloilo';
        $validated['created_by'] = Auth::id();

        $this->householdRepo->create($validated);

        return redirect()->route('households.index')->with('success', 'Household Profile registered successfully.');
    }

    public function show(Household $household)
    {
        $household = $this->householdRepo->findById($household->id);
        return view('households.show', compact('household'));
    }

    public function edit(Household $household)
    {
        $setting = BarangaySetting::first();
        $puroks = $setting->purok_list ?? ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6', 'Purok 7'];
        return view('households.edit', compact('household', 'puroks'));
    }

    public function update(Request $request, Household $household)
    {
        $validated = $request->validate([
            'household_number' => 'required|unique:households,household_number,' . $household->id,
            'head_name' => 'required|string|max:255',
            'purok' => 'required|string',
            'water_source' => 'required|string',
            'sanitary_toilet' => 'required|string',
            'income_bracket' => 'required|string',
            'address_details' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $this->householdRepo->update($household, $validated);

        return redirect()->route('households.show', $household)->with('success', 'Household Profile updated successfully.');
    }

    public function destroy(Household $household)
    {
        $this->householdRepo->delete($household);
        return redirect()->route('households.index')->with('success', 'Household deleted successfully.');
    }
}
