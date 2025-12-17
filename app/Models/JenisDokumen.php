<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class JenisDokumen extends Model
{
    protected $table = 'jenis_dokumen';


    protected $fillable = [
        'nama_jenis',
        'keterangan'
    ];


    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'jenis_dokumen_id');
    }
}
