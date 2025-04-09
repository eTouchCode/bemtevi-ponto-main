<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="workshifts"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{__('Workshifts')}}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"> {{__('Editing :name', ['name' => __('Position')])}}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <h5>{{__('Position')}}</h5>
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
                                @endif
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Name')}}</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{$workshift->name}}">
                                        </div>
                                        @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Start')}}</label>
                                            <input type="text" class="form-control time" name="start_time"
                                                value="{{$workshift->start_time}}">

                                        </div>
                                        @error('start_time')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('End')}}</label>
                                            <input type="text" class="form-control time" name="end_time"
                                                value="{{$workshift->end_time}}">
                                        </div>
                                        @error('workshift_id')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Break Time')}}</label>
                                            <input type="text" class="form-control time" name="break_time"
                                                value="{{$workshift->break_time}}">

                                        </div>
                                        @error('break_time')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Break Amount')}}</label>
                                            <input type="text" class="form-control time" name="break_amount"
                                                value="{{$workshift->break_amount}}">

                                        </div>
                                        @error('break_amount')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-2">
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">{{__('Edit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row justify-content-between">
                                <div class="col-3 pt-5 text-muted">
                                    <small>{{__("Created At")}}
                                        {{\Carbon\Carbon::parse($workshift->created_at)->format('d/m/Y H:i:s')}}
                                    </small>
                                    <br>
                                    <small>{{__("Last Updated")}}
                                        {{\Carbon\Carbon::parse($workshift->updated_at)->format('d/m/Y H:i:s')}}
                                    </small>
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