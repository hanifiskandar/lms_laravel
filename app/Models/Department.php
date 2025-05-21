<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'head_id',
    ];


    public function headDepartment()
    {
        return $this->belongsTo(User::class, 'head_id','id');
    }

}
