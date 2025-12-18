<?php


// =====================================
// App\Models\StatusDokumen.php
// =====================================


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class StatusDokumen extends Model
{
    protected $table = 'status';


    protected $fillable = [
        'nama_status',
        'keterangan'
    ];


    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'status_id');
    }
}
