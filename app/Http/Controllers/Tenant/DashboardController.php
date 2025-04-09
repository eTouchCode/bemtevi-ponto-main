<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Camera;
use App\Models\Employee;
use App\Models\EmployeeAbsence;
use App\Models\EmployeeAttendance;
use App\Models\EmployeePayment;
use App\Models\EmployeeVacation;
use App\Models\Workshift;
use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Number;

class DashboardController extends Controller
{
    public function index()
    {

        $greetings = $this->getGreetings();
        $greetings['user'] = explode(" ", Auth::user()->name)[0];

        $cameras = Camera::all();
        $employees = Employee::select(['id', 'name'])->whereNotNull('position_id')->get();

        $stats = [
            'vacations' => Employee::where('status', 2)->get()->count(),
            'sick' => Employee::where('status', 3)->get()->count(),
            'absent' => $this->getShiftAbsences(),
            'missing' => 0,
        ];

        return view('dashboard.employer.index', compact('greetings', 'cameras', 'stats', 'employees'));
    }

    public function getGreetings()
    {
        $now = Carbon::now()->format('H:i:s');
        if ($now >= '08:00:00' && $now <= '22:00:00') {
            return [
                'symbol' => '☀️',
                'greeting' => 'Good Morning',
            ];
        } else {
            return [
                'symbol' => '🌕',
                'greeting' => 'Good Evening'
            ];
        }
    }

    public function employeeStats(Request $request, $employeeId)
    {

        $employee = Employee::find($employeeId);
        // dd($employee);

        $payment = $employee->payments()->whereBetween('payment_date', [
            now()->subMonth()->firstOfMonth(),
            now()->lastOfMonth(),
        ])->orderBy('id', 'desc')->first();

        if (!$payment) {
            $paymentDate = "";
            $lastSalary = "";
        } else {
            $paymentDate = Carbon::parse($payment->payment_date)->format('d/m/Y');
            $lastSalary = Number::currency(json_decode($payment->employee_summary)->salary, 'BRL');
        }


        $nextVacation = EmployeeVacation::where('employee_id', $employee->id)->where(
            'vacation_start',
            '>=',
            now()->addDay()
        )->first();

        if ($nextVacation) {
            $employeeVacation = Carbon::parse($nextVacation->vacation_start);
            $nextVacationDate = [
                'date' => $employeeVacation->format('d/m/y'),
                'diff' => $employeeVacation->diffForHumans(),
            ];
        } else {
            $nextVacationDate = [
                'date' => "Não Informada",
                'diff' => '',
            ];
        }

        $contract_start = Carbon::parse($employee->contract_start);

        $absence = $employee->absence()->orderBy('absence_date', 'desc')->get();
        if ($absence->isNotEmpty()) {
            $lastAbsence = Carbon::parse($absence->first()->absence_date);
            $lastAbsencediff = $lastAbsence->diffInDays() == 0 ? "Hoje" : $lastAbsence->diffForHumans();
        } else {
            $lastAbsence = "N/A";
            $lastAbsencediff = "";
        }


        return response()->json([
            'contract_start' => [
                'date' => $contract_start->format('d/m/Y'),
                'diff' => $contract_start->diffForHumans(),
            ],
            'last_payment' => [
                'date' => $paymentDate,
                'salary' => $lastSalary,
            ],
            'next_vacation' => $nextVacationDate,
            'hour_bank' => $this->getHourBank($employee),
            //TODO eventos de falta
            'absent_days' => [
                'amount' => $absence->count(),
                'last_absence' => $lastAbsence instanceof Carbon ? $lastAbsence->format('d/m/Y') : $lastAbsence,
                'last_absencediff' => $lastAbsencediff,
            ],
            //TODO eventos de folga
            'break_days' => [
                'amount' => 0,
                'last_break' => now()->subDays(5)->format('d/m/Y'),
                'last_breakdiff' => now()->subDays(5)->diffForHumans()
            ]
        ]);
    }

    public function getHourBank($employee)
    {

        //Hours in a month
        $monthHours = multiplyTime($employee->position->workshift->shift_duration, now()->lastOfMonth()->day);

        $attendance = EmployeeAttendance::where('employee_id', $employee->id)
            ->whereBetween('date', [now()->firstOfMonth()->format('Y-m-d'), now()->lastOfMonth()->format('Y-m-d')])
            ->get();

        $hoursWorked = sumTime($attendance->pluck('shiftDuration')->toArray());
        $extraHours = sumTime($attendance->pluck('shiftExtraTime')->toArray());

        $attendance = $attendance->paginate(10);

        return [
            'monthHours' => $monthHours,
            'hoursWorked' => $hoursWorked,
            'extraHours' => $extraHours,
        ];
    }

    public function getShiftAbsences()
    {
        $currentTime = now()->format('H:i:s');
        $currentWorkshifts = Workshift::where('start_time', '<=', $currentTime)->where('end_time', ">=", $currentTime)->get();

        $absenceCount = 0;

        foreach ($currentWorkshifts as $currentWorkshift) {
            $absenceCount += $currentWorkshift->employees()->whereDoesntHave('attendance', function (Builder $query) {
                $query->where('date', now()->format('Y-m-d'));
            })->count();
        }

        return $absenceCount;
    }

    public function employeeAbsence(Request $request, $date = null)
    {

        if (!$date) {
            $date = now()->subDay()->format('Y-m-d');
        }

        $absences = EmployeeAbsence::with('employee')->where('absence_date', $date)->get();

        $totalAbsences = [];

        foreach ($absences as $absence) {
            $totalAbsences[] = [
                'employee' => $absence->employeeName(),
                'reason' => __($absence->absence_reason)
            ];
        }

        return response()->json($totalAbsences);
    }

    public function employeeAttendance(Request $request, $employeeId)
    {

        $employee = Employee::find($employeeId);

        $attendance = EmployeeAttendance::where('employee_id', $employee->id)
            ->whereBetween('date', [now()->firstOfMonth()->format('Y-m-d'), now()->lastOfMonth()->format('Y-m-d')])
            ->orderBy('date', 'desc')
            ->simplePaginate(perPage: 15, columns: ['date', 'firstEntranceTime', 'breakDuration', 'secondExitTime'], page: $request['page']);


        $formattedAttendance = collect();

        foreach ($attendance->items() as $item) {
            $formattedAttendance->add([
                'date' => Carbon::parse($item['date'])->format('d/m/Y'),
                'firstEntranceTime' => $item['firstEntranceTime'],
                'breakDuration' => $item['breakDuration'],
                'secondExitTime' => $item['secondExitTime'],
            ]);
        }

        return response()->json([
            'data' => $formattedAttendance,
            'links' => $attendance->links()->render()
        ]);
    }
}
