<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Estabelecimento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategoriaEProdutoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Garante um estabelecimento ativo
        $estabelecimento = Estabelecimento::first() ?? Estabelecimento::create([
            'nome' => 'Mercado Modelo'
        ]);

        // 2. Garante a existência do diretório e de uma imagem padrão de teste no Storage
        Storage::disk('public')->makeDirectory('produtos');
        $nomeImagemTeste = 'produtos/foto_demo.jpg';

        if (!Storage::disk('public')->exists($nomeImagemTeste)) {
            // Cria um quadrado de teste de 600x600 px
            $img = imagecreatetruecolor(600, 600);
            $corFundo = imagecolorallocate($img, 220, 220, 220); // Cinza claro
            imagefill($img, 0, 0, $corFundo);

            ob_start();
            imagejpeg($img);
            $conteudoBinario = ob_get_clean();
            imagedestroy($img);

            Storage::disk('public')->put($nomeImagemTeste, $conteudoBinario);
        }

        // 3. Estrutura padronizada e coerente (Categoria => Produtos)
        $dados = [
            'Bebidas' => [
                ['nome' => 'Coca-Cola 2 Litros', 'preco' => 9.90, 'unidade' => 'un', 'incremento' => 1],
                ['nome' => 'Guaraná Antarctica 2L', 'preco' => 7.50, 'unidade' => 'un', 'incremento' => 1],
                ['nome' => 'Suco de Laranja 1L', 'preco' => 11.90, 'unidade' => 'l', 'incremento' => 1],
                ['nome' => 'Cerveja Heineken Long Neck 330ml', 'preco' => 6.49, 'unidade' => 'un', 'incremento' => 1],
            ],
            'Carnes e Açougue' => [
                ['nome' => 'Picanha Bovina', 'preco' => 69.90, 'unidade' => 'kg', 'incremento' => 0.5],
                ['nome' => 'Alcatra Bovina', 'preco' => 42.90, 'unidade' => 'kg', 'incremento' => 0.5],
                ['nome' => 'Peito de Frango Desossado', 'preco' => 18.90, 'unidade' => 'kg', 'incremento' => 0.5],
                ['nome' => 'Bisteca Suína', 'preco' => 21.90, 'unidade' => 'kg', 'incremento' => 0.5],
            ],
            'Hortifruti' => [
                ['nome' => 'Banana Caturra', 'preco' => 5.99, 'unidade' => 'kg', 'incremento' => 0.5],
                ['nome' => 'Maçã Fuji', 'preco' => 8.90, 'unidade' => 'kg', 'incremento' => 0.1],
                ['nome' => 'Tomate Italiano', 'preco' => 7.90, 'unidade' => 'kg', 'incremento' => 0.1],
                ['nome' => 'Cebola Branca', 'preco' => 4.50, 'unidade' => 'kg', 'incremento' => 0.1],
            ],
            'Padaria e Confeitaria' => [
                ['nome' => 'Pão Francês', 'preco' => 14.90, 'unidade' => 'kg', 'incremento' => 0.1],
                ['nome' => 'Pão de Queijo tradicional', 'preco' => 28.90, 'unidade' => 'kg', 'incremento' => 0.1],
                ['nome' => 'Cuca de Banana', 'preco' => 16.00, 'unidade' => 'un', 'incremento' => 1],
            ],
            'Laticínios e Frios' => [
                ['nome' => 'Queijo Mussarela Fatiado', 'preco' => 44.90, 'unidade' => 'kg', 'incremento' => 0.1],
                ['nome' => 'Presunto Cozido Fatiado', 'preco' => 29.90, 'unidade' => 'kg', 'incremento' => 0.1],
                ['nome' => 'Leite Integral 1L', 'preco' => 4.89, 'unidade' => 'l', 'incremento' => 1],
                ['nome' => 'Manteiga com Sal 200g', 'preco' => 10.90, 'unidade' => 'un', 'incremento' => 1],
            ],
        ];

        // 4. Inserção no banco mantendo o vínculo das chaves estrangeiras
        foreach ($dados as $nomeCategoria => $produtos) {
            $categoria = Categoria::create([
                'estabelecimento_id' => $estabelecimento->id,
                'nome'               => $nomeCategoria,
            ]);

            foreach ($produtos as $p) {
                Produto::create([
                    'categoria_id'   => $categoria->id,
                    'nome'           => $p['nome'],
                    'preco'          => $p['preco'],
                    'unidade_medida' => $p['unidade'],
                    'incremento'     => $p['incremento'],
                    'imagem'         => $nomeImagemTeste,
                ]);
            }
        }
    }
}