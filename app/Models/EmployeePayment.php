<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'payment_date',
        'salary',
        'contribution_fgts',
        'fgts_taxrate',
        'contribution_inss',
        'inss_taxrate',
        'contribution_ir',
        'ir_taxrate',
        'additionals',
        'additionals_total',
        'employee_summary',
        'employer_summary',
    ];


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
