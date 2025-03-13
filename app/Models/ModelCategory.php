<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCategory extends Model
{
    use HasFactory;

    protected $fillable =[
        'mcategory_name',
        'mcategory_ismorethanone'
    ];
}
