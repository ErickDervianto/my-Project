<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'faculty',
        'study_program',
        'semester',
        'gpa',
        'organization_experience',
        'skills',
        'cv_path',
        'portfolio_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}