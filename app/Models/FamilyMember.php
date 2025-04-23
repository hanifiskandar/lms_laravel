<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'nric',
        'gender',
        'dob',
        'phone_number',
        'relation',
        'marital_status',
        'activity',
        'organization',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
