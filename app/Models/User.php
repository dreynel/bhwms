<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'purok',
        'assigned_barangay',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function assignments()
    {
        return $this->hasMany(BhwAssignment::class);
    }

    public function visits()
    {
        return $this->hasMany(VisitSchedule::class, 'bhw_user_id');
    }

    public function visitLogs()
    {
        return $this->hasMany(VisitLog::class, 'bhw_user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSupervisor(): bool
    {
        return in_array($this->role, ['supervisor', 'admin']);
    }

    public function isBhw(): bool
    {
        return $this->role === 'bhw';
    }
}
