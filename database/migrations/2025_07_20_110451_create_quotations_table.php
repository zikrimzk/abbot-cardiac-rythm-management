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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->json('quotation_metadata')->nullable();
            $table->date('quotation_date');
            $table->string('quotation_pt_name');
            $table->string('quotation_pt_icno');
            $table->decimal('quotation_price', 10, 2)->default(0.00);
            $table->text('quotation_directory')->nullable();
            $table->string('quotation_refno')->nullable();
            $table->foreignId('approver_id')->constrained('users');
            $table->foreignId('hospital_id')->constrained('hospitals');
            $table->foreignId('staff_id')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
