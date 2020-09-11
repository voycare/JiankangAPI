<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') !== 'production') {
            $this->call(UsersTableSeeder::class);
            $this->call(AppointmentsTableSeeder::class);
            $this->call(AdminsTableSeeder::class);
            $this->call(AppointmentSchedulesTableSeeder::class);
            $this->call(CountriesTableSeeder::class);
            $this->call(FaqsTableSeeder::class);
            $this->call(FeedbacksTableSeeder::class);
            $this->call(JobsTableSeeder::class);
            $this->call(NewsTableSeeder::class);
            $this->call(NotificationSettingsTableSeeder::class);
            $this->call(ReviewsTableSeeder::class);
            $this->call(SummaryReviewsTableSeeder::class);
            $this->call(PaymentsTableSeeder::class);
            $this->call(TranslatorSeeder::class);
        } else {
            \DB::table('users')->delete();
            $email = 'lenhatdinh@gmail.com';
            $user = \App\User::create([
                'email' => $email,
                'first_name' => 'Dinh',
                'last_name' => 'Le Nhat',
                'password' => bcrypt('A@345678'),
                'phone' => '+840834858758',
                'gender' => 1,
                'verify' => 1,
                'avatar' => null,
                'rate' => rand(0, 5),
                'role' => \App\User::ROLE_ADMIN
            ]);
        }
    }
}
