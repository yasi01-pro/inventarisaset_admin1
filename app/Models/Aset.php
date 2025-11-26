<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $table      = 'aset';
    protected $primaryKey = 'aset_id';

    protected $fillable = [
        'kategori_id',
        'kode_aset',
        'nama_aset',
        'tgl_perolehan',
        'nilai_perolehan',
        'kondisi',
    ];

    protected $casts = [
        'tgl_perolehan'   => 'date',
        'nilai_perolehan' => 'decimal:2',
    ];

    // Relasi ke kategori_aset
    public function kategori()
    {
        return $this->belongsTo(KategoriAset::class, 'kategori_id', 'kategori_id');
    }

    // Semua media yang terkait aset ini
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'aset_id')
                    ->where('ref_table', 'aset')
                    ->orderBy('sort_order');
    }

    // Foto utama (ambil 1 pertama)
    public function fotoUtama()
    {
        return $this->media()->first();
    }
}
