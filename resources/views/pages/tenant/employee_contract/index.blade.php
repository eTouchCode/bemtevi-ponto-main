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
                                <h6 class="text-white mx-3"> Rescisão do Contrato de {{ $employee->name }} </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <form id="contractEndForm" action="/employees/contract/simulate/{{ $employee->id }}"
                                method="post">
                                <div class="row">
                                    <div class="col-12">
                                        <p>{{ __('Contract Start') }}: {{ $contract_start }} ({{ $contract_duration }})
                                        </p>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="form-group col-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="quitType" class="ms-0">Tipo de Demissão</label>
                                            <select class="form-control" name="quitType" id="quitType">
                                                <option value="" selected>{{ __('Select') }}</option>
                                                <option value="1">Dispensa sem justa causa</option>
                                                <option value="2">A pedido do funcionário</option>
                                                <option value="3">Dispensa por justa causa</option>
                                                <option value="4">Termino do contrato de experiência</option>
                                                <option value="5">Rescisao antecipda do contrato de experiência por
                                                    iniciativa da empresa</option>
                                                <option value="6">Rescisão antecipda do contrato de experiência por
                                                    iniciativa do funcionário</option>
                                                <option value="7">Falecimento do funcionário</option>
                                            </select>
                                            @error('quitType')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic is-filled mt-4">
                                            <label class="form-label">Término do contrato</label>
                                            <input type="date" class="form-control" name="contract_end"
                                                value=''>
                                        </div>
                                        @error('contract_start')
                                            <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-4 d-flex align-items-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="notice" value="true"
                                                type="checkbox" id="noticeToggle" checked="">
                                            <label class="form-check-label" for="noticeToggle">
                                                {{ __('Prior Notice') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic is-filled mt-4">
                                            <label class="form-label" for="fgtsBalance">
                                                Saldo FGTS
                                            </label>
                                            <input type="text" id="fgtsBalance" class="form-control money"
                                                name="fgtsBalance" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="me-3 my-3 text-end">
                                            <button class="btn bg-gradient-dark mb-0"><i
                                                    class="material-icons text-sm">search</i>
                                                Calcular
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div id="resultContainer" class="d-none">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <x-footers.auth></x-footers.auth>
            </div>
        </div>
    </main>
    @push('js')
        <script>
            document.getElementById('contractEndForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const resultContainer = document.getElementById('resultContainer')

                if (!resultContainer.classList.contains('d-none')) {
                    resultContainer.classList.add('d-none')
                }

                const formData = new FormData(e.target);

                let response = await fetch(e.target.getAttribute('action'), {
                    method: "POST",
                    body: formData,
                })

                response = await response.json();

                resultContainer.innerHTML = response
                resultContainer.classList.remove('d-none')
            })
        </script>
    @endpush
    <x-plugins></x-plugins>
</x-layout>
