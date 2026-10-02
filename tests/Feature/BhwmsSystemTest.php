<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Household;
use App\Models\Resident;
use App\Models\VisitSchedule;
use App\Models\VisitLog;
use App\Models\IsoEvaluation;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BhwmsSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $bhw;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::where('role', 'admin')->first();
        $this->bhw = User::where('role', 'bhw')->first();
    }

    #[Test]
    public function unauthenticated_user_is_redirected_to_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)->get('/');
        $response->assertStatus(200);
        $response->assertSee('Health Management System');
    }

    #[Test]
    public function can_create_new_household_profile()
    {
        $response = $this->actingAs($this->bhw)->post('/households', [
            'household_number' => 'HH-POB-999',
            'head_name' => 'Juan Dela Cruz',
            'purok' => 'Purok 1',
            'water_source' => 'Level III - Waterworks System',
            'sanitary_toilet' => 'Water-sealed Sanitary Toilet',
            'income_bracket' => 'Low-Income / NTHP',
            'address_details' => 'Near Plaza',
            'latitude' => 10.8872,
            'longitude' => 122.6108,
        ]);

        $response->assertRedirect('/households');
        $this->assertDatabaseHas('households', [
            'household_number' => 'HH-POB-999',
            'head_name' => 'Juan Dela Cruz',
        ]);
    }

    #[Test]
    public function can_register_resident_with_vulnerability_flags()
    {
        $household = Household::first();

        $response = $this->actingAs($this->bhw)->post('/residents', [
            'household_id' => $household->id,
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'date_of_birth' => '1995-04-10',
            'sex' => 'Female',
            'civil_status' => 'Married',
            'contact_number' => '09171112233',
            'is_pregnant' => 1,
            'has_hypertension' => 1,
        ]);

        $this->assertDatabaseHas('residents', [
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'is_pregnant' => 1,
            'has_hypertension' => 1,
        ]);
    }

    #[Test]
    public function can_schedule_visit()
    {
        $resident = Resident::first();

        $response = $this->actingAs($this->bhw)->post('/visits', [
            'resident_id' => $resident->id,
            'bhw_user_id' => $this->bhw->id,
            'scheduled_date' => now()->addDay()->toDateString(),
            'scheduled_time' => '10:00',
            'visit_type' => 'maternal_checkup',
            'priority' => 'high',
            'notes' => 'Prenatal monitoring',
        ]);

        $response->assertRedirect('/visits');
        $this->assertDatabaseHas('visit_schedules', [
            'resident_id' => $resident->id,
            'visit_type' => 'maternal_checkup',
        ]);
    }

    #[Test]
    public function can_log_visit_with_gps_location_capture()
    {
        $resident = Resident::first();

        $response = $this->actingAs($this->bhw)->post('/visit-logs', [
            'resident_id' => $resident->id,
            'bhw_user_id' => $this->bhw->id,
            'vitals_bp' => '120/80',
            'vitals_weight_kg' => 60.5,
            'vitals_temp_c' => 36.6,
            'services_rendered' => 'Prenatal Counseling',
            'health_notes' => 'Patient in good health',
            'latitude' => 10.8875,
            'longitude' => 122.6108,
            'accuracy_meters' => 3.5,
            'geo_permission_granted' => 1,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('visit_logs', [
            'resident_id' => $resident->id,
            'latitude' => 10.8875,
            'accuracy_meters' => 3.5,
        ]);
    }

    #[Test]
    public function iso_25010_mean_and_verbal_interpretation_calculation()
    {
        $scores = [5.0, 4.8, 4.9, 5.0, 4.7, 4.9, 4.8, 5.0];
        $mean = IsoEvaluation::calculateMean($scores);
        $interpretation = IsoEvaluation::getInterpretation($mean);

        $this->assertEquals(4.89, $mean);
        $this->assertStringContainsString('Excellent', $interpretation);
    }

    #[Test]
    public function geo_location_service_calculates_distance_correctly()
    {
        $geoService = app(\App\Contracts\GeoCalculatorInterface::class);

        // Poblacion Plaza coordinates
        $pointA = new \App\ValueObjects\GeoCoordinates(10.887200, 122.610800);
        // Point ~100 meters away
        $pointB = new \App\ValueObjects\GeoCoordinates(10.887800, 122.610800);

        $distance = $geoService->calculateDistance($pointA, $pointB);
        $this->assertGreaterThan(50, $distance);
        $this->assertLessThan(150, $distance);

        $isWithin = $geoService->isWithinThreshold($pointA, $pointB, 200.0);
        $this->assertTrue($isWithin);

        $isNotWithin = $geoService->isWithinThreshold($pointA, $pointB, 30.0);
        $this->assertFalse($isNotWithin);
    }

    #[Test]
    public function health_vitals_value_object_evaluates_bp()
    {
        $normalVitals = new \App\ValueObjects\HealthVitals('118/78', 60.0, 36.6, '90 mg/dL');
        $this->assertTrue($normalVitals->isNormalBp());

        $elevatedVitals = new \App\ValueObjects\HealthVitals('145/95', 72.0, 37.0, '140 mg/dL');
        $this->assertFalse($elevatedVitals->isNormalBp());
    }

    #[Test]
    public function authenticated_user_can_access_iso_evaluation_and_reports()
    {
        $response = $this->actingAs($this->admin)->get('/iso-evaluation');
        $response->assertStatus(200);
        $response->assertSee('ISO/IEC 25010');

        $reportsResponse = $this->actingAs($this->admin)->get('/reports');
        $reportsResponse->assertStatus(200);

        $mapResponse = $this->actingAs($this->admin)->get('/map');
        $mapResponse->assertStatus(200);
    }

    #[Test]
    public function all_modules_and_registries_render_modular_modal_dialogs()
    {
        // 1. Dashboard Quick Modals
        $dash = $this->actingAs($this->admin)->get('/');
        $dash->assertStatus(200);
        $dash->assertSee('dash-schedule-modal');
        $dash->assertSee('dash-log-modal');
        $dash->assertSee('dash-household-modal');

        // 2. Households Registry Modal
        $households = $this->actingAs($this->admin)->get('/households');
        $households->assertStatus(200);
        $households->assertSee('add-household-modal');

        // 3. Residents Registry Modal
        $residents = $this->actingAs($this->admin)->get('/residents');
        $residents->assertStatus(200);
        $residents->assertSee('add-resident-modal');

        // 4. Visit Schedules Registry Modal
        $visits = $this->actingAs($this->admin)->get('/visits');
        $visits->assertStatus(200);
        $visits->assertSee('schedule-visit-modal');

        // 5. Recorded Field Activities / GPS Logs Modal
        $visitLogs = $this->actingAs($this->admin)->get('/visit-logs');
        $visitLogs->assertStatus(200);
        $visitLogs->assertSee('log-visit-modal');

        // 6. BHW Purok Assignments Modal
        $assignments = $this->actingAs($this->admin)->get('/assignments');
        $assignments->assertStatus(200);
        $assignments->assertSee('add-assignment-modal');

        // 7. Official Reports Hub Filter Modals
        $reports = $this->actingAs($this->admin)->get('/reports');
        $reports->assertStatus(200);
        $reports->assertSee('filter-completed-visits-modal');

        // 8. Digitized Forms & Barangay Settings Modal
        $forms = $this->actingAs($this->admin)->get('/forms');
        $forms->assertStatus(200);
        $forms->assertSee('edit-settings-modal');

        // 9. ISO/IEC 25010 Quality Rating Modal
        $iso = $this->actingAs($this->admin)->get('/iso-evaluation');
        $iso->assertStatus(200);
        $iso->assertSee('submit-evaluation-modal');
    }
}
