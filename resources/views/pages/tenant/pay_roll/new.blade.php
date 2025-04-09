<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    @push('additionalJs')
        @vite('resources/js/payroll.js')
    @endpush
    <x-navbars.sidebar activePage="payroll"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{ __('Payroll') }}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"> {{ __('Calculate Payroll') }} </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-6">
                                    @if (Session::has('status'))
                                        <div class="alert alert-success alert-dismissible text-white" role="alert">
                                            <span class="text-sm">{{ Session::get('status') }}</span>
                                            <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @elseif($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-warning alert-dismissible text-white"
                                                role="alert">
                                                <span class="text-sm">{{ $error }}</span>
                                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <form id="payRollForm" action="/payroll/fetchEmployee" method="post">
                                <div class="row justify-content-center">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">{{ __('Employee') }}</label>
                                            <select class="form-group searchBoxEmployee" name="employee">
                                                <option value="" selected>{{ __('Select') }}</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-4">
                                        <div class="h-100 d-flex align-items-end">
                                            <div class="input-group align-items-end input-group-dynamic is-filled mt-3">
                                                <label class="form-label">{{ __('Payment Date') }}</label>
                                                <input type="date" class="form-control" id="period" name="period"
                                                    value="{{ now() }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-4">
                                        <div class="input-group input-group-dynamic mt-3">
                                            <label class="form-label">{{ __('Discounts') }}</label>
                                            <input type="text" class="form-control money" name="discount"
                                                value="">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-12 col-lg-8">
                                        <div class="form-group">
                                            <label class="form-label">Adicionar Pagamento Adicional</label>
                                            <select id="addAdditionalPayment"
                                                placeholder="{{ __('Additional Payments') }}">
                                                <option value="" selected>{{ __('Select') }}</option>
                                                @foreach ($additionals as $additional)
                                                    <option value="{{ $additional->id }}">{{ $additional->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="additionalValuesTable" class="table-responsive mt-5 d-none">
                                            <table id="additionalPaymentValues" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            {{ __('Additional Payment') }}
                                                        </td>
                                                        <td>{{ __('Value') }}</td>
                                                        <td>{{ __('Percentage Value') }}</td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-2">
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">{{ __('Calculate') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="payRollSummaryContainer" class="d-none">
                                <form id="createPayrollForm" method="post">
                                    <input type="hidden" id="employee_id" name="employee">
                                    <input type="hidden" id="payment_date" name="payment_date">
                                    <input type="hidden" id="fgtsContribution" name="contributions[fgts]">
                                    <input type="hidden" id="inssContribution" name="contributions[inss]">
                                    <input type="hidden" id="irContribution" name="contributions[ir]">
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="payRollTable" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <td>{{ __('Salary') }}</td>
                                                            <td>
                                                                <p>
                                                                    {{ __('FGTS') }}
                                                                    <span class="taxRate" id="FGTS"></span>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    {{ __('INSS') }}
                                                                    <span class="taxRate" id="INSS"></span>
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    {{ __('IR') }}
                                                                    <span class="taxRate" id="IR"></span>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td id="employeeSalary">
                                                                <input type="text" class="bg-transparent border-0"
                                                                    name="employeeSalary" value="" readonly>
                                                            </td>
                                                            <td class="taxResult" data-tax="FGTS">
                                                                <input type="text" name="fgtsResult"
                                                                    id="" class="bg-transparent border-0"
                                                                    readonly>
                                                            </td>
                                                            <td class="taxResult" data-tax="INSS">
                                                                <input type="text" name="inssResult"
                                                                    id="" class="bg-transparent border-0"
                                                                    readonly>
                                                            </td>
                                                            <td class="taxResult" data-tax="IR">
                                                                <input type="text" name="irResult" id=""
                                                                    class="bg-transparent border-0" readonly>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="additionalPaymentsContainer" class="d-none">
                                                <h5 class="m-5">{{ __('Additional Payments') }}</h5>
                                                <div class="table-responsive">
                                                    <table id="additionalPaymentsTable" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <td>{{ __('Name') }}</td>
                                                                <td>{{ __('Value') }}</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <h5 class="m-5">{{ __('Summary') }}</h5>
                                            <div class="row">
                                                <div class="col-6">
                                                    <table id="employeeSummaryTable"
                                                        class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <h6>{{ __('Employee') }}</h6>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ __('Discounts') }}</td>
                                                                <td id="employeeDiscount">
                                                                    <input type="text"
                                                                        class="bg-transparent border-0"
                                                                        name="employeeDiscount" value=""
                                                                        readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('INSS') }}</td>
                                                                <td id="employeeINSS">
                                                                    <input type="text"
                                                                        class="bg-transparent border-0"
                                                                        name="employeeINSS" value="" readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('IR') }}</td>
                                                                <td id="employeeIR">
                                                                    <input type="text"
                                                                        class="bg-transparent border-0"
                                                                        name="employeeIR" value="" readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('Net Salary') }}</td>
                                                                <td id="summaryEmployeeSalary">
                                                                    <input type="text"
                                                                        class="bg-transparent border-0"
                                                                        name="summaryEmployeeSalary" value=""
                                                                        readonly>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-6">
                                                    <table id="companySummaryTable"
                                                        class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <h6>{{ __('Company') }}</h6>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ __('Employee Owed Value') }}</td>
                                                                <td id="companyEmployeeValue">
                                                                    <input type="text"
                                                                        class="bg-transparent border-0"
                                                                        name="companyEmployeeValue" value=""
                                                                        readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('Total Owed by Company') }}</td>
                                                                <td id="companyEmployeeSalary">
                                                                    <input type="text"
                                                                        class="bg-transparent border-0"
                                                                        name="companyEmployeeSalary" value=""
                                                                        readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('INSS') }}</td>
                                                                <td id="companyInss">
                                                                    <input type="text"
                                                                        class="bg-transparent border-0"
                                                                        name="companyInss" value="" readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('FGTS') }}</td>
                                                                <td id="companyFGTS">
                                                                    <input type="text"
                                                                        class="bg-transparent border-0"
                                                                        name="companyFGTS" value="" readonly>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class=" me-3 my-3 text-end">
                                                <button class="btn bg-gradient-dark mb-0" href="payroll/new"><i
                                                        class="material-icons text-sm">add</i>
                                                    {{ trans_choice('Add new :name', 1, ['name' => __('Payroll')]) }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
