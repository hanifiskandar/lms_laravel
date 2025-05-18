<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'year',
        'entitlement',
        'eligible',
        'carry_forward',
        'used',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id','id');
    }
}
