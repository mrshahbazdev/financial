<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->json('q1_revenue_data')->nullable();
        });

        Schema::table('analysis_rows', function (Blueprint $table) {
            $table->json('custom_caps_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->dropColumn('q1_revenue_data');
        });

        Schema::table('analysis_rows', function (Blueprint $table) {
            $table->dropColumn('custom_caps_data');
        });
    }
};
