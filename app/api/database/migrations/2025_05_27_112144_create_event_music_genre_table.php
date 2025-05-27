<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_music_genre', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('music_genre_id');
            $table->timestamps();

            $table->unique(['event_id', 'music_genre_id']); // Prevent duplicates

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('music_genre_id')->references('id')->on('music_genres')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_music_genre');
    }
};
