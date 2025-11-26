<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiAset extends Model
{
    protected $table      = 'lokasi_aset';
    protected $primaryKey = 'lokasi_id';

    protected $fillable = [
        'aset_id',
        'keterangan',
        'lokasi_text',
        'rt',
        'rw',
    ];

    // Relasi ke Aset
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    }

    // Semua media (denah/foto) untuk lokasi ini
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'lokasi_id')
                    ->where('ref_table', 'lokasi_aset')
                    ->orderBy('sort_order');
    }

    // Denah utama (satu foto pertama)
    public function denahUtama()
    {
        return $this->media()->first();
    }
}
