<?php

namespace App\Console;

use App\Jobs\VerifyAbsentees;
use App\Jobs\VerifyVacation;
use App\Models\Admin\Company;
use App\Models\Workshift;
use Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        tenancy()->runForMultiple(Company::all(), function () use ($schedule) {
            $workshifts = Workshift::all();

            foreach ($workshifts as $workshift) {

                $endTime = explode(":", $workshift->end_time);
                $shiftEnd = Carbon::now();
                $shiftEnd->hour = $endTime[0];
                $shiftEnd->minute = $endTime[1];
                $shiftEnd->addMinutes(30);

                if ($shiftEnd->isCurrentMinute()) {
                    $schedule->job(new VerifyAbsentees(tenant(), $workshift->id))->when($shiftEnd->isCurrentMinute());
                }
            }
        });

        $schedule->job(new VerifyVacation)->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
