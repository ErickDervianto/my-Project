<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'event_id', 'role_1', 'role_2', 'role_3', 'motivation',
        'volunteer_experience', 'skills', 'cv_path', 'portfolio_path', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}