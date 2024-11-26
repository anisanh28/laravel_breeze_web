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
        Schema::table('submateri', function (Blueprint $table) {
            $table->string('soal_warm_up')->nullable()->after('file'); // Ganti 'nama_kolom_baru' dengan nama kolom yang diinginkan
        });
    }

    public function down(): void
    {
        Schema::table('submateri', function (Blueprint $table) {
            $table->dropColumn('soal_warm_up'); // Ganti 'nama_kolom_baru' dengan nama kolom yang dihapus
        });
    }
};
