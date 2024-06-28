<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CreditAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $customers = DB::table('customers')->pluck('id'); // Get all customer IDs

        foreach ($customers as $customerId) {
            $createdAt = Carbon::now()->subDays(rand(0, 365));
            $updatedAt = Carbon::now()->subDays(rand(0, 365));

            DB::table('credit_accounts')->insert([
                'customer_id' => $customerId,
                'credit_type' => $faker->randomElement(['TEA', 'TNA']),
                'interest_rate' => $faker->randomFloat(2, 0.01, 0.30),
                'interest_arrears' => $faker->randomFloat(2, 0.31, 0.50),
                'balance' => 0,
                'due_date' => $faker->numberBetween(1, 29),
                // 'grace_period_type' => $faker->randomElement(['none', 'partial', 'full']),
                // 'grace_period' => $faker->numberBetween(0, 12),
                'credit_limit' => $faker->numberBetween(100, 3000),
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
