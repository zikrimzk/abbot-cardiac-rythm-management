<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLocation extends Model
{
    use HasFactory;

    protected $fillable =[
        'stock_location_code',
        'stock_location_name',
        'stock_location_status'
    ];
}
