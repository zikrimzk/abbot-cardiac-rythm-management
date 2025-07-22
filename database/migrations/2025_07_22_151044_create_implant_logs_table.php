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
        Schema::create('implant_logs', function (Blueprint $table) {
            $table->id();
            $table->text('log_activity');
            $table->dateTime('log_datetime');
            $table->foreignId('staff_id')->constrained('users');
            $table->foreignId('implant_id')->constrained('implants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('implant_logs');
    }
};
