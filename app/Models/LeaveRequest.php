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


    protected $statusLabels = [
        1 => 'Pending',
        2 => 'Approved',
        3 => 'Rejected',
    ];

    /**
     * Get the status label for the user.
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->statusLabels[$this->status] ?? '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id','id');
    }
}
