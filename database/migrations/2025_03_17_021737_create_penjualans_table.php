<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_produk');
            $table->decimal('harga', 10, 2);
            $table->integer('kuantitas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
};
