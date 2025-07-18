<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteGeneratorModel extends Model
{
    use HasFactory;

    protected $fillable =[
        'generator_id',
        'model_id',
    ];
}
