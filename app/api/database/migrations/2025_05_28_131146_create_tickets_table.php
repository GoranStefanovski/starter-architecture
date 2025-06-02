<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('type'); // e.g., Free Entry, Regular, VIP, Early Bird
            $table->decimal('price', 10, 2)->default(0); // e.g. 19.99
            $table->integer('quantity')->nullable(); // available tickets
            $table->timestamp('sale_start')->nullable();
            $table->timestamp('sale_end')->nullable();

            $table->unsignedBigInteger('event_id');
            $table->unique(['type', 'event_id']);

            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
