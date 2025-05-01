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
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('level');
            $table->integer('annual_leave')->default(0);
            $table->integer('sick_leave')->default(0);
            $table->integer('maternity_leave')->default(0);
            $table->integer('paternity_leave')->default(0);
            $table->integer('emergency_leave')->default(0);
            $table->integer('unpaid_leave')->default(0);
            $table->integer('compassionate_leave')->default(0);
            $table->integer('study_leave')->default(0);
            $table->integer('hospitalization_leave')->default(0);
            $table->integer('marriage_leave')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
