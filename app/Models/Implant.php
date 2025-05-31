<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Implant extends Model
{
    use HasFactory;

    protected $fillable = [
        'implant_refno',
        'implant_date',
        'implant_pt_name',
        'implant_pt_icno',
        'implant_pt_mrn',
        'implant_pt_address',
        'implant_pt_email',
        'implant_pt_phoneno',
        'implant_pt_dob',
        'implant_pt_id_card',
        'implant_pt_id_card_design',
        'implant_pt_directory',
        'implant_pt_icf',
        'implant_generator_sn',
        'implant_generator_qty',
        'implant_generator_itemPrice',
        'implant_remarkSales',
        'implant_sales_total_price',
        'implant_remark',
        'implant_note',
        'implant_approval_type',
        'implant_backup_form',
        'generator_id',
        'region_id',
        'hospital_id',
        'doctor_id',
        'stock_location_id',
    ];
}
