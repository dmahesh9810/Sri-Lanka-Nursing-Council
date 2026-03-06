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
        Schema::create('permanent_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nurse_id')->constrained()->onDelete('cascade')->unique();
            $table->string('perm_registration_no');
            $table->date('perm_registration_date');
            $table->date('appointment_date')->nullable();
            $table->string('grade')->nullable();
            $table->string('present_workplace')->nullable();
            $table->string('slmc_no')->nullable();
            $table->date('slmc_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permanent_registrations');
    }
};
