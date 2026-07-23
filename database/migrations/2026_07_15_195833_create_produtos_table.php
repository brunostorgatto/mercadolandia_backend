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
    Schema::create('produtos', function (Blueprint $table) {
        $table->id();
        // O produto obrigatoriamente pertence a uma categoria
        $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
        
        $table->string('nome');
        
        // Preço com precisão: total de 8 dígitos, sendo 2 após a vírgula (ex: 999999.99)
        $table->decimal('preco', 8, 2);
        
        // Exemplo: 'un', 'kg', 'g', 'l'
        $table->string('unidade_medida')->default('un');
        
        // Incremento: o passo do peso (ex: 0.100 para 100g). 
        // 8 total, 3 após a vírgula permite precisão de milésimos.
        $table->decimal('incremento', 8, 3)->default(1.000);
        
        $table->string('imagem')->nullable(); // Foto do produto
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
