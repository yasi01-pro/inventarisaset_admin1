<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_aset', function (Blueprint $table) {
            $table->id('kategori_id');             // Primary Key
            $table->string('nama');                // Nama kategori
            $table->string('kode')->unique();      // Kode kategori unik
            $table->text('deskripsi')->nullable(); // Optional
            $table->timestamps();                  // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_aset');
    }
};
