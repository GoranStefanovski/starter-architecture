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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger by default

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('artist_tag')->unique()->nullable();
            $table->text('bio')->nullable();

            $table->string('city_from', 200)->nullable();
            $table->string('country_from', 200)->nullable();

            $table->string('email', 150)->unique();
            $table->string('phone_number', 25)->nullable();

            $table->string('password');

            $table->boolean('is_disabled')->default(false);

            $table->string('username', 100)->unique()->nullable();

            $table->string('instagram_link')->nullable();
            $table->string('instagram_video')->nullable();

            $table->string('facebook_link')->nullable();
            $table->string('facebook_video')->nullable();

            $table->string('soundcloud_link')->nullable();
            $table->string('soundcloud_track')->nullable();

            $table->string('spotify_link')->nullable();
            $table->string('spotify_track')->nullable();

            $table->string('youtube_link')->nullable();
            $table->string('youtube_video')->nullable();

            $table->string('contact_phone', 25)->nullable();
            $table->string('contact_email', 150)->nullable();

            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
