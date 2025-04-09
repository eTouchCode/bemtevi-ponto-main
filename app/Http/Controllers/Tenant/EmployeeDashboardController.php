<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeVacation;
use App\Models\Warnings;
use Auth;
use Cache;
use Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeDashboardController extends Controller
{

    public function index()
    {

        $employee = Auth::user()->employee;

        $greetings = $this->getGreetings();
        $greetings['user'] = explode(" ", $employee->name)[0];

        $vacation = $this->getVacationInfo($employee);
        $hourBank = $this->getHourBank($employee);



        if (!empty($employee->dateofbirth)) {
            $birthday = $this->getBirthday($employee->dateofbirth);
        } else {
            $birthday = null;
        }

        //TODO 13° Salário
        $extraSalary = 0;

        return view(
            'dashboard.employee.index',
            compact(
                'greetings',
                'vacation',
                'hourBank',
                'birthday',
                'extraSalary'
            )
        );
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

    public function getVacationInfo($employee)
    {
        $nextVacation = EmployeeVacation::where('employee_id', $employee->id)->where(
            'vacation_start',
            '>=',
            now()->addDay()
        )->first();

        if ($nextVacation) {
            $nextVacationDate = Carbon::parse($nextVacation->vacation_start)->format('d/m/Y');
            $nextVacationDiff = Carbon::parse($nextVacation->vacation_start)->diffForHumans(now(), CarbonInterface::DIFF_RELATIVE_TO_NOW);
            $nextVacationDiffNumber = Carbon::parse($nextVacation->vacation_start)->diff(now())->days;
        } else {
            $nextVacationDate = "Não Informada";
            $nextVacationDiff = '';
            $nextVacationDiffNumber = null;
        }

        return [
            'nextVacationDate' => $nextVacationDate,
            'nextVacationDiff' => $nextVacationDiff,
            'nextVacationDiffNumber' => $nextVacationDiffNumber
        ];
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

        return [
            'attendance' => $attendance->paginate(5),
            'monthHours' => $monthHours,
            'hoursWorked' => $hoursWorked,
            'extraHours' => $extraHours,
        ];
    }

    public function getBirthday($birthday)
    {
        $date = Carbon::parse($birthday)->year(now()->year);
        return [
            'birthday' => $date->format('d/m/Y'),
            'diff' => now()->diffInDays($date, false),
        ];
    }

    public function clockIn(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'long' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('employeeHome')->withErrors('Erro de geolocalização, tente novamente');
        }

        $attributes = $validator->safe()->all();

        $settings = Cache::get('company_settings');

        if ((boolean) $settings['CLOCK_IN_DISTANCE_ENABLE']['value']) {

            $coordinates = explode(',', $settings['COMPANY_LOCATION']['value']);

            $employeeLocation = [
                'lat' => $attributes['lat'],
                'long' => $attributes['long']
            ];

            $companyLocation = [
                'lat' => $coordinates[0],
                'long' => $coordinates[1],
            ];

            $distance = distanceLocations($employeeLocation, $companyLocation);
            if ($distance > floatval($settings['CLOCK_IN_DISTANCE_RANGE']['value'])) {
                return redirect()->route('employeeHome')->withErrors('Erro de geolocalização, tente novamente');
            }
        }

        $now = Carbon::now();
        $employee = Auth::user()->employee;

        if (!$employee->position) {
            return redirect('/system')->withErrors('Funcionário sem cargo, entre em contato com a administração');
        }

        $clockIn = EmployeeAttendance::firstOrNew(['date' => $now->format('Y-m-d'), 'employee_id' => $employee->id]);
        $clockInAction = $clockIn->clockIn($now->format('H:i:s'));

        if ($clockInAction == 'success') {
            return redirect('/system')->with('status', "Ponto Registrado!");
        } else if ($clockInAction == "employee_status_error") {
            $employeeStatus = __($employee->getStatus());
            return redirect('/system')->withErrors("Status de Empregado é {$employeeStatus}, Entre em contato com a administração");
        } else {
            return redirect('/system')->withErrors("Ultimo Ponto diário ja foi Registrado!");
        }

    }
}
