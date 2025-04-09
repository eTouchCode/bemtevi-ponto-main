<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Admin\TaxRate;
use App\Models\Employee;
use App\Models\EmployeePayment;
use App\Models\EmployeeVacation;
use Carbon;
use Illuminate\Http\Request;
use Validator;

class EmployeeContractController extends Controller
{
    public function endContractView(Request $request, $id)
    {
        $employee = Employee::select('id', 'name', 'contract_start')->find($id);
        if (!$employee) {
            return redirect('/employees')->with('error', 'Employee Not Found!');
        }

        $contract_start = Carbon::createFromDate($employee->contract_start);
        $contract_duration = $contract_start->diffForHumans();
        return view('pages/tenant/employee_contract/index', [
            'employee' => $employee,
            'contract_start' => $contract_start->format('d/m/Y'),
            'contract_duration' => $contract_duration,
        ]);
    }

    public function simulateContractEnd(Request $request, $employeeId)
    {

        $validator = Validator::make($request->all(), [
            'quitType' => 'required|numeric',
            'contract_end' => 'required|date',
            'notice' => 'nullable',
            'fgtsBalance' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Validation Error'
            ], 500);
        }

        $attributes = $validator->safe()->all();

        $employee = Employee::find($employeeId);

        $quitType = (int) $attributes['quitType'];
        $contract_end = Carbon::parse($attributes['contract_end']);
        $previousNotice = isset($attributes['notice']);
        $fgtsBalance = isset($attributes['fgtsBalance']) ? currencyToFloat($attributes['fgtsBalance']) : 0;



        $data = null;

        switch ($quitType) {
            case 1:
                $data = $this->unfairDismissal($employee, $contract_end, $previousNotice, $fgtsBalance);
                break;
            case 2:
                $data = $this->employeeRequest($employee, $contract_end, $previousNotice, $fgtsBalance);
                break;
            case 3:
                break;
            case 4:
                break;
            case 5:
                break;
            case 6:
                break;
            case 7:
                break;
            default:
                return "Error";
        }

