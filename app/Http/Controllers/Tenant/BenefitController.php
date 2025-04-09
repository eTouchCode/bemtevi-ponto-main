<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BenefitController extends Controller
{
    public function index()
    {
        $benefits = Benefit::paginate(20);
        return view("pages/tenant/benefit/index", ['benefits' => $benefits]);
    }

    public function new(Request $request)
    {
        return view("pages/tenant/benefit/new");
    }

    public function create(Request $request)
    {
        $attributes = $request->validate([
            "name" => "required",
            "amount" => "required",
            "percentageValue" => "nullable",
        ]);

        try {
            $benefit = new Benefit($attributes);
            $benefit->amount = currencyToFloat($benefit->amount);
            $benefit->percentageValue = isset($attributes["percentageValue"]) ? true : false;
            $benefit->save();

            return redirect()->back()->with('status', 'Create Success!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Create Failed!');
        }
    }

    public function edit(Request $request, $id)
    {
        $benefit = Benefit::findOrFail($id);
        return view('pages/tenant/benefit/edit', ['benefit' => $benefit]);
    }

    public function postEdit(Request $request, $id)
    {

        $attributes = $request->validate([
            "name" => "required",
            "amount" => "required",
            "percentageValue" => "nullable",
        ]);

        try {
            $benefit = Benefit::findOrFail($id)->fill($attributes);
            $benefit->amount = currencyToFloat($benefit->amount);
            $benefit->percentageValue = isset($attributes["percentageValue"]) ? true : false;
            $benefit->save();

            return redirect()->back()->with('status', 'Edit Success!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Edit Failed!');
        }
    }

    public function destroy($id)
    {
        $benefit = Benefit::findOrFail($id);
        $benefit->delete();

        return redirect()->back()->with('status', 'benefit Deleted');
    }
}
