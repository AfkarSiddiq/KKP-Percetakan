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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama_barang');
            $table->foreignId('kategori_id');
            $table->foreignId('bahan_id');
            $table->integer('harga');
            $table->integer('harga_member');
            $table->integer('harga_studio');
            $table->string('satuan');
            $table->string('foto')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
