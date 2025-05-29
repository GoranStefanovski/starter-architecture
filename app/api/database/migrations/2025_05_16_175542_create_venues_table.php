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
        Schema::create('venues', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger by default

            $table->string('name');
            $table->text('bio')->nullable();
            $table->text('address');
            $table->float('lng'); // longitude
            $table->float('lat'); // latitude
            $table->string('email', 150)->unique();
            $table->string('phone_number', 25)->nullable();
            $table->string('slug', 100)->unique();

            $table->unsignedBigInteger('venue_type_id')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('venue_type_id')->references('id')->on('venue_types')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
