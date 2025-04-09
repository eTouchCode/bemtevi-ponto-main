<?php

namespace App\Http\Controllers;

use App\Models\Admin\CentralEmployeeLogin;
use App\Models\Admin\Company;
use App\Models\EmployeeLogin;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Log;
use Sqids\Sqids;

class EmployeeLoginController extends Controller
{

    public function show(Request $request)
    {
        // Get currently authenticated user
        if ($user = $request->user()) {
            // return $this->redirectUserToTenantOrShowTenantSelector($user);
        }

        return view('pages.tables');

        // return view('pages.central-login.create');
    }

    public function logIn(Request $request)
    {
        // Attempt authentication using the email and password from the request
        $this->authenticate($request->get('email'), $request->get('password'));
        return $this->show($request);
    }

    public function redirectUserToTenant(CentralEmployeeLogin|string|int $user, Company|string|int $tenant)
    {
        if (!$tenant instanceof Company) {
            $tenant = Company::find($tenant);

            if (is_null($tenant)) {
                throw new Exception('Tenant with the key passed in the "tenant" parameter does not exist');
            }
        }
        // If $user is not an instance of User, assume $user is the global user ID
        $globalUserId = $user instanceof CentralEmployeeLogin ? $user->global_id : $user;
        $tenantUser = $tenant->run(fn() => EmployeeLogin::firstWhere('global_id', $globalUserId));

        return redirect($tenant->impersonationUrl($tenantUser->id));
    }

    /**
     * Redirect user to tenant's primary domain,
     * or if the user has access to many tenants,
     * render the login page where the user can choose to which tenant he wants to get redirected to.
     */
    protected function redirectUserToTenantOrShowTenantSelector(CentralEmployeeLogin $user)
    {
        // If the request has a tenant, redirect user to that tenant
        $tenant = request()->get('tenant') ? tenancy()->find(request()->get('tenant')) : null;

        if (is_null($tenant)) {
            $availableTenants = CentralEmployeeLogin::firstWhere('global_id', $user->global_id)->tenants;

            // If there are multiple available tenants, let user select the tenant
            if ($availableTenants->count() > 1) {
                return view('login', ['tenants' => $availableTenants]);
            }

            $tenant = $availableTenants->first();
        }

        return $this->redirectUserToTenant($user->global_id, $tenant);
    }

    protected function authenticate(string $email, string $password): CentralEmployeeLogin|null
    {
        Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
        return auth()->user();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        
        return redirect()->route('auth');
    }
}
