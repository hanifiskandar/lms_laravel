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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('email_verified_at');
            $table->string('nric', 12)->nullable()->after('username');
            $table->string('dob')->nullable()->after('nric');
            $table->enum('martial_status', ['single', 'married', 'divorced'])->nullable()->after('dob');
            $table->string('mobile_phone')->nullable()->after('martial_status');
            $table->string('office_phone')->nullable()->after('mobile_phone');
            $table->foreignId('designation_id')->after('office_phone');
            $table->foreignId('department_id')->after('position_level');
            $table->string('address_line1')->nullable()->after('department_id');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('address_line3')->nullable()->after('address_line2');
            $table->string('city')->nullable()->after('address_line3');
            $table->string('state')->nullable()->after('city');
            $table->string('postcode')->nullable()->after('state');
            $table->date('start_date')->nullable()->after('postcode');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('spouse_name')->nullable()->after('end_date');
            $table->string('spouse_nric')->nullable()->after('spouse_name');
            $table->string('spouse_job')->nullable()->after('spouse_nric');
            $table->string('spouse_employer')->nullable()->after('spouse_job');
            $table->boolean('is_active')->default(true)->after('spouse_employer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'username',
                'nric',
                'dob',
                'martial_status',
                'mobile_phone',
                'office_phone',
                'designation_id',
                'department_id',
                'address_line1',
                'address_line2',
                'address_line3',
                'city',
                'state',
                'postcode',
                'start_date',
                'end_date',
                'spouse_name',
                'spouse_nric',
                'spouse_job',
                'spouse_employer',
                'is_active',
            ]);
        });
    }
};