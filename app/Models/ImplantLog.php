<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImplantLog extends Model
{
    use HasFactory;

      protected $fillable =[
        'log_activity',
        'log_datetime',
        'staff_id',
        'implant_id',
    ];
}
