<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="employees"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{__('Family Members')}}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"> Editing {{$child->name}} </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <h5>Profile</h5>
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
                                            <input type="text" class="form-control" name="name"
                                                value="{{$child->name}}">
                                        </div>
                                        @error('name')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Date of Birth')}}</label>
                                            <input type="date" class="form-control" name="dateofbirth"
                                                value="{{$child->dateofbirth}}">
                                        </div>
                                        @error('dateofbirth')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">CPF</label>
                                            <input type="text" class="form-control cpf" name="cpf"
                                                value='{{ $child->cpf }}'>
                                        </div>
                                        @error('cpf')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">RG</label>
                                            <input type="text" class="form-control" name="rg" value="{{$child->rg}}">
                                        </div>
                                        @error('rg')
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
                            <hr>
                            @if (!empty($children))
                                <div class="container mt-5">
                                    <h5>Children</h5>
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        NAME</th>

                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        School
                                                    </th>
                                                    <th class="text-secondary opacity-7"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($children as $child)
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <p class="mb-0 text-sm">{{$child->name}}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <p class="mb-0 text-sm">{{$child->school}}</p>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="employees/edit/{{$employee->id}}" data-original-title=""
                                                            title="">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>

                                                        <button type="button" class="btn btn-danger btn-link"
                                                            data-original-title="" title="">
                                                            <i class="material-icons">close</i>
                                                            <div class="ripple-container"></div>
                                                        </button>
                                                    </td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            <div class="row justify-content-between">
                                <div class="col-3 pt-5 text-muted">
                                    <small>{{__("Created At")}}
                                        {{\Carbon\Carbon::parse($child->created_at)->format('d/m/Y H:i:s')}}
                                    </small>
                                    <br>
                                    <small>{{__("Last Updated")}}
                                        {{\Carbon\Carbon::parse($child->updated_at)->format('d/m/Y H:i:s')}}
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