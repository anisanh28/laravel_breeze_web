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
        Schema::create('jawaban_evaluasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hasilEvaluasi_id');
            $table->foreign('hasilEvaluasi_id')->references('id')->on('hasil_evaluasis')->onDelete('cascade');

            $table->unsignedBigInteger('pertanyaan_id');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaans')->onDelete('cascade');

            $table->string('jawaban');
            $table->boolean('status')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_evaluasis');
    }
};
