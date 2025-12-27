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
        Schema::create('records', function (Blueprint $table) {
           $table->id();
        $table->foreignId('species_id')->constrained()->cascadeOnDelete();
        $table->integer('year'); // e.g., 2024
        $table->integer('count'); // How many seen
        // We store lat/lng for the map dots
        $table->decimal('latitude', 10, 7); 
        $table->decimal('longitude', 10, 7);
        $table->string('grid_ref')->nullable(); // e.g., SU1234
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
