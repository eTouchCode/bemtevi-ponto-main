<?php

namespace App\Models\Admin;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Company extends BaseTenant implements TenantWithDatabase
{

    use SoftDeletes, HasFactory, HasDatabase, HasDomains;


    public static function booted()
    {
        static::saved(function (self $model) {
            if ($model->is_primary) {
                $model->tenant->domains()
                    ->where('id', '!=', $model->id)
                    ->update(['is_primary' => false]);
            }
        });
    }

    protected $table = "companies";

    protected $fillable = [
        'company_code',
        'name',
        'address',
        'cnpj',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'company_code',
            'name',
            'address',
            'cnpj',
        ];
    }

    public function getIncrementing()
    {
        return true;
    }

    public function primary_domain(): HasOne
    {
        return $this->hasOne(CompanyDomain::class, 'tenant_id')->where('is_primary', true);
    }

    public function route(string $route, array $parameters = [], bool $absolute = true): string
    {
        if (!$this->primary_domain) {
            throw new Exception('Tenant does not have a primary domain.');
        }

        $domain = $this->primary_domain->domain;
        $parts = explode('.', $domain);

        if (count($parts) === 1) {
            $domain = $domain . '.' . config('tenancy.main_domain');
        }

        return tenant_route($domain, $route, $parameters, $absolute);
    }

    public function impersonationUrl(string $userId): string
    {
        $token = tenancy()->impersonate($this, $userId, $this->route('employeeHome'), 'tenant_employee')->token;
        return $this->route('portal', ['token' => $token]);
    }

    public function users()
    {
        return $this->belongsToMany(CentralEmployeeLogin::class, 'employee_company', 'company_id', 'global_user_id', 'id', 'global_id')
            ->using(CompanyPivot::class);
    }
}
