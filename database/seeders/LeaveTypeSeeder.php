<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\LeaveType;


class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            'Annual Leave',
            'Sick Leave',
            'Maternity Leave',
            'Paternity Leave',
            'Emergency Leave',
            'Unpaid Leave',
            'Compassionate Leave',
            'Study Leave',
            'Hospitalization Leave',
            'Marriage Leave',
        ];
    
        foreach ($leaveTypes as $leaveType) {
            LeaveType::create(['name' => $leaveType]);
        }
    }
}
