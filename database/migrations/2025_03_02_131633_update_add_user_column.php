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
        Schema::table('investments', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->integer('user_id');
            });
        });
        Schema::table('budget_types', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->integer('user_id');
            });
        });
        Schema::table('debts', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->integer('user_id');
            });
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->integer('user_id');
            });
        });
        Schema::table('goals', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->integer('user_id');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('budget_types', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('debts', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
