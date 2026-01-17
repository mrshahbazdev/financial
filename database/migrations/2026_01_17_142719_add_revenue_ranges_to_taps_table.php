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
        Schema::table('taps', function (Blueprint $table) {
            $table->decimal('min_revenue', 15, 2)->nullable()->after('industry');
            $table->decimal('max_revenue', 15, 2)->nullable()->after('min_revenue');
            $table->string('label')->nullable()->after('id'); // e.g. 'A', 'B'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taps', function (Blueprint $table) {
            //
        });
    }
};
