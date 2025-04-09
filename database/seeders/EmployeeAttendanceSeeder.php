<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 30; $i++) {
            EmployeeAttendance::create([
                'employee_id' => 208,
                'date' => $faker->dateTimeBetween('Last Month'),
                'firstEntranceTime' => "06:00",
                'firstExitTime' => "12:00",
                'breakDuration' => "01:00:00",
                'secondEntranceTime' => "01:00:00",
                'secondExitTime' => "18:00:00",
            ]);
        }
    }
}
