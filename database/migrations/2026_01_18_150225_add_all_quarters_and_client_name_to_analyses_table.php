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
            $table->string('client_name')->nullable()->after('user_id');
            $table->json('q2_revenue_data')->nullable()->after('q1_revenue_data');
            $table->json('q3_revenue_data')->nullable()->after('q2_revenue_data');
            $table->json('q4_revenue_data')->nullable()->after('q3_revenue_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('analyses', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'q2_revenue_data', 'q3_revenue_data', 'q4_revenue_data']);
        });
    }
};
