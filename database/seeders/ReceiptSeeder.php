<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $customers = DB::table('customers')->pluck('id');

        foreach ($customers as $customerId) {
            $createdAt = Carbon::now()->subDays(rand(0, 365));
            $updatedAt = Carbon::now()->subDays(rand(0, 365));

            $customer=Customer::find($customerId);
            $paymentDate = $createdAt->copy()->addMonth()->day($customer->creditAccount->due_date);

            DB::table('receipts')->insert([
                'customer_id' => $customerId,
                'subtotal' => 0,
                'interest_total' => 0,
                'status' => 0,
                'total' => 0,
                'payment_date' => $paymentDate,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
