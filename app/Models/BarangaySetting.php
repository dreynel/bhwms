<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_name',
        'municipality',
        'province',
        'captain_name',
        'health_officer_name',
        'contact_phone',
        'office_address',
        'purok_list',
        'system_announcement',
    ];

    protected $casts = [
        'purok_list' => 'array',
    ];
}
