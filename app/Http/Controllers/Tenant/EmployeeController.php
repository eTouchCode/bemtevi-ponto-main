<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\AdditionalPayment;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeFamily;
use App\Models\EmployeeLogin;
use App\Models\Position;
use Auth;
use Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{


    public function index()
    {
        $employees = Employee::where('status', '>', 0)
            ->paginate(20, ['id', 'name', 'email', 'contract_start', 'position_id', 'status']);

        return view('pages/tenant/employee/index', ['employees' => $employees]);
    }

    public function new()
    {

        $positions = Position::all();
        $additionals = AdditionalPayment::all();

        return view('pages/tenant/employee/new', ['positions' => $positions, 'additionals' => $additionals]);
    }

    public function create(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'pis' => 'required|numeric',
            'cpf' => 'required|cpf',
            'rg' => 'required',
            'contract_start' => 'required|date',
            'position_id' => 'required',
            'rg_emission' => 'required|date',
            'drivers_license' => 'nullable|numeric',
            'drivers_license_expiry' => 'nullable|date',
            'drivers_license_type' => 'nullable',
            'address' => 'required',
            'number' => 'required|numeric',
            'complement' => 'nullable',
            'neighborhood' => 'required',
            'cep' => 'required',
            'phone' => 'required',
            'dateofbirth' => 'nullable',
            'additionalPayments' => 'nullable',
        ]);

        $employee = new Employee($attributes);
        $employee->cpf = str_replace(['.', '-'], '', $employee->cpf);
        $employee->cep = str_replace('-', '', $employee->cep);
        $employee->phone = str_replace(['(', ')', '-', ' '], '', $employee->phone);

        if (isset($attributes['additionalPayments'])) {
            foreach ($attributes['additionalPayments'] as $value) {
                $employee->additionals()->attach($value);
            }
        }

        $employee->save();
        $login = Employee::createLogin($employee);
        if (!$login) {
            $employee->forceDelete();
            return redirect()->back()->with('error', 'error creating login')->withInput(request()->all());
        }

        return redirect("/employees/edit/{$employee->id}")->with('status', 'Employee Added!');
    }

    public function edit($id)
    {
        $employee = Employee::with('user', 'additionals')->find($id);

        if (!$employee) {
            return redirect('/employees')->with('error', 'Employee Not Found!');
        }

        $positions = Position::all();
        $additionals = AdditionalPayment::all();
        $family = $employee->family()->get();

        $employeeAdditionals = $employee->additionals->pluck('id')->toArray();

        return view('pages/tenant/employee/edit', compact('employee', 'employeeAdditionals', 'positions', 'additionals', 'family'));
    }

    public function postEdit(Request $request, $id)
    {

        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'pis' => 'required|numeric',
            'cpf' => 'required|cpf',
            'rg' => 'required',
            'position_id' => 'required',
            'rg_emission' => 'required|date',
            'drivers_license' => 'nullable|numeric',
            'drivers_license_expiry' => 'nullable|date',
            'drivers_license_type' => 'nullable',
            'address' => 'required',
            'number' => 'required|numeric',
            'complement' => 'nullable',
            'neighborhood' => 'required',
            'cep' => 'required',
            'phone' => 'required',
            'dateofbirth' => 'nullable',
            'status' => 'required',
            'additionalPayments' => 'nullable',
        ]);
        try {
            $employee = Employee::find($id)->fill($attributes);
            $employee->status = (int) $attributes['status'];
            $employee->cpf = str_replace(['.', '-'], '', $employee->cpf);
            $employee->cep = str_replace('-', '', $employee->cep);
            $employee->phone = str_replace(['(', ')', '-', ' '], '', $employee->phone);
            $employee->additionals()->detach();

            if (isset($attributes['additionalPayments'])) {
                foreach ($attributes['additionalPayments'] as $value) {
                    $employee->additionals()->attach($value);
                }
            }

            $employee->save();
            return redirect()->back()->with('status', 'Edit Sucessful!');
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return redirect()->back()->withErrors('Error editing Employee');
        }
    }


    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        return redirect()->back()->with('status', 'Employee deleted');
    }

    public function newFamily(Request $request, $employeeId)
    {
        return view('pages/tenant/employee_family/new');
    }

    public function postNewFamily(Request $request, $employeeId)
    {
        $attributes = $request->validate([
            'name' => 'required',
            'dateofbirth' => 'required|date',
            'cpf' => 'required|cpf',
            'rg' => 'required|numeric',
        ]);

        try {
            $child = new EmployeeFamily($attributes);
            $child->employee_id = $employeeId;
            $child->save();

            return redirect("/employees/edit/{$employeeId}")->with('status', 'Family Member Created!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error creating Family Member!');
        }
    }

    public function editFamilyView(Request $request, $employeeId, $memberId)
    {
        $child = EmployeeFamily::where('id', $memberId)->where('employee_id', $employeeId)->first();
        if (!$child) {
            return redirect("/employees/edit/{$employeeId}")->with('error', 'Family Member Not Found!');
        }
        return view('pages/tenant/employee_family/edit', ['child' => $child]);
    }

    public function editFamily(Request $request, $employeeId, $memberId)
    {

        $attributes = $request->validate([
            'name' => 'required',
            'dateofbirth' => 'required|date',
            'cpf' => 'required|cpf',
            'rg' => 'required',
        ]);

        $child = EmployeeFamily::where('id', $memberId)->where('employee_id', $employeeId)->first();
        if (!$child) {
            return redirect("/employees/edit/{$employeeId}")->with('error', 'Child Not Found!');
        }

        $child->fill($attributes);

        $child->cpf = str_replace(['.', '-'], '', $child->cpf);

        $child->save();

        return redirect()->back()->with('status', 'Child Edited!');
    }

    public function destroyMember(Request $request, $employeeId, $childId)
    {
        $child = EmployeeFamily::where('id', $childId)->where('employee_id', $employeeId)->first();
        $child->delete();
        return redirect()->back()->with('status', 'Family Member Deleted');
    }

    public function fetchList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => "Validation Error"
            ], 500);
        }

        $validated = $validator->safe()->only('name');

        $query = Employee::select(['id as value', 'name as label'])
            ->where('name', 'like', "{$validated['name']}%")->get();

        return response()->json($query);
    }

    public function fetchEmployee(Request $request, $employeeId)
    {

        $employee = Employee::with('position.salary')->where("id", $employeeId)->whereNotNull('position_id')->first();
        if (empty($employee)) {
            return response()->json([
                'error' => 'Error Fetching Employer'
            ], 500);
        }

        return response()->json($employee->toArray(), 200);
    }

    public function inviteLink(Request $request, $token)
    {
        $employeeLogin = EmployeeLogin::with('employee')->where('invite_token', $token)->first();
        if (empty($employeeLogin)) {
            abort(404);
        }

        return view('pages/tenant/invite/register', ['login' => $employeeLogin]);
    }

    public function register(Request $request, $token)
    {

        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6|max:15',
            'rememberMe' => 'nullable',
        ]);

        $employeeLogin = EmployeeLogin::with('employee')->where('invite_token', $token)->first();
        if (empty($employeeLogin)) {
            abort(404);
        }

        $employeeLogin->password = bcrypt($attributes['password']);
        $employeeLogin->save();

        if (
            Auth::guard('tenant_employee')->attempt(
                ['email' => $attributes['email'], 'password' => $attributes['password']],
                isset($attributes['rememberMe'])
            )
        ) {
            return redirect('/system')->with('success', __('Welcome :name', ['name' => $employeeLogin->employee->name]));
        }
        return redirect()->back()->with(['status' => 'Login Failed'])->withInput(['email' => $attributes['email']]);
    }

    public function employeeAttendance(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return redirect('/employees')->with('error', 'Employee Not Found!');
        }

        $employeeAttendance = EmployeeAttendance::where('employee_id', $employee->id)->orderBy('date', 'desc')->paginate(15);
        return view('pages/tenant/employee_attendance/index', ['employee' => $employee, 'employeeAttendance' => $employeeAttendance]);
    }
}
