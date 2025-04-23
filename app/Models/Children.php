<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'nric',
        'gender',
        'dob',
        'marital_status',
        'activity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
