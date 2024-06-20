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
            $table->date('issue_date');
            $table->integer('total_installment');
            $table->string('grace_period_type', 20)->nullable();
            $table->integer('grace_period')->nullable();
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
