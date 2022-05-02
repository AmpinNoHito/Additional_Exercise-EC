<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 120; $i++) { 
            Product::create([
                'name' => 'sandal',
                'price' => rand(10, 60) * 100,
                'caption' => '毎日履きたくなる、スニーカー。',
                'description' => '朝の支度が、格段にラクになる一足。シンプルで秋の来ないチームコートはクリーンでモダンなデザインが魅力。合わせたいのは、デニムやバギースウェット。スタイリッシュなレザーアッパーとフレッシュなカラーが、どんなコーディネートも引き締めてくれる。もちろん、履き心地の良さも言うことなし。',
                'image' => 'beigesandal.jpg',
            ]);
        }
    }
}
