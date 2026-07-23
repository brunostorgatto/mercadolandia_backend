<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Adiciona a coluna role para definir se é admin ou funcionário
            $table->string('role')->default('funcionario');

            // Adiciona a chave estrangeira (estabelecimento_id)
            // O ->nullable() é importante aqui para não quebrar usuários que não têm loja ainda
            $table->foreignId('estabelecimento_id')->nullable()->constrained('estabelecimentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
