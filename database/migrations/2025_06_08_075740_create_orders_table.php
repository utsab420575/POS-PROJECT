<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //per sale one order record will create
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onDelete('cascade'); // Optional: delete orders if customer is deleted

            $table->date('order_date');
            $table->string('order_status');
            $table->integer('total_products');
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->decimal('vat', 10, 2)->nullable();
            $table->string('invoice_no')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->decimal('pay', 10, 2)->nullable();
            $table->decimal('due', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
