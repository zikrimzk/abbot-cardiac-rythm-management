<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable =[
        'quotation_metadata',
        'quotation_date',
        'quotation_pt_name',
        'quotation_pt_icno',
        'quotation_price',
        'quotation_directory',
        'quotation_refno',
        'approver_id',
        'hospital_id',
        'staff_id',
        'company_id',
    ];
}
