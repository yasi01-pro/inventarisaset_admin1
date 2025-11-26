<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->id('aset_id');

            // Foreign key ke kategori_aset
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')
                ->references('kategori_id')
                ->on('kategori_aset')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('kode_aset')->unique();
            $table->string('nama_aset');
            $table->date('tgl_perolehan')->nullable();
            $table->decimal('nilai_perolehan', 15, 2)->default(0);
            $table->string('kondisi', 50)->default('baik');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset');
    }
};

