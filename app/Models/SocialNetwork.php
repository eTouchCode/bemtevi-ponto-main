<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialNetwork extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'link',
    ];
}
