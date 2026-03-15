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
            $table->boolean('certificate_printed')->default(false)->after('slmc_date');
            $table->boolean('certificate_posted')->default(false)->after('certificate_printed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permanent_registrations', function (Blueprint $table) {
            $table->dropColumn(['certificate_printed', 'certificate_posted']);
        });
    }
};
