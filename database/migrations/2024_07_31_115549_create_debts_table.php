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
        Schema::create('debts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('debt_type_id');
            $table->boolean('active')->default(0);
            $table->decimal('borrowed', 10, 2);
            $table->decimal('payment', 10, 2);
            $table->dateTime('payment_date');
            $table->decimal('interest_rate', 3, 2)->default(0);
            $table->unsignedBigInteger('document_id');
            $table->timestamps();
            $table->index('document_id');
            $table->index('debt_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debts');
    }
};
