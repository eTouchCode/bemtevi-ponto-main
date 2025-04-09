<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Workshift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkshiftController extends Controller
{

    public function index()
    {
        $workshifts = Workshift::paginate(20);
        return view("pages/tenant/workshift/index", ['workshifts' => $workshifts]);
    }

    public function new(Request $request)
    {
        return view("pages/tenant/workshift/new");
    }

    public function create(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'break_amount' => 'required|date_format:H:i',
            'break_time' => 'required|date_format:H:i',
        ]);

        $workshift = new Workshift($attributes);

        $workshift->save();
        return redirect("/workshifts/edit/{$workshift->id}")->with('status', 'Workshift Added!');
    }

    public function edit(Request $request, $id)
    {
        $workshift = Workshift::findOrFail($id);
        
        return view('pages/tenant/workshift/edit', ['workshift' => $workshift]);
    }

    public function postEdit(Request $request, $id)
    {

        $attributes = $request->validate([
            'name' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'break_amount' => 'required|date_format:H:i',
            'break_time' => 'required|date_format:H:i',
        ]);

        try {
            $workshift = Workshift::findOrFail($id)->fill($attributes);
            $workshift->save();

            return redirect()->back()->with('status', 'Edit Success!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', 'Edit Failed!');
        }
    }

    public function destroy($id)
    {
        $salary = Workshift::findOrFail($id);
        $salary->delete();

        return redirect()->back()->with('status', 'Workshift Deleted');
    }
}

