<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplantModel extends Model
{
    use HasFactory;

    protected $fillable =[
        'implant_model_sn',
        'implant_id',
        'model_id',
        'stock_location_id',
    ];
}
