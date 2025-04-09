<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="cameras"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{__('Cameras')}}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"> {{__('Cameras')}} </h6>
                            </div>
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="cameras/new"><i
                                    class="material-icons text-sm">add</i>
                                {{trans_choice("Add new :name", 1, ['name' => __('Camera')])}}
                            </a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-6">
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
                                </div>
                            </div>

                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{__('Name')}}
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{__('IP')}}
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{__('Port')}}
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{__('Status')}}
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{__('Created At')}}
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cameras as $camera)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="mb-0 text-sm">{{$camera->id}}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$camera->name}}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1 justify-content-center">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="mb-0 text-center text-sm">{{$camera->ip}}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="d-flex px-2 py-1 justify-content-center">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="mb-0 text-center text-sm">{{$camera->port}}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <div class="d-flex px-2 py-1 justify-content-center">
                                                        <div class="d-flex flex-column">
                                                            <p class="mb-0 text-sm">
                                                                {{$camera->status ? __('Enabled') : __('Disabled') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{\Carbon\Carbon::parse($camera->created_at)->format('d/m/Y')}}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a rel="tooltip" class="btn btn-success btn-link"
                                                        href="cameras/edit/{{$camera->id}}" data-original-title="" title="">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                    </a>

                                                    <a rel="tooltip" href="cameras/delete/{{$camera->id}}"
                                                        class="btnDeleteEntry btn btn-danger btn-link"
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
                        <div class="px-5">
                            {{$cameras->onEachSide(5)->links()}}
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

</x-layout>