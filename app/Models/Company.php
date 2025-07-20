<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_code',
        'company_ssm',
        'company_address',
        'company_phoneno',
        'company_fax',
        'company_website',
        'company_email',
        'company_logo',
    ];
}
