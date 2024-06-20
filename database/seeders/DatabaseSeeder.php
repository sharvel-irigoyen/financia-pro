<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\CreditAccount;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Receipt;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        if (User::count() === 0) {
            $this->call(UserSeeder::class);
        }
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }
        if (Item::count() === 0) {
            $this->call(ItemSeeder::class);
        }

        if (Customer::count() === 0) {
            $this->call(CustomerSeeder::class);
        }

        if (CreditAccount::count() === 0) {
            $this->call(CreditAccountSeeder::class);
        }

        if (Receipt::count() === 0) {
            $this->call(ReceiptSeeder::class);
        }
    }
}
