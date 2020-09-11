<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admins')->delete();
        
        \DB::table('admins')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$RfmhtOx.pU4aegvmadrkzuQ0vdSE7HBCfk4mQvV.OAcXR7dTKdhwe',
                'name' => 'Admin',
                'avatar' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


        \DB::table('admins')->insert(array (
            0 =>
                array (
                    'email' => 'admin@hera.health',
                    'password' => bcrypt('A@345678'),
                    'name' => 'Admin',
                    'avatar' => ''
                ),
            1 => array (
                'email' => 'test@admin.com',
                'password' => bcrypt('Q!2345678'),
                'name' => 'Admin',
                'avatar' => ''
            ),
        ));
        
    }
}