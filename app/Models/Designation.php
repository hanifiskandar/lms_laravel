<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{

    protected $fillable = [
        'name',
        'level',
        'annual_leave',
        'sick_leave',
        'maternity_leave',
        'paternity_leave',
        'emergency_leave',
        'unpaid_leave',
        'compassionate_leave',
        'study_leave',
        'hospitalization_leave',
        'marriage_leave',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}