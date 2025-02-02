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
            $table->string('name');
            $table->boolean('active')->default(0);
            $table->decimal('loan_size', 10, 2);
            $table->decimal('monthly_payment', 10, 2);
            $table->decimal('loan_post_interest', 10, 2);
            $table->dateTime('payment_date');
            $table->decimal('interest_rate', 10, 2)->default(0);
            $table->integer('icon_id')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->timestamps();
            $table->index('document_id');
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
