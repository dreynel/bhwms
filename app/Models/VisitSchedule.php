<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'bhw_user_id',
        'scheduled_date',
        'scheduled_time',
        'visit_type',
        'priority',
        'notes',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function bhw()
    {
        return $this->belongsTo(User::class, 'bhw_user_id');
    }

    public function visitLog()
    {
        return $this->hasOne(VisitLog::class);
    }
}
