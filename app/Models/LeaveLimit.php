<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveLimit extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'year',
        'limit_days',
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