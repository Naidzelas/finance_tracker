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
        Schema::create('investments', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('symbol')->nullable();
            $table->integer('instrument_id')->nullable();
            $table->integer('investment_type_id')->nullable();
            $table->string('iconify_name')->nullable();
            $table->integer('investment_sector_id')->nullable();
            $table->decimal('invested', 10, 2)->nullable();
            $table->decimal('profit', 10, 2)->nullable();
            $table->decimal('profit_percent', 10, 2)->nullable();
            $table->boolean('is_green')->nullable();
            $table->decimal('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
