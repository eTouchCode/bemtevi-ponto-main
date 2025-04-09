<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Models\Domain;

class CompanyDomain extends Domain
{
    use HasFactory;

    protected $table = 'domains';

    public function makePrimary(): static
    {
        $this->update([
            'is_primary' => true,
        ]);

        $this->tenant->setRelation('primary_domain', $this);

        return $this;
    }
}
