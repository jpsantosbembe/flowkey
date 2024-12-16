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
        Schema::create('key_authorizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('key_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_active')->default(true);
            $table->foreign('key_id')->references('id')->on('keys');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_authorizations');
    }
};
