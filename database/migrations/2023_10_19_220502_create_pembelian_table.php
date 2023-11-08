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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelian');
            $table->timestamp('tanggal_pembelian');
            $table->unsignedBigInteger('id_produk');
            $table->integer('kuantitas');
            $table->decimal('harga', 10, 0);
            $table->unsignedBigInteger('id_supplier');
            $table->decimal('total_harga', 10, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
