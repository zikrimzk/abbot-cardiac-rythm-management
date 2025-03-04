<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable =[
        'hospital_name',
        'hospital_code',
        'hospital_address',
        'hospital_phoneno',
        'hospital_visibility',
    ];
}
