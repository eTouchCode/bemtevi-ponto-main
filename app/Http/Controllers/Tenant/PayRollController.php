<?php

namespace App\Http\Controllers\Tenant;

use App\Exports\PaymentsExport;
use App\Http\Controllers\Controller;
use App\Models\AdditionalPayment;
use App\Models\Admin\TaxRate;
use App\Models\Employee;
use App\Models\EmployeePayment;
use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PayRollController extends Controller
{

    const MINIMUM_WAGE = 1412.00;

    public function index()
    {
        $payments = EmployeePayment::with('employee')->orderBy('id', 'desc')->paginate(20);
        return view('pages/tenant/pay_roll/index', ['payments' => $payments]);
    }

    public function new()
    {
        $additionals = AdditionalPayment::all();
        $employees = Employee::select(['id', 'name'])->whereNotNull('position_id')->get();
        return view('pages/tenant/pay_roll/new', compact('additionals', 'employees'));
    }

    public function exportPayments(Request $request)
    {
        $attributes = $request->validate([
            'period' => "required|date_format:m-Y",
        ]);

        $period = Carbon::createFromFormat('m-Y', $attributes['period']);
        $periods = [
            $period->firstOfMonth()->format('Y-m-d'),
            $period->lastOfMonth()->format('Y-m-d')
        ];
        $paymentPeriod = [
            'date' => $period->format('F/Y'),
            'days' => $period->lastOfMonth()->day
        ];


        $payments = EmployeePayment::with('employee')->whereBetween('payment_date', $periods)->get();

        $PDF = Pdf::loadView('exports.payments.holerite', compact('payments', 'paymentPeriod'));

        return $PDF->stream();
    }

    public function show(Request $request, $paymentId)
    {
        $payment = EmployeePayment::where('id', $paymentId)->with('employee')->first();

        if (!$payment) {
            return response()->json([
                'error' => true,
            ], 500);
        }

        return response()->json([
            'error' => false,
            'payment' => $payment
        ], 200);
    }

    public function createPayroll(Request $request)
    {
        $attributes = $request->validate([
            "employee" => "required|exists:employees,id",
            "payment_date" => "required|date",
            "employeeSalary" => "required",
            "contributions" => "required",
            "fgtsResult" => "required",
            "inssResult" => "required",
            "irResult" => "required",
            "additionals" => "nullable",
            "employeeDiscount" => "required",
            "employeeINSS" => "required",
            "employeeIR" => "required",
            "summaryEmployeeSalary" => "required",
            "companyEmployeeValue" => "required",
            "companyEmployeeSalary" => "required",
            "companyInss" => "required",
            "companyFGTS" => "required",
            "bases" => "required",
        ]);

        foreach ($attributes as $attrKey => $attribute) {
            if (is_array($attribute)) {
                foreach ($attribute as $key => $att) {
                    if (is_array($att)) {
                        foreach ($att as $nestedKey => $nestedAtt) {
                            $sanitized = extractFloatCurrency($nestedAtt);
                            $attributes[$attrKey][$key][$nestedKey] = is_null($sanitized) ? $attributes[$attrKey][$key][$nestedKey] : $sanitized;
                        }
                    } else {
                        $sanitized = extractFloatCurrency($att);
                        $attributes[$attrKey][$key] = is_null($sanitized) ? $attributes[$attrKey][$key] : $sanitized;
                    }
                }
            } else {
                $sanitized = extractFloatCurrency($attribute);
                $attributes[$attrKey] = is_null($sanitized) ? $attributes[$attrKey] : $sanitized;
            }
        }

        try {
            $employeePayment = new EmployeePayment();
            $employeePayment->employee_id = $attributes['employee'];
            $employeePayment->payment_date = $attributes['payment_date'];
            $employeePayment->salary = $attributes['employeeSalary'];
            $employeePayment->discounts = $attributes['employeeDiscount'];

            $employeePayment->contribution_fgts = $attributes['fgtsResult'];
            $employeePayment->fgts_taxrate = $attributes['contributions']['fgts'];
            $employeePayment->fgts_base = $attributes['bases']['fgts'];

            $employeePayment->contribution_inss = $attributes['inssResult'];
            $employeePayment->inss_taxrate = $attributes['contributions']['inss'];
            $employeePayment->inss_base = $attributes['bases']['inss'];

            $employeePayment->contribution_ir = $attributes['irResult'];
            $employeePayment->ir_taxrate = $attributes['contributions']['ir'];
            $employeePayment->ir_base = $attributes['bases']['ir'];

            $employeePayment->additionals = json_encode($attributes['additionals'] ?? []);
            $employeePayment->additionals_total = json_encode([]);
            $employeePayment->employee_summary = json_encode([
                'salary' => $attributes['summaryEmployeeSalary'],
                'fgts' => $employeePayment->contribution_fgts,
                'inss' => $employeePayment->contribution_inss,
                'ir' => $employeePayment->contribution_ir,
                'tax_rates' => [
                    'fgts' => $employeePayment->fgts_taxrate,
                    'inss' => $employeePayment->inss_taxrate,
                    'ir' => $employeePayment->ir_taxrate,
                ]
            ]);
            $employeePayment->employer_summary = json_encode([
                'companyEmployeeValue' => $attributes['companyEmployeeSalary'],
                'companyINSS' => $attributes['companyInss'],
                'companyFGTS' => $attributes['companyFGTS']
            ]);
            $employeePayment->save();
            return redirect()->to('/payroll')->with(['status', 'Payroll Created!']);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->withErrors('Error Creating Payroll');
        }
    }

    public function fetchEmployee(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee' => 'required',
            'additionals' => 'nullable',
            'discount' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => "Validation Error"
            ], 500);
        }

        $validated = $validator->safe()->all();

        if (isset($validated['discount'])) {
            $employeeDiscount = currencyToFloat($validated['discount']);
        } else {
            $employeeDiscount = 0;
        }

        $employee = Employee::with('position.salary')->where("id", $validated['employee'])->whereNotNull('position_id')->first();


        if (!$employee) {
            return response()->json([
                'error' => 'employee not found',
            ], 404);
        }


        $employeeSalary = $employee->position->salary->amount;
        $additionalSum = 0;
        $salaryIncidences = [
            'inss' => 0,
            'fgts' => 0,
            'ir' => 0,
        ];

        if (isset($validated['additionals'])) {
            $additionals = AdditionalPayment::whereIn('id', array_keys($validated['additionals']))->get();

            $additionals->each(function ($value, $key) use ($validated, $additionals) {
                $add = (object) $validated['additionals'][$value->id];

                $additionals[$key]->amount = currencyToFloat($add->amount);
                $additionals[$key]->percentageValue = isset($add->percentageValue) ? 1 : 0;
            });
        }
        // Somando todos os adicionais
        if ($additionals) {

            foreach ($additionals->all() as $additional) {

                $incidences = [
                    'fgts' => $additional->fgts,
                    'inss' => $additional->inss,
                    'ir' => $additional->ir
                ];

                $additionalValues = [
                    'name' => $additional->name,
                ];

                if ($additional->percentageValue) {
                    $additionalValues['value'] = [
                        'amount' => round($employee->position->salary->amount * ($additional->amount / 100)),
                        'percentage' => (bool) $additional->percentageValue,
                        'percentageValue' => $additional->amount
                    ];
                } else {
                    $additionalValues['value'] = [
                        'amount' => $additional->amount,
                        'percentageValue' => (bool) $additional->percentageValue,
                    ];
                }

                $additionalSum += $additionalValues['value']['amount'];
                $addPayment[] = $additionalValues;

                foreach ($incidences as $key => $incidence) {

                    if (!$incidence) {
                        continue;
                    }

                    if ($additional->percentageValue) {
                        $salaryIncidences[$key] += $employee->position->salary->amount * ($additional->amount / 100);
                    } else {
                        $salaryIncidences[$key] += $additional->amount;
                    }
                }
            }
        }

        $taxRates['FGTS'] = [
            'name' => 'FGTS',
            'percentage' => 8.00,
        ];

        $contributions['FGTS'] = round(($employeeSalary + $salaryIncidences['fgts']) * (8 / 100), 2);

        $calcBases['fgts'] = $employeeSalary + $salaryIncidences['fgts'];

        $inssTaxRate = TaxRate::where('name', 'INSS')->where('start_value', "<=", $employeeSalary + $salaryIncidences['inss'])
            ->where('end_value', ">=", $employeeSalary)
            ->first();

        $taxRates['INSS'] = $inssTaxRate;

        $contributions['INSS'] = round((($employeeSalary + $salaryIncidences['inss']) *
            ($inssTaxRate->percentage / 100)) - $inssTaxRate->reduction_value, 2);

        $calcBases['inss'] = $employeeSalary + $salaryIncidences['inss'];

        $irTaxRate = TaxRate::where('name', 'IR')->where('start_value', "<=", $employeeSalary - $contributions['INSS'])
            ->where('end_value', ">=", $employeeSalary - $contributions['INSS'])
            ->first();

        $taxRates['IR'] = $irTaxRate;

        $irCalc1 = ($employeeSalary - $contributions['INSS']) * $irTaxRate->percentage / 100 - $irTaxRate->reduction_value;

        $irCalc2_1 = (self::MINIMUM_WAGE * 2) * 0.20;
        $irCalc2 = ($employeeSalary - $irCalc2_1) * ($irTaxRate->percentage / 100) - $irTaxRate->reduction_value;

        if ($irCalc1 < $irCalc2) {
            $contributions['IR'] = round($irCalc1, 2);
            $calcBases['ir'] = $employeeSalary - $contributions['INSS'];
        } else {
            $contributions['IR'] = round($irCalc2, 2);
            $calcBases['ir'] = $employeeSalary - $irCalc2_1;
        }

        $summaryEmployeeSalary = $employeeSalary + $additionalSum - $employeeDiscount - $contributions['INSS'] - $contributions['IR'];
        $summaryEmployerValue = $summaryEmployeeSalary + $contributions['INSS'] + $contributions['FGTS'] + $contributions['IR'];

        $summary = [
            'employee' => [
                'discounts' => $employeeDiscount,
                'salary' => $summaryEmployeeSalary,
                'netSalary' => $employeeSalary,
                'inss_amount' => $contributions['INSS'],
                'ir_amount' => $contributions['IR'],
            ],
            'company' => [
                'salary' => $summaryEmployerValue,
                'totalValue' => $summaryEmployeeSalary,
                'inss_amount' => $contributions['INSS'],
                'fgts_amount' => $contributions['FGTS'],
            ]
        ];

        return response()->json([
            'employee' => $employee,
            'taxRates' => $taxRates,
            'contributions' => $contributions,
            'additionals' => $addPayment,
            'summary' => $summary,
            'bases' => $calcBases,
        ]);
    }

    public function fetchEmployeeAdditionals(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'error' => 'employee not found',
            ], 404);
        }

        //choicesjs só aceita string como indice 
        $additionalData = $employee
            ->additionals()
            ->select('id', 'amount', 'name', 'percentageValue')
            ->get();

        return response()->json([
            'data' => $additionalData
        ]);
    }

    public function getAdditionalsById(Request $request, $id)
    {
        $additional = AdditionalPayment::where('id', $id)->select('id', 'amount', 'name', 'percentageValue')->first();

        if (!$additional) {
            return response()->json([
                'error' => true,
                'message' => 'Additional not found'
            ]);
        }

        return response()->json(
            $additional
        );
    }
}
