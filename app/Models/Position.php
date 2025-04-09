<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'salary_id',
        'workshift_id',
    ];

    public function salary(): BelongsTo
    {
        return $this->belongsTo(Salary::class);
    }

    public function workshift(): BelongsTo
    {
        return $this->belongsTo(Workshift::class);
    }
}
