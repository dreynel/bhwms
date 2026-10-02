<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_number',
        'head_name',
        'purok',
        'barangay',
        'municipality',
        'province',
        'address_details',
        'water_source',
        'sanitary_toilet',
        'income_bracket',
        'latitude',
        'longitude',
        'created_by',
    ];

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
