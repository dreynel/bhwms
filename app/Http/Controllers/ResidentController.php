<?php

namespace App\Http\Controllers;

use App\Contracts\ResidentRepositoryInterface;
use App\Contracts\HouseholdRepositoryInterface;
use App\Models\Resident;
use Illuminate\Http\Request;

/**
 * Controller managing Resident HTTP endpoints (OOP Principle: Dependency Injection & Repository Pattern)
 */
class ResidentController extends Controller
{
    private ResidentRepositoryInterface $residentRepo;
    private HouseholdRepositoryInterface $householdRepo;

    public function __construct(
        ResidentRepositoryInterface $residentRepo,
        HouseholdRepositoryInterface $householdRepo
    ) {
        $this->residentRepo = $residentRepo;
        $this->householdRepo = $householdRepo;
    }

    public function index(Request $request)
    {
        $residents = $this->residentRepo->getFilteredPaginated(
            $request->query('search'),
            $request->query('vulnerability'),
            $request->query('purok'),
            15
        );

        $households = $this->householdRepo->getAllHouseholds();

        return view('residents.index', compact('residents', 'households'));
    }

    public function create()
    {
        $households = $this->householdRepo->getAllHouseholds();
        return view('residents.create', compact('households'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'household_id' => 'required|exists:households,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'date_of_birth' => 'required|date',
            'sex' => 'required|string|in:Male,Female',
            'civil_status' => 'required|string',
            'contact_number' => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:30',
            'immunization_status' => 'nullable|string',
            'medical_notes' => 'nullable|string',
        ]);

        $validated['is_head'] = $request->boolean('is_head');
        $validated['is_pregnant'] = $request->boolean('is_pregnant');
        $validated['is_lactating'] = $request->boolean('is_lactating');
        $validated['is_infant'] = $request->boolean('is_infant');
        $validated['is_senior'] = $request->boolean('is_senior');
        $validated['is_pwd'] = $request->boolean('is_pwd');
        $validated['has_hypertension'] = $request->boolean('has_hypertension');
        $validated['has_diabetes'] = $request->boolean('has_diabetes');
        $validated['has_malnutrition'] = $request->boolean('has_malnutrition');

        $resident = $this->residentRepo->create($validated);

        return redirect()->route('residents.show', $resident)->with('success', 'Resident record created successfully.');
    }

    public function show(Resident $resident)
    {
        $resident = $this->residentRepo->findById($resident->id);
        $bhws = \App\Models\User::where('role', 'bhw')->get();
        return view('residents.show', compact('resident', 'bhws'));
    }

    public function edit(Resident $resident)
    {
        $households = $this->householdRepo->getAllHouseholds();
        return view('residents.edit', compact('resident', 'households'));
    }

    public function update(Request $request, Resident $resident)
    {
        $validated = $request->validate([
            'household_id' => 'required|exists:households,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:50',
            'date_of_birth' => 'required|date',
            'sex' => 'required|string|in:Male,Female',
            'civil_status' => 'required|string',
            'contact_number' => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:30',
            'immunization_status' => 'nullable|string',
            'medical_notes' => 'nullable|string',
        ]);

        $validated['is_head'] = $request->boolean('is_head');
        $validated['is_pregnant'] = $request->boolean('is_pregnant');
        $validated['is_lactating'] = $request->boolean('is_lactating');
        $validated['is_infant'] = $request->boolean('is_infant');
        $validated['is_senior'] = $request->boolean('is_senior');
        $validated['is_pwd'] = $request->boolean('is_pwd');
        $validated['has_hypertension'] = $request->boolean('has_hypertension');
        $validated['has_diabetes'] = $request->boolean('has_diabetes');
        $validated['has_malnutrition'] = $request->boolean('has_malnutrition');

        $this->residentRepo->update($resident, $validated);

        return redirect()->route('residents.show', $resident)->with('success', 'Resident health profile updated.');
    }

    public function destroy(Resident $resident)
    {
        $this->residentRepo->delete($resident);
        return redirect()->route('residents.index')->with('success', 'Resident record deleted.');
    }
}
