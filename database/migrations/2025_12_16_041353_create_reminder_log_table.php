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
            $table->string('dokumen_type');
            $table->unsignedBigInteger('dokumen_id');
            $table->unsignedBigInteger('reminder_setting_id');
            $table->dateTime('tanggal_kirim')->nullable();
            $table->string('status_kirim')->default('pending');
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
