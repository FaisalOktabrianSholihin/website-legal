<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reminder_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('hari_sebelum'); // contoh: 90, 60, 30, 10
            $table->string('keterangan'); // contoh: Warning 3 Bulan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_setting');
    }
};
