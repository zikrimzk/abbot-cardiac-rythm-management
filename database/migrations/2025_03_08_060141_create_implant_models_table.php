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
        Schema::create('implant_models', function (Blueprint $table) {
            $table->id();
            $table->string('implant_model_sn');
            $table->foreignId('implant_id')->constrained('implants');
            $table->foreignId('model_id')->constrained('abbott_models');
            $table->foreignId('stock_location_id')->constrained('stock_locations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('implant_models');
    }
};
