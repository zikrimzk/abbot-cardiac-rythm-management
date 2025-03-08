<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroupList extends Model
{
    use HasFactory;

    protected $fillable =[
        'implant_id',
        'product_group_id'
    ];
}
