<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Salary;
use App\Models\Workshift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{

    public function index()
    {
        $positions = Position::with(['salary', 'workshift'])->paginate(20);
        return view('pages/tenant/position/index', ['positions' => $positions]);
    }

    public function new()
    {
        $salary = Salary::all();
        $workShift = Workshift::all();

        return view('pages/tenant/position/new', ['salaries' => $salary, 'workshifts' => $workShift]);
    }

    public function create(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'salary_id' => 'required|exists:salaries,id',
            'workshift_id' => 'required|exists:work_shifts,id',
        ]);

        $position = Position::create($attributes);

        return redirect("/positions/edit/{$position->id}")->with('status', 'Position Added!');
    }

    public function edit(Request $request, $id)
    {
        $position = Position::with(['salary', 'workshift'])->findOrFail($id);

        return view(
            'pages/tenant/position/edit',
            [
                'position' => $position,
                'salaries' => Salary::all(),
                'workshifts' => Workshift::all()
            ]
        );
    }

    public function postEdit(Request $request, $id)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'salary_id' => 'required|exists:salaries,id',
            'workshift_id' => 'required|exists:work_shifts,id',
        ]);
        try {
            $position = Position::findOrFail($id)->fill($attributes);
            $position->save();
            return redirect()->back()->with('status', 'Edit Sucessful!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->with('error', "Edit Failed!");
        }
    }


    public function destroy($id)
    {
        $employee = Position::find($id);
        $employee->delete();

        return redirect()->back()->with('status', 'Position deleted');
    }
}
