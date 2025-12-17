<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReminderLog extends Model
{
    protected $table = 'reminder_log';

    protected $fillable = [
        'dokumen_id',
        'hari_sebelum',
        'tanggal_kirim',
        'status_kirim'
    ];

    protected $casts = [
        'tanggal_kirim' => 'date'
    ];

    public function dokumen(): BelongsTo
    {
        return $this->belongsTo(Dokumen::class, 'dokumen_id');
    }
}
