<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class CentralEmployeeLoginsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (DB::table('central_employee_logins')->count() == 0) {
            DB::table('central_employee_logins')->insert([
                'global_id' => '1',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
