<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'organization_id', 'division_1', 'division_2', 'division_3', 'motivation',
        'organization_experience', 'skills', 'cv_path', 'portfolio_path', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}