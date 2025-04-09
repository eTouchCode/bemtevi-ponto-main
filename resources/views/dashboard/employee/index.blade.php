<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.employeeSidebar activePage='dashboard'></x-navbars.employeeSidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.employeeAuth titlePage="Dashboard"></x-navbars.navs.employeeAuth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
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
            @if ($errors->any())
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible text-white" role="alert">
                            @foreach ($errors->all() as $error)
                                <span class="text-sm">{{ $error }}</span> <br>
                            @endforeach

                            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            @if (Session::has('status'))
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible text-white" role="alert">
                            <span class="text-sm">{{ Session::get('status') }}</span>
                            <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12 col-md-6 col-sm-12 order-last order-md-first">
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pt-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">notification_important</i>
                                    </div>
                                    <div class="text-end">
                                        <h4 class="mb-0">Avisos</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="warningList">
                                                @if (isset($birthday) && $birthday['diff'] == 0)
                                                    <li>
                                                        <div class="row h-100">
                                                            <div class="col-10">
                                                                <div class="warningMessage">
                                                                    <p class="mb-0">
                                                                        <strong>
                                                                            Feliz Aniversário
                                                                            {{ auth()->user()->employee->name }}! 🥳
                                                                        </strong>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-2 p-0">
                                                                <div class="warningIcon bg-gradient-warning">
                                                                    <i class="material-icons opacity-10">cake</i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                                @if (isset($vacation['nextVacationDiffNumber']) && $vacation['nextVacationDiffNumber'] < 7)
                                                    <li>
                                                        <div class="row h-100">
                                                            <div class="col-10">
                                                                <div class="warningMessage">
                                                                    <p class="mb-0">
                                                                        Suas Férias começam em
                                                                        <mark>{{ $vacation['nextVacationDiffNumber'] }}
                                                                            dias!</mark>
                                                                        😎
                                                                        <br>
                                                                        <strong>
                                                                            Aproveite o Descanso!
                                                                        </strong>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-2 p-0">
                                                                <div class="warningIcon bg-gradient-success">
                                                                    <i class="material-icons opacity-10">event</i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                                @foreach ($notifications as $notification)
                                                    <li>
                                                        <div class="row h-100">
                                                            <div class="col-10">
                                                                <div class="warningMessage">
                                                                    <p class="mb-0">
                                                                        {{ $notification->title }}
                                                                        <br>
                                                                        <strong>
                                                                            {!! $notification->message !!}
                                                                        </strong>
                                                                    </p>
                                                                    <small>{{ ucfirst(Carbon::parse($notification->end_date)->diffForHumans()) }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-2 p-0">
                                                                <div
                                                                    class="warningIcon bg-gradient-{{ $notification->warningType }}">
                                                                    <i
                                                                        class="material-icons opacity-10">{{ $notification->icon }}</i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-xl-6 col-md-12 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-header pt-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">surfing</i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-end">
                                        <p class="text-sm mb-0 text-capitalize">Próximas Férias</p>
                                        <p class="mb-0">
                                            <span class="h5 mb-0 text-capitalize">
                                                {{ $vacation['nextVacationDiff'] }}
                                            </span>
                                            <small class="text-xs mb-0">{{ $vacation['nextVacationDate'] }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 pt-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">payments</i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-end">
                                        <p class="text-sm mb-0 text-capitalize">Total atual de 13°</p>
                                        <p class="mb-0">
                                            <span class="h5 mb-0 text-capitalize">
                                                {{ Number::currency($extraSalary, 'BRL') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-12 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-header p-3 pt-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">account_balance</i>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-end">
                                        <p class="text-sm mb-0 text-capitalize">Deduções fiscais</p>
                                        <p class="mb-0">
                                            <span class="h5 mb-0 text-capitalize">
                                                {{ Number::currency(0, 'BRL') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header p-3 pt-2 mb-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-warning shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">alarm_on</i>
                                    </div>
                                    <div class="text-end pt-2">
                                        <h4 class="px-4">Banco de Horas</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row col-12">
                                        <table class="table align-items-center justify-content-center mb-0">
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
                                                @foreach ($hourBank['attendance'] as $attendance)
                                                    <tr class="text-center">
                                                        <td>
                                                            {{ Carbon::parse($attendance['date'])->format('d/m/Y') }}
                                                        </td>
                                                        <td>
                                                            {{ $attendance['firstEntranceTime'] }} /
                                                            {{ $attendance['firstExitTime'] }}
                                                        </td>
                                                        <td>
                                                            {{ $attendance['breakDuration'] }}
                                                        </td>
                                                        <td>
                                                            {{ $attendance['secondEntranceTime'] }} /
                                                            {{ $attendance['secondExitTime'] }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="pt-5">
                                                <tr>
                                                    <td colspan="3"
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Total / Horas Trabalhadas</td>
                                                    <td
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        {{ $hourBank['hoursWorked'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Total / Horas Extras</td>
                                                    <td
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        {{ $hourBank['extraHours'] }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                {{ $hourBank['attendance']->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-sm-12 order-first order-md-last">
                    <div class="row mt-5">
                        <div class="col-12 pb-5">
                            <div class="card">
                                <div class="card-header p-3 pt-2 mb-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-info shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">alarm_on</i>
                                    </div>
                                    <div class="text-end pt-2">
                                        <h4>Bater Ponto</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <form id="clockInForm" action="/system/clockIn" method="post">
                                                @csrf
                                            </form>
                                            <button onclick="getLocation()"
                                                class="clockInBtn btn bg-gradient-success">
                                                <i class="material-icons opacity-10">fingerprint</i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <div id="clockDisplay" class="h4" onload="showTime()"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 pb-5">
                            <div class="card">
                                <div class="card-header p-3 pt-2 mb-2">
                                    <div
                                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                        <i class="material-icons opacity-10">add_reaction</i>
                                    </div>
                                    <div class="text-end pt-1">
                                        <h4 class="mb-0 px-3">Benefícios</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body px-0 pb-2">
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center justify-content-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Benefício</th>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Valor
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot class="pt-5">
                                                    <tr>
                                                        <td
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Total</td>
                                                        <td
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    @push('js')
        <script>
            async function getLocation() {
                if (!navigator.geolocation) {
                    alert('Seu navegador nao tem suporte para geolocalização, tente em outro dispositivo');
                }

                const geolocation = await navigator.geolocation.getCurrentPosition(clockIn, locationError, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0,
                });

            }

            function clockIn(location) {
                const clockInForm = document.getElementById('clockInForm');
                clockInForm.innerHtml = "";

                let coords = {
                    'lat': location.coords.latitude,
                    'long': location.coords.longitude
                }

                Object.keys(coords).forEach(element => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.setAttribute('name', element);
                    input.value = coords[`${element}`]

                    clockInForm.append(input)
                });

                clockInForm.submit();
            }

            function locationError() {
                alert('Erro a Localizar Empregado, Entre em contato com a Administração');
            }
        </script>
    @endpush
    <x-plugins></x-plugins>
    </div>
</x-layout>
