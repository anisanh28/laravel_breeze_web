<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('opsis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pertanyaan_id');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaans')->onDelete('cascade');
            $table->string('opsi');
            $table->boolean('status')->default(true); // Mengganti enum dengan boolean
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opsis');
    }
};
