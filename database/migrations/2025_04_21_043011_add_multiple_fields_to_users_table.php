<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

// {
//         Schema::table('users', function (Blueprint $table) {
//             $table->dropColumn([
//                 'username',
//                 'nric',
//                 'dob',
//                 'marital_status',
//                 'mobile_phone',
//                 'office_phone',
//                 'designation',
//                 'position_level',
//                 'department_id',
//                 'address_line1',
//                 'address_line2',
//                 'address_line3',
//                 'city',
//                 'state',
//                 'postcode',
//                 'country',
//                 'spouse_name',
//                 'spouse_nric',
//                 'spouse_job',
//                 'spouse_employer',
//                 'marital_status',
//                 'date_of_birth',
//                 'address',
//                 'emergency_contact',
//                 'is_active',
//             ]);
//         });
//     }

