<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_schedule_id',
        'resident_id',
        'bhw_user_id',
        'vitals_bp',
        'vitals_weight_kg',
        'vitals_temp_c',
        'vitals_blood_sugar',
        'health_notes',
        'services_rendered',
        'follow_up_needed',
        'follow_up_date',
        'follow_up_reason',
        'latitude',
        'longitude',
        'accuracy_meters',
        'geo_permission_granted',
        'geo_verified',
        'captured_at',
    ];

    protected $casts = [
        'follow_up_needed' => 'boolean',
        'follow_up_date' => 'date',
        'geo_permission_granted' => 'boolean',
        'geo_verified' => 'boolean',
        'captured_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
        'accuracy_meters' => 'float',
    ];

    public function schedule()
    {
        return $this->belongsTo(VisitSchedule::class, 'visit_schedule_id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function bhw()
    {
        return $this->belongsTo(User::class, 'bhw_user_id');
    }
}
