<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ikans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->nullable(); // air tawar, air laut, dll
            $table->integer('harga');               // simpan dalam rupiah
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();   // path file gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ikans');
    }
};