        // dd($employee);
        return response()->json($data);
    }


    public function unfairDismissal(Employee $employee, Carbon $contract_end, bool $previousNotice, float $fgtsBalance)
    {

        $workedDays = $contract_end->day;

        $salaryBalance['balance'] = $this->getSalaryBalance($employee->position->salary->amount, $workedDays);
        $salaryBalance['13thSalary'] = $this->get13Salary($employee->position->salary->amount, $contract_end->month);
        $salaryBalance['vacations'] = $this->getVacation($employee);
        $salaryBalance['proportionalVacation'] = $this->getProportionalVacation($employee->position->salary->amount, $contract_end->month);
        $salaryBalance['fgtsBalance'] = $this->getFGTSEstimate(
            $employee->position->salary->amount,
            $employee->contract_start,
            $contract_end->format('Y-m-d'),
            $fgtsBalance
        );

        if ($previousNotice) {
            $salaryBalance['notice'] = 0;
        } else {
            $salaryBalance['notice'] = $employee->position->salary->amount;
        }

        return view('pages.tenant.employee_contract.results.unfairDismissal', ['data' => $salaryBalance])->render();
    }

    public function employeeRequest(Employee $employee, Carbon $contract_end, bool $previousNotice, float $fgtsBalance)
    {
        $salaryBalance = [];

        return view('pages.tenant.employee_contract.results.employeeRequest', ['data' => $salaryBalance])->render();
    }

    public function getSalaryBalance($salary, $dayAmount)
    {
        $salaryBalance = [];

        $salaryBalance['amount'] = ($salary / 30) * $dayAmount;

        $inssRate = TaxRate::where('name', 'INSS')->where('start_value', "<=", $salaryBalance['amount'])
            ->where('end_value', ">=", $salaryBalance['amount'])
            ->first();
        $salaryBalance['inss'] = ($salaryBalance['amount'] * ($inssRate->percentage / 100)) - $inssRate->reduction_value;

        $irRate = TaxRate::where('name', "IR")->where('start_value', "<=", $salaryBalance['amount'] - $salaryBalance['inss'])
            ->where('end_value', ">=", $salaryBalance['amount'])->first();

        $salaryBalance['ir'] = ($salaryBalance['amount'] - $salaryBalance['inss']) * $irRate->percentage / 100 - $irRate->reduction_value;

        $salaryBalance['result'] = $salaryBalance['amount'] - $salaryBalance['inss'] - $salaryBalance['ir'];

        return $salaryBalance;
    }

    public function get13Salary($salary, $monthsWorked)
    {
        $extraSalaryBalance = [];

        $extraSalaryBalance['amount'] = ($salary / 12) * $monthsWorked;

        $inssRate = TaxRate::where('name', 'INSS')->where('start_value', "<=", $extraSalaryBalance['amount'])
            ->where('end_value', ">=", $extraSalaryBalance['amount'])->first();
        $extraSalaryBalance['inss'] = round(($extraSalaryBalance['amount'] * ($inssRate->percentage / 100)) - $inssRate->reduction_value, 2);

        $irRate = TaxRate::where('name', "IR")->where('start_value', "<=", $extraSalaryBalance['amount'] - $extraSalaryBalance['inss'])
            ->where('end_value', ">=", $extraSalaryBalance['amount'])->first();
        $extraSalaryBalance['ir'] = round(($extraSalaryBalance['amount'] - $extraSalaryBalance['inss']) * $irRate->percentage / 100 - $irRate->reduction_value, 2);

        $extraSalaryBalance['result'] = $extraSalaryBalance['amount'] - $extraSalaryBalance['inss'] - $extraSalaryBalance['ir'];

        return $extraSalaryBalance;
    }

    public function getProportionalVacation($salary, $monthsWorked)
    {

        $proportional['monthsWorked'] = $monthsWorked;
        $proportional['amount'] = ($salary / 12) * $monthsWorked;
        $proportional['result'] = $proportional['amount'] + ($proportional['amount'] / 3);

        return $proportional;
    }

    public function getVacation($employee)
    {

        $vacationAmount = EmployeeVacation::where(function ($query) {
            $query->whereBetween('vacation_start', [now()->startOfYear(), now()->endOfYear()]);
        })->orWhere(function ($query) {
            $query->whereBetween('vacation_end', [now()->startOfYear(), now()->endOfYear()]);
        })->where('employee_id', $employee->id)->get()->sum('duration');


        if ($vacationAmount < 30) {
            $vacationBalance['remainingDays'] = 30 - $vacationAmount;
            $vacationBalance['value'] = ($employee->position->salary->amount / 30) * $vacationBalance['remainingDays'];

            $inssRate = TaxRate::where('name', 'INSS')->where('start_value', "<=", $vacationBalance['value'])
                ->where('end_value', ">=", $vacationBalance['value'])->first();
            $vacationBalance['inss'] = round(($vacationBalance['value'] * ($inssRate->percentage / 100)) - $inssRate->reduction_value, 2);

            $irRate = TaxRate::where('name', "IR")->where('start_value', "<=", $vacationBalance['value'] - $vacationBalance['inss'])
                ->where('end_value', ">=", $vacationBalance['value'])->first();
            $vacationBalance['ir'] = round(($vacationBalance['value'] - $vacationBalance['inss']) * $irRate->percentage / 100 - $irRate->reduction_value, 2);


            $vacationBalance['additional'] = ($vacationBalance['value'] / 3);

            $vacationBalance['result'] = $vacationBalance['value'] + ($vacationBalance['value'] / 3) - $vacationBalance['inss'] - $vacationBalance['ir'];

            return $vacationBalance;

        } else {

            return [
                'remainingDays' => 0,
                'value' => 0,
                'inss' => 0,
                'ir' => 0,
                'additional' => 0,
                'result' => 0,
            ];
        }

    }

    public function getFGTSEstimate($salary, $hireDate, $quitDate, $previousBalance)
    {
        $dates = [
            'hireDate' => Carbon::parse($hireDate),
            'quitDate' => Carbon::parse($quitDate)->addMonth(),
        ];

        $fgtsValue = $salary * 8 / 100;

        if ($previousBalance > 0) {
            $fgtsResult = $previousBalance;
        } else {
            $fgtsResult = 0;
        }


        $difference = $dates['quitDate']->diffInMonths($dates['hireDate'], true);


        for ($i = 0; $i < $difference; $i++) {
            $fgtsResult += $fgtsValue;
        }

        return [
            'months' => $difference,
            'value' => $fgtsValue,
            'result' => $fgtsResult
        ];

    }
}
