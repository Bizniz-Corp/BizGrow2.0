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
        Schema::create('composition_stock_changes', function (Blueprint $table) {
            $table->id('composition_stock_changes_id');
            $table->foreignId('composition_id')->constrained('compositions','composition_id')->onDelete('cascade');
            $table->dateTime('composition_changes_date');
            $table->integer('composition_changes_quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('composition_stock_changes');
    }
};
