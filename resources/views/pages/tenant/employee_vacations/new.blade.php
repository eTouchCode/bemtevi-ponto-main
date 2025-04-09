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
                                <h6 class="text-white mx-3">
                                    {{trans_choice('Creating new :name', 0, ['name' => __('Vacation Period')])}}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <h5>{{__('Vacation')}}</h5>
                            <hr>
                            <form role="form" method="POST" class="d-flex flex-column gap-2">
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
                                @elseif($errors->any())
                                <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                    @foreach ($errors->all() as $error)
                                    <span class="text-sm">{{ $error }}</span>
                                    <br>
                                    @endforeach

                                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif

                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-3">
                                        <label for="">{{__('Employee')}}</label>
                                        <select class="form-group choices" data-search="true" name="employee">
                                            <option value="" selected>{{__('Select')}}</option>
                                            @foreach ($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="mt-3">
                                    <h6>{{__('Period')}}</h6>
                                    <div class="form-row d-flex jusitify-content-start gap-4">
                                        <div class="col-3">
                                            <div class="input-group input-group-dynamic is-filled">
                                                <input type="text" id="dateRangeVacationStart" class="form-control" data-max="{{$vacationTime['value']}}" name="period">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-2">
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">{{__('Create')}}</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>