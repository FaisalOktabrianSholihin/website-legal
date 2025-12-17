<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;


class Dokumen extends Model
{
    protected $table = 'dokumen';


    protected $fillable = [
        'jenis_id',
        'status_id',
        'no_dokumen',
        'nama_dokumen',
        'tgl_awal',
        'tgl_akhir',
        'catatan',
        'attachment',
        'lokasi'
    ];


    protected $casts = [
        'tgl_awal' => 'date',
        'tgl_akhir' => 'date'
    ];


    // ================= RELATION =================


    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisDokumen::class, 'jenis_id');
    }


    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusDokumen::class, 'status_id');
    }


    public function pihak(): HasMany
    {
        return $this->hasMany(PihakDokumen::class, 'dokumen_id');
    }


    public function reminderLog(): HasMany
    {
        return $this->hasMany(ReminderLog::class, 'dokumen_id');
    }


    // ================= HELPER =================


    public function getSisaHariAttribute(): ?int
    {
        if (!$this->tgl_akhir) {
            return null;
        }


        return now()->diffInDays($this->tgl_akhir, false);
    }


    public function getIsExpiredAttribute(): bool
    {
        return $this->sisa_hari !== null && $this->sisa_hari < 0;
    }
}
