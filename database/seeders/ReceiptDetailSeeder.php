<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ReceiptDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $receipts = DB::table('receipts')->pluck('id');
        $items = DB::table('items')->pluck('id');

        foreach ($receipts as $receiptId) {
            $numDetails = rand(1, 5); 
            for ($i = 0; $i < $numDetails; $i++) {
                $issueDate = Carbon::now()->subDays(rand(0, 365));
                $totalInstallments = $faker->numberBetween(0, 12);
                $gracePeriod = 0;

                if ($totalInstallments > 2) {
                    $gracePeriod = $faker->numberBetween(0, 2);
                }
                if ($totalInstallments > 4) {
                    $gracePeriod = $faker->numberBetween(0, 3);
                }

                DB::table('receipt_details')->insert([
                    'receipt_id' => $receiptId,
                    'item_id' => $faker->randomElement($items),
                    'issue_date' => $issueDate,
                    'total_installment' => $totalInstallments,
                    'grace_period_type' => $faker->randomElement(['Total', 'Parcial']),
                    'grace_period' => $gracePeriod,
                    'created_at' => $issueDate,
                    'updated_at' => $issueDate,
                ]);
            }
        }
    }
}
