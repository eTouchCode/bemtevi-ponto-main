<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeFamily extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'employee_family';

    protected $fillable = [
        'name',
        'dateofbirth',
        'cpf',
        'rg',
    ];

    protected function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
