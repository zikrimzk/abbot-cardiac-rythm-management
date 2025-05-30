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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->text('sb_approval')->nullable();
            $table->text('sb_borangG')->nullable();
            $table->text('sb_do')->nullable();
            $table->text('sb_borangF')->nullable();
            $table->text('sb_receipt')->nullable();
            $table->text('sb_other_one')->nullable();
            $table->text('sb_other_two')->nullable();
            $table->text('sb_other_three')->nullable();
            $table->text('sb_other_four')->nullable();
            $table->foreignId('implant_id')->constrained('implants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
