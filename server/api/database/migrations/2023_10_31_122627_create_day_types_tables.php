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
        Schema::create('day_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // Day type name, e.g., "Sick Day"
            $table->string('name');
            $table->boolean('is_paid');       // Whether the day type is paid
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_types');
    }
};
