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
            $table->id();
            $table->unsignedBigInteger('investment_note_id')->nullable();
            $table->unsignedBigInteger('stock_id');
            $table->decimal('invested',10,2);
            $table->decimal('profit_loss_percent',10,2);
            $table->decimal('profit_loss',10,2);
            $table->decimal('average_buy_in',10,2);
            $table->timestamps();
            $table->index('stock_id');
            $table->index('investment_note_id');
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
