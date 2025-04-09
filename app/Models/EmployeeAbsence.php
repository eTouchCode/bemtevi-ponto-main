<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAbsence extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'absence_date',
        'absence_reason'
    ];


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function employeeName()
    {
        return $this->employee->name;
    }
}
