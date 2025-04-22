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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nric', 12)->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('relation')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced'])->nullable();
            $table->string('activity')->nullable();
            $table->string('organization')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
