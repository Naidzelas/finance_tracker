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
        Schema::create('investment_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investment_id')->nullable();
            $table->text('notes');
            $table->timestamps();
            $table->foreign('investment_id')
                ->references('id')
                ->on('investments')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_notes');
    }
};
