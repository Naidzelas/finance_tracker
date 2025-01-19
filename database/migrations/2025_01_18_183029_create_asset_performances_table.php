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
        Schema::create('asset_performances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->decimal('revenue');
            $table->boolean('is_green');
            $table->decimal('eps');
            $table->boolean('is_eps_green');
            $table->decimal('pe_ratio');
            $table->boolean('is_pe_green');
            $table->decimal('dividend');
            $table->dateTime('dividend_ex_date')->nullable();
            $table->dateTime('dividend_pay_date')->nullable();
            $table->string('dividend_frequency')->nullable();
            $table->timestamps();

            $table->foreign('asset_id')
                ->references('id')
                ->on('investments')
                ->cascadeOnUpdate();

            $table->index('asset_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_performances');
    }
};
