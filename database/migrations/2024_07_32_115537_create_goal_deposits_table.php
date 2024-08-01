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
        Schema::create('goal_deposits', function (Blueprint $table) {
            $table->id();
            $table->decimal('deposit',10,2);
            $table->timestamps();
            $table->foreign('id')
                ->references('goal_deposit_id')
                ->on('goals')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_deposits');
    }
};
