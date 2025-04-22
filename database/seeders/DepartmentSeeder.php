<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'Human Resources'],
            ['name' => 'Finance'],
            ['name' => 'Information Technology'],
            ['name' => 'Marketing'],
            ['name' => 'Sales'],
            ['name' => 'Customer Service'],
            ['name' => 'Operations'],
            ['name' => 'Legal'],
            ['name' => 'Research and Development'],
            ['name' => 'Procurement'],
            ['name' => 'Engineering'],
            ['name' => 'Administration'],
            ['name' => 'Public Relations'],
            ['name' => 'Quality Assurance'],
            ['name' => 'Logistics'],
        ]);
    }
}
