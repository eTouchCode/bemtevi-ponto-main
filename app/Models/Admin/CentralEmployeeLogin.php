<?php

namespace App\Models\Admin;

use App\Models\EmployeeLogin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Contracts\SyncMaster;
use Stancl\Tenancy\Database\Concerns\CentralConnection;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;

class CentralEmployeeLogin extends Authenticatable implements SyncMaster
{
    use ResourceSyncing, CentralConnection, SoftDeletes;

    protected $fillable = [
        'global_id',
        'email',
        'password',
        'remember_token',
    ];


    protected $guarded = [];
    public $timestamps = false;

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'employee_company', 'global_user_id', 'company_id', 'global_id', 'id')
            ->using(CompanyPivot::class);

    }

    public function getTenantModelName(): string
    {
        return EmployeeLogin::class;
    }

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
        return static::class;
    }

    public function getSyncedAttributeNames(): array
    {
        return [
            'password',
            'email',
        ];
    }

    public function triggerSyncEvent()
    {

    }
}
