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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number', 100)->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); 
            $table->date('order_date');
            $table->integer('total_quantity')->default(0);
            $table->decimal('total_price', 15, 2)->default(0.00); 
            $table->decimal('total_discount', 15, 2)->default(0.00); 
            $table->decimal('shipping_cost', 15, 2)->default(0.00); 
            $table->decimal('grand_total', 15, 2)->default(0.00);
            $table->decimal('remaining_balance', 15, 2)->default(0.00);
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Partial', 'Overpayment'])->default('Unpaid'); 
            $table->integer('order_status')->default(1);
            $table->timestamps();
            $table->softDeletes(); // Adds the deleted_at column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
