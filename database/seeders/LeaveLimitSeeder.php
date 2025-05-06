<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Designation;
use App\Models\LeaveType;
use App\Models\LeaveLimit;
use Carbon\Carbon;

class LeaveLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();
        
        // Get all leave types
        $leaveTypes = LeaveType::all()->keyBy('name');
        
        // Define mapping of leave type names to designation fields
        $leaveTypeMapping = [
            'Annual Leave' => 'annual_leave',
            'Sick Leave' => 'sick_leave',
            'Emergency Leave' => 'emergency_leave',
            'Maternity Leave' => 'maternity_leave',
            'Paternity Leave' => 'paternity_leave',
            'Unpaid Leave' => 'unpaid_leave',
            'Hospitalization Leave' => 'hospitalization_leave',
            'Compassionate Leave' => 'compassionate_leave',
            'Study Leave' => 'study_leave',
            'Marriage Leave' => 'marriage_leave',
        ];
        
        $currentYear = Carbon::now()->year; // 2025

        foreach ($users as $user) {
            // Get the user's designation
            $designation = Designation::find($user->designation_id);
            
            if (!$designation) {
                continue; // Skip if designation not found
            }
            
            // Convert designation to array for easier access
            $designationData = $designation->toArray();
            
            // For each leave type, create a leave limit record
            foreach ($leaveTypes as $leaveTypeName => $leaveType) {
                $designationField = $leaveTypeMapping[$leaveTypeName] ?? null;
                
                // Get the limit_days from the designation, default to 0 if not applicable
                $limitDays = $designationField && isset($designationData[$designationField])
                    ? $designationData[$designationField]
                    : 0;
                
                LeaveLimit::create([
                    'user_id' => $user->id,
                    'leave_type_id' => $leaveType->id,
                    'year' => $currentYear,
                    'limit_days' => $limitDays,
                ]);
            }
        }
    }
}