<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_detail_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->integer('installment_number');
            $table->date('payment_date');
            $table->boolean('is_period_grace');
            $table->boolean('is_overdue');
            $table->decimal('interest_amount', 10, 2);
            $table->decimal('amortization', 10, 2);
            $table->decimal('remaining_balance', 10, 2);
            $table->decimal('installment', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
