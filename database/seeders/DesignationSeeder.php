<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $base = [
            'maternity_leave' => 60,
            'paternity_leave' => 7,
            'unpaid_leave' => 0,
            'hospitalization_leave' => 60,
            'compassionate_leave' => 3,
            'study_leave' => 5,
            'marriage_leave' => 5,
        ];

        $designations = [

            ['name' => 'Junior Engineer', 'type' => 'Engineer', 'level' => 1, 'annual_leave' => 14, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Senior Engineer', 'type' => 'Engineer', 'level' => 2, 'annual_leave' => 16, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Manager Engineer', 'type' => 'Engineer', 'level' => 3, 'annual_leave' => 20, 'sick_leave' => 14, 'emergency_leave' => 5],
            ['name' => 'Junior HR', 'type' => 'HR', 'level' => 1, 'annual_leave' => 14, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Manager HR', 'type' => 'HR', 'level' => 3, 'annual_leave' => 18, 'sick_leave' => 14, 'emergency_leave' => 5],
            ['name' => 'Junior Programmer', 'type' => 'Programmer', 'level' => 1, 'annual_leave' => 16, 'sick_leave' => 16, 'emergency_leave' => 3],
            ['name' => 'Senior Programmer', 'type' => 'Programmer', 'level' => 2, 'annual_leave' => 22, 'sick_leave' => 22, 'emergency_leave' => 5],
            ['name' => 'Junior Designer', 'type' => 'Designer', 'level' => 1, 'annual_leave' => 15, 'sick_leave' => 12, 'emergency_leave' => 3],
            ['name' => 'Senior Designer', 'type' => 'Designer', 'level' => 2, 'annual_leave' => 18, 'sick_leave' => 14, 'emergency_leave' => 4],
            ['name' => 'Manager Designer', 'type' => 'Designer', 'level' => 3, 'annual_leave' => 20, 'sick_leave' => 16, 'emergency_leave' => 5],
            ['name' => 'Junior Analyst', 'type' => 'Analyst', 'level' => 1, 'annual_leave' => 14, 'sick_leave' => 12, 'emergency_leave' => 3],
            ['name' => 'Senior Analyst', 'type' => 'Analyst', 'level' => 2, 'annual_leave' => 17, 'sick_leave' => 14, 'emergency_leave' => 4],
            ['name' => 'Manager Analyst', 'type' => 'Analyst', 'level' => 3, 'annual_leave' => 20, 'sick_leave' => 16, 'emergency_leave' => 5],
            ['name' => 'Junior Support', 'type' => 'Support', 'level' => 1, 'annual_leave' => 12, 'sick_leave' => 12, 'emergency_leave' => 2],
            ['name' => 'Senior Support', 'type' => 'Support', 'level' => 2, 'annual_leave' => 15, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Manager Support', 'type' => 'Support', 'level' => 3, 'annual_leave' => 18, 'sick_leave' => 16, 'emergency_leave' => 4],
            ['name' => 'Admin Assistant', 'type' => 'Admin', 'level' => 1, 'annual_leave' => 13, 'sick_leave' => 13, 'emergency_leave' => 3],
            ['name' => 'Admin Supervisor', 'type' => 'Admin', 'level' => 2, 'annual_leave' => 16, 'sick_leave' => 14, 'emergency_leave' => 4],
            ['name' => 'Junior Planner', 'type' => 'Planner', 'level' => 1, 'annual_leave' => 14, 'sick_leave' => 13, 'emergency_leave' => 3],
            ['name' => 'Senior Planner', 'type' => 'Planner', 'level' => 2, 'annual_leave' => 18, 'sick_leave' => 15, 'emergency_leave' => 4],
            ['name' => 'Quality Assurance Analyst', 'type' => 'Quality Assurance', 'level' => 1, 'annual_leave' => 14, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Lead Quality Assurance', 'type' => 'Quality Assurance', 'level' => 2, 'annual_leave' => 17, 'sick_leave' => 15, 'emergency_leave' => 4],
        ];

        foreach ($designations as $designation) {
            Designation::create(array_merge($base, $designation));
        }
    }
}
