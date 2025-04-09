<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\AdditionalPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdditionalPaymentController extends Controller
{
    public function index()
    {
        $additionalPayments = AdditionalPayment::paginate(20);
        return view("pages/tenant/additional_payment/index", ['additionalPayments' => $additionalPayments]);
    }

    public function new(Request $request)
    {
        return view("pages/tenant/additional_payment/new");
    }

    public function create(Request $request)
    {
        $attributes = $request->validate([
            "name" => "required",
            "amount" => "required",
            "percentageValue" => "nullable",
            "fgts" => "nullable",
            "inss" => "nullable",
            "ir" => "nullable",
        ]);

        try {
            $benefit = new AdditionalPayment($attributes);
            $benefit->amount = currencyToFloat($benefit->amount);
            $benefit->percentageValue = isset($attributes["percentageValue"]) ? true : false;
            $benefit->fgts = isset($attributes["fgts"]) ? true : false;
            $benefit->inss = isset($attributes["inss"]) ? true : false;
            $benefit->ir = isset($attributes["ir"]) ? true : false;
            $benefit->save();

            return redirect()->back()->with('status', 'Create Success!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Create Failed!');
        }
    }

    public function edit(Request $request, $id)
    {
        $additional = AdditionalPayment::findOrFail($id);
        return view('pages/tenant/additional_payment/edit', ['additional' => $additional]);
    }

    public function postEdit(Request $request, $id)
    {

        $attributes = $request->validate([
            "name" => "required",
            "amount" => "required",
            "percentageValue" => "nullable",
            "fgts" => "nullable",
            "inss" => "nullable",
            "ir" => "nullable",
        ]);

        try {
            $additional = AdditionalPayment::findOrFail($id)->fill($attributes);
            $additional->amount = currencyToFloat($additional->amount);
            $additional->percentageValue = isset($attributes["percentageValue"]) ? true : false;
            $additional->fgts = isset($attributes["fgts"]) ? true : false;
            $additional->inss = isset($attributes["inss"]) ? true : false;
            $additional->ir = isset($attributes["ir"]) ? true : false;
            $additional->save();

            return redirect()->back()->with('status', 'Edit Success!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Edit Failed!');
        }
    }

    public function destroy($id)
    {
        $additional = AdditionalPayment::findOrFail($id);
        $additional->delete();

        return redirect()->back()->with('status', 'Additional Payment Deleted');
    }
}
