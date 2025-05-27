<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_venue_attendance', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('venue_id');

            $table->integer('attendance_count')->default(0);
            $table->timestamp('last_attended_at')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'venue_id']); // One row per user-venue pair

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_venue_attendance');
    }
};
