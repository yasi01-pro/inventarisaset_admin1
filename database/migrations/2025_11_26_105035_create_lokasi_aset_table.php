<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi_aset', function (Blueprint $table) {
            $table->id('lokasi_id');

            // FK ke aset
            $table->unsignedBigInteger('aset_id');
            $table->foreign('aset_id')
                ->references('aset_id')
                ->on('aset')
                ->onUpdate('cascade')
                ->onDelete('cascade'); // kalau aset dihapus, lokasi ikut hilang

            $table->string('keterangan')->nullable();   // misal: Gudang Utara, Ruang 101, dll
            $table->text('lokasi_text')->nullable();    // deskripsi lokasi lebih detail
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_aset');
    }
};

