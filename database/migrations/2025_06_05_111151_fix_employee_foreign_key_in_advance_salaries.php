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
        Schema::table('advance_salaries', function (Blueprint $table) {
            // Drop old column if it exists
            $table->dropColumn('employee_id');

            // Recreate with correct type
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('advance_salaries', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');
            $table->integer('employee_id'); // restore original
        });
    }
};
