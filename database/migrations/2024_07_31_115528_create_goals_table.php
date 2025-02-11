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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->decimal('end_goal',8,2)->nullable();
            $table->decimal('contribution',8,2)->nullable();
            $table->string('icon_id')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('is_main_priority')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
