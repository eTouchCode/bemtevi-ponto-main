<?php

use App\Http\Controllers\EmployeeLoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('central')->group(function () {
    Route::name('central.')->group(function () {
        Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('registerCompany');
        Route::post('/register', [RegisterController::class, 'companyStore'])->middleware('guest')->name('createCompany');

    });
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect()->route('auth');
});

// Auth routes
Route::get('/login', [EmployeeLoginController::class, 'show'])->name('auth');
Route::post('/central-login', [EmployeeLoginController::class, 'logIn'])->name('central-login');
Route::get('/redirect-user/{globalUserId}/to-tenant/{tenant}', [EmployeeLoginController::class, 'redirectUserToTenant'])->name('redirect-user-to-tenant');
Route::any('/auth/logout', [EmployeeLoginController::class, 'logout'])
    ->name('centralLogout')->middleware('auth');

Route::get('tables', function () {
    return view('pages.tables');
})->name('tables');