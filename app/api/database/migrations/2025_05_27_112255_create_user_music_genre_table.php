<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_music_genre', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('music_genre_id');
            $table->timestamps();

            $table->unique(['user_id', 'music_genre_id']); // Prevent duplicates

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('music_genre_id')->references('id')->on('music_genres')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_music_genre');
    }
};
