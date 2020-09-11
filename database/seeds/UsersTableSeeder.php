<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        $faker = \Faker\Factory::create();

        $emails = ['admin@hera.health'];
        foreach ($emails as $email) {
            $user = \App\User::create([
                'email' => $email,
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'password' => bcrypt('A@345678'),
                'phone' => $faker->phoneNumber,
                'gender' => rand(0, 2),
                'verify' => 1,
                'avatar' => null,
                'rate' => rand(0, 5),
                'role' => \App\User::ROLE_ADMIN
            ]);
            \App\Models\UserAddress::create([
                'user_id' => $user->id,
                'country' => $faker->country,
                'city' => $faker->city,
                'state' => $faker->state,
                'street_line_1' => $faker->streetAddress,
                'street_line_2' => $faker->streetAddress,
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            $email = 'user' . $i . '@hera.health';
            $user = \App\User::create([
                'email' => $email,
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'password' => bcrypt('A@345678'),
                'phone' => $faker->phoneNumber,
                'age' => rand(18, 60),
                'gender' => rand(0, 2),
                'verify' => 1,
                'avatar' => null,
                'rate' => rand(0, 5),
                'role' => \App\User::ROLE_CLIENT
            ]);
            \App\Models\UserAddress::create([
                'user_id' => $user->id,
                'country' => $faker->country,
                'city' => $faker->city,
                'state' => $faker->state,
                'street_line_1' => $faker->streetAddress,
                'street_line_2' => $faker->streetAddress,
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            $email = 'clinic' . $i . '@hera.health';
            $user = \App\Models\Clinic::create([
                'email' => $email,
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'password' => bcrypt('A@345678'),
                'phone' => $faker->phoneNumber,
                'gender' => rand(0, 2),
                'verify' => 1,
                'avatar' => null,
                'rate' => rand(0, 5),
                'role' => \App\User::ROLE_CLINIC
            ]);
            \App\Models\UserAddress::create([
                'user_id' => $user->id,
                'country' => $faker->country,
                'city' => $faker->city,
                'state' => $faker->state,
                'street_line_1' => $faker->streetAddress,
                'street_line_2' => $faker->streetAddress,
            ]);
            \App\Models\ClinicProfile::create([
                'clinic_id' => $user->id,
                'title' => $faker->title,
                'description' => $faker->text,
                'type_clinic' => $faker->name,
                'contact_person' => $faker->email
            ]);
            \App\Models\ClinicCertificate::create([
                'name' => $faker->title,
                'description' => $faker->text,
                'clinic_id' => $user->id,
                'path' => null,
            ]);
            for ($j = 0; $j < 4; $j++) {
                \App\Models\ClinicTreatment::create([
                    'clinic_id' => $user->id,
                    'type' => $faker->text(25),
                    'from' => rand(100, 500),
                    'description' => $faker->text(200)
                ]);
            }
            for ($j = 0; $j < 12; $j++) {
                $date = \Carbon\Carbon::now();
                \App\Models\ClinicAvailable::create([
                    'clinic_id' => $user->id,
                    'type' => rand(1, 2),
                    'date' => $date->addDays(rand(1, 20))
                ]);
            }
            for ($j = 0; $j < 3; $j++) {
                \App\Models\ClinicLanguage::create([
                    'clinic_id' => $user->id,
                    'language' => $faker->country
                ]);
            }
            for ($j = 0; $j < 3; $j++) {
                \App\Models\Doctor::create([
                    'clinic_id' => $user->id,
                    'name' => $faker->title,
                    'title' => $faker->title,
                    'bio' => $faker->text,
                    'country' => $faker->country
                ]);
            }
        }

        \DB::table('messages')->delete();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i <= 200; $i++) {
            $to_id = rand(1, 10);
            $from_id = rand(1, 40);
            $msg = \App\Models\Message::create([
                'to_id' => $to_id,
                'from_id' => $from_id,
                'subject' => $faker->text(100),
                'content' => $faker->text(200),
            ]);
            \App\Models\MessageState::create([
                'message_id' => $msg->id,
                'user_id' => $to_id,
                'state' => rand(1, 2)
            ]);
            \App\Models\MessageState::create([
                'message_id' => $msg->id,
                'user_id' => $from_id,
                'state' => rand(1, 2)
            ]);
        }

        $emails = ['lenhatdinh@gmail.com', 'tim@voycare.com'];
        foreach ($emails as $email) {
            $user = \App\User::create([
                'email' => $email,
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'password' => bcrypt('A@345678'),
                'phone' => $faker->phoneNumber,
                'gender' => rand(0, 2),
                'verify' => 1,
                'avatar' => null,
                'rate' => rand(0, 5),
                'role' => \App\User::ROLE_ADMIN
            ]);
            \App\Models\UserAddress::create([
                'user_id' => $user->id,
                'country' => $faker->country,
                'city' => $faker->city,
                'state' => $faker->state,
                'street_line_1' => $faker->streetAddress,
                'street_line_2' => $faker->streetAddress,
            ]);
        }
    }
}