<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="settings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{ __('Settings') }}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"> {{ __('Settings') }} </h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-5">
                            <div class="row px-5">
                                <div class="row justify-content-center">
                                    <div class="col-12 col-md-6">
                                        @if ($errors->any())
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
                                    </div>
                                </div>
                                <div class="col-12">
                                    <form action="" method="post">
                                        <div class="row justify-content-end">
                                            <div class="col-2">
                                                <div class="text-center">
                                                    <button type="submit"
                                                        class="btn bg-gradient-primary w-100 my-4 mb-2">{{ __('Edit') }}</button>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="accordion" id="settingsAccordion">
                                            @foreach ($settings as $setting)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="{{ $setting->name }}">
                                                        <button
                                                            class="accordion-button settingsButton border-bottom font-weight-bold"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $loop->iteration }}"
                                                            {{ $loop->first ? "aria-expanded='true'" : '' }}
                                                            aria-controls="collapse{{ $loop->iteration }}">
                                                            <i
                                                                class="material-icons opacity-10 mx-2">{{ $loop->first ? 'remove' : 'add' }}</i>
                                                            <span>{{ __($setting->label) }}</span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $loop->iteration }}"
                                                        class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                        aria-labelledby="{{ $setting->name }}">
                                                        <div class="accordion-body">
                                                            <div class="settingDescription">
                                                                {{ __($setting->description) }}
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="settingInput">
                                                                        <div
                                                                            class="input-group input-group-outline mt-3">
                                                                            @switch($setting->value_type)
                                                                                @case('date')
                                                                                    <input type="date"
                                                                                        class="form-control date"
                                                                                        name="{{ $setting->name }}"
                                                                                        value="{{ $setting->value }}">
                                                                                @break

                                                                                @case('number')
                                                                                    <input type="text" class="form-control"
                                                                                        name="{{ $setting->name }}"
                                                                                        value="{{ $setting->value }}">
                                                                                @break

                                                                                @case('boolean')
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input"
                                                                                            name="{{ $setting->name }}"
                                                                                            type="checkbox"
                                                                                            {{ $setting->value ? 'checked' : '' }}>
                                                                                    </div>
                                                                                @break

                                                                                @case('text')
                                                                                    <input type="text" class="form-control"
                                                                                        name="{{ $setting->name }}"
                                                                                        value="{{ $setting->value }}">
                                                                                @endswitch
                                                                            </div>
                                                                            @error('{{ $setting->name }}')
                                                                                <p class='text-danger inputerror'>
                                                                                    {{ $message }} </p>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </form>
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
        <x-plugins></x-plugins>

    </x-layout>
