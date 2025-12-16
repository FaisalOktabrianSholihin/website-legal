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
        Schema::create('risalah', function (Blueprint $table) {
            $table->id();
            $table->string('no_risalah')->unique();
            $table->string('nama_risalah');
            $table->date('start_date');
            $table->date('end_date');

            $table->unsignedBigInteger('status_id');

            $table->string('lokasi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risalah');
    }
};
