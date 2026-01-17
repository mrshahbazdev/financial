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
        Schema::create('taps', function (Blueprint $table) {
            $table->id();
            $table->string('industry');
            $table->decimal('profit', 5, 2); // %
            $table->decimal('owner_pay', 5, 2); // %
            $table->decimal('tax', 5, 2); // %
            $table->decimal('opex', 5, 2); // %
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taps');
    }
};
