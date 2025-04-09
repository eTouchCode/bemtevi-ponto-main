<?php

namespace App\Jobs;

use App\Models\Admin\Company;
use App\Models\Workshift;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Stancl\Tenancy\Database\Concerns\TenantConnection;

class VerifyAbsentees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, TenantConnection;


    protected $company;
    protected $workshiftId;

    /**
     * Create a new job instance.
     */
    public function __construct(Company $company, $workshiftId)
    {
        $this->company = $company;
        $this->workshiftId = $workshiftId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        tenancy()->initialize($this->company);

        tenant()->run(function () {
            $today = now()->format('Y-m-d');
            $workshift = Workshift::find($this->workshiftId);

            foreach ($workshift->employees as $employee) {
                $attendance = $employee->attendance()->where('date', $today)->first();
                $absence = $employee->absence()->where('absence_date', $today)->first();
                if (!$attendance && !$absence) {
                    $employee->absence()->create([
                        'employee_id' => $employee->id,
                        'absence_date' => $today,
                        'absence_reason' => "ATTENDANCE_NOT_FOUND"
                    ]);
                }
            }
        });
    }
}
