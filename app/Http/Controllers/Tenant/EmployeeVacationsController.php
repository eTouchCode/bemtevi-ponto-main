<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\CompanySettings;
use App\Models\Employee;
use App\Models\EmployeeVacation;
use Carbon;
use Illuminate\Http\Request;

class EmployeeVacationsController extends Controller
{
    public function index(Request $request)
    {
        $vacations = EmployeeVacation::where('vacation_end', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy('vacation_end', 'desc')->get();

        return view('pages/tenant/employee_vacations/index', ['vacations' => $vacations]);
    }

    public function new(Request $request)
    {
        $vacationTime = CompanySettings::select('value')->where('name', 'VACATION_TIME')->first();
        $employees = Employee::select('id', 'name')->where('status', 1)->get();
        return view('pages/tenant/employee_vacations/new', ['employees' => $employees, 'vacationTime' => $vacationTime]);
    }

    public function postNew(Request $request)
    {
        $attributes = $request->validate([
            'employee' => 'required|exists:employees,id',
            'period' => 'required'
        ]);

        $existing = EmployeeVacation::where(function ($query) {
            $query->whereBetween('vacation_start', [now()->startOfYear(), now()->endOfYear()]);
        })->orWhere(function ($query) {
            $query->whereBetween('vacation_end', [now()->startOfYear(), now()->endOfYear()]);
        })->where('employee_id', $attributes['employee'])->first();

        if ($existing) {
            return redirect()->back()->withErrors("Funcionário já tem/teve férias para este ano");
        }

        $vacationTime = CompanySettings::select('value')->where('name', 'VACATION_TIME')->first();
        $periods = array_map('trim', explode("|", $attributes['period'], 2));

        foreach ($periods as $key => $value) {
            $periods[$key] = Carbon::parse($value);
        }

        $vacation = new EmployeeVacation();
        $vacation->employee_id = $attributes['employee'];
        $vacation->vacation_start = $periods[0]->format('y-m-d');
        $vacation->vacation_end = $periods[1]->format('y-m-d');

        $days = $periods[0]->diff($periods[1])->days;
        if ($days > $vacationTime['value']) {
            return redirect()->back()->withErrors("Diferença de dias maior que o valor configurado ({$vacationTime['value']} dias)");
        }
        $vacation->duration = $days;

        $vacation->save();

        return redirect("/vacations")->with('status', 'Vacation Added!');
    }
}
