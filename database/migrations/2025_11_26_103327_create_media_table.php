<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');
            $table->string('ref_table');        // contoh: 'aset'
            $table->unsignedBigInteger('ref_id'); // contoh: aset_id
            $table->string('file_url');         // path file di storage/public
            $table->string('caption')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // opsional index biar query cepat
            $table->index(['ref_table', 'ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};

