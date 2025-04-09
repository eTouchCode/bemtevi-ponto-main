<x-layout bodyClass="g-sidenav-show  bg-gray-200">

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
                                <h6 class="text-white mx-3"> {{ __('Payroll') }} </h6>
                            </div>
                        </div>
                        <div class="me-3 my-3 text-end">
                            <button id="btnExportPayment" type="button" class="btn bg-gradient-primary mb-0">
                                <i class="material-icons text-sm">
                                    file_open
                                </i>
                                {{ __('Export :name', ['name' => __('Payroll')]) }}
                            </button>
                            <a class="btn bg-gradient-dark mb-0" href="payroll/new">
                                <i class="material-icons text-sm">add</i>
                                {{ trans_choice('Add new :name', 1, ['name' => __('Payroll')]) }}
                            </a>
                        </div>
                        <div class="card-body px-0 pb-2">

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
                                    @elseif(Session::has('error'))
                                        <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                            <span class="text-sm">{{ Session::get('error') }}</span>
                                            <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @elseif($errors->any())
                                        <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <span class="text-sm">{{ $error }}</span>
                                                <br>
                                            @endforeach

                                            <button type="button" class="btn-close text-lg py-3 opacity-10"
                                                data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            {{ __('Period') }}
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __('Employee') }}
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __('Position') }}
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __('Salary') }}
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __('Net Salary') }}
                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 text-sm">
                                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('M/Y') }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $payment->employee->name }}</h6>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ $payment->employee->position->name }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-sm text-secondary mb-0">
                                                    {{ Number::currency($payment->salary, config('app.currency_locale')) }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-sm text-secondary mb-0">
                                                    {{ Number::currency(json_decode($payment->employee_summary)->salary, "BRL") }}
                                                </p>
                                            </td>
                                            <td class="align-middle">
                                                <a rel="tooltip" class="btn btn-success btn-link btnPaymentModal mb-0"
                                                    href="/payroll/view/{{ $payment->id }}" data-original-title=""
                                                    title="">
                                                    <i class="material-icons">visibility</i>
                                                    <div class="ripple-container"></div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="px-5">
                        {{ $payments->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
        </div>
        <!-- Payment View Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="paymentModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                                            <input type="text" name="fgtsResult" id=""
                                                class="bg-transparent border-0" readonly>
                                        </td>
                                        <td class="taxResult" data-tax="INSS">
                                            <input type="text" name="inssResult" id=""
                                                class="bg-transparent border-0" readonly>
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
                                <table id="employeeSummaryTable" class="table table-striped table-bordered">
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
                                                <input type="text" class="bg-transparent border-0"
                                                    name="employeeDiscount" value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('INSS') }}</td>
                                            <td id="employeeINSS">
                                                <input type="text" class="bg-transparent border-0"
                                                    name="employeeINSS" value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('IR') }}</td>
                                            <td id="employeeIR">
                                                <input type="text" class="bg-transparent border-0"
                                                    name="employeeIR" value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Net Salary') }}</td>
                                            <td id="summaryEmployeeSalary">
                                                <input type="text" class="bg-transparent border-0"
                                                    name="summaryEmployeeSalary" value="" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <table id="companySummaryTable" class="table table-striped table-bordered">
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
                                                <input type="text" class="bg-transparent border-0"
                                                    name="companyEmployeeValue" value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('Company') . ' ' . __('Salary') }}</td>
                                            <td id="companyEmployeeSalary">
                                                <input type="text" class="bg-transparent border-0"
                                                    name="companyEmployeeSalary" value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('INSS') }}</td>
                                            <td id="companyInss">
                                                <input type="text" class="bg-transparent border-0"
                                                    name="companyInss" value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('FGTS') }}</td>
                                            <td id="companyFGTS">
                                                <input type="text" class="bg-transparent border-0"
                                                    name="companyFGTS" value="" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Export Payments Modal -->
        <div class="modal fade" id="modalExport" tabindex="-1" role="dialog" aria-labelledby="modal-title-export"
            aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title font-weight-normal" id="modal-title-export">
                            {{ __('Export :name', ['name' => __('Payroll')]) }}</h6>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="/payroll/export" method="post">
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <div class="input-group input-group-dynamic mt-3 is-filled">
                                        <label class="form-label">{{ __('Period') }}</label>
                                        <input type="date" class="form-control datePeriod" id="period"
                                            name="period" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Export') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
        <script src="{{ asset('assets') }}/js/moment.min.js"></script>
        <script>
            const currencyFormat = new Intl.NumberFormat("pt-BR", {
                style: "currency",
                currency: "BRL",
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            const exportPaymentModal = new bootstrap.Modal(document.getElementById('modalExport'), {
                backdrop: true,
                keyboard: true,
                focus: true,
            })

            const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'), {
                backdrop: true,
                keyboard: true,
                focus: true,
            })
            const modalBtn = document.querySelectorAll('.btnPaymentModal')

            modalBtn.forEach((elem) => {
                elem.addEventListener('click', async (e) => {
                    e.preventDefault()
                    const response = await fetch(elem.href);
                    let responseData = await response.json();
                    responseData = responseData.payment
                    document.getElementById('paymentModalLabel').innerHTML =
                        `Pagamento de ${responseData.employee.name}`

                    document.querySelector('#employeeSalary input').value = currencyFormat.format(
                        responseData.salary)
                    document.querySelectorAll(".taxResult").forEach((elem) => {
                        const tax = elem.dataset.tax.toLowerCase()
                        elem.querySelector('input').value = currencyFormat.format(responseData[
                            `contribution_${tax}`])
                    })

                    document.querySelector('.taxRate#FGTS').innerHTML = `(${responseData.fgts_taxrate}%)`
                    document.querySelector('.taxRate#INSS').innerHTML = `(${responseData.inss_taxrate}%)`
                    document.querySelector('.taxRate#IR').innerHTML = `(${responseData.ir_taxrate}%)`

                    const additionalTable = document.getElementById(
                        "additionalPaymentsTable"
                    );

                    const additionalTableBody =
                        additionalTable.getElementsByTagName("tbody")[0];


                    additionalTableBody.innerHTML = "";

                    console.log(responseData)

                    const additionals = JSON.parse(responseData.additionals);

                    if (additionals.length > 0) {
                        document.getElementById('additionalPaymentsContainer').classList.remove('d-none');
                    }

                    additionals.forEach((element, index) => {
                        const tableRow = additionalTableBody.insertRow(
                            additionalTableBody.rows.length
                        );

                        const additional = {
                            name: element.name,
                            value: element.value,
                        };
                        let count = 0;


                        Object.keys(additional).forEach((key) => {
                            const input = document.createElement("input");
                            input.type = "text";
                            input.classList.add("bg-transparent", "border-0");
                            input.setAttribute("readonly", true);
                            const cell = element[key];
                            const tableCell = tableRow.insertCell(count);
                            tableCell.appendChild(input);

                            if (typeof cell === "string") {
                                input.value = cell;
                            } else if (typeof cell === "number") {
                                input.value = currencyFormat.format(cell)
                            }

                            input.setAttribute("name", `additionals[${index}][${key}]`);
                            count++;
                        });
                    });

                    const employerSummary = JSON.parse(responseData.employer_summary)
                    const employeeSummary = JSON.parse(responseData.employee_summary)

                    document.querySelector("#employeeDiscount input").value =
                        currencyFormat.format(responseData.discounts);

                    document.querySelector("#employeeINSS input").value =
                        currencyFormat.format(employeeSummary.inss);

                    document.querySelector("#employeeIR input").value =
                        currencyFormat.format(employeeSummary.ir);

                    document.querySelector("#summaryEmployeeSalary input").value =
                        currencyFormat.format(employeeSummary.salary);

                    document.querySelector("#companyEmployeeSalary input").value =
                        currencyFormat.format(employeeSummary.salary);

                    document.querySelector("#companyEmployeeValue input").value =
                        currencyFormat.format(employerSummary.companyEmployeeValue);

                    document.querySelector("#companyInss input").value =
                        currencyFormat.format(employerSummary.companyINSS);
                    document.querySelector("#companyFGTS input").value =
                        currencyFormat.format(employerSummary.companyFGTS);

                    paymentModal.show()
                })
            })


            document.getElementById('btnExportPayment').addEventListener('click', (event) => {
                exportPaymentModal.show();
            })

            document.getElementById('paymentModal').addEventListener('hidden.bs.modal', (event) => {
                document.querySelector('#additionalPaymentsTable tbody').innerHTML = "";
                document.getElementById('additionalPaymentsContainer').classList.add('d-none');
            })
        </script>
    @endpush
</x-layout>
