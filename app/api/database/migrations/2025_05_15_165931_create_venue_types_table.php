<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('venue_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        DB::table('venue_types')->insert([
            ['name' => 'Restaurant', 'order' => 0],
            ['name' => 'Bar', 'order' => 1],
            ['name' => 'Nightclub', 'order' => 2],
            ['name' => 'Cafe', 'order' => 3],
            ['name' => 'Pub', 'order' => 4],
            ['name' => 'Music Venue', 'order' => 5],
            ['name' => 'Art Gallery', 'order' => 6],
            ['name' => 'Theater', 'order' => 7],
            ['name' => 'Movie Theater', 'order' => 8],
            ['name' => 'Shopping Mall', 'order' => 9],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('venue_types');
    }
};
