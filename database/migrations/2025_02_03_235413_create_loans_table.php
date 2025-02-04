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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("borrowed_by_user_id")->constrained("users"); //primeiro usuario que emprestou a chave
            $table->foreignId("given_by_user_id")->constrained("users");//usuario que deu a chave
            $table->foreignId("borrowed_key_id")->constrained("keys"); //a dita cuja chave emprestada
            $table->foreignId("returned_by_user_id")->nullable()->constrained("users");//o usuario que devolveu a chave
            $table->foreignId("receiver_user_id")->nullable()->constrained("users");//o usuario que recebeu a chave na guarita
            $table->timestamp("borrowed_at")->useCurrent();
            $table->timestamp("returned_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
