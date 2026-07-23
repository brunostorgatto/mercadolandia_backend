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
    Schema::create('estabelecimentos', function (Blueprint $table) {
        $table->id();
        
        // Dados principais
        $table->string('nome_fantasia');
        $table->string('razao_social');
        $table->string('cnpj', 18)->unique(); // Formato: 00.000.000/0000-00
        
        // Dados de contato
        $table->string('telefone');
        $table->string('email_contato');
        
        // Dados de endereço (Otimizado)
        $table->string('cep', 9);
        $table->string('logradouro');
        $table->string('numero', 10);
        $table->string('complemento')->nullable();
        $table->string('bairro');
        $table->string('cidade');
        $table->string('estado', 2); // Ex: RS, SP
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estabelecimentos');
    }
};
