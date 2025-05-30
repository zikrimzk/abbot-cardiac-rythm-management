<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

      protected $fillable = [
        'sb_approval',
        'sb_borangG',
        'sb_do',
        'sb_borangF',
        'sb_receipt',
        'sb_other_one',
        'sb_other_two',
        'sb_other_three',
        'sb_other_four',
        'implant_id'
    ];
}
