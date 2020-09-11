<?php

use Illuminate\Database\Seeder;

class TranslatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('translators')->delete();
        \DB::table('translator_languages')->delete();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i <= 50; $i++) {
            $translator = \App\Models\Translator::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'wechat' => $faker->phoneNumber,
                'phone' => $faker->phoneNumber,
                'current_location' => $faker->address,
                'nationality' => $faker->name,
                'national_id' => $faker->uuid
            ]);
            for ($j = 0; $j <= 4; $j++) {
                \App\Models\TranslatorLanguage::create([
                    'translator_id' => $translator->id,
                    'language_id' => rand(1, 6)
                ]);
            }
        }
    }
}
