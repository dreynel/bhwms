<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BarangaySetting;
use App\Models\Household;
use App\Models\Resident;
use App\Models\BhwAssignment;
use App\Models\VisitSchedule;
use App\Models\VisitLog;
use App\Models\IsoEvaluation;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Barangay Settings
        BarangaySetting::create([
            'barangay_name' => 'Poblacion',
            'municipality' => 'New Lucena',
            'province' => 'Iloilo',
            'captain_name' => 'Hon. Jose R. Maravilla',
            'health_officer_name' => 'Dr. Maria Santos, MD',
            'contact_phone' => '(033) 540-1234',
            'office_address' => 'Barangay Health Station, Poblacion, New Lucena, 5005 Iloilo',
            'purok_list' => ['Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6', 'Purok 7'],
            'system_announcement' => 'BHW Health Caravan & Maternal Care Immunization scheduled this Thursday at Barangay Hall.',
        ]);

        // 2. Users
        $admin = User::create([
            'name' => 'Hon. Jose R. Maravilla (Admin)',
            'email' => 'admin@newlucena.gov.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone_number' => '09171234567',
            'purok' => 'Purok 1',
            'assigned_barangay' => 'Poblacion',
        ]);

        $supervisor = User::create([
            'name' => 'Dr. Maria Santos (Health Supervisor)',
            'email' => 'supervisor@newlucena.gov.ph',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'phone_number' => '09189876543',
            'purok' => 'Purok 1',
            'assigned_barangay' => 'Poblacion',
        ]);

        $bhw1 = User::create([
            'name' => 'Ana Garcia (BHW)',
            'email' => 'bhw1@newlucena.gov.ph',
            'password' => Hash::make('password'),
            'role' => 'bhw',
            'phone_number' => '09195551111',
            'purok' => 'Purok 1',
            'assigned_barangay' => 'Poblacion',
        ]);

        $bhw2 = User::create([
            'name' => 'Maria Clara (BHW)',
            'email' => 'bhw2@newlucena.gov.ph',
            'password' => Hash::make('password'),
            'role' => 'bhw',
            'phone_number' => '09195552222',
            'purok' => 'Purok 3',
            'assigned_barangay' => 'Poblacion',
        ]);

        $bhw3 = User::create([
            'name' => 'Juana Dela Cruz (BHW)',
            'email' => 'bhw3@newlucena.gov.ph',
            'password' => Hash::make('password'),
            'role' => 'bhw',
            'phone_number' => '09195553333',
            'purok' => 'Purok 5',
            'assigned_barangay' => 'Poblacion',
        ]);

        // 3. BHW Worker Assignments
        BhwAssignment::create(['user_id' => $bhw1->id, 'purok' => 'Purok 1', 'assigned_date' => now()->subMonths(6)]);
        BhwAssignment::create(['user_id' => $bhw1->id, 'purok' => 'Purok 2', 'assigned_date' => now()->subMonths(6)]);
        BhwAssignment::create(['user_id' => $bhw2->id, 'purok' => 'Purok 3', 'assigned_date' => now()->subMonths(6)]);
        BhwAssignment::create(['user_id' => $bhw2->id, 'purok' => 'Purok 4', 'assigned_date' => now()->subMonths(6)]);
        BhwAssignment::create(['user_id' => $bhw3->id, 'purok' => 'Purok 5', 'assigned_date' => now()->subMonths(6)]);

        // 4. Households in Poblacion, New Lucena, Iloilo with GPS coordinates
        $h1 = Household::create([
            'household_number' => 'HH-POB-001',
            'head_name' => 'Roberto Gonzales',
            'purok' => 'Purok 1',
            'address_details' => 'Near Municipal Plaza, Poblacion',
            'water_source' => 'Level III - Waterworks System',
            'sanitary_toilet' => 'Water-sealed Sanitary Toilet',
            'income_bracket' => 'Low-Income / NTHP',
            'latitude' => 10.887500,
            'longitude' => 122.610800,
            'created_by' => $bhw1->id,
        ]);

        $h2 = Household::create([
            'household_number' => 'HH-POB-002',
            'head_name' => 'Elena Magbanua',
            'purok' => 'Purok 2',
            'address_details' => 'Purok 2 Highway, Poblacion',
            'water_source' => 'Level II - Communal Faucet',
            'sanitary_toilet' => 'Water-sealed Sanitary Toilet',
            'income_bracket' => '4Ps Beneficiary',
            'latitude' => 10.888100,
            'longitude' => 122.611500,
            'created_by' => $bhw1->id,
        ]);

        $h3 = Household::create([
            'household_number' => 'HH-POB-003',
            'head_name' => 'Fernando Villanueva',
            'purok' => 'Purok 3',
            'address_details' => 'Riverside Area, Purok 3, Poblacion',
            'water_source' => 'Level I - Protected Well',
            'sanitary_toilet' => 'Pour Flush Toilet',
            'income_bracket' => 'Low-Income',
            'latitude' => 10.886900,
            'longitude' => 122.609800,
            'created_by' => $bhw2->id,
        ]);

        $h4 = Household::create([
            'household_number' => 'HH-POB-004',
            'head_name' => 'Lourdes Sonza',
            'purok' => 'Purok 5',
            'address_details' => 'Near Elementary School, Purok 5',
            'water_source' => 'Level III - Waterworks System',
            'sanitary_toilet' => 'Water-sealed Sanitary Toilet',
            'income_bracket' => 'Middle Class',
            'latitude' => 10.889200,
            'longitude' => 122.612200,
            'created_by' => $bhw3->id,
        ]);

        // 5. Residents with Vulnerability Flags
        $r1 = Resident::create([
            'household_id' => $h1->id,
            'family_code' => 'FAM-001',
            'first_name' => 'Teresa',
            'middle_name' => 'Cruz',
            'last_name' => 'Gonzales',
            'date_of_birth' => '1998-05-14',
            'sex' => 'Female',
            'civil_status' => 'Married',
            'contact_number' => '09179998811',
            'philhealth_number' => '12-054329871-9',
            'is_head' => false,
            'is_pregnant' => true,
            'is_lactating' => false,
            'medical_notes' => 'Prenatal 2nd Trimester, BP monitoring needed',
        ]);

        $r2 = Resident::create([
            'household_id' => $h1->id,
            'family_code' => 'FAM-001',
            'first_name' => 'Baby Lucas',
            'middle_name' => 'Gonzales',
            'last_name' => 'Gonzales',
            'date_of_birth' => '2025-11-10',
            'sex' => 'Male',
            'civil_status' => 'Single',
            'contact_number' => '09179998811',
            'philhealth_number' => 'N/A',
            'is_head' => false,
            'is_infant' => true,
            'immunization_status' => 'Pentavalent 2 completed',
            'medical_notes' => 'Scheduled for MMR vaccine next month',
        ]);

        $r3 = Resident::create([
            'household_id' => $h2->id,
            'family_code' => 'FAM-002',
            'first_name' => 'Elena',
            'middle_name' => 'Rios',
            'last_name' => 'Magbanua',
            'date_of_birth' => '1954-08-20',
            'sex' => 'Female',
            'civil_status' => 'Widowed',
            'contact_number' => '09187776622',
            'philhealth_number' => '18-987654321-0',
            'is_head' => true,
            'is_senior' => true,
            'has_hypertension' => true,
            'has_diabetes' => true,
            'medical_notes' => 'Senior Wellness maintenance meds: Amlodipine 5mg & Metformin 500mg',
        ]);

        $r4 = Resident::create([
            'household_id' => $h3->id,
            'family_code' => 'FAM-003',
            'first_name' => 'Fernando Jr.',
            'middle_name' => 'Bautista',
            'last_name' => 'Villanueva',
            'date_of_birth' => '2010-03-15',
            'sex' => 'Male',
            'civil_status' => 'Single',
            'contact_number' => '09194445566',
            'philhealth_number' => 'N/A',
            'is_head' => false,
            'is_pwd' => true,
            'medical_notes' => 'Orthopedic disability, routine physical therapy follow-up',
        ]);

        $r5 = Resident::create([
            'household_id' => $h4->id,
            'family_code' => 'FAM-004',
            'first_name' => 'Lourdes',
            'middle_name' => 'Sonza',
            'last_name' => 'Sonza',
            'date_of_birth' => '1958-12-05',
            'sex' => 'Female',
            'civil_status' => 'Married',
            'contact_number' => '09193339999', // Ends in 99 for simulated failure test
            'philhealth_number' => '15-112233445-6',
            'is_head' => true,
            'is_senior' => true,
            'has_hypertension' => true,
            'medical_notes' => 'Senior maintenance checkup',
        ]);

        // 6. Visit Schedules
        $s1 = VisitSchedule::create([
            'resident_id' => $r1->id,
            'bhw_user_id' => $bhw1->id,
            'scheduled_date' => now()->subDays(2),
            'scheduled_time' => '09:00:00',
            'visit_type' => 'maternal_checkup',
            'priority' => 'high',
            'notes' => 'Maternal prenatal checkup & iron supplements distribution',
            'status' => 'completed',
        ]);

        $s2 = VisitSchedule::create([
            'resident_id' => $r2->id,
            'bhw_user_id' => $bhw1->id,
            'scheduled_date' => now()->addDays(1),
            'scheduled_time' => '10:30:00',
            'visit_type' => 'child_immunization',
            'priority' => 'urgent',
            'notes' => 'Child weight monitoring & Vitamin A drops',
            'status' => 'scheduled',
        ]);

        $s3 = VisitSchedule::create([
            'resident_id' => $r3->id,
            'bhw_user_id' => $bhw1->id,
            'scheduled_date' => now()->subDays(5),
            'scheduled_time' => '14:00:00',
            'visit_type' => 'senior_wellness',
            'priority' => 'medium',
            'notes' => 'Blood pressure check & glucometer testing',
            'status' => 'completed',
        ]);

        $s4 = VisitSchedule::create([
            'resident_id' => $r5->id,
            'bhw_user_id' => $bhw3->id,
            'scheduled_date' => now()->addDays(3),
            'scheduled_time' => '09:30:00',
            'visit_type' => 'senior_wellness',
            'priority' => 'medium',
            'notes' => 'Maintenance medicine verification',
            'status' => 'scheduled',
        ]);

        // 7. Visit Logs with Geolocation capture (Specific Objective 4)
        VisitLog::create([
            'visit_schedule_id' => $s1->id,
            'resident_id' => $r1->id,
            'bhw_user_id' => $bhw1->id,
            'vitals_bp' => '118/78',
            'vitals_weight_kg' => 62.5,
            'vitals_temp_c' => 36.6,
            'vitals_blood_sugar' => '95 mg/dL',
            'health_notes' => 'Fetal heart tone normal. Mother feeling well. Given Ferrous Sulfate + Folic Acid 30 tabs.',
            'services_rendered' => 'Prenatal Vitals, Tetanus Toxoid counseling, Nutrition advice',
            'follow_up_needed' => true,
            'follow_up_date' => now()->addWeeks(2),
            'follow_up_reason' => 'Routine 3rd Trimester Prenatal Checkup',
            'latitude' => 10.887520,
            'longitude' => 122.610810,
            'accuracy_meters' => 4.2,
            'geo_permission_granted' => true,
            'geo_verified' => true,
            'captured_at' => now()->subDays(2)->setHour(9)->setMinute(15),
        ]);

        VisitLog::create([
            'visit_schedule_id' => $s3->id,
            'resident_id' => $r3->id,
            'bhw_user_id' => $bhw1->id,
            'vitals_bp' => '138/88',
            'vitals_weight_kg' => 58.0,
            'vitals_temp_c' => 36.5,
            'vitals_blood_sugar' => '130 mg/dL',
            'health_notes' => 'Slightly elevated BP. Reminded to lessen salt intake and continue daily Amlodipine.',
            'services_rendered' => 'BP Screening, Blood Sugar test, Free Maintenance Meds turn-over',
            'follow_up_needed' => true,
            'follow_up_date' => now()->addDays(7),
            'follow_up_reason' => 'Repeat BP check after 1 week',
            'latitude' => 10.888120,
            'longitude' => 122.611530,
            'accuracy_meters' => 3.8,
            'geo_permission_granted' => true,
            'geo_verified' => true,
            'captured_at' => now()->subDays(5)->setHour(14)->setMinute(10),
        ]);

        // 8. ISO/IEC 25010:2011 Evaluation Benchmark Data (Specific Objective 6)
        IsoEvaluation::create([
            'evaluator_name' => 'Dr. Maria Santos',
            'evaluator_role' => 'supervisor',
            'organization' => 'Municipal Health Office, New Lucena',
            'score_functional_suitability' => 4.90,
            'score_performance_efficiency' => 4.80,
            'score_compatibility' => 4.85,
            'score_usability' => 4.95,
            'score_reliability' => 4.80,
            'score_security' => 4.90,
            'score_maintainability' => 4.85,
            'score_portability' => 4.90,
            'overall_mean' => 4.87,
            'verbal_interpretation' => 'Excellent (Very High Quality)',
            'feedback_comments' => 'The system accurately addresses all BHW record-keeping needs, visit scheduling, and GPS map verification.',
        ]);

        IsoEvaluation::create([
            'evaluator_name' => 'Ana Garcia',
            'evaluator_role' => 'bhw',
            'organization' => 'Barangay Health Workers Association',
            'score_functional_suitability' => 4.80,
            'score_performance_efficiency' => 4.75,
            'score_compatibility' => 4.80,
            'score_usability' => 4.90,
            'score_reliability' => 4.70,
            'score_security' => 4.85,
            'score_maintainability' => 4.75,
            'score_portability' => 4.80,
            'overall_mean' => 4.79,
            'verbal_interpretation' => 'Excellent (Very High Quality)',
            'feedback_comments' => 'Very easy to log visits using mobile phones with automatic GPS coordinate capture.',
        ]);

        IsoEvaluation::create([
            'evaluator_name' => 'Engr. Mark Reyes, MIT',
            'evaluator_role' => 'it_expert',
            'organization' => 'Iloilo IT Systems Evaluators Guild',
            'score_functional_suitability' => 5.00,
            'score_performance_efficiency' => 4.85,
            'score_compatibility' => 4.90,
            'score_usability' => 4.80,
            'score_reliability' => 4.85,
            'score_security' => 4.95,
            'score_maintainability' => 4.90,
            'score_portability' => 4.85,
            'overall_mean' => 4.89,
            'verbal_interpretation' => 'Excellent (Very High Quality)',
            'feedback_comments' => 'Robust Laravel architecture with ISO/IEC 25010 metrics calculation and clean DataTables print layout.',
        ]);
    }
}
