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
        Schema::create('guaritas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campuses_id');
            $table->string( 'nome');
            $table->timestamps();
            $table->foreign('campuses_id')->references('id')->on('campuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guaritas');
    }
};
