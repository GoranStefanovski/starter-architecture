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
        Schema::create('vacation_days', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('day_type_id');
            $table->date('date_from'); 
            $table->date('date_to')->nullable(); 
            $table->integer('year')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacation_days');
    }
};
