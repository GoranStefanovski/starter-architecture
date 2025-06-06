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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger by default

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('city');
            $table->string('country')->default('North Macedonia'); // or nullable
            $table->text('address')->nullable();

            $table->float('lng');
            $table->float('lat');

            $table->timestamp('event_start');
            $table->timestamp('event_end')->nullable();

            $table->string('slug', 100)->unique();

            $table->unsignedBigInteger('user_id'); // creator (collaborator)
            $table->unsignedBigInteger('venue_id')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
