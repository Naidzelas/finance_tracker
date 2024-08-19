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
        Schema::create('investment_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon_id')->nullable();
            $table->decimal('price',10,2);
            $table->decimal('eps',10,2);
            $table->decimal('pe',10,2);
            $table->timestamps();
            $table->foreign('id')
                ->references('stock_id')
                ->on('investments')
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_stocks');
    }
};
