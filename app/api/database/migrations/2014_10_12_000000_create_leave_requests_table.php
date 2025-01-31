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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('leave_type_id');
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->string('reason')->nullable();
            $table->string('request_to');
            $table->integer('approved_by')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
