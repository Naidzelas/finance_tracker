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
        Schema::create('filter_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('budget_type_id');
            $table->string('tag');
            $table->timestamps();
            $table->index('budget_type_id');
            $table->foreign('budget_type_id')
                ->references('id')
                ->on('budget_types')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_tags');
    }
};
