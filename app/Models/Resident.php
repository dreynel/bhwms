<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_id',
        'family_code',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'date_of_birth',
        'sex',
        'civil_status',
        'contact_number',
        'philhealth_number',
        'is_head',
        'is_pregnant',
        'is_lactating',
        'is_infant',
        'is_senior',
        'is_pwd',
        'has_hypertension',
        'has_diabetes',
        'has_malnutrition',
        'immunization_status',
        'medical_notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_head' => 'boolean',
        'is_pregnant' => 'boolean',
        'is_lactating' => 'boolean',
        'is_infant' => 'boolean',
        'is_senior' => 'boolean',
        'is_pwd' => 'boolean',
        'has_hypertension' => 'boolean',
        'has_diabetes' => 'boolean',
        'has_malnutrition' => 'boolean',
    ];

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function visitSchedules()
    {
        return $this->hasMany(VisitSchedule::class);
    }

    public function visitLogs()
    {
        return $this->hasMany(VisitLog::class);
    }

    public function getFullNameAttribute(): string
    {
        $name = $this->first_name . ' ' . ($this->middle_name ? $this->middle_name[0] . '. ' : '') . $this->last_name;
        if ($this->suffix) {
            $name .= ' ' . $this->suffix;
        }
        return $name;
    }

    public function getAgeAttribute(): int
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function getVulnerabilitiesAttribute(): array
    {
        $list = [];
        if ($this->is_pregnant) $list[] = 'Pregnant';
        if ($this->is_lactating) $list[] = 'Lactating';
        if ($this->is_infant) $list[] = 'Infant/Child';
        if ($this->is_senior) $list[] = 'Senior Citizen';
        if ($this->is_pwd) $list[] = 'PWD';
        if ($this->has_hypertension) $list[] = 'Hypertension';
        if ($this->has_diabetes) $list[] = 'Diabetes';
        if ($this->has_malnutrition) $list[] = 'Malnutrition';
        return $list;
    }
}
