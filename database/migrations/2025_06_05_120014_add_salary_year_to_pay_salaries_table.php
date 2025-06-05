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
        Schema::table('pay_salaries', function (Blueprint $table) {
            $table->string('salary_year')->nullable()->after('salary_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pay_salaries', function (Blueprint $table) {
            $table->dropColumn('salary_year');
        });
    }
};
