<?php

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('payments')->delete();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i <= 50; $i++) {
            \App\Models\Payment::create([
                'client_id' => rand(2, 22),
                'clinic_id' => rand(22, 42),
                'appointment_id' => rand(1, 100),
                'consulation_type' => rand(1, 4),
                'name' => $faker->text(40),
                'email' => $faker->email,
                'payment_type' => rand(1, 3),
                'paid_date' => \Carbon\Carbon::now()->addDays(rand(-10, -1)),
                'paid_amount' => rand(200, 3000),
                'status' => rand(1, 2)
            ]);
        }

        \DB::table('payment_items')->delete();

        for ($i = 0; $i <= 300; $i++) {
            $price = rand(100, 500);
            $quantity = rand(1, 10);
            $total = $price * $quantity;
            \App\Models\PaymentItem::create([
                'name' => $faker->name,
                'clinic_id' => rand(1, 10),
                'payment_id' => rand(1, 50),
                'price' => $price,
                'quantity' => $quantity,
                'total' => $total,
            ]);
        }

        \DB::table('statements')->delete();
        \DB::table('statement_items')->delete();
        for ($i = 0; $i <= 200; $i++) {
            $statement = \App\Models\Statement::create([
                'statement_no' => $faker->numberBetween(),
                'sale_period' => \Carbon\Carbon::now()->addDays(rand(1, 10)),
                'payment_date' => \Carbon\Carbon::now()->addDays(rand(11, 20)),
                'from_id' => rand(1, 10),
                'to_id' => rand(22, 41),
                'status' => rand(1, 2),
                'net' => rand(100, 4000)
            ]);

            $max = rand(3, 7);
            for ($j = 1; $j <= $max; $j++) {
                \App\Models\StatementItem::create([
                    'statement_id' => $statement->id,
                    'item_date' => \Carbon\Carbon::now()->addDays(rand(1, 10)),
                    'item_name' => $faker->text(40),
                    'appointment_no' => $faker->numberBetween(),
                    'amount' => $faker->numberBetween(100, 2000)
                ]);
            }
        }
    }
}