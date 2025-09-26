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
        Schema::create('jadwal_ekskul', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ekstrakurikuler_id');
            $table->json('hari');
            $table->timestamps();
            $table->foreign('ekstrakurikuler_id')->references('id')->on('ekstrakurikuler')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_ekskul');
    }
};
