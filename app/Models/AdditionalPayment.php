<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalPayment extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];


    protected $fillable = [
        'name',
        'amount',
        'percentageValue',
        'fgts',
        'inss',
        'ir',
    ];
}
