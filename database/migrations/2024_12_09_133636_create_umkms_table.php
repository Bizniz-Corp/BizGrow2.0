<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id('umkm_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('npwp_no', 25)->nullable();
            $table->string('izin_usaha_path')->nullable(); // Path file upload izin usaha
            $table->string('profile_picture')->nullable(); // Path file upload profile picture
            $table->boolean('forecasting_demand')->default(false);
            $table->boolean('buffer_stock')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->integer('durasi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
