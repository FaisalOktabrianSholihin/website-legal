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
        Schema::create('risalah_peminta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('risalah_id');
            $table->unsignedBigInteger('peminta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risalah_peminta');
    }
};
