<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BhwAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'purok',
        'barangay',
        'assigned_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'assigned_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
