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
        Schema::create('composition_purchase_transactions', function (Blueprint $table) {
            $table->id('composition_purchase_id');
            $table->foreignId('composition_id')->constrained('compositions','composition_id')->onDelete('cascade');
            $table->dateTime('composition_purchase_date');
            $table->integer('composition_purchase_quantity');
            $table->integer('composition_price_per_item');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('composition_purchase_transactions');
    }
};
