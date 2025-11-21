<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'available_divisions' => 'array',
        'deadline' => 'date', // <-- TAMBAHKAN BARIS INI
    ];

    public function registrations()
    {
        return $this->hasMany(OrganizationRegistration::class);
    }
}