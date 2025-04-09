<?php

namespace Database\Seeders;

use App\Models\AdditionalPayment;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdditionalPaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('additional_payments')->count() == 0) {
            AdditionalPayment::insert(
                [
                    ['name' => 'Abono (outros)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Abono de férias', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Adicionais (Insalubridade, periculosidade, etc)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Acidente de trabalho (Quinze primeiros dias de afastamento)', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => true, 'ir' => true],
                    ['name' => 'Acidente de trabalho (Período de afastamento)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => false, 'ir' => true],
                    ['name' => 'Acidente de trabalho (complementação até o valor do salário)', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => true],
                    ['name' => 'Ajuda de custo (Até 50% do salário)', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Ajuda de custo (Acima de 50% do salário)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => false],
                    ['name' => 'Auxílio-doença', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Auxílio-doença (complementação até o valor do salário)', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => true],
                    ['name' => 'Aviso prévio (Indenizado)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => false],
                    ['name' => 'Aviso prévio (trabalhado)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Creche', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Comissões', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => '13º Salário 1º Parcela', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => false, 'ir' => false],
                    ['name' => '13º Salário 2º Parcela', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => '13º Salário', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => '13º Salário (correspondente à projeção de aviso prévio)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => '13º Salário (parcela de ajuste paga em janeiro do ano seguinte)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Demissão Voluntária Incentivada', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Descanso Semanal Remunerado', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Diárias até 50% do salário', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Diárias acima de 50%', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Estagiários', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => true],
                    ['name' => 'Férias (indenizadas + 1/3 constitucional ou proporcional)', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Férias normais (inclusive férias coletivas + 1/3 constitucional)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Férias (dobra)', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => true],
                    ['name' => 'Gorjetas', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Gratificação Ajustadas', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Horas Extras', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Indenizações por tempo de serviço', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Indenização em geral', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Indenização adicional', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Multa', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Participação nos lucros e resultados', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => true],
                    ['name' => 'Percentagens', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Prêmios', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Produtividade', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Quebra de Caixa', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Retiradas de Diretores Empregados', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => true, 'ir' => true],
                    ['name' => 'Retiradas de Diretores Proprietários', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => true, 'ir' => true],
                    ['name' => 'Salário-Família', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Salário-Maternidade', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Salário utilidade (Programas de alimentação)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Salário utilidade (Plano educacional)', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Salário utilidade (Previdência complementar)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Salário utilidade (Cobertura médica e/ou Odontológica)', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Salário utilidade (Prêmio de seguro de vida)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Salário utilidade (Outros)', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => true, 'ir' => true],
                    ['name' => 'Saldo de Salário', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => true, 'ir' => true],
                    ['name' => 'Serviço de Autônomo', 'amount' => 0, 'percentageValue' => false, 'fgts' => true, 'inss' => false, 'ir' => true],
                    ['name' => 'Serviço Militar Obrigatório', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => true, 'ir' => true],
                    ['name' => 'Transportador Autônomo', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Utilidades', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                    ['name' => 'Vale-Transporte', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => true],
                    ['name' => 'Veículo do Emprego', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => true],
                    ['name' => 'Vestuários, equipamentos e outros acessórios', 'amount' => 0, 'percentageValue' => false, 'fgts' => false, 'inss' => false, 'ir' => false],
                ]
            );
        }
    }
}
