<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="qrCode"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{ __('QR Code') }}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"> {{ __('QR Code') }} </h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-5">
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
                            <div class="row px-5">
                                <div class="col-4">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img class="img-fluid" src="{!! $qrCode !!}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-2 justify-content-start">
                                <div class="col-2">
                                    <div class="text-center">
                                        <a href="/settings/qrCode/share" target="_blank"
                                            class="btn bg-gradient-primary w-100 my-4 mb-2">{{ __('Print') }}</a>
                                    </div>

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
