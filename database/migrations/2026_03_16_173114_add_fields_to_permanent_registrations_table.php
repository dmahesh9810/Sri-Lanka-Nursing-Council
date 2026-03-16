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
        Schema::table('permanent_registrations', function (Blueprint $table) {
            $table->text('address')->nullable()->after('present_workplace');
            $table->string('batch')->nullable()->after('address');
            $table->string('school_university')->nullable()->after('batch');
            $table->date('birth_date')->nullable()->after('school_university');
            $table->string('qualification')->nullable()->after('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permanent_registrations', function (Blueprint $table) {
            $table->dropColumn(['address', 'batch', 'school_university', 'birth_date', 'qualification']);
        });
    }
};
