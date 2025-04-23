<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'duration',
        'reason',
        'status',
        'file_original_name',
        'file_path',
        'file_size',
        'approved_by_id',
        'approved_at',
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
