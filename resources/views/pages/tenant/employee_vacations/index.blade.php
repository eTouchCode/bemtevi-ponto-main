<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="vacations"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{__('Vacations')}}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"> {{__('Vacations')}} </h6>
                            </div>
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="vacations/new"><i class="material-icons text-sm">add</i>
                                {{trans_choice("Add new :name", 0, ['name' => __('Vacation Period')])}}
                            </a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-6">
                                    @if (Session::has('status'))
                                    <div class="alert alert-success alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('status') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @elseif(Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('error') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
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
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{__('Employee')}}
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{__('Vacation Start')}}
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{__("Vacation End")}}
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{__("Duration")}}
                                        </th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vacations as $vacation)
                                    <tr>
                                        <td class="align-middle text-center text-sm">
                                            <h6 class="text-xs text-secondary mb-0">
                                                {{$vacation->employee->name}}
                                            </h6>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <h6 class="text-xs text-secondary mb-0">
                                                {{\Carbon\Carbon::parse($vacation->vacation_start)->format('d/m/Y')}}
                                            </h6>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <h6 class="text-xs text-secondary mb-0">
                                                {{\Carbon\Carbon::parse($vacation->vacation_end)->format('d/m/Y')}}
                                            </h6>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <h6 class="text-xs text-secondary mb-0">
                                                {{$vacation->duration}}
                                            </h6>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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