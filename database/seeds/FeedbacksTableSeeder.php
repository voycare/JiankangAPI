<?php

use Illuminate\Database\Seeder;

class FeedbacksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('feedbacks')->delete();
        
        \DB::table('feedbacks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'first_name' => 'Laboriosam mollitia',
                'last_name' => 'Vel exercitation id ',
                'phone' => 'Optio alias debitis',
                'email' => 'Asperiores placeat ',
                'message' => 'Nobis magnam natus n',
                'created_at' => '2020-04-19 17:35:18',
                'updated_at' => '2020-04-19 17:35:18',
            ),
            1 => 
            array (
                'id' => 2,
                'first_name' => '',
                'last_name' => '',
                'phone' => '',
                'email' => '',
                'message' => '',
                'created_at' => '2020-04-21 05:31:29',
                'updated_at' => '2020-04-21 05:31:29',
            ),
            2 => 
            array (
                'id' => 3,
                'first_name' => 'Tim',
                'last_name' => 'Hera',
                'phone' => 'na',
                'email' => 'tim@voycare.com',
                'message' => 'hi',
                'created_at' => '2020-04-25 20:17:55',
                'updated_at' => '2020-04-25 20:17:55',
            ),
            3 => 
            array (
                'id' => 4,
                'first_name' => 'Sarah',
                'last_name' => 'Li',
                'phone' => '16267845846',
                'email' => 'info@voycare.com',
                'message' => 'hi',
                'created_at' => '2020-05-11 08:52:55',
                'updated_at' => '2020-05-11 08:52:55',
            ),
        ));
        
        
    }
}