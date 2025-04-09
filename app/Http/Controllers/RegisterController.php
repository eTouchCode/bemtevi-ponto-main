<?php

namespace App\Http\Controllers;

use App\Models\Admin\Company;
use App\Models\CompanyUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use StevenFox\LaravelSqids\Facades\Sqidder;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
        ]);

        $user = User::create($attributes);
        auth()->login($user);

        return redirect('/dashboard');
    }



    public function companyStore()
    {

        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:15',
            'companyName' => 'required|max:30',
            'companyCNPJ' => 'required|cnpj',
            'companyAddress' => 'required|min:10|max:255',
            'companyDomain' => 'required|min:3|max:10',
        ]);

        $companyCode = Str::random(6);

        $company = Company::create([
            'company_code' => $companyCode,
            'name' => $attributes['companyName'],
            'cnpj' => str_replace(['.', '/'], '', $attributes['companyCNPJ']),
            'address' => $attributes['companyAddress'],
            'tenancy_db_name' => $companyCode,
        ]);

        if ($company) {

            try {
                $company->domains()->create([
                    'domain' => $attributes['companyDomain'],
                ]);

                tenancy()->initialize($company);

                CompanyUser::create([
                    'name' => $attributes['name'],
                    'email' => $attributes['email'],
                    'password' => Hash::make($attributes['password']),
                ]);

            } catch (\Throwable $th) {
                $company->delete();

                Log::info($th->getMessage());
                return redirect()->back()->withErrors('status', 'Something went wrong, please try again');
            }

            return redirect(sprintf('http://%s%s/login', $company->domains()->first()->domain, config('session.domain')))->with([
                'email' => $attributes['email'],
                'password' => $attributes['password'],
            ]);
        }
    }
}
