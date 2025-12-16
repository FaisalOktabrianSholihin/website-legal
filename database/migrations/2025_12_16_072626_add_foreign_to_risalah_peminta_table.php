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
        Schema::table('risalah_peminta', function (Blueprint $table) {
            $table->foreign('risalah_id')
                ->references('id')->on('risalah')
                ->cascadeOnDelete();

            $table->foreign('peminta_id')
                ->references('id')->on('master_bantu')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('risalah_peminta', function (Blueprint $table) {
            //
        });
    }
};
