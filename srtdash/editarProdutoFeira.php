<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ProdutoFeira;
    use App\Entity\Produto;

    if (!isset($_POST['idProductFeira']) or !is_numeric($_POST['idProductFeira'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID inválido'
        ]);
        exit;
    }

    $obProd = ProdutoFeira::getProdutoFeiraPorId($_POST['idProductFeira']);

    if (!$obProd instanceof ProdutoFeira) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Produto não encontrado'
        ]);
        exit;
    }

    if (isset($_POST['editIdFeira'], $_POST['idEditProduto'], $_POST['editPreco'], $_POST['editQuantidade'])) {
        $obProd->idFeira = $_POST['editIdFeira'];
        $obProd->idProduto = $_POST['idEditProduto'];
        $obProd->preco = $_POST['editPreco'];

        if ($_POST['editQuantidade'] != $obProd->quantidade) {
            $novaQuantidade = $_POST['editQuantidade'];
            $quantidadeAntiga = $obProd->quantidade;
            $diferenca = $novaQuantidade - $quantidadeAntiga;

            $obProd->quantidade = $novaQuantidade;

            $produto = Produto::getProduto($obProd->idProduto);
            if ($produto instanceof Produto) {
                if ($diferenca > $produto->estoque) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Estoque insuficiente'
                    ]);
                    exit;
                }
                $produto->estoque -= $diferenca;
                $produto->atualizar();
            }
            $obProd->atualizar();
            echo json_encode([
                'status' => 'success',
                'message' => 'Produto atualizado com sucesso'
            ]);
            exit;
        }
    }
