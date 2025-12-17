<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderSetting extends Model
{
    protected $table = 'reminder_setting';

    protected $fillable = [
        'hari_sebelum',
        'keterangan'
    ];
}
