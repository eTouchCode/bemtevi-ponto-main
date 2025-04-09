<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeVacation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'vacation_start',
        'vacation_end',
        'duration',
    ];


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
