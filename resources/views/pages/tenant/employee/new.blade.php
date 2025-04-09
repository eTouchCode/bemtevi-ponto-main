<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="employees"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="New Employee"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3">
                                    {{ trans_choice('Creating new :name', 0, ['name' => __('Employee')]) }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <h5>{{ __('Profile') }}</h5>
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
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Name') }}</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}">
                                        </div>
                                        @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Position') }}</label>
                                            <select name="position_id" class="form-control">
                                                <option value="" selected>{{ __('Select') }}</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('position_id')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email"
                                                value='{{ old('email') }}'>
                                        </div>
                                        @error('email')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Contract Start') }}</label>
                                            <input type="date" class="form-control" name="contract_start"
                                                value='{{ old('contract_start') }}'>
                                        </div>
                                        @error('contract_start')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Date of Birth') }}</label>
                                            <input type="date" class="form-control" name="dateofbirth"
                                                value='{{ old('dateofbirth') }}'>
                                        </div>
                                        @error('dateofbirth')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">CPF</label>
                                            <input type="text" class="form-control cpf" name="cpf"
                                                value="{{ old('cpf') }}">
                                        </div>
                                        @error('cpf')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="my-5"></div>
                                <h6>{{ __('Address') }}</h6>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-4">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('CEP') }}</label>
                                            <input type="text" class="form-control cepMask" name="cep"
                                                value='{{ old('cep') }}'>
                                        </div>
                                        @error('cep')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">

                                    <div class="form-group col-4">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Address') }}</label>
                                            <input type="text" class="form-control" name="address"
                                                value='{{ old('address') }}'>
                                        </div>
                                        @error('address')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="col-2"></div>
                                    <div class="form-group col-4">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Neighborhood') }}</label>
                                            <input type="text" class="form-control" name="neighborhood"
                                                value='{{ old('neighborhood') }}'>
                                        </div>
                                        @error('neighborhood')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-2">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Number') }}</label>
                                            <input type="text" class="form-control" name="number"
                                                value='{{ old('number') }}'>
                                        </div>
                                        @error('number')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="form-group col-4">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Complement') }}</label>
                                            <input type="text" class="form-control" name="complement"
                                                value='{{ old('complement') }}'>
                                        </div>
                                        @error('address')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="col-2"></div>
                                </div>
                                <div class="my-5"> </div>
                                <div class="form-row d-flex justify-content-start gap-3">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">PIS</label>
                                            <input type="text" class="form-control" name="pis"
                                                value="{{ old('pis') }}">
                                        </div>
                                        @error('rg')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="row justify-content-center">
                                            <div class="col-6">
                                                <div class="input-group input-group-dynamic mt-3 is-filled">
                                                    <label class="form-label">RG</label>
                                                    <input type="text" class="form-control" name="rg"
                                                        value="{{ old('rg') }}">
                                                </div>
                                                @error('rg')
                                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                                @enderror
                                            </div>

                                            <div class="col-6">
                                                <div class="input-group input-group-dynamic mt-3 is-filled">
                                                    <label class="form-label">{{ __('RG Emission Date') }}</label>
                                                    <input type="date" class="form-control" name="rg_emission"
                                                        value='{{ old('rg_emission') }}'>
                                                </div>
                                                @error('rg_emission')
                                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row d-flex justify-content-start gap-3">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">CNH</label>
                                            <input type="text" class="form-control" name="drivers_license"
                                                value="{{ old('drivers_license') }}">
                                        </div>
                                        @error('drivers_license')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="row justify-content-center">
                                            <div class="col-6">
                                                <div class="input-group input-group-dynamic mt-3 is-filled">
                                                    <label class="form-label">{{ __('CNH Type') }}</label>
                                                    <select name="drivers_license_type" class="form-control">
                                                        <option value="" selected>{{ __('Select') }}</option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                        <option value="E">E</option>
                                                    </select>
                                                </div>
                                                @error('drivers_license_type')
                                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group input-group-dynamic mt-3 is-filled">
                                                    <label class="form-label">{{ __('CNH Expiry Date') }}</label>
                                                    <input type="date" class="form-control"
                                                        name="drivers_license_expiry"
                                                        value='{{ old('drivers_license_expiry') }}'>
                                                </div>
                                                @error('drivers_license_expiry')
                                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row d-flex justify-content-start gap-3">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Phone') }}</label>
                                            <input type="text" class="form-control phone" name="phone"
                                                value="{{ old('phone') }}">
                                        </div>
                                        @error('phone')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row d-flex justify-content-start gap-3">
                                    <div class="form-group col-6">
                                        <label class="form-label">{{ __('Additional Payments') }}</label>
                                        <select multiple class="searchBoxAdditional" name="additionalPayments[]"
                                            placeholder="{{ __('Additional Payments') }}">
                                            @foreach ($additionals as $additional)
                                                <option value="{{ $additional->id }}">{{ $additional->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-2">
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">{{ __('Create') }}</button>
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
