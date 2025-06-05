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
        Schema::create('pay_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id'); // match employees.id type
            $table->string('salary_month')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('advance_salary')->nullable();
            $table->string('due_salary')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('employee_id')
                ->references('id')->on('employees')
                ->onDelete('cascade'); // Optional: cascade delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_salaries');
    }
};
