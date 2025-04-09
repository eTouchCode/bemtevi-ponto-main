<?php

declare(strict_types=1);

use App\Http\Controllers\CompanySettingsController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Features\UserImpersonation;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\EmployeeDashboardController;
use App\Http\Controllers\Tenant\ProfileController;
use App\Http\Controllers\Tenant\SessionsController;
use App\Http\Controllers\Tenant\AdditionalPaymentController;
use App\Http\Controllers\Tenant\BenefitController;
use App\Http\Controllers\Tenant\CameraController;
use App\Http\Controllers\Tenant\EmployeeContractController;
use App\Http\Controllers\Tenant\EmployeeController;
use App\Http\Controllers\Tenant\EmployeeVacationsController;
use App\Http\Controllers\Tenant\PayRollController;
use App\Http\Controllers\Tenant\PositionController;
use App\Http\Controllers\Tenant\SalaryController;
use App\Http\Controllers\Tenant\UserImpersonationController;
use App\Http\Controllers\Tenant\WarningController;
use App\Http\Controllers\Tenant\WorkshiftController;
use App\Http\Middleware\NotificationData;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    NotificationData::class,
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/home', function () {
        return redirect('/dashboard');
    });
    Route::get('/', function () {
        return redirect('login');
    });

    Route::get('login', [SessionsController::class, 'create'])->name('login')->middleware('guest:company,tenant_employee');
    Route::post('login', [SessionsController::class, 'store'])->name('loginPost');

    Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth:company,tenant_employee,central_employee');

    Route::get('profile', [ProfileController::class, 'create']);
    Route::post('user-profile', [ProfileController::class, 'update']);

    Route::group(['middleware' => 'auth:company'], function () {

        Route::prefix("dashboard")->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('companyDashboard');
            Route::get('/employeeStats/{employeeId}', [DashboardController::class, 'employeeStats']);
            Route::get('/employeeStats/attendance/{employeeId}', [DashboardController::class, 'employeeAttendance']);
            Route::get('/employeeAbsence/{date?}', [DashboardController::class, 'employeeAbsence']);
        });


        Route::prefix('employees')->group(function () {
            Route::get('/', [EmployeeController::class, 'index']);
            Route::get('/new', [EmployeeController::class, 'new']);
            Route::post('/new', [EmployeeController::class, 'create']);
            Route::get('/edit/{id}', [EmployeeController::class, 'edit']);
            Route::post('/edit/{id}', [EmployeeController::class, 'postEdit']);
            // Route::get('/delete/{id}', [EmployeeController::class, 'destroy']);

            Route::get('/login/{id}', [EmployeeController::class, 'createLogin']);

            Route::get('/attendance/{id}', [EmployeeController::class, 'employeeAttendance']);


            Route::prefix('/contract')->group(function () {
                Route::get('/{id}', [EmployeeContractController::class, 'endContractView']);
                Route::post('/simulate/{id}', [EmployeeContractController::class, 'simulateContractEnd']);
            });

            Route::prefix('/{id}/family')->group(function () {
                Route::get('/new', [EmployeeController::class, 'newFamily']);
                Route::post('/new', [EmployeeController::class, 'postNewFamily']);

                Route::get('/{memberId}/edit', [EmployeeController::class, 'editFamilyView'])->name('editFamilyView');
                Route::post('/{memberId}/edit', [EmployeeController::class, 'editFamily']);
                Route::get('/{memberId}/delete', [EmployeeController::class, 'destroyMember']);
            });

            Route::post('/list', [EmployeeController::class, 'fetchList']);
        });

        Route::prefix('positions')->group(function () {
            Route::get('/', [PositionController::class, 'index']);
            Route::get('/new', [PositionController::class, 'new']);
            Route::post('/new', [PositionController::class, 'create']);
            Route::get('/edit/{id}', [PositionController::class, 'edit']);
            Route::post('/edit/{id}', [PositionController::class, 'postEdit']);
            Route::get('/delete/{id}', [PositionController::class, 'destroy']);
        });

        Route::prefix('salaries')->group(function () {
            Route::get('/', [SalaryController::class, 'index']);
            Route::get('/new', [SalaryController::class, 'new']);
            Route::post('/new', [SalaryController::class, 'create']);
            Route::get('/edit/{id}', [SalaryController::class, 'edit']);
            Route::post('/edit/{id}', [SalaryController::class, 'postEdit']);
            Route::get('/delete/{id}', [SalaryController::class, 'destroy']);
        });

        Route::prefix('workshifts')->group(function () {
            Route::get('/', [WorkshiftController::class, 'index']);
            Route::get('/new', [WorkshiftController::class, 'new']);
            Route::post('/new', [WorkshiftController::class, 'create']);
            Route::get('/edit/{id}', [WorkshiftController::class, 'edit']);
            Route::post('/edit/{id}', [WorkshiftController::class, 'postEdit']);
            Route::get('/delete/{id}', [WorkshiftController::class, 'destroy']);
        });

        Route::prefix('cameras')->group(function () {
            Route::get('/', [CameraController::class, 'index']);
            Route::get('/new', [CameraController::class, 'new']);
            Route::post('/new', [CameraController::class, 'create']);
            Route::get('/edit/{id}', [CameraController::class, 'edit']);
            Route::post('/edit/{id}', [CameraController::class, 'postEdit']);
            Route::get('/delete/{id}', [CameraController::class, 'destroy']);

            Route::post('/url', [CameraController::class, 'url']);
        });

        Route::prefix('benefits')->group(function () {
            Route::get('/', [BenefitController::class, 'index']);
            Route::get('/new', [BenefitController::class, 'new']);
            Route::post('/new', [BenefitController::class, 'create']);
            Route::get('/edit/{id}', [BenefitController::class, 'edit']);
            Route::post('/edit/{id}', [BenefitController::class, 'postEdit']);
            Route::get('/delete/{id}', [BenefitController::class, 'destroy']);
        });

        Route::prefix('additional_payments')->group(function () {
            Route::get('/', [AdditionalPaymentController::class, 'index']);
            Route::get('/new', [AdditionalPaymentController::class, 'new']);
            Route::post('/new', [AdditionalPaymentController::class, 'create']);
            Route::get('/edit/{id}', [AdditionalPaymentController::class, 'edit']);
            Route::post('/edit/{id}', [AdditionalPaymentController::class, 'postEdit']);
            Route::get('/delete/{id}', [AdditionalPaymentController::class, 'destroy']);
        });

        Route::prefix('payroll')->group(function () {
            Route::get('/', [PayRollController::class, 'index']);
            Route::get('/new', [PayRollController::class, 'new']);
            Route::post('/new', [PayRollController::class, 'createPayroll']);
            Route::get('/view/{id}', [PayRollController::class, 'show']);
            Route::post('/export', [PayRollController::class, 'exportPayments']);
            Route::post('/fetchEmployee', [PayRollController::class, 'fetchEmployee']);
            Route::get('/fetchEmployeeAdditionals/{id}', [PayRollController::class, 'fetchEmployeeAdditionals']);
            Route::get('/fetchAdditional/{id}', [PayRollController::class, 'getAdditionalsById']);

        });

        Route::prefix('warnings')->group(function () {
            Route::get('/', [WarningController::class, 'index']);
            Route::get('/new', [WarningController::class, 'new']);
            Route::post('/new', [WarningController::class, 'createWarning']);
            Route::get('/edit/{id}', [WarningController::class, 'edit']);
            Route::post('/edit/{id}', [WarningController::class, 'postEdit']);
            Route::get('/delete/{id}', [WarningController::class, 'destroy']);
        });

        Route::prefix('settings')->group(function () {
            Route::get('/', [CompanySettingsController::class, 'index']);
            Route::post('/', [CompanySettingsController::class, 'saveSettings']);
            Route::get('/qrCode', [CompanySettingsController::class, 'qrCode']);
            Route::get('/qrCode/share', [CompanySettingsController::class, 'shareQrCode']);
        });

        Route::prefix('vacations')->group(function () {
            Route::get('/', [EmployeeVacationsController::class, 'index']);
            Route::get('/new', [EmployeeVacationsController::class, 'new']);
            Route::post('/new', [EmployeeVacationsController::class, 'postNew']);
        });

        // Route::get('billing', function () {
        //     return view('pages.billing');
        // })->name('billing');
        // Route::get('rtl', function () {
        //     return view('pages.rtl');
        // })->name('rtl');
        // Route::get('virtual-reality', function () {
        //     return view('pages.virtual-reality');
        // })->name('virtual-reality');
        // Route::get('notifications', function () {
        //     return view('pages.notifications');
        // })->name('notifications');
        // Route::get('static-sign-in', function () {
        //     return view('pages.static-sign-in');
        // })->name('static-sign-in');
        // Route::get('static-sign-up', function () {
        //     return view('pages.static-sign-up');
        // })->name('static-sign-up');
    });


    Route::prefix('invite')->group(function () {
        Route::get('/{token}', [EmployeeController::class, 'inviteLink']);
        Route::post('/{token}', [EmployeeController::class, 'register']);
    });



    Route::prefix('/system')->group(function () {
        Route::get('/portal/{token}', [UserImpersonationController::class, 'impersonate'])->name('portal');
        Route::middleware('auth:tenant_employee')->group(function () {
            Route::get('/home', [EmployeeDashboardController::class, 'index'])->name('employeeHome');
            Route::post('/clockIn', [EmployeeDashboardController::class, 'clockIn']);
        });
    });
});
