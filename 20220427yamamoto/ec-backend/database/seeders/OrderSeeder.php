<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Faker\Generator;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        for ($i = 1; $i <= 40; $i++) {
            for ($j = 1; $j <= 20; $j++) { 
                $item = Order::create([
                    'id' => $faker->uuid(),
                ]);
                $rand1 = rand(1, 40);
                $rand2 = 0;
                do {
                    $rand2 = rand(1, 40);
                } while ($rand2 === $rand1);
                $item->products()->sync([
                    $rand1 => [
                        'product_quantity' => 1,
                        'user_id' => $i,
                    ],
                    $rand2 => [
                        'product_quantity' => 2,
                        'user_id' => $i,
                    ],
                ]);
            }
        }
    }
}
