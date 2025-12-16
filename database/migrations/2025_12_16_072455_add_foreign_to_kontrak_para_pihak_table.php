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
        Schema::table('kontrak_para_pihak', function (Blueprint $table) {
            $table->foreign('kontrak_id')
                ->references('id')->on('kontrak')
                ->cascadeOnDelete();

            $table->foreign('pihak_id')
                ->references('id')->on('master_bantu')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
