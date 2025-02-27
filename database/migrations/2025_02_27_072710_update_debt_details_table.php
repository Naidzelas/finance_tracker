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
        Schema::table('debt_details', function (Blueprint $table) {
            $table->dropColumn('paid_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('debt_details', function (Blueprint $table) {
            $table->after('debt_id', function ($table) {
                $table->integer('paid_amount');
            });
        });
    }
};
