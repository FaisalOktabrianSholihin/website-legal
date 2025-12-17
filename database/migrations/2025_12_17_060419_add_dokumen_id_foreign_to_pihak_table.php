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
        Schema::table('pihak', function (Blueprint $table) {
            $table->foreign('dokumen_id')
                ->references('id')->on('dokumen')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pihak', function (Blueprint $table) {
            $table->dropForeign(['dokumen_id']);
        });
    }
};
