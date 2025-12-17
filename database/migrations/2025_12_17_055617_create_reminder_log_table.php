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
        Schema::create('reminder_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dokumen_id');
            $table->integer('hari_sebelum');
            $table->date('tanggal_kirim');
            $table->string('status_kirim')->default('pending'); // pending, sent, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_log');
    }
};
