<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PihakDokumen extends Model
{
    protected $table = 'pihak_dokumen';


    protected $fillable = [
        'dokumen_id',
        'nama_pihak',
        'jabatan_pihak',
        'keterangan'
    ];


    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }
}
