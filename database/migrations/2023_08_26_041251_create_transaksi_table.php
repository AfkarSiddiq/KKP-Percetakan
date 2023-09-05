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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id');
            $table->foreignId('pelanggan_id');
            $table->date('tgl');
            $table->integer('jumlah');
            $table->double('harga');    
            $table->double('panjang');
            $table->double('lebar');
            $table->double('luas');
            $table->double('total_harga');
            $table->double('total_bayar');
            $table->double('sisa');
            $table->integer('status')->default(0);
            $table->string('keterangan')->nullable();
            $table->string('pembayaran')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
