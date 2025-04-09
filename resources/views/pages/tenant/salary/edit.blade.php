<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="salaries"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="{{__('Editing :name', ['name' => __('Salary')])}}"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3">
                                    {{__('Editing :name', ['name' => __('Salary')])}}
                                </h6>
                            </div>
                        </div>
                        <div class="card-body px-5 pb-5">
                            <h5>{{__('Salary')}}</h5>
                            <hr>
                            <form id="salaryForm" role="form" method="POST" class="d-flex flex-column gap-2">
                                @if (Session::has('status'))
                                <div class="alert alert-success alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ Session::get('status') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @elseif(Session::has('error'))
                                <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ Session::get('error') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
                                <div class="form-row d-flex justify-content-start gap-4">
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Name')}}</label>
                                            <input type="text" class="form-control" name="name" value="{{$salary->name}}">
                                        </div>
                                        @error('name')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <div class="input-group input-group-dynamic mt-3 is-filled">
                                            <label class="form-label">{{__('Amount')}}</label>
                                            <input id="salary" type="text" class="form-control money" name="amount" value="{{$salary->amount}}">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        @error('name')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-2">
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">{{__("Edit")}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row justify-content-between">
                                <div class="col-3 pt-5 text-muted">
                                    <small>{{__("Created At")}}
                                        {{\Carbon\Carbon::parse($salary->created_at)->format('d/m/Y H:i:s')}}
                                    </small>
                                    <br>
                                    <small>{{__("Last Updated")}}
                                        {{\Carbon\Carbon::parse($salary->updated_at)->format('d/m/Y H:i:s')}}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary Modal -->
            <div class="modal fade" id="salaryModal" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="salaryModalLabel">Alteração de Salário</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <h6>O Salário foi alterado</h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h6>A mudança será temporária ou permanente?</h6>
                                    <small>Em caso de mudança temporária um aviso para o proxímo mês será criado</small>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="permanent" type="checkbox" id="salaryCheck">
                                        <label class="form-check-label" for="salaryCheck">
                                            Mudança Permanente
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btnSalaryChanges" type="button" class="btn btn-primary">{{__("Edit")}}</button>
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
        const salaryAmount = Number(document.getElementById('salary').value.replace(',', ''));
        const salaryForm = document.getElementById('salaryForm');
        let temporaryCheck = false

        const salaryModal = new bootstrap.Modal(document.getElementById('salaryModal'), {
            backdrop: true,
            keyboard: true,
            focus: true,
        });

        salaryForm.addEventListener('submit', (e) => {
            const editedSalaryAmount = Number(document.getElementById('salary').value.replace(',', ''));
            if (editedSalaryAmount !== salaryAmount) {
                e.preventDefault();
                salaryModal.show();
            }
        })

        document.getElementById('salaryCheck').addEventListener('change', (e) => {
            const elem = e.target;
            const label = document.querySelector('label[for="salaryCheck"]')
            if (elem.checked) {
                label.innerHTML = "Mudança Temporária"
                temporaryCheck = true
            } else {
                label.innerHTML = "Mudança Permanente"
                temporaryCheck = false
            }

        })

        document.getElementById('btnSalaryChanges').addEventListener('click', (e) => {
            if (temporaryCheck) {
                const permanentInput = document.createElement('input');
                permanentInput.type = "hidden";
                permanentInput.name = "temporary";
                permanentInput.value = 1

                const oldSalaryInput = document.createElement('input');
                oldSalaryInput.type = "hidden";
                oldSalaryInput.name = "oldValue";
                oldSalaryInput.value = salaryAmount;
                salaryForm.append(permanentInput, oldSalaryInput);
            }

            salaryForm.submit();
        })
    </script>
    @endpush
</x-layout>