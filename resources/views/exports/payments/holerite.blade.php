<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Holerite em HTML</title>

    <style>
        body,
        html {
            margin: 5px;
            width: auto;
            font-family: arial, sans-serif;
            color: #242424;
            font-size: 11px;
            line-height: 1.8;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: auto;
            border: 1px dashed #918F8F;
        }

        thead tr th {
            padding-top: 5px;
            padding-bottom: 10px;
        }

        thead tr td {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 0px;
            padding-bottom: 0px;
        }

        tbody tr td {
            padding-left: 10px;
            padding-right: 10px;
        }

        tfoot tr td {
            padding-left: 10px;
            padding-right: 10px;
        }

        .border-top {
            border-top: 1px dashed #FFFFFF;
        }

        .border-bottom {
            border-bottom: 1px dashed #FFFFFF;
        }

        .border-left {
            border-left: 1px dashed #FFFFFF;
        }

        .border-right {
            border-right: 1px dashed #FFFFFF;
        }

        .border-top,
        .border-bottom,
        .border-left,
        .border-right {
            border-color: #918F8F;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-value {
            text-align: right;
        }

        .row-width {
            height: 30px;
        }

        .table-clean {
            border: 0px;
        }

        .table-label-title {
            text-align: center;
            font-size: 8px;
            font-weight: bold;
        }

        .table-label-text {
            text-align: center;
            font-size: 13px;
        }

        .table-label-text-description {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
        }

        .padding-clean {
            padding: 0px;
        }

        .display-block {
            display: block;
        }

        .row-label-value {
            font-size: 13px;
        }

        .row-description {
            padding-top: 15px;
            padding-bottom: 5px;
        }

        .page {
            width: 100%;
            height: 50vh;
        }

        .page_break {
            page-break-after: always;
        }
    </style>

</head>

<body>
    @foreach ($payments as $payment)
        <div class="page">
            <table>
                <thead>
                    <tr>
                        <th colspan="5">Recebimento de Pagamento Mensal</th>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-uppercaseS">{{ tenant('name') }}</td>
                        <td colspan="2" class="text-uppercase">{{ $paymentPeriod['date'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-uppercase">{{ stringMask(tenant('cnpj'), '##.###.###/####-##') }}
                        </td>
                        <td colspan="2" class="">Departamento: {{ $payment->employee->position->name }}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-uppercase border-top border-bottom">{{ $payment->employee->id }}
                            -
                            {{ $payment->employee->name }}</td>
                    </tr>
                    <tr>
                        <td class="border-bottom">Cod.</td>
                        <td class="border-bottom">Descrição</td>
                        <td class="border-bottom text-value">Referência</td>
                        <td class="border-bottom text-value">Vencimentos</td>
                        <td class="border-bottom text-value">Descontos</td>
                    </tr>
                </thead>
                <tbody>
                    <!-- Eventos -->
                    <tr>
                        <td class=""></td>
                        <td class="border-right text-uppercase">Salario do Empregado</td>
                        <td class="border-right text-value">{{ $paymentPeriod['days'] }} Dias</td>
                        <td class="border-right text-value">{{ $payment->salary }}</td>
                        <td class="border-right text-value"></td>
                    </tr>
                    @foreach (json_decode($payment->additionals) as $additional)
                        <tr>
                            <td class="">{{ $loop->iteration }}</td>
                            <td class="border-right text-uppercase">{{ $additional->name }}</td>
                            <td class="border-right text-value"></td>
                            <td class="border-right text-value">{{ $additional->value }}</td>
                            <td class="border-right text-value"></td>
                        </tr>
                    @endforeach
                    <!-- Fim Eventos -->

                    <!-- Espaço em Branco -->
                    <tr>
                        <td class="row-width border-bottom"></td>
                        <td class="row-width border-bottom border-right"></td>
                        <td class="row-width border-bottom border-right"></td>
                        <td class="row-width border-bottom border-right"></td>
                        <td class="row-width border-bottom border-right"></td>
                    </tr>
                    <!-- Fim do Espaço em Branco -->
                </tbody>
                <tfoot>
                    <!-- Linha Total -->
                    <tr>
                        @php
                            $employee_summary = json_decode($payment->employee_summary);
                            $discountTotal = $employee_summary->ir + $employee_summary->inss;
                            $salary = $employee_summary->salary;
                        @endphp
                        <td colspan="3" rowspan="2" class="border-bottom border-right"></td>
                        <td class="border-bottom border-right text-value">
                            <span class="table-label-title display-block">Total de Vencimentos</span>
                            <span class="row-label-value">{{ $salary }}</span>
                        </td>
                        <td class="border-bottom border-right text-value">
                            <span class="table-label-title display-block">Total de Descontos</span>

                            <span class="row-label-value">{{ $discountTotal }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-bottom border-right text-value">Liquido:</td>
                        <td class="border-bottom border-right text-value row-label-value">
                            {{ $employee_summary->salary }}
                        </td>
                    </tr>
                    <!-- Fim da Linha Total -->
                    <!-- Linha de Calculo Base -->
                    <tr>
                        <td colspan="5" class="border-bottom">
                            <table class="table-clean">
                                <tr>
                                    <td class="table-label-title">Salário Base</td>
                                    <td class="table-label-title">Sal. Contr. INSS</td>
                                    <td class="table-label-title">Base Cálc. FGTS</td>
                                    <td class="table-label-title">FGTS do Mês</td>
                                    <td class="table-label-title">Base Cálc. IRRF</td>
                                    <td class="table-label-title">Faixa IRRF</td>
                                </tr>
                                <tr>
                                    <td class="table-label-text">{{ number_format($payment->salary, 2) }}</td>
                                    <td class="table-label-text"> {{ number_format($employee_summary->salary, 2) }}
                                    </td>
                                    <td class="table-label-text">{{ number_format($payment->fgts_base, 2) }}</td>
                                    <td class="table-label-text">{{ number_format($payment->contribution_fgts, 2) }}
                                    </td>
                                    <td class="table-label-text">{{ number_format($payment->ir_base, 2) }}</td>
                                    <td class="table-label-text">{{ number_format($payment->ir_taxrate, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Fim Linha de Calculo Base -->
                    <!-- Linha Declaração -->
                    <tr>
                        <td colspan="5">
                            <table class="table-clean">
                                <tr>
                                    <td class="table-label-text-description" colspan="2">Declaro ter recebido a
                                        importância
                                        líquida discriminada neste recibo.</td>
                                </tr>
                                <tr>
                                    <td class="table-label-text row-description">
                                        <span class="row-label-value">____/____/____</span>
                                        <span class="table-label-title display-block">Data</span>
                                    </td>
                                    <td class="table-label-text row-description">
                                        <span
                                            class="row-label-value">________________________________________________________</span>
                                        <span class="table-label-title display-block">Assinatura do funcionário</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Fim Linha Declaração -->
                </tfoot>
            </table>
            <hr />
        </div>
        @if ($loop->iteration % 2 == 0)
            <div class="page_break"></div>
        @endif
    @endforeach
</body>

</html>
