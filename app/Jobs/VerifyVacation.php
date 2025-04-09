<?php

namespace App\Jobs;

use App\Models\Admin\Company;
use App\Models\EmployeeVacation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Stancl\Tenancy\Contracts\Tenant;

class VerifyVacation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = now()->format('Y-m-d');

        tenancy()->runForMultiple(Company::all(), function () use ($today) {
            $vacations = EmployeeVacation::with('employee')
                ->where('vacation_start', $today)
                ->orWhere('vacation_end', $today)
                ->get();


            foreach ($vacations as $vacation) {
                $employee = $vacation->employee;
                if ($vacation->vacation_start == $today) {
                    Log::info($employee);
                    $employee->status = 2;
                } else {
                    $employee->status = 1;
                }
                $employee->save();
            }
        });
    }
}
