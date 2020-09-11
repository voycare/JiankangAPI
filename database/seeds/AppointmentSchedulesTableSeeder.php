<?php

use Illuminate\Database\Seeder;

class AppointmentSchedulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('appointment_schedules')->delete();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i <= 300; $i++) {
            \App\Models\AppointmentSchedule::create([
                'appointment_id' => rand(1, 100),
                'reschedule_time' => \Carbon\Carbon::now()->addDays(rand(1, 10)),
                'accept' => 0,
            ]);
        }
    }
}