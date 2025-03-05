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
        Schema::create('abbott_models', function (Blueprint $table) {
            $table->id();
            $table->string('model_name');
            $table->string('model_code')->unique();
            $table->integer('model_status')->default(1);
            $table->foreignId('mcategory_id')->constrained('model_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abbott_models');
    }
};
