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
        Schema::table('pertanyaans', function (Blueprint $table) {
            $table->integer('skor')->nullable()->after('file');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertanyaans', function (Blueprint $table) {
            $table->dropColumn('soal_warm_up');
        });
    }
};