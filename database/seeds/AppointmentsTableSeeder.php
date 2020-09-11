<?php

use Illuminate\Database\Seeder;

class AppointmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        \DB::table('appointments')->delete();
        \DB::table('appointment_cancellations')->delete();

        for ($i = 0; $i <= 200; $i++) {
            $spec_id = rand(\App\Models\Appointment::COUNSELING, \App\Models\Appointment::FERTILITY);
            $treatment_id = $spec_id == \App\Models\Appointment::COUNSELING ? rand(1, 5) : rand(6, 11);

            $appt = \App\Models\Appointment::create([
                'client_id' => rand(2, 21),
                'doctor_id' => rand(1, 50),
                'clinic_id' => rand(22, 42),
                'date' => \Carbon\Carbon::now()->addHours(rand(1, 48)),
                'status' => rand(0, 4),
                'mode' => rand(1, 2),
                'type_id' => rand(1, 2),
                'state' => rand(1, 2),
                'specialty_id' => $spec_id,
                'treatment_id' => $treatment_id,
                'interpreter_id' => rand(1, 10)
            ]);

            if ($appt->status == \App\Models\Appointment::CANCELLED) {
                \App\Models\AppointmentCancellation::create([
                    'appointment_id' => $appt->id,
                    'client_id' => $appt->client_id,
                    'why_cancel' => rand(0, 1),
                    'note' => $faker->text(),
                    'provide_options' => rand(0, 1),
                    'use_again' => rand(0, 1),
                    'status' => rand(1, 2),
                    'fee' => rand(50, 100),
                    'admin_note' => $faker->text()
                ]);
            }
        }

        \DB::table('interpreters')->delete();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i <= 10; $i++) {
            \App\Models\Interpreter::create([
                'name' => $faker->name,
                'language' => rand(1, 3),
                'phone' => $faker->phoneNumber
            ]);
        }
    }
}