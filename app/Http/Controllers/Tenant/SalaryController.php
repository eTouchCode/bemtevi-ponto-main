<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;

class SalaryController extends Controller
{

    public function index()
    {
        $salaries = Salary::paginate(20);
        return view("pages/tenant/salary/index", ['salaries' => $salaries]);
    }

    public function new(Request $request)
    {
        return view("pages/tenant/salary/new");
    }

    public function create(Request $request)
    {
        $attributes = $request->validate([
            "name" => "required",
            "amount" => "required"
        ]);

        try {
            $salary = new Salary($attributes);
            $salary->amount = currencyToFloat($salary->amount);
            $salary->save();

            return redirect()->back()->with('status', 'Create Success!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Create Failed!');
        }
    }

    public function edit(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);

        return view('pages/tenant/salary/edit', ['salary' => $salary]);
    }

    public function postEdit(Request $request, $id)
    {

        $attributes = $request->validate([
            "name" => "required",
            "amount" => "required",
            "temporary" => "nullable",
            "oldValue" => "nullable",
        ]);
        try {
            $salary = Salary::findOrFail($id)->fill($attributes);

            if (isset($attributes['temporary'])) {
                $salary->temporary_change = true;
                $salary->change_date = now()->format('Y-m-d');
                $salary->old_amount = (float) $attributes['oldValue'];
            }

            $salary->amount = currencyToFloat($salary->amount);

            $salary->save();

            return redirect()->back()->with('status', 'Edit Success!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Edit Failed!');
        }
    }

    public function destroy($id)
    {
        $salary = Salary::findOrFail($id);
        $salary->delete();

        return redirect()->back()->with('status', 'Salary Deleted');
    }
}
