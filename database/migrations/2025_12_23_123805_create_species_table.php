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
        Schema::create('species', function (Blueprint $table) {
       $table->id();
        $table->string('name'); // Common name e.g., "Red Admiral"
        $table->string('scientific_name')->nullable();
        $table->text('description')->nullable();
        $table->string('image')->nullable(); // For the photo
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
