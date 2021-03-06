<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\facades\Hash;
use Faker\Generator;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        for ($i=0; $i < 40; $i++) {     
            User::create([
                'name' => $faker->name(),
                'email' => 'test'.$i.'@ex.com',
                'email_verified_at' => now(),
                'password' => Hash::make('testpass'.$i),
                'remember_token' => Str::random(10),
            ]);
        }
        
    }
}
