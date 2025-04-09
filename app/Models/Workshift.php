<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Workshift extends Model
{
    use HasFactory;

    protected $table = 'work_shifts';

    public static function boot()
    {
        parent::boot();

        self::creating(function ($workshift) {
            $workshift->setShiftDuration();
        });

        self::updating(function ($workshift) {
            $workshift->setShiftDuration();
        });
    }

    protected $fillable = [
        'name',
        'start_time',
        'break_time',
        'break_amount',
        'end_time',
        'shift_duration',
    ];


    public function setShiftDuration()
    {
        $start_time = Carbon::parse($this->start_time);
        $break_amount = Carbon::parse($this->break_amount);
        $end_time = Carbon::parse($this->end_time);
        $shiftDuration = Carbon::parse($start_time->diff($end_time)->format("%H:%I:%S"));

        $this->shift_duration = $shiftDuration->subHours($break_amount->hour)->subMinutes($break_amount->minute);
    }


    public function employees(): HasManyThrough
    {
        return $this->hasManyThrough(Employee::class, Position::class);
    }
}
