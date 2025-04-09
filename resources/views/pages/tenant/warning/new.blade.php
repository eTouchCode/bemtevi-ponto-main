<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="warnings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{ __('Warning') }}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3">
                                    {{ trans_choice('Creating new :name', 0, ['name' => __('Warning')]) }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <h5>{{ __('Warning') }}</h5>
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
                                            <label class="form-label">{{ __('Title') }}</label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ old('title') }}">
                                        </div>
                                        @error('title')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="ms-0">{{ __('Type') }}</label>
                                            <select class="form-control" name="warningType">
                                                <option>{{ __('Select') }}</option>
                                                <option value="success" class="text-success">Success</option>
                                                <option value="warning">Warning</option>
                                                <option value="info">Info</option>
                                                <option value="danger">Danger</option>
                                                <option value="primary">Primary</option>
                                                <option value="secondary">Secondary</option>
                                            </select>
                                        </div>
                                        @error('warningType')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic">
                                            <textarea class="form-control" name="message" rows="2" placeholder="{{ _('Message') }}" spellcheck="false">{{ old('message') }}</textarea>
                                        </div>
                                        @error('message')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="ms-0">{{ __('Target') }}</label>
                                            <select class="form-control">
                                                <option>{{ __('Select') }}</option>
                                                <option value="company">Todos</option>
                                                <option value="admins">Administradores</option>
                                                <option value="employees">Funcionários</option>
                                            </select>
                                        </div>
                                        @error('target')
                                            <p class="text-danger inputerror">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-group input-group-static mb-4">
                                                    <label class="ms-0">{{ __('Icon') }}</label>
                                                    <select id="iconSelect" class="form-control" name="icon">
                                                        @foreach ($icons as $icon)
                                                            <option value="{{ $icon }}">{{ $icon }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('icon')
                                                    <p class="text-danger inputerror">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="col-6">
                                                <div class="h-100 d-flex flex-row align-items-center gap-5">
                                                    <p class="m-0">Preview:</p>
                                                    <span id="previewIcon"><i
                                                            class="material-icons">{{ $icons[0] }}</i></span>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{ __('Start') }}</label>
                                            <input type="date" class="form-control" name="date"
                                                value='{{ old('date') ?? now()->format('Y-m-d') }}'>
                                        </div>
                                        @error('date')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
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
    @push('js')
        <script>
            document.getElementById('iconSelect').addEventListener('change', (e) => {
                const value = e.target.value
                const icon = document.querySelector('#previewIcon i');
                console.log(icon);
                icon.innerHTML = value;
            })
        </script>
    @endpush
</x-layout>
