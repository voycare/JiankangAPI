<?php

use Illuminate\Database\Seeder;

class SummaryReviewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('summary_reviews')->delete();
        
        \DB::table('summary_reviews')->insert(array (
            0 => 
            array (
                'id' => 1,
                'clinic_id' => 1,
                'star_5' => 1,
                'star_4' => 1,
                'star_3' => 0,
                'star_2' => 0,
                'star_1' => 0,
                'star' => '4.5',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'clinic_id' => 2,
                'star_5' => 3,
                'star_4' => 1,
                'star_3' => 0,
                'star_2' => 0,
                'star_1' => 0,
                'star' => '4.7',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}