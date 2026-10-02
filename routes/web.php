<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\BhwAssignmentController;
use App\Http\Controllers\VisitScheduleController;
use App\Http\Controllers\VisitLogController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\IsoEvaluationController;
use App\Http\Controllers\DigitizedFormController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected System Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Central Database CRUD
    Route::resource('households', HouseholdController::class);
    Route::resource('residents', ResidentController::class);
    Route::resource('assignments', BhwAssignmentController::class)->only(['index', 'store', 'destroy']);

    // Scheduled Field Visits & Monitoring
    Route::get('/visits', [VisitScheduleController::class, 'index'])->name('visits.index');
    Route::get('/visits/create', [VisitScheduleController::class, 'create'])->name('visits.create');
    Route::post('/visits', [VisitScheduleController::class, 'store'])->name('visits.store');
    Route::post('/visits/{schedule}/status', [VisitScheduleController::class, 'updateStatus'])->name('visits.status');

    // Location Capture & Restricted Map View
    Route::get('/visit-logs', [VisitLogController::class, 'index'])->name('visit-logs.index');
    Route::get('/visit-logs/create', [VisitLogController::class, 'create'])->name('visit-logs.create');
    Route::post('/visit-logs', [VisitLogController::class, 'store'])->name('visit-logs.store');
    Route::get('/visit-logs/{visitLog}', [VisitLogController::class, 'show'])->name('visit-logs.show');

    Route::get('/map', [MapController::class, 'index'])->name('map.index');

    // Searchable & Printable Summaries
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/completed-visits', [ReportController::class, 'completedVisits'])->name('reports.completed-visits');
    Route::get('/reports/pending-followups', [ReportController::class, 'pendingFollowups'])->name('reports.pending-followups');
    Route::get('/reports/worker-activities', [ReportController::class, 'workerActivities'])->name('reports.worker-activities');

    // Objective 6: ISO/IEC 25010:2011 Quality Evaluation Engine
    Route::get('/iso-evaluation', [IsoEvaluationController::class, 'index'])->name('iso-evaluation.index');
    Route::get('/iso-evaluation/create', [IsoEvaluationController::class, 'create'])->name('iso-evaluation.create');
    Route::post('/iso-evaluation', [IsoEvaluationController::class, 'store'])->name('iso-evaluation.store');

    // Objective 1: Baseline Digitized Forms & Barangay Configuration
    Route::get('/forms', [DigitizedFormController::class, 'index'])->name('forms.index');
    Route::get('/forms/target-client-maternal', [DigitizedFormController::class, 'targetClientListMaternal'])->name('forms.target-client-maternal');
    Route::get('/forms/child-immunization', [DigitizedFormController::class, 'childImmunizationTracker'])->name('forms.child-immunization');
    Route::get('/forms/household-survey', [DigitizedFormController::class, 'householdSurveyForm'])->name('forms.household-survey');
    Route::post('/forms/settings', [DigitizedFormController::class, 'updateSettings'])->name('forms.update-settings');
});
