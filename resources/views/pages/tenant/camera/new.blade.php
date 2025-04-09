<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="cameras"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{__('Camera')}}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3">
                                    {{trans_choice('Creating new :name', 1, ['name' => __('Camera')])}}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <h5>{{__('Camera')}}</h5>
                            <hr>
                            <form id="rtspForm" role="form" method="POST" class="d-flex flex-column gap-2">
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
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="status" type="checkbox"
                                                id="statusToggle" checked="">
                                            <label class="form-check-label" for="statusToggle">
                                                {{__('Status')}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('User')}}</label>
                                            <input type="text" class="form-control" name="user" value="{{old('user')}}">
                                        </div>
                                        @error('user')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Password')}}</label>
                                            <input type="text" class="form-control" name="password"
                                                value="{{old('password')}}">
                                        </div>
                                        @error('password')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-between  gap-4 my-4">
                                    <div class="from-group col-3">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('External IP')}}</label>
                                            <input type="text" class="form-control" name="ip" value="{{old('ip')}}">
                                        </div>
                                        @error('port')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="from-group col-3">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Port')}}</label>
                                            <input type="number" class="form-control number" name="port" min="0"
                                                value="{{old('port')}}">
                                        </div>
                                        @error('port')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="from-group col-3">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Location')}}</label>
                                            <select name="location" class="form-control">
                                                <option value="" selected>{{__("Select")}}</option>
                                                <option value="entrance">{{__("Entrance")}}</option>
                                                <option value="exit">{{__('Exit')}}</option>
                                            </select>
                                        </div>
                                        @error('location')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-3">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Path')}}</label>
                                            <input type="text" class="form-control" name="path" value="{{old('path')}}">
                                        </div>
                                        @error('path')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-12">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Address')}}</label>

                                            <input id="rtsp" type="text" class="form-control" name="address"
                                                value="{{old('address')}}">
                                        </div>
                                        @error('address')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-2">
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">{{__('Create')}}</button>
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
    <script>

        const form = document.getElementById('rtspForm');

        function setAddress(values) {
            const addr = form.querySelector('input[name=address]')
            addr.value = `rtsp://${values.user}:${values.password}@${values.ip}:${values.port}/${values.path}`
        }

        const rtspCredentials = form.querySelectorAll('input[type=number], input[type=text]:not([name=address])')
        const values = []

        rtspCredentials.forEach(element => {
            console.log(element)
            element.addEventListener('keyup', (e) => {
                values[element.name] = element.value
                console.log(element)
                setAddress(values)
            })
        });


        form.querySelectorAll('input[type=number],input[type=text]').forEach((elem) => {
            values[elem.name] = elem.value
        })

        setAddress(values);

    </script>
</x-layout>