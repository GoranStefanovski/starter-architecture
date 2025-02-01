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
            $table->string('reason')->nullable()->default("-");
            $table->string('request_to');
            $table->integer('confirmed_by')->nullable();
            $table->integer('is_confirmed')->nullable();
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
