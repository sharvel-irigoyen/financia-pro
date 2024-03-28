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
        Schema::create('receipt_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('item_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->decimal('interest', 10, 2)->nullable();
            $table->integer('installments')->unsigned()->nullable();
            $table->integer('actual_installment')->unsigned()->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->date('issue_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_details');
    }
};
