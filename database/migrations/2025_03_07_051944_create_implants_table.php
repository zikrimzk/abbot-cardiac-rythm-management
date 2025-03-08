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
        Schema::create('implants', function (Blueprint $table) {
            $table->id();
            $table->string('implant_code')->unique();
            $table->date('implant_date');
            $table->string('implant_pt_name');
            $table->string('implant_pt_icno');
            $table->string('implant_pt_address')->nullable();
            $table->string('implant_pt_mrn')->nullable();
            $table->string('implant_pt_id_card')->nullable();
            $table->text('implant_pt_id_card_design')->nullable();
            $table->text('implant_pt_directory')->nullable();
            $table->string('implant_generator_sn');
            $table->string('implant_invoice_no')->nullable();
            $table->double('implant_sales')->default(0.00);
            $table->integer('implant_quantity')->default(1);
            $table->text('implant_remark')->nullable();
            $table->text('implant_note')->nullable();
            $table->string('implant_approval_type')->nullable();
            $table->text('implant_backup_form')->nullable();
            $table->foreignId('generator_id')->constrained('generators');
            $table->foreignId('region_id')->constrained('regions');
            $table->foreignId('hospital_id')->constrained('hospitals');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('stock_location_id')->constrained('stock_locations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('implants');
    }
};
