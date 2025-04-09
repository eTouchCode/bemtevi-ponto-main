<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    @push('additionalJs')
        @vite('resources/js/employerDashboard.js')
    @endpush
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2 mb-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">person</i>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <h4 class="px-4">{{ $greetings['symbol'] }} {{ __($greetings['greeting']) }},
                                {{ $greetings['user'] }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-sm-6 col-md-6 col-xxl-3 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2 mb-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-success shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">surfing</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0">Funcionários de Férias</p>
                                <h4 class="mb-0">{{ $stats['vacations'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-xxl-3 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2 mb-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-danger shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">sick</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0">Funcionários doentes</p>
                                <h4 class="mb-0">{{ $stats['sick'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-xxl-3 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2 mb-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-secondary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">person</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0">Funcionários Ausentes</p>
                                <h4 class="mb-0">{{ $stats['absent'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-xxl-3 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2 mb-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-warning shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">article</i>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0">Faltas Justificadas</p>
                                <h4 class="mb-0">{{ $stats['missing'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0"></div>
                        <div class="card-body px-5">
                            <h5>Relatório de Funcionários</h5>
                            <hr>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">{{ __('Employee') }}</label>
                                                <select id="dashboardEmployeeSearch" class="form-group" name="employee">
                                                    <option value="" selected>{{ __('Select') }}</option>
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div id="statCardsContainer" class="col-12 mt-5">
                                            <div class="statCards">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <div class="card bg-gradient-success">
                                                            <div class="card-header bg-transparent">
                                                                <div class="icon">
                                                                    <i class="material-icons">event</i>
                                                                </div>
                                                                <div class="text-end">
                                                                    <h6 class="text-white">Data de Contratação</h6>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="text-end text-white">
                                                                    <p id="contractStart" class="statData m-0"></p>
                                                                    <small id="contractStartDiff"></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="card bg-gradient-primary">
                                                            <div class="card-header bg-transparent">
                                                                <div class="icon">
                                                                    <i class="material-icons">schedule</i>
                                                                </div>
                                                                <div class="text-end">
                                                                    <h6 class="text-white">Saldo de Horas</h6>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="text-end text-white">
                                                                    <p id="hourBankExtra" class="statData m-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="card bg-gradient-danger">
                                                            <div class="card-header bg-transparent">
                                                                <div class="icon">
                                                                    <i class="material-icons">surfing</i>
                                                                </div>
                                                                <div class="text-end">
                                                                    <h6 class="text-white">Próximas Férias</h6>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="text-end text-white">
                                                                    <p id="nextVacationDate" class="statData m-0"></p>
                                                                    <small id="nextVacationDiff"></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="card bg-gradient-dark">
                                                            <div class="card-header bg-transparent">
                                                                <div class="icon">
                                                                    <i class="material-icons">timer_off</i>
                                                                </div>
                                                                <div class="text-end">
                                                                    <h6 class="text-white">Quantidade Faltas</h6>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="text-end text-white">
                                                                    <p id="absentDays" class="statData m-0"></p>
                                                                    <span>Ultima Falta: <small
                                                                            id="lastAbsence"></small></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="card bg-gradient-info">
                                                            <div class="card-header bg-transparent">
                                                                <div class="icon">
                                                                    <i class="material-icons">savings</i>
                                                                </div>
                                                                <div class="text-end">
                                                                    <h6 class="text-white">Valor/ Último Salário</h6>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="text-end text-white">
                                                                    <p id="lastPayment" class="statData m-0"></p>
                                                                    <small id="lastPaymentDate"></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="card bg-gradient-warning">
                                                            <div class="card-header bg-transparent">
                                                                <div class="icon">
                                                                    <i class="material-icons">update</i>
                                                                </div>
                                                                <div class="text-end">
                                                                    <h6 class="text-white">Quantidade Folgas</h6>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="text-end text-white">
                                                                    <p id="breakDaysAmount" class="statData m-0"></p>
                                                                    <span>Ultima Folga: <small
                                                                            id="lastBreak"></small></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="employeeChartContainer" class="col-12 col-sm-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row mt-5">
                                                <div class="col-12">
                                                    <div class="attendanceTableContainer">
                                                        <h5 class="text-center">Historico de Ponto (Este Mês)</h5>
                                                        <div class="table-responsive">
                                                            <table id="dashboardEmployeeAttendance"
                                                                class="table align-items-center justify-content-center mb-0">
                                                                <thead>
                                                                    <tr class="text-center">
                                                                        <th
                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                            Data</th>
                                                                        <th
                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                            Primeiro Turno</th>
                                                                        <th
                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                            Duração Intervalo</th>
                                                                        <th
                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                            Segundo Turno</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div id="attendancePagination" class="simplePagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h5>{{ __('Cameras') }}</h5>
                                </div>
                                <div class="col-lg-6 col-5 my-auto text-end">
                                    <div class="dropdown float-lg-end pe-4">
                                        <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa fa-ellipsis-v text-secondary"></i>
                                        </a>
                                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5"
                                            aria-labelledby="dropdownTable">
                                            <li><a class="dropdown-item border-radius-md"
                                                    href="javascript:;">Action</a>
                                            </li>
                                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Another
                                                    action</a></li>
                                            <li><a class="dropdown-item border-radius-md"
                                                    href="javascript:;">Something
                                                    else here</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('Camera') }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('Location') }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ _('Status') }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cameras as $camera)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $camera->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">
                                                                {{ __(ucfirst($camera->location)) }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            @if ($camera->status)
                                                                <span class="badge bg-gradient-success">
                                                                    <i class="material-icons opacity-10">check_box</i>
                                                                </span>
                                                            @else
                                                                <span class="badge bg-gradient-danger">
                                                                    <i class="material-icons">close</i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            @if ($camera->status)
                                                                <button
                                                                    class="btn btn-primary btn-link btnCameraModal mb-0"
                                                                    data-camera="{{ $camera->id }}">
                                                                    <i class="material-icons">visibility</i>
                                                                    <div class="ripple-container"></div>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-primary btn-link mb-0"
                                                                    data-camera="{{ $camera->id }}">
                                                                    <i class="material-icons">visibility_off</i>
                                                                    <div class="ripple-container"></div>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h5>{{ __('Absentees') }}</h5>
                                </div>
                                <div class="col-lg-6 col-5 my-auto text-end">
                                    <div class="dropdown float-lg-end pe-4">
                                        <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa fa-ellipsis-v text-secondary"></i>
                                        </a>
                                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5"
                                            aria-labelledby="dropdownTable">
                                            <li><a class="dropdown-item border-radius-md"
                                                    href="javascript:;">Action</a>
                                            </li>
                                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Another
                                                    action</a></li>
                                            <li><a class="dropdown-item border-radius-md"
                                                    href="javascript:;">Something
                                                    else here</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <div class="input-group input-group-dynamic is-filled mt-3">
                                        <input type="date" class="form-control" id="absencePeriod"
                                            value="{{ now()->subDay() }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table id="employeeAbsenceTable" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('Employee') }}
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('Absence Reason') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-lg-down modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cameraModalTitle">Feed de Camera: <span id="cameraName"></span></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="cameraResult" class="ratio ratio-16x9">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <x-plugins></x-plugins>
    @push('js')
        <script>
            const cameraModal = new bootstrap.Modal(
                document.getElementById("cameraModal"), {
                    backdrop: true,
                    keyboard: true,
                    focus: true,
                }
            );

            const cameraBtn = document.querySelectorAll("button.btnCameraModal");

            cameraBtn.forEach((elem) => {
                elem.addEventListener("click", async (e) => {
                    const cameraId = elem.dataset.camera;

                    let response = await fetch(`/cameras/url`, {
                        method: "post",
                        credentials: "same-origin",
                        headers: {
                            "Content-Type": "application/json",
                            Accept: "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                        },
                        body: JSON.stringify({
                            camera: cameraId,
                        }),
                    });

                    response = await response.json();

                    if (!response.error) {
                        document.getElementById("cameraName").innerHTML =
                            response.cameraName;
                        const videoPlayer = document.createElement("iframe");
                        videoPlayer.src = response.url;
                        document.getElementById("cameraResult").appendChild(videoPlayer);
                        cameraModal.show();
                    }
                });

                document
                    .getElementById("cameraModal")
                    .addEventListener("hidden.bs.modal", (e) => {
                        document.getElementById("cameraResult").innerHTML = "";
                    });
            });
        </script>
    @endpush
</x-layout>
