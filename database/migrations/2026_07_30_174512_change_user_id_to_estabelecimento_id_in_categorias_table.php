<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            // Remove a chave antiga
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Adiciona a nova chave apontando para a tabela estabelecimentos
            $table->foreignId('estabelecimento_id')
                  ->after('id')
                  ->constrained('estabelecimentos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropForeign(['estabelecimento_id']);
            $table->dropColumn('estabelecimento_id');
            $table->foreignId('user_id')->constrained('users');
        });
    }
};
