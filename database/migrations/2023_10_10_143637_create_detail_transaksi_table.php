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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->decimal('harga_produk', 10, 0);
            $table->integer('kuantitas');
            $table->decimal('subtotal', 10, 0);
            $table->decimal('total_harga', 10, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
