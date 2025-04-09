<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class TaxRate extends Model
{
    use HasFactory, CentralConnection;

    protected $fillable = [
        "name",
        "start_value",
        "end_value",
        "percentage",
        "reduction",
        "reduction_value",
    ];

    protected $casts = [
        'reduction' => 'boolean',
    ];
}
