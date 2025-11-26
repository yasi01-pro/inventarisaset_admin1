<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeliharaanAset extends Model
{
    protected $table      = 'pemeliharaan_aset';
    protected $primaryKey = 'pemeliharaan_id';

    protected $fillable = [
        'aset_id',
        'tanggal',
        'tindakan',
        'biaya',
        'pelaksana',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'biaya'   => 'decimal:2',
    ];

    // Relasi ke Aset
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    }

    // Semua media bukti pemeliharaan
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'pemeliharaan_id')
                    ->where('ref_table', 'pemeliharaan_aset')
                    ->orderBy('sort_order');
    }

    // Bukti utama (satu file pertama)
    public function buktiUtama()
    {
        return $this->media()->first();
    }
}
