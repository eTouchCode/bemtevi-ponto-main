<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'name',
        'value_type',
        'value',
    ];
}
