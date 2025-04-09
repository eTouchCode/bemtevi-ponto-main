<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\CompanyUser;
use App\Models\EmployeeLogin;
use Sqids\Sqids;
use Str;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Log;

class SessionsController extends Controller
{
    protected $guards = [
        'company' => [
            'redirectTo' => 'companyDashboard',
        ],
        'tenant_employee' => [
            'redirectTo' => 'employeeHome'
        ],
    ];

    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {

        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
            'rememberMe' => 'nullable'
        ]);

        $chosenGuard = null;

        foreach ($this->guards as $key => $guard) {

            $auth = Auth::guard($key)->attempt(
                [
                    'email' => $attributes['email'],
                    'password' => $attributes['password']
                ],
                isset($attributes['rememberMe'])
            );
            if ($auth) {
                $chosenGuard = $this->guards[$key];
                break;
            }
        }

        if (!$auth && !$chosenGuard) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }

        return redirect()->route($chosenGuard['redirectTo']);
    }

    public function show()
    {
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

    }

    public function update()
    {

        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        // return $status === Password::PASSWORD_RESET
        //     ? redirect()->route('login')->with('status', __($status))
        //     : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy(Request $request)
    {
        switch (true) {
            case $request->user() instanceof EmployeeLogin:
                Auth::guard('tenant_employee')->logout();
                break;
            case $request->user() instanceof CompanyUser:
                Auth::guard('company')->logout();
                break;
        }
        return redirect()->route('login');
    }

}
