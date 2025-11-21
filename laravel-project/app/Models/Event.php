<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'available_roles' => 'array',
        'deadline' => 'date', // <-- TAMBAHKAN BARIS INI
        'event_date' => 'date', // <-- TAMBAHKAN BARIS INI JUGA
    ];

    public function volunteerRegistrations()
    {
        return $this->hasMany(VolunteerRegistration::class);
    }
}