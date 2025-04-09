<?php

namespace App\Models;

use App\Models\Admin\CentralEmployeeLogin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Contracts\Syncable;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;

class EmployeeLogin extends Authenticatable implements Syncable
{
    use SoftDeletes, HasFactory, ResourceSyncing;

    protected $fillable = [
        'employee_id',
        'global_id',
        'email',
        'password',
        'invite_token',
        'remember_token',
    ];

    public function getGlobalIdentifierKey()
    {
        return $this->getAttribute($this->getGlobalIdentifierKeyName());
    }

    public function getGlobalIdentifierKeyName(): string
    {
        return 'global_id';
    }

    public function getCentralModelName(): string
    {
        return CentralEmployeeLogin::class;
    }

    public function getSyncedAttributeNames(): array
    {
        return [
            'password',
            'email',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function triggerSyncEvent()
    {

    }
}
