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
        $designations = [
            [
                'name' => 'Engineer',
                'level' => 'Junior',
                'annual_leave' => 14,
                'sick_leave' => 14,
                'maternity_leave' => 60,
                'paternity_leave' => 7,
                'emergency_leave' => 3,
                'unpaid_leave' => 0,
                'compassionate_leave' => 3,
                'study_leave' => 5,
                'hospitalization_leave' => 60,
                'marriage_leave' => 3,
            ],
            [
                'name' => 'Engineer',
                'level' => 'Senior',
                'annual_leave' => 16,
                'sick_leave' => 14,
                'maternity_leave' => 60,
                'paternity_leave' => 7,
                'emergency_leave' => 3,
                'unpaid_leave' => 0,
                'compassionate_leave' => 3,
                'study_leave' => 5,
                'hospitalization_leave' => 60,
                'marriage_leave' => 3,
            ],
            [
                'name' => 'Engineer',
                'level' => 'Manager',
                'annual_leave' => 20,
                'sick_leave' => 14,
                'maternity_leave' => 60,
                'paternity_leave' => 7,
                'emergency_leave' => 5,
                'unpaid_leave' => 0,
                'compassionate_leave' => 5,
                'study_leave' => 7,
                'hospitalization_leave' => 60,
                'marriage_leave' => 5,
            ],
            [
                'name' => 'HR',
                'level' => 'Junior',
                'annual_leave' => 14,
                'sick_leave' => 14,
                'maternity_leave' => 60,
                'paternity_leave' => 7,
                'emergency_leave' => 3,
                'unpaid_leave' => 0,
                'compassionate_leave' => 3,
                'study_leave' => 5,
                'hospitalization_leave' => 60,
                'marriage_leave' => 3,
            ],
            [
                'name' => 'HR',
                'level' => 'Manager',
                'annual_leave' => 18,
                'sick_leave' => 14,
                'maternity_leave' => 60,
                'paternity_leave' => 7,
                'emergency_leave' => 5,
                'unpaid_leave' => 0,
                'compassionate_leave' => 5,
                'study_leave' => 7,
                'hospitalization_leave' => 60,
                'marriage_leave' => 5,
            ],
                        [
                'name' => 'Programmer',
                'level' => 'Junior',
                'annual_leave' => 16,
                'sick_leave' => 16,
                'maternity_leave' => 60,
                'paternity_leave' => 7,
                'emergency_leave' => 3,
                'unpaid_leave' => 0,
                'compassionate_leave' => 3,
                'study_leave' => 5,
                'hospitalization_leave' => 60,
                'marriage_leave' => 3,
            ],
            [
                'name' => 'Programmer',
                'level' => 'Senior',
                'annual_leave' => 22,
                'sick_leave' => 22,
                'maternity_leave' => 60,
                'paternity_leave' => 7,
                'emergency_leave' => 5,
                'unpaid_leave' => 0,
                'compassionate_leave' => 5,
                'study_leave' => 7,
                'hospitalization_leave' => 60,
                'marriage_leave' => 5,
            ],
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
