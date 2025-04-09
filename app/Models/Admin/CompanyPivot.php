<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Stancl\Tenancy\Database\Models\TenantPivot;

class CompanyPivot extends Pivot
{

    protected $table = "employee_company";

    protected $fillable = [
        'company_id',
        'global_user_id',
    ];
}
