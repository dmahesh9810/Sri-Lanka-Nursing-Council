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
        Schema::table('temporary_registrations', function (Blueprint $table) {
            $table->text('address')->nullable()->after('temp_registration_date');
            $table->string('batch')->nullable()->after('address');
            $table->string('school_university')->nullable()->after('batch');
            $table->date('birth_date')->nullable()->after('school_university');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_registrations', function (Blueprint $table) {
            $table->dropColumn(['address', 'batch', 'school_university', 'birth_date']);
        });
    }
};
