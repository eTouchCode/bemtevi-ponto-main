@props(['activePage'])
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href="/dashboard">
            <img src="{{ asset('assets') }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">{{tenant('name')}}</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} " href="/dashboard">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'payroll' ? ' active bg-gradient-primary' : '' }} " href="/payroll">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Payroll')}}</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">{{__('Forms')}}
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'cameras' ? ' active bg-gradient-primary' : '' }} " href="/cameras">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">video_camera_front</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Cameras')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'employees' ? ' active bg-gradient-primary' : '' }} " href="/employees">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">diversity_1</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Employees')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'positions' ? ' active bg-gradient-primary' : '' }} " href="/positions">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">cases</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Positions')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'salaries' ? ' active bg-gradient-primary' : '' }} " href="/salaries">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">payments</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Salaries')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'workshifts' ? ' active bg-gradient-primary' : '' }} " href="/workshifts">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">schedule</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Workshifts')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'vacations' ? ' active bg-gradient-primary' : '' }} " href="/vacations">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">date_range</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Vacations')}}</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">{{__('Settings')}}
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'benefits' ? ' active bg-gradient-primary' : '' }} " href="/benefits">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">fact_check</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Benefits')}}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'additional_payments' ? ' active bg-gradient-primary' : '' }} " href="/additional_payments">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Additional Payments')}}</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">
                    {{tenant('name')}}
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'warnings' ? ' active bg-gradient-primary' : '' }} " href="/warnings">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">report</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Warnings')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'settings' ? ' active bg-gradient-primary' : '' }} " href="/settings">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dataset</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('Settings')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'qrCode' ? ' active bg-gradient-primary' : '' }} " href="/settings/qrCode">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">qr_code</i>
                    </div>
                    <span class="nav-link-text ms-1">{{__('QR Code')}}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>