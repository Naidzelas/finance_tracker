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
        Schema::create('debt_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('debt_id');
            $table->decimal('paid_amount',10,2)->default(0);
            $table->integer('payment_date');
            $table->dateTime('loan_end_date');
            $table->string('loan_iban')->nullable();
            $table->timestamps();
            $table->index('debt_id');
            $table->foreign('debt_id')
                ->references('id')
                ->on('debts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_details');
    }
};
