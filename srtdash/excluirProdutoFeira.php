<?php

    require __DIR__ . '/../vendor/autoload.php';

    use App\Entity\ProdutoFeira;
    use App\Entity\Produto;

    if (!isset($_POST['prodFeira_id']) || !is_numeric($_POST['prodFeira_id'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID inválido'
        ]);
        exit;
    }

    $obProd = ProdutoFeira::getProdutoFeiraPorId($_POST['prodFeira_id']);

    if (!$obProd instanceof ProdutoFeira) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Produto não encontrado'
        ]);
        exit;
    }

    $prod = Produto::getProduto($obProd->idProduto);
    if ($prod instanceof Produto) {
        $prod->estoque += $obProd->quantidade;
        $prod->atualizar();
    }
    if($obProd->excluir()){
        echo json_encode([
            'status' => 'success',
            'message' => 'Produto deletado com sucesso!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erro ao deletar produto.'
        ]);
    }

