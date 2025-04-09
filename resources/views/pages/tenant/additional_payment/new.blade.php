<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="additional_payments"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{__('Additional Payment')}}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3">
                                    {{trans_choice('Creating new :name', 0, ['name' => __('Additional Payment')])}}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <h5>{{__('Additional Payment')}}</h5>
                            <hr>
                            <form role="form" method="POST" class="d-flex flex-column gap-2">
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
                                @endif

                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Name')}}</label>
                                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                        </div>
                                        @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Amount')}}</label>
                                            <input type="text" class="form-control money" name="amount"
                                                value="{{old('amount')}}">
                                        </div>
                                        @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start mt-5 gap-4">
                                    <div class="form-group col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" id="percentageToggle" name="percentageValue"
                                                type="checkbox">
                                            <label class="form-check-label" for="percentageToggle">
                                                {{__('Percentage Value')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="text-md mt-3">{{__('Occurences')}}</h6>
                                <div class="form-row d-flex justify-content-start mt-2 gap-4">
                                    <div class="form-group col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" id="fgtsToggle" name="fgts" type="checkbox">
                                            <label class="form-check-label" for="fgtsToggle">
                                                {{__('FGTS')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start mt-2 gap-4">
                                    <div class="form-group col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" id="inssToggle" name="inss" type="checkbox">
                                            <label class="form-check-label" for="inssToggle">
                                                {{__('INSS')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start mt-2 gap-4">
                                    <div class="form-group col-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" id="irToggle" name="ir" type="checkbox">
                                            <label class="form-check-label" for="irToggle">
                                                {{__('IR')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-2">
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">{{__("Create")}}</button>
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