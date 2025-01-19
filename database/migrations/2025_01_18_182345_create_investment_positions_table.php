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
        Schema::create('investment_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investment_id');
            $table->dateTime('open_datetime');
            $table->decimal('open_rate')->default(0);
            $table->decimal('invested')->default(0);
            $table->decimal('profit')->default(0);
            $table->decimal('profit_percent')->default(0);
            $table->boolean('is_green')->default(1);
            $table->decimal('close_rate')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->timestamps();

            // cascade soft delete?
            $table->foreign('investment_id')
                ->references('id')
                ->on('investments')
                ->cascadeOnUpdate();

            $table->index('investment_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_positions');
    }
};
