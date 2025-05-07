<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $userCount = 10;

        for ($i = 0; $i < $userCount; $i++) {

            $userData =  [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'username' => $faker->unique()->userName, 
                'password' => Hash::make('password'),
                'nric' => $faker->numerify('96##########'),
                'dob' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                'martial_status' => $faker->randomElement(["single", "married", "divorced"]),
                'mobile_phone' => $faker->numerify('01#########'),
                'office_phone' => $faker->numerify('06#######'),
                'designation_id' => $faker->numberBetween(1, 10),
                'department_id' => $faker->numberBetween(1, 10),
                'address_line1' => $faker->streetAddress,
                'address_line2' => $faker->optional()->secondaryAddress,
                'address_line3' => $faker->optional()->streetName,
                'city' => $faker->city,
                'state' => $faker->randomElement(['Johor', 'Kedah', 'Kelantan', 'Kuala Lumpur', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu']),
                'postcode' => $faker->numerify('#####'),
                'start_date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'spouse_name' => $faker->optional(0.5)->name,
                'spouse_nric' => $faker->optional(0.5)->numerify('96##########'),
                'spouse_job' => $faker->optional(0.5)->jobTitle,
                'spouse_mobile_phone' => $faker->numerify('01#########'),
                'is_active' => 1
            ];

            $user = User::create($userData);
        }
    }
}