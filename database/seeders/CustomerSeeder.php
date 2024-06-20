<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 30; $i++) {
            $createdAt = Carbon::now()->subDays(rand(0, 365));
            $updatedAt = Carbon::now()->subDays(rand(0, 365));

            DB::table('customers')->insert([
                'name' => $faker->firstName,
                'lastname' => $faker->lastName,
                'document' => $faker->unique()->numerify('##########'), // 10 digit document number
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->numerify('9########'), // 9 digit phone number
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
