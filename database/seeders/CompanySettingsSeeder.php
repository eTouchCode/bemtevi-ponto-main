<?php

namespace Database\Seeders;

use App\Models\CompanySettings;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('company_settings')->count() == 0) {
            CompanySettings::insert([
                [
                    'label' => 'Vacations',
                    'name' => 'VACATION_TIME',
                    'description' => 'VACATION_TIME_DESCRIPTION',
                    'value_type' => 'number',
                    'value' => '30',
                ],
                [
                    'label' => '13th Paycheck Date',
                    'name' => '13_SALARY',
                    'description' => '13_SALARY_DESCRIPTION',
                    'value_type' => 'date',
                    'value' => "11-30",
                ],
                [
                    'label' => '13th Paycheck Payment',
                    'name' => '13_PAYMENT',
                    'description' => '13_PAYMENT_DESCRIPTION',
                    'value_type' => 'boolean',
                    'value' => '0',
                ],
                [
                    'label' => '13th Paycheck first installment',
                    'name' => '13_SALARY_INSTALLMENT_1',
                    'description' => '',
                    'value_type' => 'date',
                    'value' => "11-30",
                ],
                [
                    'label' => '13th Paycheck second installment',
                    'name' => '13_SALARY_INSTALLMENT_2',
                    'description' => '',
                    'value_type' => 'date',
                    'value' => "12-20",
                ],
                [
                    'label' => 'Enable Clock In Distance',
                    'name' => 'CLOCK_IN_DISTANCE_ENABLE',
                    'description' => 'CLOCK_IN_DISTANCE_DESCRIPTION',
                    'value_type' => 'boolean',
                    'value' => '0'
                ],
                [
                    'label' => 'Clock In Distance Range',
                    'name' => 'CLOCK_IN_DISTANCE_RANGE',
                    'description' => 'CLOCK_IN_DISTANCE_RANGE_DESCRIPTION',
                    'value_type' => 'number',
                    'value' => '0'
                ],
                [
                    'label' => 'Company Coordinates',
                    'name' => 'COMPANY_LOCATION',
                    'description' => 'COMPANY_LOCATION_DESCRIPTION',
                    'value_type' => 'text',
                    'value' => '',
                ]
            ]);
        }
    }
}
