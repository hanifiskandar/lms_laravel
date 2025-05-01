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

            ['name' => 'Engineer', 'level' => 'Junior', 'annual_leave' => 14, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Engineer', 'level' => 'Senior', 'annual_leave' => 16, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Engineer', 'level' => 'Manager', 'annual_leave' => 20, 'sick_leave' => 14, 'emergency_leave' => 5],
            ['name' => 'HR', 'level' => 'Junior', 'annual_leave' => 14, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'HR', 'level' => 'Manager', 'annual_leave' => 18, 'sick_leave' => 14, 'emergency_leave' => 5],
            ['name' => 'Programmer', 'level' => 'Junior', 'annual_leave' => 16, 'sick_leave' => 16, 'emergency_leave' => 3],
            ['name' => 'Programmer', 'level' => 'Senior', 'annual_leave' => 22, 'sick_leave' => 22, 'emergency_leave' => 5],
            ['name' => 'Designer', 'level' => 'Junior', 'annual_leave' => 15, 'sick_leave' => 12, 'emergency_leave' => 3],
            ['name' => 'Designer', 'level' => 'Senior', 'annual_leave' => 18, 'sick_leave' => 14, 'emergency_leave' => 4],
            ['name' => 'Designer', 'level' => 'Manager', 'annual_leave' => 20, 'sick_leave' => 16, 'emergency_leave' => 5],
            ['name' => 'Analyst', 'level' => 'Junior', 'annual_leave' => 14, 'sick_leave' => 12, 'emergency_leave' => 3],
            ['name' => 'Analyst', 'level' => 'Senior', 'annual_leave' => 17, 'sick_leave' => 14, 'emergency_leave' => 4],
            ['name' => 'Analyst', 'level' => 'Manager', 'annual_leave' => 20, 'sick_leave' => 16, 'emergency_leave' => 5],
            ['name' => 'Support', 'level' => 'Junior', 'annual_leave' => 12, 'sick_leave' => 12, 'emergency_leave' => 2],
            ['name' => 'Support', 'level' => 'Senior', 'annual_leave' => 15, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Support', 'level' => 'Manager', 'annual_leave' => 18, 'sick_leave' => 16, 'emergency_leave' => 4],
            ['name' => 'Admin', 'level' => 'Assistant', 'annual_leave' => 13, 'sick_leave' => 13, 'emergency_leave' => 3],
            ['name' => 'Admin', 'level' => 'Supervisor', 'annual_leave' => 16, 'sick_leave' => 14, 'emergency_leave' => 4],
            ['name' => 'Planner', 'level' => 'Junior', 'annual_leave' => 14, 'sick_leave' => 13, 'emergency_leave' => 3],
            ['name' => 'Planner', 'level' => 'Senior', 'annual_leave' => 18, 'sick_leave' => 15, 'emergency_leave' => 4,],
            ['name' => 'Quality Assurance', 'level' => 'Analyst', 'annual_leave' => 14, 'sick_leave' => 14, 'emergency_leave' => 3],
            ['name' => 'Quality Assurance', 'level' => 'Lead', 'annual_leave' => 17, 'sick_leave' => 15, 'emergency_leave' => 4,],
        ];

        foreach ($designations as $designation) {
            Designation::create(array_merge($base, $designation));
        }
    }
}
