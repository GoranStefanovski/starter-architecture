<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('music_genres', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        DB::table('music_genres')->insert([
            ['id' => 1, 'name' => 'Pop', 'order' => 1],
            ['id' => 2, 'name' => 'Rock', 'order' => 2],
            ['id' => 3, 'name' => 'Hip-Hop/Rap', 'order' => 3],
            ['id' => 4, 'name' => 'Jazz', 'order' => 4],
            ['id' => 5, 'name' => 'Blues', 'order' => 5],
            ['id' => 6, 'name' => 'R&B (Rhythm and Blues)', 'order' => 6],
            ['id' => 7, 'name' => 'Country', 'order' => 7],
            ['id' => 8, 'name' => 'Electronic', 'order' => 8],
            ['id' => 9, 'name' => 'Classical', 'order' => 9],
            ['id' => 10, 'name' => 'Reggae', 'order' => 10],
            ['id' => 11, 'name' => 'Punk', 'order' => 11],
            ['id' => 12, 'name' => 'Metal', 'order' => 12],
            ['id' => 13, 'name' => 'Funk', 'order' => 13],
            ['id' => 14, 'name' => 'Soul', 'order' => 14],
            ['id' => 15, 'name' => 'Gospel', 'order' => 15],
            ['id' => 16, 'name' => 'Folk', 'order' => 16],
            ['id' => 17, 'name' => 'Indie', 'order' => 17],
            ['id' => 18, 'name' => 'Alternative', 'order' => 18],
            ['id' => 19, 'name' => 'Dance', 'order' => 19],
            ['id' => 20, 'name' => 'Techno', 'order' => 20],
            ['id' => 21, 'name' => 'EDM (Electronic Dance Music)', 'order' => 21],
            ['id' => 22, 'name' => 'House', 'order' => 22],
            ['id' => 23, 'name' => 'Trance', 'order' => 23],
            ['id' => 24, 'name' => 'Dubstep', 'order' => 24],
            ['id' => 25, 'name' => 'Drum and Bass', 'order' => 25],
            ['id' => 26, 'name' => 'Dub', 'order' => 26],
            ['id' => 27, 'name' => 'Ska', 'order' => 27],
            ['id' => 28, 'name' => 'Reggaeton', 'order' => 28],
            ['id' => 29, 'name' => 'Latin', 'order' => 29],
            ['id' => 30, 'name' => 'Classical Crossover', 'order' => 30],
            ['id' => 31, 'name' => 'K-Pop', 'order' => 31],
            ['id' => 32, 'name' => 'J-Pop', 'order' => 32],
            ['id' => 33, 'name' => 'Blues Rock', 'order' => 33],
            ['id' => 34, 'name' => 'Psychedelic Rock', 'order' => 34],
            ['id' => 35, 'name' => 'Progressive Rock', 'order' => 35],
            ['id' => 36, 'name' => 'Hard Rock', 'order' => 36],
            ['id' => 37, 'name' => 'Heavy Metal', 'order' => 37],
            ['id' => 38, 'name' => 'Death Metal', 'order' => 38],
            ['id' => 39, 'name' => 'Thrash Metal', 'order' => 39],
            ['id' => 40, 'name' => 'Country Pop', 'order' => 40],
            ['id' => 41, 'name' => 'Bluegrass', 'order' => 41],
            ['id' => 42, 'name' => 'Americana', 'order' => 42],
            ['id' => 43, 'name' => 'World Music', 'order' => 43],
            ['id' => 44, 'name' => 'Fusion', 'order' => 44],
            ['id' => 45, 'name' => 'Experimental', 'order' => 45],
            ['id' => 46, 'name' => 'New Wave', 'order' => 46],
            ['id' => 47, 'name' => 'Grunge', 'order' => 47],
            ['id' => 48, 'name' => 'Post-Punk', 'order' => 48],
            ['id' => 49, 'name' => 'Salsa', 'order' => 49],
            ['id' => 50, 'name' => 'Merengue', 'order' => 50],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('music_genres');
    }
};