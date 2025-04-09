<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAttendance extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'firstEntranceTime',
        'firstExitTime',
        'breakDuration',
        'secondEntranceTime',
        'secondExitTime',
        'shiftDuration',
        'shiftExtraTime',
    ];


    public function clockIn($clockInTime)
    {
        // dd($this->employee->status);
        if ((int) $this->employee->status !== 1) {
            return 'employee_status_error';
        }

        $times = [
            'firstEntranceTime',
            'firstExitTime',
            'secondEntranceTime',
            'secondExitTime',
        ];

        foreach ($times as $key => $time) {
            if (!empty($this->{$time} && array_key_exists($key + 1, $times))) {
                if (!empty($this->{$times[$key + 1]})) {
                    continue;
                }

                $this->{$times[$key + 1]} = $clockInTime;
                if ($times[$key + 1] == "secondEntranceTime") {
                    //Break Duration
                    $breakduration = Carbon::parse($this->secondEntranceTime)
                        ->diff(Carbon::parse($this->firstExitTime))->format('%H:%I:%S');

                    $this->breakDuration = $breakduration;
                } else if ($times[$key + 1] == "secondExitTime") {
                    //Total Duration + extra

                    //WorkShift minimum duration
                    $workShift = Carbon::parse($this->employee->position->workshift->shift_duration);

                    //Total Shift Time
                    $totalDurationDiff = Carbon::parse($this->firstEntranceTime)
                        ->diff(Carbon::parse($this->secondExitTime));


                    //Total Shift Time minus Break Duration
                    $breakDuration = Carbon::parse($this->breakDuration);
                    $totalDurationDiff = Carbon::parse($totalDurationDiff->format("%H:%I:%S"))
                        ->subHours($breakDuration->hour)
                        ->subMinutes($breakDuration->minute)
                        ->subSeconds($breakDuration->second);

                    $this->shiftDuration = $totalDurationDiff->format('H:i:s');

                    if ($workShift->gte($this->shiftDuration)) {
                        $this->shiftExtraTime = null;
                    } else {
                        $this->shiftExtraTime = Carbon::parse($this->shiftDuration)->diff($workShift)->format("%H:%I:%S");
                    }
                }
                break;
            } else if ($key == array_key_last($times)) {
                return 'clock_in_error';
            } else {
                $this->{$time} = $clockInTime;
                break;
            }
        }

        $this->save();
        return 'success';
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
