<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="employees"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{ __('Employees') }}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"> {{ __('Editing :name', ['name' => $employee->name]) }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <div class="d-flex justify-content-between">
                                <h5>{{ __('Profile') }}</h5>
                                <a rel="tooltip" class="btn btn-danger btn-link btnEndContract"
                                    href="/employees/contract/{{ $employee->id }}" title="Rescindir Contrato">
                                    <i class="material-icons">block</i>
                                    <span>Rescindir Contrato</span>
                                    <div class="ripple-container"></div>
                                </a>
                            </div>
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
                                        @endforeach

                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="for-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="statusSelect" class="ms-0">{{ __('Status') }}</label>
                                            <select class="form-control" name="status" id="statusSelect">
                                                @foreach ($employee->status() as $key => $value)
                                                    <option {{ $key == 0 ? 'disabled' : '' }}
                                                        {{ $employee->status == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">
                                                        {{ __($value) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Name') }}</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $employee->name }}">
                                        </div>
                                        @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Position') }}</label>
                                            <select name="position_id" class="form-control">
                                                <option value=""
                                                    {{ empty($employee->position) ? 'selected' : '' }}>
                                                    {{ __('Select') }}
                                                </option>
                                                @foreach ($positions as $position)
                                                    <option
                                                        {{ $employee->position && $employee->position->id == $position->id ? 'selected' : '' }}
                                                        value="{{ $position->id }}">
                                                        {{ $position->name }}
                                                    </option>
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
                                                value='{{ $employee->email }}'>
                                        </div>
                                        @error('email')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">CPF</label>
                                            <input type="text" class="form-control cpf" name="cpf"
                                                value="{{ $employee->cpf }}">
                                        </div>
                                        @error('cpf')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Date of Birth') }}</label>
                                            <input type="date" class="form-control" name="dateofbirth"
                                                value='{{ $employee->dateofbirth }}'>
                                        </div>
                                        @error('dateofbirth')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row d-flex justify-content-start gap-3">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">PIS</label>
                                            <input type="text" class="form-control" name="pis"
                                                value="{{ $employee->pis }}">
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
                                                        value="{{ $employee->rg }}">
                                                </div>
                                                @error('rg')
                                                    <p class='text-danger inputerror'>{{ $message }} </p>
                                                @enderror
                                            </div>

                                            <div class="col-6">
                                                <div class="input-group input-group-dynamic mt-3 is-filled">
                                                    <label class="form-label">{{ __('RG Emission Date') }}</label>
                                                    <input type="date" class="form-control" name="rg_emission"
                                                        value='{{ $employee->rg_emission }}'>
                                                </div>
                                                @error('address')
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
                                                value="{{ $employee->drivers_license }}">
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
                                                        value='{{ $employee->drivers_license_expiry }}'>
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
                                                value="{{ $employee->phone }}">
                                        </div>
                                        @error('phone')
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
                                                value='{{ $employee->cep }}'>
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
                                                value='{{ $employee->address }}'>
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
                                                value='{{ $employee->neighborhood }}'>
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
                                                value='{{ $employee->number }}'>
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
                                                value='{{ $employee->complement }}'>
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
                                        <label class="form-label">{{ __('Additional Payments') }}</label>
                                        <select multiple class="searchBoxAdditional" name="additionalPayments[]"
                                            placeholder="{{ __('Additional Payments') }}">
                                            @foreach ($additionals as $additional)
                                                <option
                                                    {{ array_search($additional->id, $employeeAdditionals) !== false ? 'selected' : '' }}
                                                    value="{{ $additional->id }}">{{ $additional->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="row justify-content-end">
                                    <div class="col-2">
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn bg-gradient-primary w-100 my-4 mb-2">{{ __('Edit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="container mt-5">
                                <h5>Login</h5>
                                <div class="row">
                                    @if ($employee->user)
                                        <div class="col-2">
                                            <button
                                                class="btn bg-gradient-primary mb-0 w-100">{{ __('Create') }}</button>
                                        </div>
                                    @else
                                        <div class="col-6">
                                            {{ __('User already has an account') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            @if (!empty($family))
                                <div class="container mt-5">
                                    <h5>{{ __('Family Members') }}</h5>
                                    <div class=" me-3 my-3 text-end">
                                        <a class="btn bg-gradient-dark mb-0"
                                            href="/employees/{{ $employee->id }}/family/new"><i
                                                class="material-icons text-sm">add</i>
                                            {{ trans_choice('Add new :name', 0, ['name' => __('Family Member')]) }}
                                        </a>
                                    </div>
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        {{ __('Name') }}
                                                    </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        {{ __('CPF') }}
                                                    </th>
                                                    <th class="text-secondary opacity-7"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($family as $member)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <p class="mb-0 text-sm">{{ $member->name }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <p class="mb-0 text-sm">{{ stringMask($member->cpf, "###.###.###-##") }}</p>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">
                                                            <a rel="tooltip" class="btn btn-success btn-link"
                                                                href="/employees/{{ $employee->id }}/family/{{ $member->id }}/edit"
                                                                data-original-title="" title="">
                                                                <i class="material-icons">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </a>

                                                            <a rel="tooltip"
                                                                class="btnDeleteEntry btn btn-danger btn-link"
                                                                href="/employees/{{ $employee->id }}/family/{{ $member->id }}/delete"
                                                                data-original-title="" title="">
                                                                <i class="material-icons">close</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <div class="row justify-content-between">
                                <div class="col-3 pt-5 text-muted">
                                    <small>{{ __('Created At') }}
                                        {{ \Carbon\Carbon::parse($employee->created_at)->format('d/m/Y H:i:s') }}
                                    </small>
                                    <br>
                                    <small>{{ __('Last Updated') }}
                                        {{ \Carbon\Carbon::parse($employee->updated_at)->format('d/m/Y H:i:s') }}
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
    @push('js')
        <script>
            const btnEndContract = document.querySelector('a.btnEndContract')
            const employeeName = document.querySelector('input[name="name"]').value
            btnEndContract.addEventListener('click', (e) => {
                e.preventDefault();
                const prompt = window.confirm(`Você deseja rescindir o contrato de ${employeeName}?`)

                if (prompt) {
                    window.location.href = btnEndContract.href
                }
            })
        </script>
    @endpush
</x-layout>
