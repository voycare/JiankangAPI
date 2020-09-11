<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create();

        \DB::table('news_categories')->delete();

        for ($i = 0; $i <= 10; $i++) {
            \App\Models\NewsCategory::create([
                'name' => $faker->text(40)
            ]);
        }

        \DB::table('news')->delete();

        for ($i = 0; $i <= 40; $i++) {
            \App\Models\News::create([
                'title' => $faker->text(100),
                'author_id' => 1,
                'publish_date' => \Carbon\Carbon::now()->addDays(rand(1, 10)),
                'content' => $faker->text(),
                'source' => $faker->text(50),
                'status' => rand(0, 1)
            ]);
        }
    }
}