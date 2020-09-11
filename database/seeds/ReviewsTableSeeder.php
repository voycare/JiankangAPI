<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('reviews')->delete();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            \App\Models\Review::create([
                'appointment_id' => rand(1, 100),
                'client_id' => rand(1, 20),
                'clinic_id' => rand(22, 42),
                'treatment_id' => rand(1, 40),
                'star' => rand(0, 5),
                'content' => $faker->text,
                'title' => $faker->name,
                'status' => rand(1, 2)
            ]);
        }
    }
}