<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warnings extends Model
{
    use HasFactory;

    protected $fillable = [
        'warningType',
        'icon',
        'target',
        'title',
        'message',
        'date',
    ];
}
