<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add a nullable user_id column to report_logs for audit-trail purposes.
     * Nullable so that any pre-existing rows (generated before this migration)
     * are not affected.
     */
    public function up(): void
    {
        Schema::table('report_logs', function (Blueprint $table) {
            // Place user_id after the primary key for readability
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('report_logs', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\User::class);
            $table->dropColumn('user_id');
        });
    }
};
