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
        Schema::create('transaction_detail_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_id')->constrained('transaction_details')->onDelete('cascade'); 
            $table->foreignId('attributes_id')->constrained('attributess')->onDelete('cascade'); 
            $table->string('attributes_value',200);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_detail_products');
    }
};
