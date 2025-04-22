<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('leave_types')->insert([
            ['id' => 1, 'name' => 'Annual Leave'],
            ['id' => 2, 'name' => 'Sick Leave'],
            ['id' => 3, 'name' => 'Maternity Leave'],
            ['id' => 4, 'name' => 'Paternity Leave'],
            ['id' => 5, 'name' => 'Emergency Leave'],
            ['id' => 6, 'name' => 'Unpaid Leave'],
            ['id' => 7, 'name' => 'Compassionate Leave'],
            ['id' => 8, 'name' => 'Study Leave'],
            ['id' => 9, 'name' => 'Hospitalization Leave'],
            ['id' => 10, 'name' => 'Marriage Leave'],
        ]);
    }
}
