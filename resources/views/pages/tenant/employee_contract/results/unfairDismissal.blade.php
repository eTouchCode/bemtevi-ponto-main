<div class="fluid-container">
    <div class="row gap-2">
        <div class="col-12">
            <h6>Saldo Salário</h6>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Valor</td>
                            <td>INSS</td>
                            <td>IR</td>
                            <td>Valor Final</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ Number::currency($data['balance']['amount'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['balance']['inss'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['balance']['ir'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['balance']['result'], 'BRL') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12">
            <h6>13° Salário Proporcional</h6>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Valor</td>
                            <td>INSS</td>
                            <td>IR</td>
                            <td>Valor Final</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ Number::currency($data['13thSalary']['amount'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['13thSalary']['inss'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['13thSalary']['ir'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['13thSalary']['result'], 'BRL') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12">
            <h6>Férias Vencidas</h6>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Dias Vencidos</td>
                            <td>Valor</td>
                            <td>INSS</td>
                            <td>IR</td>
                            <td>Abono Pecuniário</td>
                            <td>Valor Final</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $data['vacations']['remainingDays'] }}</td>
                            <td>
                                {{ Number::currency($data['vacations']['value'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['vacations']['inss'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['vacations']['ir'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['vacations']['additional'], 'BRL') }}
                            </td>
                            <td>
                                {{ Number::currency($data['vacations']['result'], 'BRL') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <h6>Saldo FGTS Estimado</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Meses Contribuição</td>
                                    <td>Valor</td>
                                    <td>Valor Final</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $data['fgtsBalance']['months'] }}</td>
                                    <td>
                                        {{ Number::currency($data['fgtsBalance']['value'], 'BRL') }}
                                    </td>
                                    <td>
                                        {{ Number::currency($data['fgtsBalance']['result'], 'BRL') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6">
                    <h6>Ferias Proporcionais</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Meses Trabalhados</td>
                                    <td>Valor</td>
                                    <td>Valor Final (Valor + 1/3)</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $data['proportionalVacation']['monthsWorked'] }}</td>
                                    <td>
                                        {{ Number::currency($data['proportionalVacation']['amount'], 'BRL') }}
                                    </td>
                                    <td>
                                        {{ Number::currency($data['proportionalVacation']['result'], 'BRL') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
